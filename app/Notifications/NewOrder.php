<?php

namespace App\Notifications;

use Error;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrder extends Notification
{
    use Queueable;
    public $clientName;
    public $totalHours;
    public $leftHours;
    public $subject;
    public $mainMessage;
    public $url = null;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($clientName, $totalHours, $spendHours)
    {
        $this->totalHours = $totalHours;
        $this->spendHours = $spendHours;
        $this->subject = 'Consumo de horas';
        if ($totalHours < 3) {
            $this->mainMessage = 'Se han consumido ' . $this->spendHours . ' hora(s), actualmente cuentas con un total de ' . $this->totalHours . ' horas.
                                ¡Te invitamos a comprar otro paquete! ';
            $this->url = url('https://global-systems.mx/finalizar-compra/');
        } else {
            $this->mainMessage = 'Se han consumido ' . $this->spendHours . ' hora(s), actualmente cuentas con un total de ' . $this->totalHours . ' horas. ';
        }
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
        $mailMessage = new MailMessage();
        $mailMessage
            ->from(config('mail.from.address'), config('app.name'))
            ->subject($this->subject)
            ->greeting('¡Hola!')
            ->line($this->mainMessage);

        if ($this->url) {
            $mailMessage->action('Contratar Plan', $this->url);
        }
        return $mailMessage;
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
