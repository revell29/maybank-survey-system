<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $data = [
            'branch_id' => 1,
            'level_1' => 1,
            'level_2' => null,
            'level_3' => null,
            'teller_id' => 1004,
        ];

        $this->post(route('home.store'), $data)
        ->assertStatus(200)
        ->assertJson($data);
    }
}
