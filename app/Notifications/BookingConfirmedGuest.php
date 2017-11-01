<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BookingConfirmedGuest extends Notification
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
        $mailData['establishment'] = $this->establishment;
        $mailData['username'] = $this->user->getFirstname().' '.$this->user->getLastname();
        $mailData['guest_message'] = $this->booking->getGuestsMessage();
        $mailData['booking_date'] = formatDate($this->booking->getDatetimeReservation());
        $mailData['booking_time'] = formatDate($this->booking->getDatetimeReservation(), \IntlDateFormatter::NONE, \IntlDateFormatter::SHORT);
        
        $message = (new MailMessage)
            ->subject("Dinerscope - Vous avez reçu une invitation")
            ->markdown('emails.booking-confirmed-guest', $mailData);
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
