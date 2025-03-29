<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
        protected $table = 'provinces';
        protected $primaryKey = 'code';
        public $incrementing = false;
        protected $keyType = 'string';
        protected $fillable = ['code', 'name'];
   
}
