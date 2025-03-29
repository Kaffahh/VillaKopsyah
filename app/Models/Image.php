<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = [
        'villa_id',
        'url',
    ];
    public function villa()
    {
        return $this->belongsTo(Villa::class);
    }
}

