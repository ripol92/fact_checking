<?php

namespace App\Mail;

use App\Models\Feedback;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Feedback
     */
    private $feedback;

    /**
     * Create a new message instance.
     *
     * @param Feedback $feedback
     */
    public function __construct(Feedback $feedback)
    {
        //
        $this->feedback = $feedback;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.admin', [
            "feedback" => $this->feedback->feedback,
            "userName" => $this->feedback->user->name
        ]);
    }
}
