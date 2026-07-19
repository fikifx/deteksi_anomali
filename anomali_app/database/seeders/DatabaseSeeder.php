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
        // Create Manajemen user
        User::updateOrCreate(
            ['email' => 'manajemen@gmail.com'],
            [
                'name' => 'Manajemen Pusat',
                'password' => Hash::make('password'),
                'role' => 'Manajemen',
            ]
        );

        // Create Kepala Kebun user
        User::updateOrCreate(
            ['email' => 'kebun@gmail.com'],
            [
                'name' => 'Kepala Kebun',
                'password' => Hash::make('password'),
                'role' => 'Kepala Kebun',
            ]
        );

        // Create Asisten Afdeling user
        User::updateOrCreate(
            ['email' => 'asisten@gmail.com'],
            [
                'name' => 'Asisten Afdeling',
                'password' => Hash::make('password'),
                'role' => 'Asisten Afdeling',
            ]
        );

        $this->call([
            NormaKerjaSeeder::class,
        ]);
    }
}
