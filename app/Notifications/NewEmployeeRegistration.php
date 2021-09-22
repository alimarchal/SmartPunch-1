<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewEmployeeRegistration extends Notification
{
    use Queueable;

    private $user;
    private $password;
    private $role;
    private $email;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $password, $role, $email)
    {
        $this->user = $user;
        $this->password = $password;
        $this->role = $role;
        $this->email = $email;
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
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->subject('SmartPunch Registration')
            ->markdown('email.employeeRegistration', ['user' => $this->user, 'password' => $this->password, 'role' => $this->role, 'email' => $this->email]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
