<?php

namespace App\Models;

// use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'requiredAchievement',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    
}
