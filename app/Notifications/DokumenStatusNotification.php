<?php
namespace App\Notifications;
use App\Models\PendaftaranPernikahan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
class DokumenStatusNotification extends Notification
{
    use Queueable;
    public function __construct(public readonly PendaftaranPernikahan $pendaftaran, public readonly string $pesan) {}
    public function via(object $notifiable): array { return ['mail']; }
    public function toMail(object $notifiable): MailMessage
    {
        $statusLabel = match ($this->pendaftaran->status_dokumen) {
            'lengkap'       => 'Dokumen Lengkap',
            'tidak_lengkap' => 'Dokumen Tidak Lengkap',
            default         => 'Informasi Dokumen',
        };
        $mail = (new MailMessage)
            ->subject("Pemeriksaan Dokumen — {$statusLabel} | Biara Loresa SCJ")
            ->greeting('Yth. ' . $this->pendaftaran->nama_pria . ' & ' . $this->pendaftaran->nama_wanita)
            ->line('Kami telah memeriksa kelengkapan dokumen persyaratan pendaftaran kursus pernikahan Anda.');
        if ($this->pendaftaran->status_dokumen === 'lengkap') {
            $mail->line('**Status Dokumen: Lengkap**')->line('Dokumen Anda telah dinyatakan lengkap dan memenuhi persyaratan.');
        } else {
            $mail->line('**Status Dokumen: Tidak Lengkap**')->line('Terdapat dokumen yang belum lengkap atau perlu diperbaiki.');
        }
        if ($this->pesan) $mail->line('---')->line('**Catatan dari Admin:**')->line($this->pesan);
        return $mail->line('Jika ada pertanyaan, silakan menghubungi kami.')->salutation('Hormat kami, **Biara Loresa SCJ**');
    }
}
