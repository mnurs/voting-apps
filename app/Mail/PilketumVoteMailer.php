<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PilketumVoteMailer extends Mailable
{
    use Queueable, SerializesModels;

    public $voter;
    public $candidate_choosen;
    public $refkey;
    public $pilketum_title;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($voter,$candidate_choosen,$refkey,$pilketum_title)
    {
        $this->voter = $voter;
        $this->candidate_choosen = $candidate_choosen;
        $this->refkey = $refkey;
        $this->pilketum_title = $pilketum_title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.email')->subject('Voting - Pemilihan Ketua Umum Ikastara')->from('database@ikastara.or.id', 'E-Voting Ikastara');
    }
}
