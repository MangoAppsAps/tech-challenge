<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex302()
    {
        $response = $this->get(route('clients.index'));

        $response->assertStatus(302);
    }

    public function testIndex()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('clients.index'));

        $response->assertStatus(200);
    }
}
