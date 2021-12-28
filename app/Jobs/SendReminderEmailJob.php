<?php

namespace App\Jobs;

use App\Models\Todo;
use App\Mail\ReminderEmail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

use Illuminate\Queue\Middleware\WithoutOverlapping;

class SendReminderEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    // public $todo;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    protected $todo;
    protected $userId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    // public function __construct($email, $todo)
    public function __construct($data)
    {
        $this->todo = $data[0];
        $this->userId = $data[1];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $reminderEmail = new ReminderEmail($this->email,$this->todo);
        // Storage::disk('local')->append('error_log/error_check.txt', $this->data['email']);
        $user = User::find($this->userId);
        // $reminderEmail = new ReminderEmail($this->todo,$user);
        $data = [$this->todo,$user];
        Mail::to($user['email'])->send(new ReminderEmail($data));

        // PASS!!
        // Mail::to($user['email'])->send(new ReminderEmail("PLSSSSxx!!"));

    }

    public function middleware()
    {
        $todo = $this->todo;
        return [new WithoutOverlapping($todo->id)];
    }
}
