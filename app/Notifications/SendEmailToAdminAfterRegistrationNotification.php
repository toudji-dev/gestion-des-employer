<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEmailToAdminAfterRegistrationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $code;
    public $email;


    public function __construct($codeToSend, $SendToEmail)
    {
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
            ->subject('Creation de compte administrateur.')
            ->line('Bonjour')
            ->line('Votre compte a été crée avec succés sur la plateforme de gestion de salaire et d\'employer.')
            ->line('Cliquez sur le bouton ci dessous pour valider votre compt')
            ->line('Saisissez le code' . $this->code . 'et renseigner le dans le formulaire qui appraitra')
            ->action('Cliquez ici ', url('/validate-account' . '/' .  $this->email))
            ->line('Merci d\'utiliser nos services');
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
