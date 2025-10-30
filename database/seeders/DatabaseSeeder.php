<?php

namespace Database\Seeders;

use App\Models\Player;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Player::factory(10)->create();

        Player::factory()->create([
            'name' => 'Test Player',
            'email' => 'test@example.com',
        ]);
    }
}
