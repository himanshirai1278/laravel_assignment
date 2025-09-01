<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Customer;
use App\Models\Product;

class OrderPlacementTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_place_order(): void
    {
        $customer = Customer::factory()->create();
        $product = Product::factory()->create(['stock'=>10]);

        $this->actingAs($customer,'customer')
            ->post('/orders',[
                'product_id'=>$product->id,
                'quantity'=>2
            ])->assertRedirect();

        $this->assertDatabaseHas('orders',[
            'customer_id'=>$customer->id,
            'status'=>'Pending'
        ]);
        $this->assertDatabaseHas('order_items',[
            'product_id'=>$product->id,'quantity'=>2
        ]);
    }
}
