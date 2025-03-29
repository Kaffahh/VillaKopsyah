<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model {
    protected $table = 'districts';
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['code', 'city_code', 'name'];
}
