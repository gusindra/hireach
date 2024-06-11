<?php

namespace Tests\Feature;

use App\Http\Livewire\Commercial\Progress;
use App\Models\OrderProduct;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class QuotationUserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_render_order__user()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->get('quotation');

        $response->assertStatus(200);
    }

    public function test_approve_quoation_user()
    {
        $user = User::find(1);
        $user2 = User::find(2);

        //Admin Side
        $adminQuotation = Quotation::create([
            'title' => 'Quotation Test',
            'type' => 'Type Value',
            'description' => 'Description Value',
            'quote_no' => 320372083,
            'commerce_id' => 1,
            'source_id' => 1,
            'client_id' => 1,
            'model' => 'USER',
            'model_id' => $user2->id,
            'terms' => 'Terms Value',
            'discount' => 0.1,
            'price' => 100,
            'status' => 'draft',
            'valid_day' => 7,
            'date' => now(),
            'user_id' => 1,
            'created_by' => 1,
            'created_role' => 'Created Role Value',
            'addressed_name' => 'Addressed Name Value',
            'addressed_role' => 'Addressed Role Value',
            'addressed_company' => 'Addressed Company Value',
        ]);

        $orderProduct = OrderProduct::create([
            'name' => 'Name Value',
            'model' => 'Quotation',
            'model_id' => $adminQuotation->id,
            'product_id' => null,
            'qty' => 1,
            'unit' => 'item',
            'price' => 100,
            'total_percentage' => 0.5,
            'note' => 'Note Value',
            'user_id' => $user->id,
        ]);
        //AdminSubmitted
        Livewire::actingAs($user)
            ->test(Progress::class, ['model' => $adminQuotation, 'id' => $adminQuotation->id])
            ->call('submit');

        // User Approve
        Livewire::actingAs($user2)
            ->test(Progress::class, ['model' => $adminQuotation, 'id' => $adminQuotation->id])
            ->call('next', 'approved');
        //Admin Activate
        Livewire::actingAs($user)
            ->test(Progress::class, ['model' => $adminQuotation, 'id' => $adminQuotation->id])
            ->call('activated');
        $adminQuotation->refresh();
        $this->assertEquals('active', $adminQuotation->status);
    }
}
