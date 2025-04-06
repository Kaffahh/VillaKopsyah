<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemilikVilla extends Model
{
    protected $table = 'pemilik_villa';

    protected $fillable = [
        'user_id',
        'gender',
        // 'address',
        // 'job',
        'birthdate',
        'province_code',
        'city_code',
        'district_code',
        'village_code',
        'rtrw',
        'kode_pos',
        'nomor_rumah'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_code', 'code');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_code', 'code');
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'village_code', 'code');
    }
}
