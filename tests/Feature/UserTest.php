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
            'username' => "gavra",
            'password' => "rahasia",
            'name' => "gavra arva maheswara",
        ])->assertStatus(201)
            ->assertJson([
                "data" => [
                    "username" => "Gavra",
                    'name' => "Gavra Arva Maheswara"
                ]
            ]);
    }

    // public function testRegisterFailed()
    // {
    // }
    // public function testRegisterUsernameAlreadyExist()
    // {
    // }
}
