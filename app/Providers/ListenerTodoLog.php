<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Providers\EventTodoLog;
use App\Services\ReportService;
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
        /** @var App\Models\User  */
        // $user = Auth::user();
        $user = $event->user;
        $content =
        'Title Todo:'.$event->title.
        ' | Activity:'.$event->activity.
        ' | Name:'.$user->name .
        ' | User Type:'.$user->user_type .
        ' | User Achievement:'.$user->achievements.
        ' | Log Date:' . Carbon::now()->toString();
        
        ReportService::reportAudit($content);
    }
}
