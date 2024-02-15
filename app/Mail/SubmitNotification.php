<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubmitNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $location;
    public $date;
    public $service;
    public $stylist;
    public $fullname;
    public $phone;
    /**
     * Create a new message instance.
     */
    public function __construct($code, $location, $date, $service, $stylist, $fullname, $phone)
    {
        $this->code = $code;
        $this->location = $location;
        $this->date = $date;
        $this->service = $service;
        $this->stylist = $stylist;
        $this->fullname = $fullname;
        $this->phone = $phone;
    }

    public function build()
    {
        return $this->view('emails.submitted')
                    ->subject('Your Booking  with Hairtricandlashility'); // Create a blade template in resources/views/emails/marketing.blade.php
    }
}
