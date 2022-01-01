<?php

namespace Database\Seeders;

use Carbon\Carbon;
// use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $badgeBank = [
            ['1st', 2],
            ['2nd', 5 ],
            ['3rd', 10],
        ];

        for ($i = 0; $i < count($badgeBank); $i++) {
            // $user = User::where('username', 'mazlan94')->firstOrFail();

            DB::table('badges')->insert([
                'name' => $badgeBank[$i][0],
                'requiredAchievement' => $badgeBank[$i][1],
                "created_at" =>  Carbon::now(), 
                "updated_at" =>  Carbon::now(), 
                // 'user_id' => $user->id,
            ]);
        }
    }
}
