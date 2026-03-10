<?php

namespace App\Notifications;

use App\Models\BiayaTagihan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BiayaTagihanLunasNotification extends Notification
{
    use Queueable;

    public function __construct(public readonly BiayaTagihan $tagihan)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $biaya = $this->tagihan->biaya;
        $pendaftaran = $this->tagihan->pendaftaran;

        $nominal = $biaya
            ? 'Rp ' . number_format($biaya->nominal, 0, ',', '.')
            : '—';

        $namaBiaya = $biaya?->nama ?: 'Biaya Tambahan';
        $periodeNama = $biaya?->periode?->nama;

        $mail = (new MailMessage)
            ->subject('Pembayaran Biaya Tambahan Lunas | Biara Loresa SCJ')
            ->greeting('Yth. Admin Biara Loresa SCJ')
            ->line('Seorang peserta telah menyelesaikan pembayaran biaya tambahan.')
            ->line('**Peserta:** ' . ($pendaftaran?->namaLengkap() ?? '-'))
            ->when($pendaftaran?->email, function (MailMessage $m) use ($pendaftaran) {
                return $m->line('**Email Peserta:** ' . $pendaftaran->email);
            })
            ->line('**Nama Biaya:** ' . $namaBiaya)
            ->line('**Jumlah Dibayar:** ' . $nominal);

        if ($periodeNama) {
            $mail->line('**Periode:** ' . $periodeNama);
        }

        if ($this->tagihan->midtrans_order_id) {
            $mail->line('**Midtrans Order ID:** ' . $this->tagihan->midtrans_order_id);
        }

        return $mail
            ->line('Silakan cek halaman Biaya di dashboard admin untuk detail lebih lanjut.')
            ->salutation('Hormat kami, **Sistem Kursus Pernikahan Biara Loresa SCJ**');
    }
}

