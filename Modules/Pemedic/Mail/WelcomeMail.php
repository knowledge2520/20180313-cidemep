<?php
 
namespace Modules\Pemedic\Mail;
 
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
 
class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;
 
 	public $user;
 	public $password;
    public function __construct($user,$password)
    {
        $this->user = $user;
        $this->password = $password;
    }
 
 
    public function build()
    {
        return $this->view('pemedic::mail.welcome');
    }
}