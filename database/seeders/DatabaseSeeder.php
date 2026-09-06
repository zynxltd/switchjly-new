<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * Default passwords (change in production):
     * - admin@switchly.test / password
     * - affiliate@switchly.test / password
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@switchly.test'],
            [
                'name' => 'Switchly Admin',
                'password' => 'password',
                'role' => User::ROLE_ADMIN,
                'referral_code' => null,
                'commission_rate' => 0,
                'email_verified_at' => now(),
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'affiliate@switchly.test'],
            [
                'name' => 'Demo Affiliate',
                'password' => 'password',
                'role' => User::ROLE_AFFILIATE,
                'referral_code' => 'DEMOAFF1',
                'commission_rate' => 30,
                'email_verified_at' => now(),
            ],
        );
    }
}
