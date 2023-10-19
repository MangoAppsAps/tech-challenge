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
//        $user = User::first() ?? factory(User::class)->create();
//
//        factory(Client::class, 50)->create([
//            'user_id' => $user->id
//        ]);

        factory(User::class)->create();

        $users = User::all();
        foreach ($users as $user) {
            factory(Client::class, 5)->create([
                'user_id' => $user->id
            ]);
        }
    }
}
