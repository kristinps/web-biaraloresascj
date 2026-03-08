<?php

namespace App\Notifications;

use App\Models\PeriodePernikahan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PeriodeDiperbaruiNotification extends Notification
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
            ->subject('Informasi Periode Kursus Diperbarui | Biara Loresa SCJ')
            ->greeting('Yth. ' . $notifiable->nama_pria . ' & ' . $notifiable->nama_wanita)
            ->line('Data periode kursus **' . $this->periode->nama . '** telah diperbarui oleh admin.')
            ->line('Tanggal mulai: ' . $this->periode->tanggal_mulai->format('d F Y'))
            ->line('Silakan perhatikan jadwal terbaru di dashboard peserta.')
            ->line('Jika ada pertanyaan, silakan hubungi kami.')
            ->salutation('Hormat kami, **Biara Loresa SCJ**');
    }
}
