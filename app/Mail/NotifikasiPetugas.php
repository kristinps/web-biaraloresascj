<?php

namespace App\Mail;

use App\Models\PendaftaranPernikahan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifikasiPetugas extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public PendaftaranPernikahan $pendaftaran
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔔 [Notifikasi] Pembayaran Kursus Pernikahan Diterima – #' . str_pad($this->pendaftaran->id, 6, '0', STR_PAD_LEFT),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.notifikasi-petugas',
        );
    }
}
