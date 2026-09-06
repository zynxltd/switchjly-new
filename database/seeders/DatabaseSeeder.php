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
     * - admin@brillia.test / password
     * - affiliate@brillia.test / password
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@brillia.test'],
            [
                'name' => 'Brillia Admin',
                'password' => 'password',
                'role' => User::ROLE_ADMIN,
                'referral_code' => null,
                'commission_rate' => 0,
                'email_verified_at' => now(),
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'affiliate@brillia.test'],
            [
                'name' => 'Demo Affiliate',
                'password' => 'password',
                'role' => User::ROLE_AFFILIATE,
                'referral_code' => 'DEMOAFF1',
                'commission_rate' => 30,
                'email_verified_at' => now(),
            ],
        );

        $this->call(CmsSeeder::class);
    }
}
