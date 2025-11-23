<?php

namespace App\Mail\p01_movimientos_personal;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreacionCuentaEmpleado extends Mailable
{
    use Queueable, SerializesModels;

    public $subject, $movimientoPersonal, $usuario, $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $movimientoPersonal, $usuario, $password)
    {
        $this->subject = $subject;
        $this->movimientoPersonal = $movimientoPersonal;
        $this->usuario = $usuario;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->markdown('p01_movimientos_personal.emails.TA02_create_user_empleado');
    }
}
