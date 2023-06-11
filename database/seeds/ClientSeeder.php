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
        for ($i = 0; $i < 10; $i++) {
            // We could pick an existing user at random. But, for now, let's leave them as is, so we have users with
            // zero clients as well.
            $user = factory(User::class)->create();

            factory(Client::class, 10)->create([
                'created_by' => $user->id,
            ]);
        }
    }
}
