<?php

namespace Tests\Feature;

use App\Client;
use Tests\TestCase;
use RuntimeException;
use Illuminate\Support\Facades\DB;

class ClientsControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Omit the authentication
        // Note: This might lead to unwanted side effects but let's
        //       not make it an issue before it turns into one.
        $this->withoutMiddleware();
    }

    /**
     * Test the show action and make sure that the client bookings are included.
     */
    public function testShowWithBookings(): void
    {
        DB::beginTransaction();

        // Fetch the first client which we use for testing
        $firstClient = Client::first();
        if ($firstClient === null) {
            throw new RuntimeException('The database in missing client. Run seeders.');
        }

        // Fetch the first client though the controller
        $response = $this->get('/clients/' . $firstClient->id);
        $response->assertStatus(200);

        $response->assertViewIs('clients.show');
        $response->assertViewHas('client', function ($client) {
            $clientArray = $client->toArray();
            // Assert that the client data includes the bookings
            $this->assertArrayHasKey('bookings', $clientArray);
            $this->assertIsArray($clientArray['bookings']);

            return true;
        });

        DB::rollBack();
    }
}
