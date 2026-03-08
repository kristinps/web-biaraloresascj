<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminDihapusEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $email,
        public string $nama
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Akun Admin Telah Dihapus – Biara Loresa SCJ',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-dihapus',
        );
    }
}
