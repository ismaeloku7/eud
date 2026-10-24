<?php

namespace Tests\Feature\Admin;

use App\Filament\Resources\Honors\Pages\EditHonor;
use App\Models\Honor;
use App\Models\Ministry;
use App\Models\User;
use Database\Seeders\CatalogueSeeder;
use Database\Seeders\MinistrySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class LegacyImagePathsTest extends TestCase
{
    use RefreshDatabase;

    public function test_saving_a_record_keeps_images_that_are_not_on_the_upload_disk(): void
    {
        Storage::fake('public');
        $this->seed([CatalogueSeeder::class, MinistrySeeder::class]);
        $this->actingAs(User::factory()->create());

        $honor = Honor::create([
            'ministry_id' => Ministry::first()->id,
            'category_id' => 1,
            'name' => ['en' => 'Camping'],
            'image' => '/images/honors/camping.png',
            'image_secondary' => 'pending-download.png',
        ]);

        Livewire::test(EditHonor::class, ['record' => $honor->getRouteKey()])
            ->fillForm(['name' => 'Camping Skills'])
            ->call('save')
            ->assertHasNoFormErrors();

        $honor->refresh();
        $this->assertSame('/images/honors/camping.png', $honor->image);
        $this->assertSame('pending-download.png', $honor->image_secondary);
    }
}
