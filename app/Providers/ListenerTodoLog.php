<?php

namespace App\Providers;

use App\Providers\EventTodoLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ListenerTodoLog
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Providers\EventTodoLog  $event
     * @return void
     */
    public function handle(EventTodoLog $event)
    {

        //updated|created|user name|date write the log|achieviement|user_type

        /** @var App\Models\User  */
        $user = Auth::user();
        $content =
        'Title Todo:'.$event->title .
        ' | Activity:'.$event->activity .
        ' | Name:'.$user->name .
        ' | User Type:'.$user->user_type .
        ' | Log Date:' . Carbon::now()->toString();
        Storage::disk('local')->append('todo_log/todo_activity_log.txt', $content);
    }
}
