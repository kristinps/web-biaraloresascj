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
            'lengkap'       => 'Dokumen Diterima',
            'tidak_lengkap' => 'Dokumen Perlu Perbaikan',
            default         => 'Informasi Dokumen',
        };
        $mail = (new MailMessage)
            ->subject("Pemeriksaan Dokumen — {$statusLabel} | Biara Loresa SCJ")
            ->greeting('Yth. ' . $this->pendaftaran->nama_pria . ' & ' . $this->pendaftaran->nama_wanita)
            ->line('Kami telah memeriksa kelengkapan dokumen persyaratan pendaftaran kursus pernikahan Anda.');
        if ($this->pendaftaran->status_dokumen === 'lengkap') {
            $mail->line('**Status: Dokumen Diterima**')->line('Dokumen Anda telah disetujui dan dinyatakan lengkap.');
        } else {
            $mail->line('**Status: Perlu Perbaikan**')->line('Terdapat dokumen yang perlu dilengkapi atau diperbaiki. Silakan masuk ke dashboard dan isi form perbaikan lalu klik Kirim.');
        }
        if ($this->pesan) $mail->line('---')->line('**Catatan dari Admin:**')->line($this->pesan);
        return $mail->line('Jika ada pertanyaan, silakan menghubungi kami.')->salutation('Hormat kami, **Biara Loresa SCJ**');
    }
}
