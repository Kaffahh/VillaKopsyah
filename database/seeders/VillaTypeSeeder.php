<?php

namespace Database\Seeders;

use App\Models\VillaType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VillaTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VillaType::create([
            'name' => 'Private Villa',
            'description' => 'Villa yang berfungsi untuk peristirahatan keluarga yang dimiliki oleh perorangan dan jarang digunakan untuk tujuan komersial. Private Villa biasanya berupa bangunan yang berdiri sendiri dan tidak terhubung dengan villa lainnya.',
        ]);
        VillaType::create([
            'name' => 'Resort Villa',
            'description' => 'Resort Villa merupakan villa yang komposisi bangunannya terpisah pisah seperti halnya sebuah kawasan villa. Pelayanan villa berbintang dengan segala kelebihan fasilitasnya dapat ditemukan pada villa jenis ini. Tentu saja resort villa dibangun dengan tujuan komersial untuk memperoleh keuntungan dan penyewaan masing-masing unit villa.',
        ]);
    }
}
