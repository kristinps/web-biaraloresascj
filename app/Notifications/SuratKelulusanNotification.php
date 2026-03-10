<?php

namespace App\Notifications;

use App\Models\PendaftaranPernikahan;
use App\Models\SuratKelulusan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuratKelulusanNotification extends Notification
{
    use Queueable;

    public function __construct(
        public readonly PendaftaranPernikahan $pendaftaran,
        public readonly SuratKelulusan $surat
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $loginUrl = route('login');

        return (new MailMessage)
            ->subject('Sertifikat Kelulusan Kursus Pernikahan Anda Siap | Biara Loresa SCJ')
            ->greeting('Yth. ' . $this->pendaftaran->nama_pria . ' & ' . $this->pendaftaran->nama_wanita)
            ->line('**Selamat! Sertifikat kelulusan kursus pernikahan Anda sudah tersedia.**')
            ->line('Periode: **' . optional($this->pendaftaran->periode)->nama . '**')
            ->line('Silakan login ke dashboard peserta untuk melihat dan mengunduh sertifikat kelulusan Anda.')
            ->action('Login ke Dashboard Peserta', $loginUrl)
            ->line('Jika tombol di atas tidak berfungsi, Anda dapat membuka alamat berikut secara manual:')
            ->line($loginUrl)
            ->salutation('Hormat kami, Biara Loresa SCJ');
    }
}

