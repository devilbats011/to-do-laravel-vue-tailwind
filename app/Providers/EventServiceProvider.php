<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\User;
// use App\Models\Badge;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        EventTodoLog::class => [
            ListenerTodoLog::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        // Badge::factory()->create([
        //     'name' => '1st',
        //     'requiredAchievement' => 2,
        //     "created_at" =>  Carbon::now(), 
        //     "updated_at" =>  Carbon::now(), 
        // ]);
    }
}
