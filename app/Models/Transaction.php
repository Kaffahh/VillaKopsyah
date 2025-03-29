<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'villa_id',
        'check_in',
        'check_out',
        'status',
        'total_price',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function villa()
    {
        return $this->belongsTo(Villa::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
