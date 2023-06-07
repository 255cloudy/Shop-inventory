<?php

namespace Tests\Feature\Models;

use App\Models\asset_register;
use Tests\TestCase;

class AssetModelTest extends TestCase
{
   function test_model_exists(){
       $asset = asset_register::factory()->create();
       $this->assertModelExists($asset);
   }
}
