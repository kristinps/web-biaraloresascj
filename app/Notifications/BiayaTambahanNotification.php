<?php

namespace App\Notifications;

use App\Models\Biaya;
use App\Models\PendaftaranPernikahan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BiayaTambahanNotification extends Notification
{
    use Queueable;

    public function __construct(
        public readonly Biaya $biaya,
        public readonly PendaftaranPernikahan $pendaftaran
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $nominal = 'Rp ' . number_format($this->biaya->nominal, 0, ',', '.');
        $namaBiaya = $this->biaya->nama ?: 'Biaya Tambahan';
        $periodeNama = $this->biaya->periode?->nama;

        $mail = (new MailMessage)
            ->subject('Informasi Biaya Tambahan Kursus Pernikahan | Biara Loresa SCJ')
            ->greeting('Yth. ' . $this->pendaftaran->nama_pria . ' & ' . $this->pendaftaran->nama_wanita)
            ->line('Admin menambahkan biaya tambahan untuk kursus pernikahan Anda.')
            ->line('**Nama Biaya:** ' . $namaBiaya)
            ->line('**Jumlah Biaya:** ' . $nominal);

        if ($periodeNama) {
            $mail->line('**Periode:** ' . $periodeNama);
        }

        if ($this->biaya->keterangan) {
            $mail->line('**Keterangan:** ' . $this->biaya->keterangan);
        }

        $mail->action('Login ke Dashboard', route('dashboard.user'));

        return $mail
            ->line('Silakan melakukan pembayaran biaya tambahan melalui menu Biaya di dashboard peserta.')
            ->salutation('Hormat kami, **Biara Loresa SCJ**');
    }
}

