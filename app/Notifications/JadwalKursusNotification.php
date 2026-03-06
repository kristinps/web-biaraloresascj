<?php
namespace App\Notifications;
use App\Models\PendaftaranPernikahan;
use App\Models\PeriodePernikahan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
class JadwalKursusNotification extends Notification
{
    use Queueable;
    public function __construct(public readonly PeriodePernikahan $periode, public readonly PendaftaranPernikahan $pendaftaran, public readonly string $pesan) {}
    public function via(object $notifiable): array { return ['mail']; }
    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Jadwal Kursus Pernikahan — ' . $this->periode->nama . ' | Biara Loresa SCJ')
            ->greeting('Yth. ' . $this->pendaftaran->nama_pria . ' & ' . $this->pendaftaran->nama_wanita)
            ->line('Anda telah dijadwalkan untuk mengikuti **Kursus Pernikahan**:')
            ->line('**Periode:** ' . $this->periode->nama)
            ->line('**Tanggal Mulai:** ' . $this->periode->tanggal_mulai->format('d M Y'));
        if ($this->periode->tanggal_selesai) $mail->line('**Tanggal Selesai:** ' . $this->periode->tanggal_selesai->format('d M Y'));
        if ($this->pesan) $mail->line('---')->line('**Informasi Tambahan:**')->line($this->pesan);
        return $mail->line('Mohon hadir tepat waktu pada setiap sesi kursus.')->salutation('Hormat kami, **Biara Loresa SCJ**');
    }
}
