<?php

namespace App\Notifications\Auth;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordReset extends Notification implements ShouldQueue
{
    use Queueable;

    public $token;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, User $user)
    {
        $this->token = $token;
        $this->user = $user;
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
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Restablecer contraseña")
            ->greeting("Hola, {$this->user->nombre_completo}:")
            ->line('Hemos recibido una solicitud de restablecimiento de contraseña. Haga clic en el siguiente botón para restablecerla:')
            ->action('Restablecer contraseña', url('password/reset', $this->token) . "?email={$this->user->email}")
            ->line('Éste enlace caducará en 60 minutos.')
            ->line('Si usted no realizó ésta solicitud, no requiere hacer ninguna acción.');
    }
}
