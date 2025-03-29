<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $status;
    protected $message;

    public function __construct($status, $message)
    {
        $this->status = $status;
        $this->message = $message;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database']; // Kirim notifikasi via email dan simpan ke database
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Status Pengajuan Anda')
            ->line('Status pengajuan Anda telah diperbarui.')
            ->line('Status: ' . $this->status)
            ->line('Pesan: ' . $this->message)
            ->action('Lihat Status', url('/dashboard-customers'))
            ->line('Terima kasih telah menggunakan layanan kami!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'url' => url('/dashboard-customers'),
        ];
    }
}
