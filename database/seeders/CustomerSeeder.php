<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'user_id' => 5,
            'fullname' => 'Customersssss',
            // 'address' => 'Jl. Pahlawan No. 1',
            'gender' => 'Male',
            // 'job' => 'Programmer',
            'birthdate' => '2000-01-01',
            'province_code' => '31',
            'city_code' => '3101',
            'district_code' => '310101',
            'village_code' => '3101011001',
            'rtrw' => 'RT.01 RW.01',
            'kode_pos' => '11410',
            'nomor_rumah' => '01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
