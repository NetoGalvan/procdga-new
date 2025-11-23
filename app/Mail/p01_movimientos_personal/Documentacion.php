<?php

namespace App\Mail\p01_movimientos_personal;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Documentacion extends Mailable
{
    use Queueable, SerializesModels;

    public $subject, $movimientoPersonal, $usuario;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $movimientoPersonal, $usuario)
    {
        $this->subject = $subject;
        $this->movimientoPersonal = $movimientoPersonal;
        $this->usuario = $usuario;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->markdown('p01_movimientos_personal.emails.TA02_documentacion');
    }
}
