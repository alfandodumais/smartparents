<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Fernel Dumais',
            'email' => 'admin@admin.id',
            'password' => Hash::make('password'), // Ganti password sesuai kebutuhan
            'role' => 'admin',
        ]);
    }
}