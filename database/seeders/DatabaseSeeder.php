<?php

namespace Database\Seeders;

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
        \App\Models\User::factory()->create([
            'name' => 'AlexNeo68',
            'email' => 'test@test.test'
        ]);
        \App\Models\User::factory()->create([
            'name' => 'AlexNeo68_1',
            'email' => 'test1@test.test'
        ]);
        \App\Models\User::factory()->create([
            'name' => 'AlexNeo68_2',
            'email' => 'test2@test.test'
        ]);
    }
}
