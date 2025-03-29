<?php

namespace Database\Seeders;

use App\Models\PemilikVilla;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PemilikVillaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PemilikVilla::create([            
            'user_id' => 3,
            // 'address' => 'Jl. Gweh No. 1',
            'gender' => 'Male',
            // 'job' => '-',
            'birthdate' => '1945-08-17',
        ]);
    }
}
