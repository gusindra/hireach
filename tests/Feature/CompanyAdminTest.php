<?php

namespace Tests\Feature;

use App\Http\Livewire\Setting\CompanyAdd;
use App\Http\Livewire\Setting\CompanyEdit;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CompanyAdminTest extends TestCase
{
    public function test_company_can_be_rendered()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->get('admin/settings/company');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_company()
    {
        $user = User::find(2);
        Livewire::actingAs($user)->test(CompanyAdd::class)
            ->set('input', [
                'name' => 'Test Company',
                'code' => 'TEST',
                'tax_id' => '123456789',
                'post_code' => '12345',
                'province' => 'Test Province',
                'city' => 'Test City',
                'address' => 'Test Address',
                'person_in_charge' => 'Test Person',
                'user_id' => $user->id
            ])
            ->call('create');

        $this->assertDatabaseHas('companies', [
            'name' => 'Test Company',
            'code' => 'TEST',
            'tax_id' => '123456789',
            'post_code' => '12345',
            'province' => 'Test Province',
            'city' => 'Test City',
            'address' => 'Test Address',
            'person_in_charge' => 'Test Person',
            'user_id' => $user->id,
        ]);
    }



    public function test_can_update_company()
    {
        $company = Company::where('name', 'Test Company')->latest()->first();
        $user = User::find(1);

        Livewire::actingAs($user)->test(CompanyEdit::class, ['company' => $company])
            ->set('input.name', 'New Name')
            ->set('input.code', 'NEW')
            ->set('input.tax_id', '654321')
            ->set('input.person_in_charge', 'New Person')
            ->call('update', $company->id);

        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'name' => 'New Name',
            'code' => 'NEW',
            'tax_id' => '654321',
            'person_in_charge' => 'New Person'
        ]);
    }


    public function test_can_delete_company()
    {
        $company = Company::where('name', 'New Name')->latest()->first();
        $user = User::find(1);
        Livewire::actingAs($user)->test(CompanyEdit::class, ['company' => $company])
            ->call('actionShowDeleteModal')
            ->call('delete');

        $this->assertDatabaseHas('companies', ['id' => $company->id]);
        $this->assertNotNull($company->fresh()->deleted_at);
    }
}
