<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'villa_id',
        'gender',
        'address',
        // 'job',
        'birthdate',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'customer_id');
    }
    public function villa()
    {
        return $this->belongsTo(Villa::class);
    }
}
