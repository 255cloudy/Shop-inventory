<?php

namespace Tests\Feature\Models;

use App\Models\categories;
use App\Models\expense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpensesModelTest extends TestCase
{
    use RefreshDatabase;

    function test_model_exists_in_db()
    {
        $category = categories::factory()->create();
        $expenses = expense::factory()
            -> state([
                "category_id"=> $category->id
            ])->create();
        $this->assertModelExists($expenses);
    }
    function  test_categories_relationship(){
        $category = categories::factory()->create();
        $expense = expense::factory()->for(
        $category, "category"
        )->create();
        $this->assertEquals($category->id, $expense->category->id);
    }
}
