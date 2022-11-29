<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    public $email;
    public $token;

    /**  * Create a new message instance.  *
     *   * @return void  */
    public function __construct($email,$token)
    {
        $this->email = $email;
        $this->token== Str($token);;
    }
    /**  * Build the message.  *  * @return $this  */
    public function build()
    {
        return $this->view('emails.resetPassword'.$this->token);
    }
}
