<?php

namespace App\Notifications;

use App\Models\MateriKursus;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MateriBaruNotification extends Notification
{
    use Queueable;

    public function __construct(public readonly MateriKursus $materi)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Materi Kursus Baru: ' . $this->materi->judul . ' | Biara Loresa SCJ')
            ->greeting('Yth. ' . $notifiable->nama_pria . ' & ' . $notifiable->nama_wanita)
            ->line('Materi kursus baru telah ditambahkan untuk periode Anda: **' . $this->materi->judul . '**.')
            ->line('Link Zoom dan file materi akan dikirim melalui email terpisah apabila admin mengirimkannya.')
            ->line('Jika ada pertanyaan, silakan hubungi kami.')
            ->salutation('Hormat kami, **Biara Loresa SCJ**');
    }
}
