<?php

namespace Database\Seeders;

use App\Models\Petugas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Petugas::create([            
            'user_id' => 4,
            'address' => 'Jl. TC No. 1',
            'gender' => 'Male',
            'birthdate' => '2000-1-10',
        ]);
    }
}
