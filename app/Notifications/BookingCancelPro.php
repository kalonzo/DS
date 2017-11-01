<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BookingCancelPro extends Notification
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
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $booking)
    {
        $this->user = $user;
        $this->booking = $booking;
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
            ->subject("Dinerscope - Réservation annulée")
            ->line("La réservation du ". formatDate($this->booking->getDatetimeReservation())
                    ." à ".formatDate($this->booking->getDatetimeReservation(), \IntlDateFormatter::NONE, \IntlDateFormatter::SHORT)
                    ." pour ".$this->booking->getNbAdults()." personne(s) a été annulée par ".$this->user->getFirstname().' '.$this->user->getLastname().".")
            ->action("Accéder à mon espace", url("/admin"))
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
