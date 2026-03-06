<?php
namespace App\Notifications;
use App\Models\PendaftaranPernikahan;
use App\Models\PeriodePernikahan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
class SertifikatLulusNotification extends Notification
{
    use Queueable;
    public function __construct(public readonly PeriodePernikahan $periode, public readonly PendaftaranPernikahan $pendaftaran, public readonly string $pesan = '') {}
    public function via(object $notifiable): array { return ['mail']; }
    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Selamat! Sertifikat Kelulusan Kursus Pernikahan | Biara Loresa SCJ')
            ->greeting('Yth. ' . $this->pendaftaran->nama_pria . ' & ' . $this->pendaftaran->nama_wanita)
            ->line('**Selamat! Anda telah dinyatakan LULUS Kursus Pernikahan.**')
            ->line('Periode: **' . $this->periode->nama . '**')
            ->line('Anda telah menyelesaikan seluruh rangkaian kursus pernikahan dengan kehadiran yang memenuhi syarat.');
        if ($this->pesan) $mail->line('---')->line($this->pesan);
        return $mail->line('Sertifikat kelulusan dapat diambil di kantor Biara Loresa SCJ.')->salutation('Hormat kami, **Biara Loresa SCJ**');
    }
}
