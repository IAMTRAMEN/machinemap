<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@mkgilze-africa.tn',
            'password' => Hash::make('1234'), // Change this password!
            'role' => 'admin',
        ]);

        $this->command->info('Admin user created:');
        $this->command->info('Email: admin@mkgilze-africa.tn');
        $this->command->info('Password: 1234');
        $this->command->warn('Please change the password after first login!');
    }
}