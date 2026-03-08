<?php

namespace App\Notifications;

use App\Models\PeriodePernikahan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AbsensiDisimpanNotification extends Notification
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
            ->subject('Data Kehadiran Kursus Telah Diperbarui | Biara Loresa SCJ')
            ->greeting('Yth. ' . $notifiable->nama_pria . ' & ' . $notifiable->nama_wanita)
            ->line('Data kehadiran kursus pernikahan Anda untuk periode **' . $this->periode->nama . '** telah diperbarui oleh admin.')
            ->line('Anda dapat memeriksa status kehadiran dan status kursus di dashboard peserta.')
            ->line('Jika ada pertanyaan, silakan hubungi kami.')
            ->salutation('Hormat kami, **Biara Loresa SCJ**');
    }
}
