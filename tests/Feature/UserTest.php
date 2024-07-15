<?php

namespace Tests\Feature;

use Tests\TestCase;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    public function testRegisterSuccess()
    {
        $this->post('/api/users', [
            'username' => 'Gavra',
            'password' => 'rahasia',
            'name' => 'Gavra arva maheswara',
        ])->assertStatus(201)
            ->assertJson([
                "data" => [
                    'username' => 'Gavra',
                    'name' => 'Gavra arva maheswara'
                ]
            ]);
    }

    // public function testRegisterSuccess()
    // {
    //     $this->post('/api/users', [
    //         'username' => 'Gavra',
    //         'password' => 'rahasia',
    //         'name' => 'Gavra arva maheswara'
    //     ])->assertStatus(201)
    //         ->assertJson([
    //             "data" => [
    //                 'username' => 'Gavra',
    //                 'name' => 'Gavra arva maheswara'
    //             ]
    //         ]);
    // }


    public function testRegisterFailed()
    {
        $this->post('/api/users', [
            'username' => '',
            'password' => '',
            'name' => '',
        ])->assertStatus(400)
            ->assertJson([
                "errors" => [
                    'username' => [
                        "The username field is required."
                    ],
                    'password' => [
                        "The password field is required."
                    ],
                    'name' => [
                        "The name field is required."
                    ]
                ]
            ]);
    }
    public function testRegisterUsernameAlreadyExist()
    {
        $this->testRegisterSuccess();
        $this->post('/api/users', [
            'username' => 'Gavra',
            'password' => 'rahasia',
            'name' => 'Gavra arva maheswara',
        ])->assertStatus(400)
            ->assertJson([
                "errors" => [
                    'username' => [
                        'Username Already Registered',
                    ]
                ]
            ]);
    }

    public function testLoginSucces()
    {
        $this->seed([UserSeeder::class]);
        $this->post('/api/users/login', [
            'username' => 'test',
            'password' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    'username' => 'test',
                    'name' => 'test',
                ]
            ]);

        $user = User::where('username', 'test')->first();
        self::assertNotNull($user->token);
    }

    public function testLoginFailedUsernameNotFound()
    {
        $this->post('/api/users/login', [
            'username' => 'test',
            'password' => 'test'
        ])->assertStatus(401)
            ->assertJson([
                'errors' => [
                    "message" => [
                        "Username or Password Wrong"
                    ]
                ]
            ]);

    }

    public function testLoginPasswordWrong()
    {
        $this->seed([UserSeeder::class]);
        $this->post('/api/users/login', [
            'username' => 'test',
            'password' => 'salah'
        ])->assertStatus(401)
            ->assertJson([
                'errors' => [
                    "message" => [
                        "Username or Password Wrong"
                    ]
                ]
            ]);

    }
}
