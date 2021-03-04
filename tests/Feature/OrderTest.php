<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;
    /**
     * 
     *
     * @return void
     */
    public function testAuthenticatedUserCanSeeAllHisOrder()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        // $this->actingAs($user);
        $this->json('get', '/api/order', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'message',
                'data'
            ]);
    }

    public function testRequiredFieldForCreateOrder()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->json('post', '/api/order', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'quantity' => ['The quantity field is required.']
                ] 
            ]);
    }

    public function testAuthenticatedUserCanCreateOrder()
    {
        $this->withoutExceptionHandling();
        Ticket::create([
            'id' => 1,
            'price' => 10000
        ]);
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        
        $data = [
            'quantity' => 2
        ];
        
        $this->json('post', '/api/order', $data, ['Accept' => 'application/json'])
        ->assertStatus(200)
        ->assertJsonStructure([
            'code',
            'message',
            'data'
            ]);
        }

}