<?php

namespace App\Legacy;

use Closure;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;

/** Shared state for one import run: connections, file copier, logging and id lookups. */
final class LegacyContext
{
    /** @var array<string, array<int|string, true>> */
    private array $ids = [];

    public function __construct(
        public readonly ConnectionInterface $legacy,
        public readonly FileCopier $files,
        private readonly Closure $info,
        private readonly Closure $warn,
    ) {}

    public function info(string $message): void
    {
        ($this->info)($message);
    }

    public function warn(string $message): void
    {
        ($this->warn)($message);
    }

    /** Whether a row exists in the NEW database (parents are imported before children). */
    public function exists(string $table, mixed $id): bool
    {
        if ($id === null || $id === '') {
            return false;
        }

        $this->ids[$table] ??= array_fill_keys(DB::table($table)->pluck('id')->all(), true);

        return isset($this->ids[$table][$id]);
    }

    public function forget(string $table): void
    {
        unset($this->ids[$table]);
    }
}
