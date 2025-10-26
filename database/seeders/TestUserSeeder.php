<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\Subscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@texvia.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create a company profile for the test user
        Company::create([
            'user_id' => $user->id,
            'name' => 'Test Company BV',
            'industry' => 'Technology',
            'tone_of_voice' => 'professional',
            'keywords' => ['innovation', 'technology', 'Netherlands', 'business'],
        ]);

        // Create a subscription for the test user
        Subscription::create([
            'user_id' => $user->id,
            'plan' => 'free',
            'limit' => 10,
            'used' => 2,
            'renew_date' => now()->addMonth(),
        ]);

        $this->command->info('Test user created: test@texvia.com (password: password)');
    }
}
