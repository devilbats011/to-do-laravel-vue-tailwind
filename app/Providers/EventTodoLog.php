<?php

namespace App\Providers;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventTodoLog
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $title;
    public $activity;
    public $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $arguments)
    {
        $this->setConstructor($arguments);
    }

    private function setConstructor(array $arguments)
    {
        $defaults = array(
            'activity' => '',
            'title' => '',
            'user' => null,
        );

        $arguments = array_merge($defaults, $arguments);
        $this->title = $arguments['title'];
        $this->activity = $arguments['activity'];
        $this->user = $arguments['user'];

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
