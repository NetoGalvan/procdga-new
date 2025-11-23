<?php

namespace App\Mail\p08_solicita_servicios;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\p08_solicita_servicios\P08SolicitaServicio;

class MailSolicitaServicioSolicitada extends Mailable
{
    use Queueable, SerializesModels;

    protected $solicitaServicio;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($solicitaServicio)
    {
        $this->solicitaServicio = $solicitaServicio;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $asunto = $this->solicitaServicio->urgente ? '¡Urgente! ' . $this->solicitaServicio->servicioGeneral->nombre_servicio_general : $this->solicitaServicio->servicioGeneral->nombre_servicio_general;
        return $this->markdown('p08_solicita_servicios.mails.solicitaServicioSolicitada', [
                                    'solicitaServicio' => $this->solicitaServicio,
                                ])->subject($asunto);
    }
}
