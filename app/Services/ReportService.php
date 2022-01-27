<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ReportService
{

    public static function reportAudit(String $content)
    {
        Storage::disk('local')->append('todo_log/todo_activity_log.txt', $content);
    }


    public static function reportLog(String $content)
    {
        Storage::disk('local')->append('error_log/error_check.txt', $content);
    }
    
}
