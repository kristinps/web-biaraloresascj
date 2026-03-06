<?php
namespace App\Notifications;
use App\Models\PendaftaranPernikahan;
use App\Models\PeriodePernikahan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
class JadwalSelanjutnyaNotification extends Notification
{
    use Queueable;
    public function __construct(public readonly PeriodePernikahan $periode, public readonly PendaftaranPernikahan $pendaftaran, public readonly string $pesan) {}
    public function via(object $notifiable): array { return ['mail']; }
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Jadwal Kegiatan Selanjutnya — Kursus Pernikahan | Biara Loresa SCJ')
            ->greeting('Yth. ' . $this->pendaftaran->nama_pria . ' & ' . $this->pendaftaran->nama_wanita)
            ->line('Setelah menyelesaikan Kursus Pernikahan periode **' . $this->periode->nama . '**, berikut informasi jadwal kegiatan selanjutnya:')
            ->line('---')
            ->line($this->pesan)
            ->line('---')
            ->line('Jika ada pertanyaan, silakan menghubungi kami.')
            ->salutation('Hormat kami, **Biara Loresa SCJ**');
    }
}
