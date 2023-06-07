<?php

namespace Tests\Feature\Models;

use App\Models\distributer;
use App\Models\order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderModelTest extends TestCase
{
    use RefreshDatabase;
   public function test_model_exists(){
       $user = User::factory()->create();
       $distributer = distributer::factory()->create();
       $order = order::factory()->for(
           $user,"user"
       )->for($distributer, "distributer")->create();
       $this->assertModelExists($order);
   }

   public function test_distributer_relationship(){
       $user = User::factory()->create();
       $distributer = distributer::factory()->create();
       $order = order::factory()->for(
           $user,"user"
       )->for($distributer, "distributer")->create();
       $this->assertEquals($distributer->id, $order->distributer->id);
   }
   public function test_received_by_relationship(){
       $user = User::factory()->create();
       $distributer = distributer::factory()->create();
       $order = order::factory()->for(
           $user,"user"
       )->for($distributer, "distributer")->create();
       $this->assertEquals($user->id, $order->user->id);
   }
}
