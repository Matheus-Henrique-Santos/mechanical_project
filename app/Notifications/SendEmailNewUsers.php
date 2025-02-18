<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEmailNewUsers extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    public $user, $token;

    public function __construct($userCreated,$token)
    {
        $this->user = $userCreated;
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Mecanica: Convite de acesso')
            ->markdown('mail.send-email-new-users', [
                'token' => $this->token,
                'userName' => $this->user->name,
                'userEmail' => $this->user->email,
                'colorSec' => '#6b7280',
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
