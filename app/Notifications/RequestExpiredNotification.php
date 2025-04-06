<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestExpiredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Pengajuan Anda Telah Expired')
            ->line('Pengajuan Anda untuk menjadi pemilik villa telah dibatalkan karena melewati batas waktu.')
            ->line('Silakan mengajukan ulang jika Anda masih berminat.')
            ->action('Ajukan Ulang', url('/requests/create'));
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Pengajuan Anda telah dibatalkan karena expired.',
            'type' => 'request_expired'
        ];
    }
}
