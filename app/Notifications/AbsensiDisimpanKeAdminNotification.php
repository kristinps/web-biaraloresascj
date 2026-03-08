<?php

namespace App\Notifications;

use App\Models\PeriodePernikahan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AbsensiDisimpanKeAdminNotification extends Notification
{
    use Queueable;

    public function __construct(public readonly PeriodePernikahan $periode, public readonly int $jumlahPeserta)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Data Kehadiran Berhasil Disimpan | Biara Loresa SCJ')
            ->greeting('Yth. ' . $notifiable->name . ',')
            ->line('Data kehadiran untuk periode **' . $this->periode->nama . '** telah berhasil disimpan.')
            ->line('Jumlah peserta: ' . $this->jumlahPeserta)
            ->line('Pemberitahuan ini dikirim otomatis setelah tombol Simpan Kehadiran digunakan.')
            ->salutation('Hormat kami, **Biara Loresa SCJ**');
    }
}
