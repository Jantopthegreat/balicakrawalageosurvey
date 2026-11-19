<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class AdminResetPassword extends ResetPassword
{
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->markdown('emails.admin-reset-password')
            ->subject('Reset Password Admin')
            ->greeting('Halo, '.$notifiable->name.'!')
            ->line('Kami menerima permintaan reset password untuk akun admin Anda.')
            ->action('Reset Password', route('admin.password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ]))
            ->line('Tautan ini berlaku selama '.config('auth.passwords.users.expire').' menit dan hanya dapat digunakan sekali.')
            ->line('Jika Anda tidak meminta reset password, abaikan email ini.');
    }
}
