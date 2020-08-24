<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $row;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($row)
    {
        $this->row = $row;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.welcome')
                    ->from('no-reply@aips.com', 'No Reply')
                    ->subject('Your account verified successfully.');
    }
}
