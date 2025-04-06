<?php

namespace App\Jobs;

use App\Models\Request as VillaRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Notifications\RequestStatusNotification;

class CheckExpiredRequests implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        try {
            DB::beginTransaction();

            // Ambil request yang sudah expired (expired_at < sekarang) dan masih pending
            $expiredRequests = VillaRequest::where('status', 'pending')
                ->where('expired_at', '<', now())
                ->get();

            foreach ($expiredRequests as $request) {
                // Update status request menjadi rejected
                $request->update([
                    'status' => 'rejected'
                ]);

                // Kirim notifikasi ke user
                $request->user->notify(new RequestStatusNotification(
                    'rejected',
                    'Pengajuan Anda telah dibatalkan karena melewati batas waktu.'
                ));

                Log::info("Request ID {$request->id} telah expired dan dibatalkan.");
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error in CheckExpiredRequests job: " . $e->getMessage());
        }
    }
}
