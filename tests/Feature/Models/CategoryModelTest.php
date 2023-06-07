<?php

namespace Tests\Feature\Models;

use App\Models\categories;
use App\Models\expense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryModelTest extends TestCase
{
    use RefreshDatabase;
   public function test_model_exists_in_db(){
       $category = categories::factory()->create();
       $this->assertModelExists($category);
   }
   public function test_expenses_relationships(){
       $category = categories::factory()->create();
       $expenses = expense::factory()->for(
           $category, "category"
       )->count(3)->create();
       $this->assertEquals($category->id, $expenses[2]->category->id);

   }
}
