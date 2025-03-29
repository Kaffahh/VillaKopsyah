<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fullname',
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
        'nomor_rumah',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'customer_id');
    }
}
