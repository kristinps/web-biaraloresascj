<?php

namespace App\Notifications;

use App\Models\PeriodePernikahan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PeriodeTutupNotification extends Notification
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
            ->subject('Periode Kursus Telah Ditutup | Biara Loresa SCJ')
            ->greeting('Yth. ' . $notifiable->nama_pria . ' & ' . $notifiable->nama_wanita)
            ->line('Periode kursus pernikahan **' . $this->periode->nama . '** telah ditutup oleh admin.')
            ->line('Terima kasih telah mengikuti kursus. Jika Anda dinyatakan lulus, sertifikat akan dikirim melalui email terpisah.')
            ->line('Jika ada pertanyaan, silakan hubungi kami.')
            ->salutation('Hormat kami, **Biara Loresa SCJ**');
    }
}
