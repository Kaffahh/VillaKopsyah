<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillaPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'villa_id',
        'price_per_night',
    ];

    // Relasi ke Villa
    public function villa()
    {
        return $this->belongsTo(Villa::class, 'villa_id');
    }
}