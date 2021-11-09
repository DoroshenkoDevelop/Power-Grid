<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Client;
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
        Client::factory()->times(100)->create()->each(function ($client)
        {
            /** @var Client $client */

            $client->account()->save(Account::factory()->create());
        });
    }
}
