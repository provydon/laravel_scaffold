<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class SendMail extends Notification
{
    use Queueable;

    public $user;

    public $title;

    public $description;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $title, $description)
    {
        $this->user = $user;
        $this->title = $title;
        $this->description = $description;
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
        return (new MailMessage)
            ->from(config('app.email'), config('app.name'))
            ->subject($this->title)
            ->line(new HtmlString($this->description.'<br>'))
            ->line('Thank you for using our application!');
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

    public function routeNotificationForMail()
    {
        return $this->user->email;
    }
}
