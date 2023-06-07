<?php

namespace Tests\Feature\Models;

use App\Models\distributer;
use App\Models\order;
use App\Models\order_entry;
use App\Models\product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderEntryModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_model_exist(){
        $user = User::factory()->create();
        $distributer = distributer::factory()->create();
        $order = order::factory()->for(
            $user,"user"
        )->for($distributer, "distributer")->create();
        $product = product::factory()->create();
        $entry = order_entry::factory()
            ->for($order, "order")
            ->for($product, "product")->create();
        $this->assertModelExists($entry);
    }

    public function test_order_relationship(){
        $user = User::factory()->create();
        $distributer = distributer::factory()->create();
        $order = order::factory()->for(
            $user,"user"
        )->for($distributer, "distributer")->create();
        $product = product::factory()->create();
        $entry = order_entry::factory()
            ->for($order, "order")
            ->for($product, "product")->create();
        $this->assertEquals($order->id, $entry->order->id);
    }
    public function test_product_relationship(){
        $user = User::factory()->create();
        $distributer = distributer::factory()->create();
        $order = order::factory()->for(
            $user,"user"
        )->for($distributer, "distributer")->create();
        $product = product::factory()->create();
        $entry = order_entry::factory()
            ->for($order, "order")
            ->for($product, "product")->create();
        $this->assertEquals($product->id, $entry->product->id);
    }
}
