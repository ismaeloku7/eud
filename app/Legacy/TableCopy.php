<?php

namespace App\Legacy;

use Closure;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Declarative copy of one legacy table into its new counterpart. Ids are
 * preserved and rows are upserted, so the import can be re-run safely.
 */
final class TableCopy
{
    /** @var array<string, string> */
    private array $renames = [];

    /** @var array<int, string> */
    private array $translatable = [];

    /** @var array<int, string> */
    private array $json = [];

    /** @var array<int, string> */
    private array $plain = [];

    /** @var array<int, string> */
    private array $paths = [];

    /** @var array<int, string> */
    private array $booleans = [];

    /** @var array<int, string> */
    private array $integers = [];

    /** @var array<string, string> column => parent table (row skipped when missing) */
    private array $requires = [];

    /** @var array<string, string> column => parent table (set to null when missing) */
    private array $optional = [];

    private ?Closure $transform = null;

    private ?Closure $query = null;

    private function __construct(private readonly string $legacyTable, private readonly string $targetTable) {}

    public static function for(string $legacyTable, ?string $targetTable = null): self
    {
        return new self($legacyTable, $targetTable ?? $legacyTable);
    }

    /** @param  array<string, string>  $renames  legacy column => new column */
    public function rename(array $renames): self
    {
        $this->renames = $renames;

        return $this;
    }

    /** @param  array<int, string>  $columns */
    public function translatable(array $columns): self
    {
        $this->translatable = $columns;

        return $this;
    }

    /** @param  array<int, string>  $columns */
    public function json(array $columns): self
    {
        $this->json = $columns;

        return $this;
    }

    /** Columns that were translatable before and are plain strings now. @param  array<int, string>  $columns */
    public function plain(array $columns): self
    {
        $this->plain = $columns;

        return $this;
    }

    /** @param  array<int, string>  $columns */
    public function paths(array $columns): self
    {
        $this->paths = $columns;

        return $this;
    }

    /** @param  array<int, string>  $columns */
    public function booleans(array $columns): self
    {
        $this->booleans = $columns;

        return $this;
    }

    /** @param  array<int, string>  $columns */
    public function integers(array $columns): self
    {
        $this->integers = $columns;

        return $this;
    }

    /** @param  array<string, string>  $columns */
    public function requires(array $columns): self
    {
        $this->requires = $columns;

        return $this;
    }

    /** @param  array<string, string>  $columns */
    public function optional(array $columns): self
    {
        $this->optional = $columns;

        return $this;
    }

    /** @param  Closure(array<string, mixed>): (array<string, mixed>|null)  $transform */
    public function transform(Closure $transform): self
    {
        $this->transform = $transform;

        return $this;
    }

    /** @param  Closure(Builder): void  $query */
    public function where(Closure $query): self
    {
        $this->query = $query;

        return $this;
    }

    public function run(LegacyContext $context): int
    {
        $targetColumns = array_fill_keys(Schema::getColumnListing($this->targetTable), true);
        $imported = 0;
        $skipped = 0;

        $query = $context->legacy->table($this->legacyTable)->orderBy('id');

        if ($this->query) {
            ($this->query)($query);
        }

        $query->chunk(300, function (Collection $rows) use (&$imported, &$skipped, $targetColumns, $context): void {
            $prepared = [];

            foreach ($rows as $row) {
                $row = $this->prepare((array) $row, $targetColumns, $context);

                if ($row === null) {
                    $skipped++;

                    continue;
                }

                $prepared[] = $row;
            }

            if ($prepared === []) {
                return;
            }

            $keys = array_fill_keys(array_keys($prepared[0]), null);
            $prepared = array_map(fn (array $row) => array_merge($keys, array_intersect_key($row, $keys)), $prepared);

            DB::table($this->targetTable)->upsert($prepared, ['id'], array_values(array_diff(array_keys($keys), ['id'])));
            $imported += count($prepared);
        });

        $context->forget($this->targetTable);
        $context->info(sprintf('%-32s %5d rows%s', $this->targetTable, $imported, $skipped ? " ({$skipped} skipped: missing parent)" : ''));

        return $imported;
    }

    /**
     * @param  array<string, mixed>  $row
     * @param  array<string, true>  $targetColumns
     * @return array<string, mixed>|null
     */
    private function prepare(array $row, array $targetColumns, LegacyContext $context): ?array
    {
        foreach ($this->renames as $from => $to) {
            if (array_key_exists($from, $row)) {
                $row[$to] = $row[$from];
                unset($row[$from]);
            }
        }

        foreach ($this->requires as $column => $parent) {
            if (! $context->exists($parent, $row[$column] ?? null)) {
                $context->warn("{$this->targetTable} #{$row['id']}: {$column} points to a missing {$parent} row, skipped.");

                return null;
            }
        }

        foreach ($this->optional as $column => $parent) {
            if (! $context->exists($parent, $row[$column] ?? null)) {
                $row[$column] = null;
            }
        }

        foreach ($this->translatable as $column) {
            $row[$column] = Json::encode(Json::translatable($row[$column] ?? null));
        }

        foreach ($this->json as $column) {
            $row[$column] = Json::encode(Json::list($row[$column] ?? null));
        }

        foreach ($this->plain as $column) {
            $row[$column] = Json::plain($row[$column] ?? null);
        }

        foreach ($this->paths as $column) {
            $row[$column] = $context->files->path($row[$column] ?? null);
        }

        foreach ($this->booleans as $column) {
            $row[$column] = (int) Json::bool($row[$column] ?? false);
        }

        foreach ($this->integers as $column) {
            $row[$column] = Json::int($row[$column] ?? null);
        }

        if ($this->transform) {
            $row = ($this->transform)($row);

            if ($row === null) {
                return null;
            }
        }

        return array_intersect_key($row, $targetColumns);
    }
}
