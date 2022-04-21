<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = Client::all();

        foreach ($clients as $client) {
            $numberOfBookings = rand(0, 30);

            Booking::factory()->count($numberOfBookings)->create([
                'client_id' => $client->id,
            ]);
        }
    }
}
