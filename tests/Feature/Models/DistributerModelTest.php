<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\distributer;

class DistributerModelTest extends TestCase
{
    use RefreshDatabase;

    function test_distributer_created()
    {
        $distributer = distributer::factory()->create();
        $this->assertModelExists($distributer);
    }
}
