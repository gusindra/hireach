<?php

namespace Tests\Unit;

use App\Http\Livewire\Provider\AddSettingProvider;
use App\Models\Provider;
use App\Models\SettingProvider;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AddSettingProviderTest extends TestCase
{

    /** @test */
    public function can_creates_setting_provider()
    {
        $user = User::find(1);
        $provider = Provider::create([
            'name' => 'test',
            'code' => '778',
            'channel' => 'email'
        ]);

        Livewire::actingAs($user)->test(AddSettingProvider::class, ['provider' => $provider])
            ->set('key', 'test-key')
            ->set('value', 'test-value')
            ->call('create')
            ->assertEmitted('added');

        $this->assertDatabaseHas('setting_providers', [
            'provider_id' => $provider->id,
            'key' => 'test-key',
            'value' => 'test-value',
        ]);
        $provider->delete();
    }

    /** @test */
    public function test_it_deletes_setting_provider()
    {
        $user = User::find(1);
        $provider = Provider::create([
            'name' => 'test',
            'code' => '8998',
            'channel' => 'email'
        ]);

        $settingProvider = SettingProvider::create([
            'provider_id' => $provider->id,
            'key' => 'test',
            'value' => 'oo'
        ]);

        Livewire::actingAs($user)->test(AddSettingProvider::class, ['provider' => $provider])
            ->call('deleteShowModal', $settingProvider->id)
            ->assertSet('confirmingActionRemoval', true)
            ->call('delete');


        $this->assertDatabaseMissing('setting_providers', ['id' => $settingProvider->id]);
        $provider->delete();
    }
}
