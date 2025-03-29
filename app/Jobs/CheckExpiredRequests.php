<?php

namespace App\Jobs;

use App\Models\Request as VillaRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckExpiredRequests implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // Ambil request yang sudah expired (expired_at < sekarang)
        $expiredRequests = VillaRequest::where('status', 'pending')
            ->where('expired_at', '<', now())
            ->get();

        // Update status request yang expired
        foreach ($expiredRequests as $request) {
            $request->update(['status' => 'expired']);
            Log::info("Request ID {$request->id} telah expired.");
        }
    }
}