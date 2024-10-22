<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $signUpLink;

    public function __construct($signUpLink)
    {
        $this->signUpLink = $signUpLink;
    }

    public function build()
    {
        return $this->subject('Invitation to Join Our Platform')
            ->view('emails.invite')
            ->with(['signUpLink' => $this->signUpLink]);
    }
}
