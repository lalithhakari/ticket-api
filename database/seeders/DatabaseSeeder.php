<?php

namespace Database\Seeders;

use App\Models\Ticket;
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
        User::factory()
            ->has(Ticket::factory()->count(20))
            ->state([
                'email' => 'lalith@example.com',
            ])
            ->create();

        $users = User::factory(10)->create();

        Ticket::factory(100)
            ->recycle($users)
            ->create();
    }
}
