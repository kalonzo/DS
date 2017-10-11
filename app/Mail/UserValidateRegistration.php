<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserValidateRegistration extends Mailable
{
    use Queueable, SerializesModels;
    
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\App\Models\User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        $link = null;
        $user = null;
        return $this->view('emails.auth.user-validate-registration')
                ->with('user', $user)
                ->with('link', $link)
                ;
    }
}
