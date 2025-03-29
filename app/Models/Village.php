<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model {
    protected $table = 'villages';
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['code', 'district_code', 'name'];
}

