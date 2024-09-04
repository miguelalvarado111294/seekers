<?php

namespace Database\Seeders;

use App\Models\cliente;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
            //cliente::factory(50)->create();

        $this->call(RoleSeeder::class);

    }
}
