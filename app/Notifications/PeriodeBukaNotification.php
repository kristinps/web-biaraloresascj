<?php

namespace App\Notifications;

use App\Models\PeriodePernikahan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PeriodeBukaNotification extends Notification
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
            ->subject('Periode Kursus Diaktifkan Kembali | Biara Loresa SCJ')
            ->greeting('Yth. ' . $notifiable->nama_pria . ' & ' . $notifiable->nama_wanita)
            ->line('Periode kursus pernikahan **' . $this->periode->nama . '** telah diaktifkan kembali oleh admin.')
            ->line('Silakan perhatikan jadwal dan informasi yang akan dikirim untuk periode ini.')
            ->line('Jika ada pertanyaan, silakan hubungi kami.')
            ->salutation('Hormat kami, **Biara Loresa SCJ**');
    }
}
