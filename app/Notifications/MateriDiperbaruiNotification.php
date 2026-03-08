<?php

namespace App\Notifications;

use App\Models\MateriKursus;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MateriDiperbaruiNotification extends Notification
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
            ->subject('Materi Kursus Diperbarui: ' . $this->materi->judul . ' | Biara Loresa SCJ')
            ->greeting('Yth. ' . $notifiable->nama_pria . ' & ' . $notifiable->nama_wanita)
            ->line('Materi kursus **' . $this->materi->judul . '** telah diperbarui oleh admin.')
            ->line('Silakan periksa jadwal materi dan link Zoom terbaru di dashboard peserta.')
            ->line('Jika ada pertanyaan, silakan hubungi kami.')
            ->salutation('Hormat kami, **Biara Loresa SCJ**');
    }
}
