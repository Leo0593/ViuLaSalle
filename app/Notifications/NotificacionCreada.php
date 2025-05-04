<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificacionCreada extends Notification
{
    use Queueable;

    public $titulo;
    public $mensaje;

    public function __construct($titulo, $mensaje)
    {
        $this->titulo = $titulo;
        $this->mensaje = $mensaje;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->titulo)
            ->line($this->mensaje)
            ->line('Gracias por usar nuestra plataforma.');
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
