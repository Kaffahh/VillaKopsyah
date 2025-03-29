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
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

