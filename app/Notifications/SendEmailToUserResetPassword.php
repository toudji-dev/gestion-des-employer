<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEmailToUserResetPassword extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $code;
    public $email;

    public function __construct($codeToSend, $SendToEmail)
    {
        //
        $this->code = $codeToSend;
        $this->email = $SendToEmail;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('RÉINITIALISER LE MOT DE PASSE.')
            ->line('Bonjour')
            ->line('Cliquez sur le bouton ci dessous pour réinitialiser le mot de passe')
            ->line('Saisissez le code' . $this->code . 'et renseigner le dans le formulaire qui appraitra')
            ->action('Notification Action', url('/reset-code-password' . '/' .  $this->email))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
