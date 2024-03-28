<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        $currentDate = Carbon::now()->toDateString();
        return $this->view('emails.submitted')
                    ->subject('Booking Received. Thank You for Choosing Hairtric and Lashility - ' . $currentDate); // Create a blade template in resources/views/emails/marketing.blade.php
    }
}
