<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Todo;
use App\Models\User;
use App\Models\Badge;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoApiTest extends TestCase
{

    use RefreshDatabase;
//register test

    public function test_user_succesfully_login_with_Email_and_password()
    {
        // // $this->seed();
        $user = User::factory()->create();
        $this->withoutExceptionHandling();

        $loginData = ['email_or_username' => $user->email, 'password' => 'pass12345'];

        $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "access_token",
                "token_type",
                "to",
            ]);

        $this->assertAuthenticated();

    }

    public function test_user_succesfully_login_with_Username_and_password()
    {
        $user = User::factory()->create();
        $this->withoutExceptionHandling();
        $loginData = ['email_or_username' => $user->username, 'password' => 'pass12345'];

        $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "access_token",
                "token_type",
                "to",
            ]);

        $this->assertAuthenticated();

    }

    public function test_display_all_todo_when_user_had_authenticated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->get('api/todos', ['Accept' => 'application/json']);
        $response->assertOk()->assertJsonStructure([
            "message",
            "data",
        ]);
    }

    public function test_create_a_new_todo_list_when_user_had_authenticated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->post('api/todos', [
            'title' => 'title to-do testing #' . Str::random(3),
            'description' => 'lorums plorums vec desc',
            'date' => null,
        ], ['Accept' => 'application/json']);
        $response->assertOk();
    }

    public function test_edit_the_todo_when_user_had_authenticated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $todo = Todo::factory()->create(
            [
                'title' => Str::random(10),
                'description' => Str::random(45),
                'user_id' => $user->id,
            ]);
        $id = $todo->user_id;
        // dd($user->id,$id);
        $response = $this->put('api/todos/' . $id, [
            'title' => 'title to-do updated testing #',
            'description' => 'lorums plorums vec desc updated',
            'date' => "",
            'toggle_reminder' => false,
        ], ['Accept' => 'application/json']);
        $response->assertOk();
    }

    public function test_user_are_blocked_to_edit_other_user_todo_list()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        Sanctum::actingAs($user1);
        Todo::factory()->create(
            [
                'title' => Str::random(10),
                'description' => Str::random(45),
                'user_id' => $user1->id,
            ]);
        $response = $this->put('api/todos/' . $user2->id, [
            'title' => 'title to-do updated testing #',
            'description' => 'lorums plorums vec desc updated',
            'date' => "",
            'toggle_reminder' => false,
        ], ['Accept' => 'application/json']);
        $response->assertStatus(403);
    }

    public function test_delete_the_todo_list_when_user_had_authenticated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $todo = Todo::factory()->create(
            [
                'title' => Str::random(10),
                'description' => Str::random(45),
                'user_id' => $user->id,
            ]);
        $response = $this->delete('api/todos/' . $todo->user_id, ['Accept' => 'application/json']);
        $response->assertOk();
    }

    public function test_user_are_blocked_to_delete_other_user_todo_list()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        Sanctum::actingAs($user1);
        $todo = Todo::factory()->create(
            [
                'title' => Str::random(10),
                'description' => Str::random(45),
                'user_id' => $user2->id,
            ]);
        $response = $this->delete('api/todos/' . $todo->user_id, ['Accept' => 'application/json']);
        $response->assertStatus(403);
    }

    public function test_free_user_allow_to_visit_create_page (){
        $user = User::factory()->create();
        Todo::factory()->count(1)->create([
            'title' => Str::random(10),
            'description'  => Str::random(10),
            'user_id' => $user->id,
        ]
        );
        
        $this->assertDatabaseCount(User::class, 1);
        $this->assertDatabaseCount(Todo::class, 1);
       
        Sanctum::actingAs($user);
        
        $response = $this->get('api/todos/create', ['Accept' => 'application/json']);

        $response
            ->assertStatus(200)
            ->assertJson(
            ['check-todo-count' =>
            array(
                'permission' => 'ALLOW',
                'redirect' => '',
                'to' => 'create'
            )]);

    }

    public function test_free_user_are_block_to_visit_create_page (){
        $user = User::factory()->create();
        Todo::factory()->count(10)->create([
            'title' => Str::random(10),
            'description'  => Str::random(10),
            'user_id' => $user->id,
        ]
        );
        
        $this->assertDatabaseCount(User::class, 1);
        $this->assertDatabaseCount(Todo::class, 10);
       
        Sanctum::actingAs($user);
        
        $response = $this->get('api/todos/create', ['Accept' => 'application/json']);

        $response
            ->assertStatus(403)
            ->assertJson(
            ['check-todo-count' =>
            array(
                'permission' => 'DENIED',
                'message' => 'Go premium for unlimited todos! free user only limited to 10 todos only',
                'redirect' => 'plan-package',
                'to' => ''
            )]);

    }

    public function test_premium_user_allow_to_visit_create_page_without_blocked() {
        $user = User::factory()->create();
        $user->update(['user_type'=>'premium_user']);
        Todo::factory()->count(10)->create([
            'title' => Str::random(10),
            'description'  => Str::random(10),
            'user_id' => $user->id,
        ]);
        
        $this->assertDatabaseCount(User::class, 1);
        $this->assertDatabaseCount(Todo::class, 10);
       
        Sanctum::actingAs($user);
        
        $response = $this->get('api/todos/create', ['Accept' => 'application/json']);

        $response
        ->assertStatus(200)
        ->assertJson(
        ['check-todo-count' =>
        array(
            'permission' => 'ALLOW',
            'message' => '',
            'redirect' => '',
            'to' => 'create'
        )]);

    }

    public function test_user_upgrade_to_premium(){
        $user = User::factory()->create();
        $freeUser = $user->user_type;
        Sanctum::actingAs($user);
        $response = $this->get('api/go-premium', ['Accept' => 'application/json']);
        $response->assertOk()->assertJsonStructure([
            'message_status',
            'message',
            'to'
        ]);

        // free_user !== premium_user
        $this->assertNotEquals($freeUser, $user->user_type);
    }

    private function injectBadgesToDB(){

        $badgeBank = [
            ['1st', 2],
            ['2nd', 5 ],
            ['3rd', 10],
        ];
        $tempArray = [];

        for ($i = 0; $i < count($badgeBank); $i++) {
            $tempArray[$i] = badge::factory()->create([
                'name' => $badgeBank[$i][0],
                'requiredAchievement' => $badgeBank[$i][1],
                "created_at" =>  Carbon::now(), 
                "updated_at" =>  Carbon::now(), 
    
            ]);

        }
        $this->assertDatabaseCount(badge::class, 3);

        return $tempArray;
    }

    public function test_milestones_user_achieved_1st_badge(){
        $badges = $this->injectBadgesToDB();
        $user = User::factory()->create();
        $count = 19;
        $user->update(['user_type'=>'premium_user','count'=>$count]);
        Todo::factory()->count($count)->create([
            'title' => Str::random(10),
            'description'  => Str::random(10),
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseCount(User::class, 1);
        $this->assertDatabaseCount(badge::class, 3);

        Sanctum::actingAs($user);
        $response = $this->post('api/todos', [
            'title' => 'title to-do testing #' . Str::random(5),
            'description' => 'lorums plorums vec desc',
            'date' => null,
        ], ['Accept' => 'application/json']);
        $response->assertOk();
        $firstBadge = $badges[0];
        $badge_user = DB::table('badge_user')->where('user_id',$user->id)->where('badge_id', $firstBadge->id);
        $this->assertDatabaseCount(Todo::class, 20);
        $this->assertEquals($badge_user->first()->noti_status, "unread");
        $this->assertEquals($user->achievements,2);
    }

    public function test_milestones_user_achieved_2st_badge(){
        $badges = $this->injectBadgesToDB();
        $user = User::factory()->create();
        $count = 49;
        $user->update(['user_type'=>'premium_user','count'=>$count]);
        Todo::factory()->count($count)->create([
            'title' => Str::random(10),
            'description'  => Str::random(10),
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseCount(User::class, 1);
        $this->assertDatabaseCount(badge::class, 3);

        Sanctum::actingAs($user);
        $response = $this->post('api/todos', [
            'title' => 'title to-do testing #' . Str::random(5),
            'description' => 'lorums plorums vec desc',
            'date' => null,
        ], ['Accept' => 'application/json']);
        $response->assertOk();
        $secondBadge = $badges[1];
        $badge_user = DB::table('badge_user')->where('user_id',$user->id)->where('badge_id', $secondBadge->id);
        $this->assertDatabaseCount(Todo::class, 50);
        $this->assertEquals($badge_user->first()->noti_status, "unread");
        $this->assertEquals($user->achievements,5);
    }

    public function test_milestones_user_achieved_3st_badge(){
        $badges = $this->injectBadgesToDB();
        $user = User::factory()->create();
        $count = 99;
        $user->update(['user_type'=>'premium_user','count'=>$count]);
        Todo::factory()->count($count)->create([
            'title' => Str::random(10),
            'description'  => Str::random(10),
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseCount(User::class, 1);
        $this->assertDatabaseCount(badge::class, 3);

        Sanctum::actingAs($user);
        $response = $this->post('api/todos', [
            'title' => 'title to-do testing #' . Str::random(5),
            'description' => 'lorums plorums vec desc',
            'date' => null,
        ], ['Accept' => 'application/json']);
        $response->assertOk();
        $thirdBadge = $badges[2];
        $badge_user = DB::table('badge_user')->where('user_id',$user->id)->where('badge_id', $thirdBadge->id);
        $this->assertDatabaseCount(Todo::class, 100);
        $this->assertEquals($user->count, 100);
        $this->assertEquals($badge_user->first()->noti_status, "unread");
        $this->assertEquals($user->achievements,10);
    }



    public function test_user_able_to_logout()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->get('api/logout', ['Accept' => 'application/json']);
        $response->assertOk();
    }


}
