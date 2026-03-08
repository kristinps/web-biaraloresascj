<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PeriodeDihapusNotification extends Notification
{
    use Queueable;

    public function __construct(public readonly string $namaPeriode)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Periode Kursus Dihapus | Biara Loresa SCJ')
            ->greeting('Yth. ' . $notifiable->name . ',')
            ->line('Periode kursus **' . $this->namaPeriode . '** telah dihapus dari sistem oleh admin.')
            ->line('Pemberitahuan ini dikirim ke semua admin.')
            ->salutation('Hormat kami, **Biara Loresa SCJ**');
    }
}
