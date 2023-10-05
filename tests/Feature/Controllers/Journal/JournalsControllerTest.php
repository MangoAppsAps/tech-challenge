<?php

namespace Tests\Feature\Controllers\Journal;

use App\Client;
use App\Journal;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JournalsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_not_allowed_to_view_when_not_logged_in(): void
    {
        $response = $this->getJson(route('journals.index', ['client' => 1]));

        $response->assertUnauthorized();
    }

    public function test_not_allowed_to_view_when_logged_in_as_other_user(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->forUser($user)->create();
        Journal::factory()->forClient($client)->create();

        $otherUser = User::factory()->create();
        $otherClient = Client::factory()->forUser($otherUser)->create();
        Journal::factory()->forClient($otherClient)->create();

        $this->actingAs($user);

        $response = $this->getJson(route('journals.index', [
            'client' => $otherClient->id,
        ]));

        $response->assertForbidden();
    }

    public function test_allowed_to_view_when_logged_in_as_correct_user(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->forUser($user)->create();
        Journal::factory()->forClient($client)->create();

        $this->actingAs($user);

        $response = $this->getJson(route('journals.index', [
            'client' => $client->id,
        ]));

        $response->assertOk()
            ->assertJsonCount(1)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'date',
                        'text',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);
    }

    public function test_not_allowed_to_store_when_not_logged_in(): void
    {
        $response = $this->postJson(
            route('journals.store', ['client' => 1]),
            [
                'date' => '2021-01-01',
                'text' => 'Some text',
            ]
        );

        $response->assertUnauthorized();
    }

    public function test_not_allowed_to_store_in_someone_else_client(): void
    {
        $user = User::factory()->create();

        $otherUser = User::factory()->create();
        $otherClient = Client::factory()->forUser($otherUser)->create();

        $this->actingAs($user);

        $response = $this->postJson(
            route('journals.store', ['client' => $otherClient->id]),
            [
                'date' => '2021-01-01',
                'text' => 'Some text',
            ]
        );

        $response->assertForbidden();
    }

    public function test_validates_when_storing_in_correct_client(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->forUser($user)->create();

        $this->actingAs($user);

        $response = $this->postJson(
            route('journals.store', ['client' => $client->id]),
        );

        $response->assertUnprocessable()
            ->assertJsonMissing([
                'date' => 'The date field is required.',
                'text' => 'The text field is required.',
            ]);
    }

    public function test_can_store_journal_in_correct_client(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->forUser($user)->create();

        $this->actingAs($user);

        $response = $this->postJson(
            route('journals.store', ['client' => $client->id]),
            [
                'date' => '2021-01-01',
                'text' => 'Some text',
            ],
        );

        $response->assertCreated();
    }

    public function test_not_allowed_to_destroy_when_not_logged_in(): void
    {
        $response = $this->deleteJson(route('journals.destroy', ['client' => 1, 'journal' => 1]));

        $response->assertUnauthorized();
    }

    public function test_not_allowed_to_destroy_someone_else_journal(): void
    {
        $user = User::factory()->create();

        $otherUser = User::factory()->create();
        $otherClient = Client::factory()->forUser($otherUser)->create();
        $otherJournal = Journal::factory()->forClient($otherClient)->create();

        $this->actingAs($user);

        $response = $this->deleteJson(route('journals.destroy', [
            'client' => $otherClient->id,
            'journal' => $otherJournal->id,
        ]));

        $response->assertForbidden();
    }

    public function test_allowed_to_destroy_own_journal(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->forUser($user)->create();
        $journal = Journal::factory()->forClient($client)->create();

        $this->actingAs($user);

        $response = $this->deleteJson(route('journals.destroy', [
            'client' => $client->id,
            'journal' => $journal->id,
        ]));

        $response->assertOk();
    }
}
