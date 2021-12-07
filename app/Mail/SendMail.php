<?php

namespace App\Mail;

use App\Jobs\SendEmailJob;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    protected $sendMail;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sendMail)
    {
        $this->sendMail = SendEmailJob::class;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return view('mail.send-mail');
    }
}
