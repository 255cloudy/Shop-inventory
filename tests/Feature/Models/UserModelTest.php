<?php

namespace Tests\Feature\Models;

use App\Models\distributer;
use App\Models\order;
use App\Models\product;
use App\Models\sale;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;
//    set up the user
    public function test_user_created_in_database()
    {
        $user = User::factory()->create();
        $this->assertModelExists($user);
    }

    public function test_user_with_sales()
    {
        $product = Product::factory()->create();
        $user = User::factory()->create();
        $sale = sale::factory()->for($user, 'User')->for($product, "product")->create();
        $this->assertModelExists($user);
        $this->assertModelExists($product);
        $this->assertEquals($sale->user->id, $user->id);
    }
    public function test_orders_rlationship(){
        $user = User::factory()->create();
        $distributer = distributer::factory()->create();
//        order stuff
        $order = new order();
        $order->total = 10000.50;
        $order->user_id = $user->id;
        $order->distributer_id = $distributer->id;
        $order->save();
//        sale stuff
        $product = product::factory()->create();
        $sale = new sale();
        $sale->sale_price = 500;
        $sale->product_id = $product->id;
        $sale->user_id = $user->id;
        $sale->save();
        $this->assertEquals($order->id, $user->orders[0]->id);

    }
}
