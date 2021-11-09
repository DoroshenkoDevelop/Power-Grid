<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\User;
use Database\Factories\AccountFactory;
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
        $this->call([
            UserSeeder::class,
            ClientSeeder::class,
        ]);
    }
}
