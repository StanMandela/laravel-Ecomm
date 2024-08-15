<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'smstan8@gmail.com',
            'password' => bcrypt('@stanley101'),
            'email_verified_at' => now(),
            'is_admin' => true
        ]);
    }
}
