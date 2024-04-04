<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class VueResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
{
    $url = url('/password-reset/' . $this->token); // Add a slash between '/password-reset' and $this->token

    // Update this URL to the path of your Vue app's password reset page
    $vueAppUrl = config('app.client_url') . '/password-reset/' . $this->token;

    return (new MailMessage)
        ->subject(Lang::get('Reset Password Notification'))
        ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
        ->action(Lang::get('Reset Password'), $vueAppUrl)
        ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.users.expire')]))
        ->line(Lang::get('If you did not request a password reset, no further action is required.'));
}

}
