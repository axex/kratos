<?php
namespace App\Services\Mail;

use Illuminate\Mail\Mailer;

class MailService
{
    protected $mail;


    /**
     * MailService constructor.
     *
     * @param Mailer $mail
     */
    public function __construct(Mailer $mail)
    {
        $this->mail = $mail;
    }


    /**
     * 发送邮件
     *
     * @param string $view
     * @param array $attributes
     * @param string $email
     * @param string $subject
     */
    public function send($view, array $attributes, $email, $subject = '')
    {
        $subject = $subject ? $subject : trans('email.subject');
        $this->mail->queue($view, $attributes, function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });
    }
}