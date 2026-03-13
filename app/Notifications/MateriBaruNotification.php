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
            ->when($this->materi->nama_pemateri, function (MailMessage $mail) {
                return $mail->line('Pemateri: **' . $this->materi->nama_pemateri . '**');
            })
            ->when($this->materi->tanggal_pelaksanaan, function (MailMessage $mail) {
                return $mail->line('Tanggal pelaksanaan: **' . $this->materi->tanggal_pelaksanaan->format('d M Y') . '**');
            })
            ->line('Anda dapat melihat jadwal lengkap materi melalui dashboard peserta.')
            ->action('Buka Dashboard', route('dashboard.user'))
            ->line('Jika ada pertanyaan, silakan hubungi kami.')
            ->salutation('Hormat kami, **Biara Loresa SCJ**');
    }
}
