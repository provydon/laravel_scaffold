<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class SendEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $subject;
    public $message;
    public $user;
    public $link;
    public $name;

    public function __construct($user, $subject, $message, $link = null)
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->user = $user;
        $this->link = $link;
        $this->name = $user->first_name ? $user->first_name : "Welcome To SitEat";
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
        if ($this->link != null) {
            return (new MailMessage)
                ->subject($this->subject)
                ->greeting("Hello " . ucfirst($this->name))
                ->line(new HtmlString($this->message . '<br>'))
                ->action('Click Here', url($this->link))
                ->line('Thank you for using our application!');
        } else {
            return (new MailMessage)
                ->subject($this->subject)
                ->greeting("Hello " . ucfirst($this->name))
                ->line(new HtmlString($this->message . '<br>'))
                // ->action('Notification Action', url('/'))
                ->line('Thank you for using our application!');
        }
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
