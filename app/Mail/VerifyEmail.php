<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    protected $data;
    protected $purpose;
    public function __construct(array $data, $purpose)
    {
        $this->data = $data;
        $this->purpose = $purpose;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = match ($this->purpose) {
            'email_verification' => 'Email Verification Code',
            'password_reset' => 'Password Reset OTP Code',
            'resend' => 'Resend OTP Code',
            default => 'Your OTP Code',
        };
        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $fullName = $this->data['full_name'];
        $otp = $this->data['otp'];
        return (new Content(
            view: 'email.VerifyEmail',
        ))->with([
            'full_name' => $fullName,
            'otp' => $otp
        ]);
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
