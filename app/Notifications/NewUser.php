<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\User;

class NewUser extends Notification
{
    use Queueable;
    public $clientPwd;
    public $clientName;
    public $url;
    public $subject;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($clientPassword, $clientName)
    {
        $this->clientPwd = $clientPassword;
        $this->clientName = $clientName;
        $this->subject = 'Tu usuario ha sido dado de alta!';
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
            ->from(config('mail.from.address'), config('app.name'))
            ->subject($this->subject)
            ->greeting('¡Bienvenido, ' . $this->clientName . '!')
            ->line('¡Ahora ya puedes ingresar a nuestro portal!')
            ->line('Usuario: ' . $notifiable->email)
            ->line('Contraseña: ' . $this->clientPwd)
            ->action('Sistema de Paquetes', url(config('app.url')))
            ->level('success')
            ->line('Tu usuario y contraseña fue generado automaticamente.')
            ->line('Para tu mayor seguridad te recomendamos ingresar a cambiarla, desde la pagina de login o dando click a este link: ')
            ->salutation(url(config('app.url')) . '/password/reset');
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