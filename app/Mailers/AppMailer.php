<?php

namespace App\Mailers;

use App\Models\User;
use Illuminate\Contracts\Mail\Mailer;

class AppMailer {

    protected $mailer;

    protected  $from = 'support@connectedut.com';

    protected $to;

    protected $view;

    protected $data = [];

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Sends an email confirmation email for user activation
     *
     * @param $token
     * @param User $user
     */
    public function sendEmailConfirmation($token, User $user)
    {
        $this->to = $user->email;
        $this->view = 'emails.confirm';
        $this->data = ['token' => $token];

        $this->deliver();
    }

    /**
     * Delivers an email
     *
     */
    public function deliver()
    {
        $this->mailer->send($this->view, $this->data, function($message) {
            $message->from($this->from, 'Connected UT')
                ->to($this->to)->subject('Email Verification');
        });
    }
}