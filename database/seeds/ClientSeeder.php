<?php

use App\User;
use App\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first() ?? User::factory()->create();

        Client::factory()->count(150)->forUser($user)->create();
    }
}
