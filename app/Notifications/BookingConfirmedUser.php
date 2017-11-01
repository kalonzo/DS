<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BookingConfirmedUser extends Notification
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
        $mailData['intro'] = "Votre réservation du ". formatDate($this->booking->getDatetimeReservation())
                                ." à ".formatDate($this->booking->getDatetimeReservation(), \IntlDateFormatter::NONE, \IntlDateFormatter::SHORT)
                                ." pour ".$this->booking->getNbAdults()." personne(s) dans l'établissement ".$this->establishment->getName().' est confirmée.';
        $mailData['cancelUrl'] = url("/admin/booking/cancel/".$this->booking->getUuid());
        if(!empty($this->token)){
            $mailData['activateUrl'] = route('register.verify', $this->token);
        }
        
        $message = (new MailMessage)
            ->subject("Dinerscope - Votre réservation est confirmée")
            ->markdown('emails.booking-confirmed', $mailData);
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
