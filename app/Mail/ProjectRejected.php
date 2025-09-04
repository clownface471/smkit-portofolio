<?php

namespace App\Mail;

use App\Models\Project; // Tambahkan ini
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProjectRejected extends Mailable
{
    use Queueable, SerializesModels;

    // Tambahkan property ini
    public Project $project;

    /**
     * Create a new message instance.
     */
    // Modifikasi constructor
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Update Mengenai Proyek Portofolio Anda: Butuh Revisi', // Tambahkan subjek email
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Arahkan ke view yang akan kita buat
        return new Content(
            markdown: 'emails.project-rejected',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}