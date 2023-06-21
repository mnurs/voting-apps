<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PilketumDptMailer extends Mailable
{
    use Queueable, SerializesModels;
    

    public $member;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($member)
    {
        $this->member = $member;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.email_dpt')->subject('Konfirmasi Daftar Pemilih Tetap')->from('database@ikastara.or.id', 'E-Voting Ikastara');
    }
}
