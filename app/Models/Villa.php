<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Villa extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_id',
        'user_id',
        'name',
        'description',
        'location',
        'image',
        'status',
        'created_by',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}
    // Relasi ke VillaType
    public function type()
    {
        return $this->belongsTo(VillaType::class, 'type_id');
    }

    public function prices()
    {
        return $this->hasMany(VillaPrice::class);
    }

    public function capacities()
    {
        return $this->hasMany(VillaCapacity::class);
    }

    // Relasi ke Transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'villa_facilities');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
