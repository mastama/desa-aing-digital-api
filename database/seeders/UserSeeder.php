<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserFactory::new()->count(35)->create();
        Log::info('seeder.user: created factory users', ['count' => 35]);

        Log::info('seeder.user: done', ['total' => User::count()]);
    }
}
