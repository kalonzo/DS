<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BookingDeniedUser extends Notification
{
    use Queueable;

    /**
     *
     * @var \App\Models\User
     */
    protected $user;
    /**
     *
     * @var \App\Models\Booking
     */
    protected $booking;
    /**
     *
     * @var \App\Models\Establishment
     */
    protected $establishment;
    
    protected $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $booking, $establishment, $token)
    {
        $this->user = $user;
        $this->booking = $booking;
        $this->establishment = $establishment;
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
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mailData = array();
        $mailData['lines'][] = "Nous avons bien reçu votre souhait de réservation du ". formatDate($this->booking->getDatetimeReservation())
                            ." à ".formatDate($this->booking->getDatetimeReservation(), \IntlDateFormatter::NONE, \IntlDateFormatter::SHORT)
                            ." dans l'établissement ".$this->establishment->getName().', cependant nous regrettons de ne pouvoir accéder à votre demande.';
        $mailData['lines'][] = "En effet, notre établissement est complet à cette date mais vous pouvez bien entendu modifier la date de réservation.";
        $mailData['lines'][] = "En espérant pouvoir vous recevoir prochainement, nous vous prions d’agréer, Madame, Monsieur, nos sincères salutations.";
        if(!empty($this->token)){
            $mailData['activateUrl'] = route('register.verify', $this->token);
        }
        
        $message = (new MailMessage)
            ->subject("Dinerscope - Votre réservation est déclinée")
            ->markdown('emails.booking-denied', $mailData);
        return $message;
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
