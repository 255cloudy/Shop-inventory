<?php

namespace Tests\Feature\Models;

use App\Models\product;
use App\Models\sale;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SaleModelTest extends TestCase
{
    use RefreshDatabase;
    public function test_model_exist(){
        $product = product::factory()->create();
        $user = User::factory()->create();
        $sale = sale::factory()
            ->for($user, "user")
            ->for($product, "product")
            ->create();
        $this->assertModelExists($sale);
    }

    public function test_user_relationship(){
        $product = product::factory()->create();
        $user = User::factory()->create();
        $sale = sale::factory()
            ->for($user, "user")
            ->for($product, "product")
            ->create();
        $this->assertEquals($user->id, $sale->user->id);

    }

    public function test_products_relationship(){

        $product = product::factory()->create();
        $user = User::factory()->create();
        $sale = sale::factory()
            ->for($user, "user")
            ->for($product, "product")
            ->create();
        $this->assertEquals($product->id, $sale->product->id);
    }
}
