<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscribersMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $slug;
    public $title;
    public $body;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($slug, $title, $body, $data)
    {
        $this->slug = $slug;
        $this->title = $title;
        $this->body = $body;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.subscribers')
                    ->from('info@aips.us', 'AIPS')
                    ->subject('New Program.');
    }
}
