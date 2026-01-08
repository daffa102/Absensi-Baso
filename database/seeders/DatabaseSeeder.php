<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TahunAjar;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Users (Admin & Guru)
        // Note: User model has 'password' => 'hashed' cast, so we provide plain text.
        
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrator',
                'password' => 'password', // Will be hashed by model cast
                'role' => 'admin',
            ]
        );

        // Guru Piket
        User::updateOrCreate(
            ['email' => 'guru@guru.com'],
            [
                'name' => 'Guru Piket',
                'password' => 'password', // Will be hashed by model cast
                'role' => 'guru_piket',
            ]
        );

        // 3. Create Tahun Ajar
        $tahunAjar = TahunAjar::updateOrCreate(
            ['nama' => '2024/2025'],
            ['aktif' => true]
        );

        // 4. Create 10 Kelas
        $classes = [
            'XII RPL 1', 'XII RPL 2',
            'XII TKJ 1', 'XII TKJ 2',
            'XI RPL 1', 'XI RPL 2',
            'XI TKJ 1', 'XI TKJ 2',
            'X RPL 1', 'X TKJ 1'
        ];

        $kelasModels = [];
        foreach ($classes as $className) {
            $kelasModels[] = Kelas::updateOrCreate(['nama_kelas' => $className]);
        }

        // 5. Create 100 Siswa
        // We will distribute 100 students into the 10 classes created above
        for ($i = 0; $i < 100; $i++) {
            Siswa::create([
                'nis' => fake()->unique()->numerify('2024#####'),
                'nama' => fake()->name(),
                'kelas_id' => $kelasModels[array_rand($kelasModels)]->id,
                'tahun_ajar_id' => $tahunAjar->id,
            ]);
        }
    }
}
