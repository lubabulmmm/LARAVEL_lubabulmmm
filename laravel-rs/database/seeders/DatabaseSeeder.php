<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\RumahSakit;
use App\Models\Pasien;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create test user
        User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create sample hospital
        $rumahSakit = RumahSakit::create([
            'nama_rumah_sakit' => 'RS Example',
            'alamat' => 'Jl. Example No. 1',
            'email' => 'rs@example.com',
            'telepon' => '08123456789',
        ]);

        // Create a new hospital
        $rumahSakit = RumahSakit::create([
            'nama_rumah_sakit' => 'RS Contoh',
            'alamat' => 'Jl. Contoh No. 123',
            'email' => 'rs@contoh.com',
            'telepon' => '08123456789'
        ]);

        // Create a patient associated with the hospital
        $pasien = Pasien::create([
            'nama_pasien' => 'John Doe',
            'alamat' => 'Jl. Pasien No. 45',
            'no_telepon' => '087654321',
            'rumah_sakit_id' => $rumahSakit->id
        ]);

        // Get all patients from a hospital
        $allPasien = $rumahSakit->pasien;

        // Get hospital of a patient
        $hospital = $pasien->rumahSakit;
    }
}
