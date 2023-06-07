<?php

namespace Tests\Feature\Models;

use App\Models\product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductModelTest extends TestCase
{
    use RefreshDatabase;
   public function  test_model_exists()
   {
       $product = product::factory()->create();
       $this->assertModelExists($product);
   }
}
