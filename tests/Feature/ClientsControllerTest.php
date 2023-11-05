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

    /**
     * Test the index action and the ordering.
     */
    public function testIndexAndOrder(): void
    {
        DB::beginTransaction();

        $user = User::first() ?? factory(User::class)->create();
        $this->actingAs($user);
    
        // Create a new client for this test
        $first = new Client();
        $first->name = "Test index 1";
        $first->email = "test1@example.com";
        $first->phone = "123456";
        $first->user_id = $user->id;
        $first->saveOrFail();

        // Sleep for one second to prevent clients from being created on the same second
        // TODO: Solve this in a more elegant way as we don't want to have arbitrary
        //       sleep periods spread around our tests affecting the performance.
        sleep(1);

        // Create a new client for this test
        $latest = new Client();
        $latest->name = "Test index 2";
        $latest->email = "test2@example.com";
        $latest->phone = "654321";
        $latest->user_id = $user->id;
        $latest->saveOrFail();

        // Fetch the clients from the index action
        $response = $this->get('/clients');
        $response->assertStatus(200);

        $response->assertViewIs('clients.index');
        $response->assertViewHas('clients', function ($clients) use ($latest) {
            // Assert that the first client returned, is the 
            // new client we created during this test.
            $this->assertTrue($latest->is($clients->first()));
            return true;
        });

        DB::rollBack();
    }

    /**
     * Test the store action.
     */
    public function testStore(): void
    {
        DB::beginTransaction();

        $user = User::first() ?? factory(User::class)->create();
        $this->actingAs($user);

        // Test without phone
        $response = $this->postJson('/clients', [
            "name" => "Test index 1",
            "email" => "test1@example.com",
            "address" => "Test address",
            "zip" => "00000",
            "country" => "Test country",
        ]);

        $response->assertStatus(201);

        // Test without email
        $response = $this->postJson('/clients', [
            "name" => "Test index 1",
            "phone" => "123456",
            "address" => "Test address",
            "zip" => "00000",
            "country" => "Test country",
        ]);

        $response->assertStatus(201);

        DB::rollBack();
    }

    /**
     * Test validation fo the store action.
     */
    public function testValidation(): void
    {
        DB::beginTransaction();

        $user = User::first() ?? factory(User::class)->create();
        $this->actingAs($user);

        // Test all the required fields
        $response = $this->postJson('/clients', []);
        $response->assertStatus(422);

        $expected = [
            "message" => "The given data was invalid.",
            "errors" => [
                "name" => [
                    "The name field is required."
                ],
                "email" => [
                    "The email field is required when phone is not present."
                ],
                "phone" => [
                    "The phone field is required when email is not present."
                ]
            ]
        ];
        $this->assertEquals($expected, $response->json());
       

        // Test invalid input
        $response = $this->postJson('/clients', [
            "name" => bin2hex(random_bytes(100)), // generate string with 200 chars
            "email" => "non_valid_email",
            "phone" => "non_valid_phone",
        ]);
        $response->assertStatus(422);

        $expected = [
            "message" => "The given data was invalid.",
            "errors" => [
                "name" => [
                    "The name may not be greater than 190 characters.",
                ],
                "email" =>[
                    "The email must be a valid email address.",
                ],
                "phone" => [
                    "The phone format is invalid.",
                ]
            ]
        ];
        $this->assertEquals($expected, $response->json());

        DB::rollBack();
    }
}
