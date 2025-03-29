<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = [
            ['name' => 'AC', 'detail' => 'Air Conditioner 2PK'],
            ['name' => 'WiFi', 'detail' => 'WiFi with speed 100MB/s'],
            ['name' => 'TV', 'detail' => 'Television 100 Inch'],
            ['name' => 'Dapur', 'detail' => 'Full kitchen set'],
            ['name' => 'Kolam Renang', 'detail' => 'Private swimming pool'],
            ['name' => 'Parkir Gratis', 'detail' => 'Parking space for 5 cars'],
            ['name' => 'Sarapan Gratis', 'detail' => 'Free breakfast for 4 guests'],
        ];
        Facility::insert($facilities);

    }
}
