<?php

namespace App\Notifications;

use App\Models\PendaftaranPernikahan;
use App\Models\PeriodePernikahan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PindahJadwalNotification extends Notification
{
    use Queueable;

    public function __construct(
        public readonly PendaftaranPernikahan $pendaftaran,
        public readonly PeriodePernikahan $periodeBaru
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pendaftaran Dipindah ke Periode Baru | Biara Loresa SCJ')
            ->greeting('Yth. ' . $this->pendaftaran->nama_pria . ' & ' . $this->pendaftaran->nama_wanita)
            ->line('Pendaftaran kursus pernikahan Anda telah dipindahkan ke periode berikut:')
            ->line('**' . $this->periodeBaru->nama . '**')
            ->line('Tanggal mulai: ' . $this->periodeBaru->tanggal_mulai->format('d F Y'))
            ->line('Silakan perhatikan jadwal dan informasi yang akan dikirim untuk periode ini.')
            ->line('Jika ada pertanyaan, silakan hubungi kami.')
            ->salutation('Hormat kami, **Biara Loresa SCJ**');
    }
}
