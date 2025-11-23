<?php

namespace App\Notifications\Administrador\Usuarios;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CuentaCreada extends Notification implements ShouldQueue
{
    use Queueable;

    var $tipoRegistro, $user, $password;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tipoRegistro, User $user, $password)
    {
        $this->tipoRegistro = $tipoRegistro;
        $this->user = $user;
        $this->password = $password;
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
        return (new MailMessage)
            ->subject("BIENVENIDO AL SISTEMA PROCDGA")
            ->greeting("Hola, {$this->user->nombre_completo}:")
            ->line('Bienvenido(a) al sistema PROCDGA, su solicitud de registro se ha realizado con éxito.')
            ->line("<strong>Correo electrónico:</strong> {$this->user->email} <br> <strong>RFC:</strong> {$this->user->rfc}<br> <strong>Contraseña:</strong> {$this->password}")
            ->line('Puede ingresar a la plataforma haciendo clic en el siguiente enlace:')
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
