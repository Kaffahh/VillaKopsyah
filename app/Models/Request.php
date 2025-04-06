<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\RequestExpiredNotification;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ktp_image',
        'kk_image',
        'villa_image',
        'other_documents',
        'status',
        'expired_at'
    ];
    protected $casts = [
        'expired_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessed($query)
    {
        return $query->whereIn('status', ['approved', 'rejected']);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    protected static function boot()
    {
        parent::boot();

        // Ketika request diupdate
        static::updated(function ($request) {
            // Jika status berubah menjadi rejected karena expired
            if ($request->isDirty('status') && $request->status === 'rejected' && $request->expired_at < now()) {
                $request->user->notify(new RequestExpiredNotification());
            }
        });
    }
}
