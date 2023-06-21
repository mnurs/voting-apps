<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PilketumRsvpMailer extends Mailable
{
    use Queueable, SerializesModels;

    public $member_name;
    public $member_nosis;
    public $member_batch;
    public $imageQrRsvp;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($member_name, $member_nosis, $member_batch, $imageQrRsvp)
    {
        $this->member_name = $member_name;
        $this->member_nosis = $member_nosis;
        $this->member_batch = $member_batch;
        $this->imageQrRsvp = $imageQrRsvp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.email_rsvp')->subject('RSVP - Munas Ikastara')->from('database@ikastara.or.id', 'E-Voting Ikastara');
    }
}
