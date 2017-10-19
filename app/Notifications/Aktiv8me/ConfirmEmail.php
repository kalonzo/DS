<?php

namespace App\Notifications\Aktiv8me;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ConfirmEmail extends Notification
{
    use Queueable;

    /** @var \App\RegistrationToken */
    public $registration_token;


    /**
     * Create a new notification instance.
     *
     * @param \App\RegistrationToken $registration_token
     */
    public function __construct($registration_token)
    {
        $this->token = $registration_token->token;
        $this->username = $registration_token->user->name;
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
            ->subject("Dinerscope - Votre inscription")
            ->greeting("Vous y êtes presque…")
            ->line("Merci de vous être enregistré")
            ->line("Veuillez confirmer votre compte")
            ->action("Activez votre compte maintenant", route('register.verify', $this->token))
            ->line("Les identifiants, ci-dessous, vous permettront de vous connecter sur ".url('/admin').".")
            ->line("Vous pouvez à tout instant modifier l’ensemble de vos informations personnelles dans la rubrique Mon compte.")
            ->line("Votre identifiant : ".$this->username)
            ->line("Votre mot de passe est celui que vous avez défini lors de votre demande d'inscription. Si vous l'avez oublié, vous pourrez le redéfinir "
                    . "après activation de votre compte.")
            ->line("Nous vous remercions de votre confiance.")
            ->line("A vous de jouer !")
            ;
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
