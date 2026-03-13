<?php
namespace App\Notifications;
use App\Models\MateriKursus;
use App\Models\PendaftaranPernikahan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
class MateriKursusNotification extends Notification
{
    use Queueable;
    public function __construct(public readonly MateriKursus $materi, public readonly PendaftaranPernikahan $pendaftaran) {}
    public function via(object $notifiable): array { return ['mail']; }
    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Materi Kursus: ' . $this->materi->judul . ' | Biara Loresa SCJ')
            ->greeting('Yth. ' . $this->pendaftaran->nama_pria . ' & ' . $this->pendaftaran->nama_wanita)
            ->line('Materi kursus pernikahan tersedia untuk Anda.')
            ->line('**Materi ke-' . $this->materi->urutan . ': ' . $this->materi->judul . '**');
        if ($this->materi->nama_pemateri) $mail->line('**Pemateri:** ' . $this->materi->nama_pemateri);
        if ($this->materi->tanggal_pelaksanaan) $mail->line('**Tanggal:** ' . $this->materi->tanggal_pelaksanaan->format('d M Y'));
        if ($this->materi->deskripsi) $mail->line($this->materi->deskripsi);
        if ($this->materi->file_materi) {
            $mail->action('Unduh Materi', asset('storage/' . $this->materi->file_materi));
        }
        $mail->action('Buka Dashboard', route('dashboard.user'));
        return $mail
            ->line('Mohon pelajari materi ini sebelum sesi berlangsung.')
            ->salutation('Hormat kami, **Biara Loresa SCJ**');
    }
}
