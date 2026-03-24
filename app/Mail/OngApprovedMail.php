<?php

namespace App\Mail;

use App\Models\Ong;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OngApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ong;

    public function __construct(Ong $ong)
    {
        $this->ong = $ong;
    }

    public function build()
    {
        return $this->subject('Sua ONG foi aprovada!')->markdown('emails.ong_approved');
    }
}