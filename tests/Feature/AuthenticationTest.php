<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRequiredFiledsForRegistration()
    {
        $this->json('POST', 'api/register', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                'message' => "The given data was invalid.",
                'errors' => [
                    'name' => ['The name field is required.'],
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ]
            ]);
    }

    public function testSuccessfulRegistration()
    {
        $userData = [
            'name' => 'kodok',
            'email' => 'kodok@kodok.com',
            'password' => 'kodok123',
        ];

        $this->json('post', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'message'
            ]);
    }

    public function testLoginMustEnterEmailAndPassword()
    {
        // $this->withoutExceptionHandling();
        $this->json('post', 'api/login', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.']
                ]
            ]);
    }

    public function testEmailAndPasswordMustMatch()
    {
        // $this->withoutExceptionHandling();

        User::factory()->create([
            'name' => 'kodok',
            'email' => 'kodok@kodok.com',
            'password' => 'kodok123'
        ]);

        $loginData = [
            'email' => 'kodok@kodok.com',
            'password' => 'testing123'
        ];

        $this->json('post', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => ['Email and password does not match.']
                ]
            ]);
    }

    public function testSuccessfulLogin()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create([
            'name' => 'kodok',
            'email' => 'kodok@kodok.com',
            'password' => Hash::make('kodok123')
        ]);

        $loginData = [
            'email' => 'kodok@kodok.com',
            'password' => 'kodok123'
        ];
        
        $this->json('post', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'message',
                'data',
                'token',
            ]);
        $this->assertAuthenticated();
    }
}
