<?php

namespace App\Mail;

use App\Models\Candidature;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificationStatutCandidature extends Mailable
{
    use Queueable, SerializesModels;

    public $candidature;

    /**
     * Create a new message instance.
     */
    public function __construct(Candidature $candidature)
    {
        $this->candidature = $candidature;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // Définition dynamique du sujet selon les deux niveaux de statuts
        if ($this->candidature->statut_candidature === 'refusé') {
            $sujet = 'Notification de rejet de dossier de candidature';
        } elseif ($this->candidature->statut_marche === 'tributaire') {
            $sujet = 'Notification d\'attribution provisoire du marché';
        } elseif ($this->candidature->statut_marche === 'rejeté') {
            $sujet = 'Notification de non-attribution du marché';
        } else {
            $sujet = 'Notification de validation de dossier de candidature';
        }

        return new Envelope(
            subject: '[SNGP-BAD] ' . $sujet,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.notification_candidature',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}