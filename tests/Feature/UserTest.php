<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
}
