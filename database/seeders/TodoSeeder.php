<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 1;

        $user = User::first();
        $user->update(['count'=> $count]);
        $user->update(['achievements'=> 1]);
        Todo::factory()->count($count)->create();
    }
}
