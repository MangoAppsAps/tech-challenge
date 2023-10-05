<?php

namespace Tests\Feature\Controllers\Booking;

use App\Booking;
use App\Client;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_not_allowed_to_view_when_not_logged_in(): void
    {
        $response = $this->getJson(route('bookings.index', ['client' => 1]));

        $response->assertUnauthorized();
    }

    public function test_not_allowed_to_view_when_logged_in_as_other_user(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->forUser($user)->create();
        Booking::factory()->forClient($client)->create();

        $otherUser = User::factory()->create();
        $otherClient = Client::factory()->forUser($otherUser)->create();
        Booking::factory()->forClient($otherClient)->create();

        $this->actingAs($user);

        $response = $this->getJson(route('bookings.index', [
            'client' => $otherClient->id,
        ]));

        $response->assertForbidden();
    }

    public function test_allowed_to_view_when_logged_in_as_correct_user(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->forUser($user)->create();
        Booking::factory()->forClient($client)->create();

        $this->actingAs($user);

        $response = $this->getJson(route('bookings.index', [
            'client' => $client->id,
        ]));

        $response->assertOk()
            ->assertJsonCount(1)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'start',
                        'end',
                        'notes',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);
    }

    public function test_not_allowed_to_destroy_when_not_logged_in(): void
    {
        $response = $this->deleteJson(route('bookings.destroy', ['client' => 1, 'booking' => 1]));

        $response->assertUnauthorized();
    }

    public function test_not_allowed_to_destroy_someone_else_booking(): void
    {
        $user = User::factory()->create();

        $otherUser = User::factory()->create();
        $otherClient = Client::factory()->forUser($otherUser)->create();
        $otherBooking = Booking::factory()->forClient($otherClient)->create();

        $this->actingAs($user);

        $response = $this->deleteJson(route('bookings.destroy', [
            'client' => $otherClient->id,
            'booking' => $otherBooking->id,
        ]));

        $response->assertForbidden();
    }

    public function test_allowed_to_destroy_own_booking(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->forUser($user)->create();
        $booking = Booking::factory()->forClient($client)->create();

        $this->actingAs($user);

        $response = $this->deleteJson(route('bookings.destroy', [
            'client' => $client->id,
            'booking' => $booking->id,
        ]));

        $response->assertOk();
    }
}
