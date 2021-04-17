<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotifyUser
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $user;
    public $title;
    public $description;
    public $notification;
    public $dateTime;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $title, $description)
    {
        $this->user = $user;
        $this->title = $title;
        $this->description = $description;

        // Set Notification
        // $notification = new Notification;
        // $notification->user_id = $user->id;
        // $notification->title = $title;
        // $notification->content = $description;
        // $notification->save();

        // $this->notification = $notification;
        // $this->dateTime = $notification->created_at;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
