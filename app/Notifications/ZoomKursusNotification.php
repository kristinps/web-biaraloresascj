<?php
namespace App\Notifications;
use App\Models\MateriKursus;
use App\Models\PendaftaranPernikahan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
class ZoomKursusNotification extends Notification
{
    use Queueable;
    public function __construct(public readonly MateriKursus $materi, public readonly PendaftaranPernikahan $pendaftaran) {}
    public function via(object $notifiable): array { return ['mail']; }
    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Link Zoom — ' . $this->materi->judul . ' | Biara Loresa SCJ')
            ->greeting('Yth. ' . $this->pendaftaran->nama_pria . ' & ' . $this->pendaftaran->nama_wanita)
            ->line('Link Zoom untuk sesi kursus pernikahan telah tersedia.')
            ->line('**Sesi: ' . $this->materi->judul . '**');
        if ($this->materi->tanggal_pelaksanaan) $mail->line('**Tanggal:** ' . $this->materi->tanggal_pelaksanaan->format('d M Y'));
        if ($this->materi->zoom_link) $mail->action('Bergabung via Zoom', $this->materi->zoom_link)->line('Link: ' . $this->materi->zoom_link);
        return $mail->line('Mohon bergabung tepat waktu. Kehadiran Zoom akan dicatat.')->salutation('Hormat kami, **Biara Loresa SCJ**');
    }
}
