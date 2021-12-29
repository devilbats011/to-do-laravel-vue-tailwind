<?php

namespace App\Mail;

// use App\Models\Todo;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $content;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->content = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $user= $this->content[1];
        $name = $user->name;

        $todo= $this->content[0];
        $title = $todo->title;
        $date = $todo->date;

        Storage::disk('local')->append('error_log/error_check.txt', $name." | ".$title."| ".$date);
        return $this->view('emails.reminder_email')->with([
            'name' => $name,
            'title' => $title,
            'date' => $date,
        ]);
    }
}
