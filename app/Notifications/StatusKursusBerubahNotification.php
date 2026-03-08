<?php

namespace App\Notifications;

use App\Models\PendaftaranPernikahan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusKursusBerubahNotification extends Notification
{
    use Queueable;

    public function __construct(
        public readonly PendaftaranPernikahan $pendaftaran,
        public readonly string $statusKursus
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $label = match ($this->statusKursus) {
            'terjadwal' => 'Terjadwal',
            'sedang_berjalan' => 'Sedang Berjalan',
            'lulus' => 'Lulus',
            'tidak_lulus' => 'Tidak Lulus',
            default => $this->statusKursus,
        };

        return (new MailMessage)
            ->subject("Status Kursus Diperbarui: {$label} | Biara Loresa SCJ")
            ->greeting('Yth. ' . $this->pendaftaran->nama_pria . ' & ' . $this->pendaftaran->nama_wanita)
            ->line('Status kursus pernikahan Anda telah diperbarui oleh admin.')
            ->line("**Status saat ini: {$label}**")
            ->line('Jika ada pertanyaan, silakan hubungi kami.')
            ->salutation('Hormat kami, **Biara Loresa SCJ**');
    }
}
