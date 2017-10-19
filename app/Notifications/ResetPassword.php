<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Description of ResetPassword
 *
 * @author Nico
 */
class ResetPassword extends Notification
{
    use Queueable;
    
    public $token;
    
    /**
     * Create a new notification instance.
     *
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
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
     * @return MailMessage
     */
    public function toMail($notifiable){   
//        return (new MailMessage)
//        ->subject("Dinerscope - Mot de passe oublié")
//        ->view(
//            'emails.password-forgotten', ['reset_link' => url("/password/reset/".$this->token)]
//        );
        return (new MailMessage)
            ->subject("Dinerscope - Mot de passe oublié")
            ->line("Vous avez demandé à réinitialiser le mot de passe de votre compte ou vous l’avez oublié.")
            ->line("Pour cette raison, cliquez sur le lien ci-dessous :")
            ->action("Réinitialiser votre mot de passe", url("/password/reset/".$this->token))
            ->line("Si vous n'avez pas demandé la réinitialisation de votre mot de passe, ignorez simplement cet email.")
            ->line("Cette requête a été déposée le : ".formatDate(new \DateTime())."")
            ;
    }
}
