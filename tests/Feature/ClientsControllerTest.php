<?php

namespace Tests\Feature;

use App\User;
use App\Client;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class ClientsControllerTest extends TestCase
{

    /**
     * Test the show action and make sure that the user can only access own
     * clients and that the client bookings are included in the response.
     */
    public function testShowWithBookings(): void
    {
        DB::beginTransaction();

        $user = User::first() ?? factory(User::class)->create();
        $this->actingAs($user);

        // Create a new client for this test
        $client = new Client();
        $client->name = "Test show";
        $client->email = "test@example.com";
        $client->phone = "123456";
        $client->user_id = $user->id;
        $client->saveOrFail();

        // Fetch the created client though the controller
        $response = $this->get('/clients/' . $client->id);
        $response->assertStatus(200);

        $response->assertViewIs('clients.show');
        $response->assertViewHas('client', function ($clientData) {
            $clientArray = $clientData->toArray();
            // Assert that the client data includes the bookings
            $this->assertArrayHasKey('bookings', $clientArray);
            $this->assertIsArray($clientArray['bookings']);

            return true;
        });

        // Assign the client to a different user
        $client->user_id = null;
        $client->saveOrFail();

        // Fetch the client again and expect status Forbidden
        $response = $this->get('/clients/' . $client->id);
        $response->assertStatus(403);

        DB::rollBack();
    }
}
