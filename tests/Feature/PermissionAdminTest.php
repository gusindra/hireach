<?php

namespace Tests\Feature;

use App\Http\Livewire\Permission\Add;
use App\Http\Livewire\Permission\Delete;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class PermissionAdminTest extends TestCase
{
    /**
     * test_create_permission
     *
     * @return void
     */
    public function test_create_permission()
    {
        $user = User::find(1);
        $type = ['create' => 'Create', 'edit' => 'Edit', 'delete' => 'Delete'];
        $model = 'Post';

        Livewire::actingAs($user)->test(Add::class)
            ->set('type', $type)
            ->set('model', $model)
            ->call('create')
            ->assertEmitted('refreshLivewireDatatable');

        foreach ($type as $key => $menu) {
            $this->assertDatabaseHas('permissions', [
                'name' => strtoupper($key . ' ' . $model),
                'model' => strtoupper($model)
            ]);
        }
    }

    /**
     * test_delete_permission
     *
     * @return void
     */
    public function test_delete_permission()
    {
        $permission = Permission::where('name', 'EDIT POST')->latest()->first();
        $user = User::find(1);


        Livewire::actingAs($user)->test(Delete::class, ['permission' => $permission, 'id' => $permission->id])
            ->call('deletePermission');
        $this->assertDatabaseMissing('permissions', ['id' => $permission->id]);
    }
}
