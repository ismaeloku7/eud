<?php

namespace Tests\Feature\Admin;

use App\Filament\Resources\Resources\Pages\EditResource;
use App\Filament\Resources\Resources\RelationManagers\FilesRelationManager;
use App\Models\Language;
use App\Models\Resource;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Filament\Forms\Components\Select;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FilesRelationManagerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
    }

    public function test_language_options_are_listed_alphabetically_in_the_current_locale(): void
    {
        $spanish = Language::create(['code' => 'es', 'name' => ['en' => 'Spanish', 'es' => 'Español']]);
        $romanian = Language::create(['code' => 'ro', 'name' => ['en' => 'Romanian']]);
        $german = Language::create(['code' => 'de', 'name' => ['en' => 'German', 'es' => 'Alemán']]);
        $french = Language::create(['code' => 'fr', 'name' => ['en' => 'French', 'es' => 'Francés']]);
        $resource = Resource::create(['slug' => 'manual', 'title' => ['en' => 'Manual']]);

        app()->setLocale('es');

        $this->languageSelect($resource, function (Select $select) use ($german, $spanish, $french, $romanian): void {
            $this->assertSame(
                [$german->id => 'Alemán', $spanish->id => 'Español', $french->id => 'Francés', $romanian->id => 'Romanian'],
                $select->getOptions(),
            );
        });
    }

    public function test_language_options_follow_the_english_names_when_the_locale_is_english(): void
    {
        $spanish = Language::create(['code' => 'es', 'name' => ['en' => 'Spanish', 'es' => 'Español']]);
        $german = Language::create(['code' => 'de', 'name' => ['en' => 'German', 'es' => 'Alemán']]);
        $french = Language::create(['code' => 'fr', 'name' => ['en' => 'French', 'es' => 'Francés']]);
        $resource = Resource::create(['slug' => 'manual', 'title' => ['en' => 'Manual']]);

        app()->setLocale('en');

        $this->languageSelect($resource, function (Select $select) use ($french, $german, $spanish): void {
            $this->assertSame(
                [$french->id => 'French', $german->id => 'German', $spanish->id => 'Spanish'],
                $select->getOptions(),
            );
        });
    }

    /** Opens the "add file" modal of a resource and hands its language select to the callback. */
    private function languageSelect(Resource $resource, \Closure $assert): void
    {
        Livewire::test(FilesRelationManager::class, ['ownerRecord' => $resource, 'pageClass' => EditResource::class])
            ->mountAction(TestAction::make('create')->table())
            ->assertSchemaComponentExists('language_id', null, function (Select $select) use ($assert): bool {
                $assert($select);

                return true;
            });
    }
}
