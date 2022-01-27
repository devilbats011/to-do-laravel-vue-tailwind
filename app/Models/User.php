<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Todo;
use App\Models\Badge;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'user_type',
        'count',
        'plan_package',
        'achievements',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function todos()
    {
        return $this->hasMany(Todo::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class);
    }

     public function setAllBadge() {
        //assume all badge were seeded
        $badges = DB::table('badges')->get();

        foreach ($badges as $badge) {
            $this->badges()->attach($badge->id);
        }
    }

    public function handleMilestones()
    {
        $count = $this['count'] + 1;
        $this->update(['count' => $count]);

        $achievementCount = ($count) / 10;
        if (is_int($achievementCount)) {
            $this->update(['achievements' => $achievementCount]);
        }
        
        $result = [
            'notficition_status' => "none",
            'achievements' => $this['achievements'],
            'badge_id' => null,
            'badge_name' => null,
        ];
        
        $badges = $this->badges()->get();
        foreach ($badges as $badge) {
            $badge_user = DB::table('badge_user')->where('user_id',$this->id)->where('badge_id', $badge->id);
            $badge_user_first = $badge_user->first(); 
            // $badge_user = DB::table('badge_user')->where('user_id',1)->where('badge_id', 1)->first();
            
            
            Storage::disk('local')->append('check_user/milestones.txt',
                "| badgeId ".$badge->id.
                "| thisId ". $this->id.
                "| achievementCount ". $achievementCount.
                "| requiredAchievement ". $badge->requiredAchievement.
                "| this_noti_status ".  $badge_user_first->noti_status
            );

            if( $achievementCount >= $badge->requiredAchievement && $badge_user_first->noti_status == "none" ) {
                $noti_status = "unread";
                $badge_user->update(array('noti_status' => $noti_status));
                $result = [
                    'notficition_status' => $noti_status,
                    'achievements' => $achievementCount,
                    'badge_id' => $badge->id,
                    'badge_name' => $badge->name,
                ];
            }
        }

        return $result;

    }

    public function onRead($badge_id) {
        $badge_user = DB::table('badge_user')->where('user_id',$this->id)->where('badge_id', $badge_id);
        $noti_status = "read";
        $badge_user->update(array('noti_status' => $noti_status));
    }


}
