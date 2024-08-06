<?php

namespace Tests\Feature;

use App\Http\Livewire\Setting\Add;
use App\Http\Livewire\Setting\Edit;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Support\Facades\Cache;

class SettingTest extends TestCase
{


    protected function setUp(): void
    {
        parent::setUp();
        $user = User::find(1);
        $this->actingAs($user);
    }

    public function test_it_can_add_a_setting()
    {
        Livewire::test(Add::class)
            ->set('key', 'test_key')
            ->set('value', 'test_value')
            ->set('remark', 'test_remark')
            ->call('save');

        $this->assertDatabaseHas('setting', [
            'key' => 'test_key',
            'value' => 'test_value',
            'remark' => 'test_remark',
        ]);
    }

    public function test_it_updates_settings()
    {
        $setting = Setting::create([
            'key' => 'test_key',
            'value' => 'original_value',
            'remark' => 'original_remark',
        ]);

        $updatedValue = 'updated_value';
        $updatedRemark = 'updated_remark';

        Livewire::test(Add::class)
            ->call('showModalUpdate', $setting->id)
            ->set('valueEdit', $updatedValue)
            ->set('remarkEdit', $updatedRemark)
            ->call('updateSetting');

        $this->assertDatabaseHas('setting', [
            'id' => $setting->id,
            'value' => $updatedValue,
            'remark' => $updatedRemark,
        ]);
        $this->assertNull(Cache::get('vat_setting'));
    }

    public function test_it_can_delete_a_setting()
    {
        $setting = Setting::latest()->first();

        Livewire::test(Add::class)
            ->call('confirmDelete', $setting->id)
            ->call('delete');

        $this->assertDatabaseMissing('setting', [
            'id' => $setting->id,
        ]);
    }
}

