<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create();

        $this->call(ClientSeeder::class);
        $this->call(BookingSeeder::class);
        $this->call(JournalSeeder::class);
    }
}
