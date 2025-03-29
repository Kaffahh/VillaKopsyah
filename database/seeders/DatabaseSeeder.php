<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(\Laravolt\Indonesia\Seeds\DatabaseSeeder::class);

        $this->call([
            UserSeeder::class,
            CustomerSeeder::class,
            PetugasSeeder::class,
            PemilikVillaSeeder::class,
            VillaTypeSeeder::class,
            FacilitySeeder::class,
            VillaSeeder::class,
            TransactionSeeder::class,
        ]);
    }
}
