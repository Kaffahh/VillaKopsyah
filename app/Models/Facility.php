<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'detail'];

    public function villas()
    {
        return $this->belongsToMany(Villa::class, 'villa_facilities');
    }
}
