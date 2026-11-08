<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat akun admin default jika belum ada
        User::firstOrCreate(
            ['name' => 'admin'],
            [
                'email' => 'admin@komq.test',
                'password' => Hash::make('kominfodamai'),
            ]
        );
    }
}
