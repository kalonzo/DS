<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BookingCreatedPro extends Notification
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
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $booking, $establishment)
    {
        $this->user = $user;
        $this->booking = $booking;
        $this->establishment = $establishment;
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
        $mailData['lines'][] = "Un client vient d'envoyer une demande de réservation pour le ". formatDate($this->booking->getDatetimeReservation())
                                ." à ".formatDate($this->booking->getDatetimeReservation(), \IntlDateFormatter::NONE, \IntlDateFormatter::SHORT)
                                ." pour ".$this->booking->getNbAdults()." personne(s) dans votre établissement.";
        if(!empty($this->booking->getComment())){
            $mailData['lines'][] = "<br/>Commentaires du client : ".$this->booking->getComment();
        }
        $mailData['confirmUrl'] = url("/admin/booking/confirm/".$this->booking->getUuid());
        $mailData['denyUrl'] = url("/admin/booking/deny/".$this->booking->getUuid());
        $mailData['mySpaceUrl'] = url("/admin");
        
        $message = (new MailMessage)
            ->subject("Dinerscope - Une demande de réservation vous est adressée")
            ->markdown('emails.booking-approval', $mailData);
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
