<?php

namespace App\Notifications;

use App\Models\PeriodePernikahan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PeriodeBaruNotification extends Notification
{
    use Queueable;

    public function __construct(public readonly PeriodePernikahan $periode)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Periode Kursus Baru Dibuat: ' . $this->periode->nama . ' | Biara Loresa SCJ')
            ->greeting('Yth. ' . $notifiable->name . ',')
            ->line('Periode kursus pernikahan baru telah dibuat di dashboard: **' . $this->periode->nama . '**.')
            ->line('Tanggal mulai: ' . $this->periode->tanggal_mulai->format('d F Y'))
            ->line('Anda dapat mengelola pendaftaran dan materi untuk periode ini di dashboard.')
            ->salutation('Hormat kami, **Biara Loresa SCJ**');
    }
}
