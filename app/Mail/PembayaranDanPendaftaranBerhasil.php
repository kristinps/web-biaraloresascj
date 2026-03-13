<?php

namespace App\Mail;

use App\Models\PendaftaranPernikahan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PembayaranDanPendaftaranBerhasil extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public PendaftaranPernikahan $pendaftaran,
        public ?string $password
    ) {
        $this->pendaftaran->load('periode');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Selamat! Pembayaran dan Pendaftaran Kursus Pernikahan Berhasil – Biara Loresa SCJ',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pembayaran-dan-pendaftaran-berhasil',
        );
    }
}
