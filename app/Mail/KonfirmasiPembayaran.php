<?php

namespace App\Mail;

use App\Models\PendaftaranPernikahan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KonfirmasiPembayaran extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public PendaftaranPernikahan $pendaftaran
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Konfirmasi Pembayaran Kursus Pernikahan – Biara Loresa SCJ',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.konfirmasi-pembayaran',
        );
    }
}
