<?php
namespace App\Services;

use Illuminate\Mail\Mailer;

class EmailService
{
    protected $mail;


    /**
     * EmailService constructor.
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
     * @param string $confirmCode
     * @param string $email
     * @param string $subject
     */
    public function send($view, $confirmCode, $email, $subject = '')
    {
        $subject = $subject ? $subject : trans('email.subject');
        $this->mail->queue($view, ['confirmCode' => $confirmCode, 'email' => $email], function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });
    }
}