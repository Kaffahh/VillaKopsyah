<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\Villa;
use App\Models\VillaPrice;
use App\Models\VillaCapacity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VillaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat data villa
        $villa = Villa::create([
            'user_id' => 3,
            'name' => 'Villa Puncak Indah',
            'type_id' => 1,
            'description' => 'Villa nyaman dengan pemandangan pegunungan.',
            'location' => 'Puncak',
            'image' => 'villas/villa1.jpg',
            'status' => 'available',
            'created_by' => 3,
        ]);

        // Simpan harga ke tabel villa_prices
        $villa->prices()->create([
            'price_per_night' => 2000000, // Sesuaikan dengan nama kolom yang benar
        ]);

        // Simpan kapasitas ke tabel villa_capacities
        $villa->capacities()->create([
            'capacity' => 8,
        ]);

        // Ambil fasilitas tertentu untuk Villa ini
        $facilityIds = Facility::whereIn('name', ['AC', 'WiFi', 'TV'])->pluck('id')->toArray();
        $villa->facilities()->attach($facilityIds);
    }
}