<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Description of Test
 *
 * @author Nico
 */
class Test extends Notification
{
    use Queueable;
    
    /**
     * Create a new notification instance.
     *
     * @param string $token
     */
    public function __construct()
    {
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
        return (new MailMessage)
            ->subject("Dinerscope - Test")
            ->line("Ne pas tenir compte de cet email.")
            ;
    }
}
