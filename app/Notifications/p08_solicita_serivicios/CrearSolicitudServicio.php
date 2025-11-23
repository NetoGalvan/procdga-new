<?php

namespace App\Notifications\p08_solicita_serivicios;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CrearSolicitudServicio extends Notification
{
    use Queueable;

    var $solicitaServicio;
    var $correoscc;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($solicitaServicio, $correoscc)
    {
        $this->solicitaServicio = $solicitaServicio;
        $this->correoscc = $correoscc;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $asunto = $this->solicitaServicio->urgente ? '¡Urgente! ' . $this->solicitaServicio->servicioGeneral->nombre_servicio_general : $this->solicitaServicio->servicioGeneral->nombre_servicio_general;
        return (new MailMessage)
                    ->subject($asunto)
                    ->cc($this->correoscc)
                    ->greeting('¡Hola!')
                    ->line('Buen día, se solicita atender la siguiente solicitud: <b>'. $this->solicitaServicio->servicioGeneral->nombre_servicio_general .'</b>, con folio: <b>'. $this->solicitaServicio->folio .'</b>')
                    ->line('Gracias')
                    ->action('Ingresar a PROCDGA', route("login"));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
