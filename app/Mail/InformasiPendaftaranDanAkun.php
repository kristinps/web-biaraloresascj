<?php

namespace App\Mail;

use App\Models\PendaftaranPernikahan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InformasiPendaftaranDanAkun extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public PendaftaranPernikahan $pendaftaran,
        public string $password
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📋 Pendaftaran Kursus Pernikahan & Informasi Akun Login – Biara Loresa SCJ',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.informasi-pendaftaran-dan-akun',
        );
    }
}
