<?php

namespace Tests\Feature\Models;

use App\Models\product;
use App\Models\stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockModelTest extends TestCase
{
    use RefreshDatabase;
   public function test_model_exists(){
       $product = product::factory()->create();
       $stock = stock::factory()->for($product, "product")->create();
       $this->assertModelExists($stock);
   }
    public function test_product_relationship(){
        $product = product::factory()->create();
        $stock = stock::factory()->for($product, "product")->create();
        $this->assertEquals($product->id, $stock->product->id);
    }

}
