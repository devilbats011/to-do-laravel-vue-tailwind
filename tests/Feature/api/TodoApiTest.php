<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoApiTest extends TestCase
{

    use RefreshDatabase;
    
    public function create_get_user_mock()
    {
        $user = User::where('username','mazlan94');

        if ($user->first() == null) {
            $user = User::factory()->create();
        }

        return $user;
    }

    public function test_user_succesfully_login_with_Email_and_password()
    {
        $user = $this->create_get_user_mock();
        $this->withoutExceptionHandling();

        $loginData = ['email_or_username' => 'maz@lan94.com', 'password' => 'pass12345'];

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
        $user = $this->create_get_user_mock();
        $this->withoutExceptionHandling();
        $loginData = ['email_or_username' => 'mazlan94', 'password' => 'pass12345'];

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
        $user = $this->create_get_user_mock();
        Sanctum::actingAs($user);
        $response = $this->get('api/todos', ['Accept' => 'application/json']);
        $response->assertOk()->assertJsonStructure([
            "message",
            "data",
        ]);
    }

    public function test_user_able_to_access_create_page_when_user_had_authenticated()
    {
        $user = $this->create_get_user_mock();
        Sanctum::actingAs($user);
        $response = $this->get('api/todos/create', ['Accept' => 'application/json']);
        $response->assertOk();
    }

    public function test_create_3_new_todo_list_when_user_had_authenticated()
    {
        $user = $this->create_get_user_mock();
        Sanctum::actingAs($user);

        $this->create_a_new_todo();
        $this->create_a_new_todo();
        $this->create_a_new_todo();

    }

    private function create_a_new_todo(){
        $randomString = Str::random(3);
        $response = $this->post('api/todos', [
            'title' => 'title to-do testing #' . $randomString,
            'description' => 'lorums plorums vec desc',
            'date' => null,
        ], ['Accept' => 'application/json']);
        $response->assertOk();
    }

    public function test_edit_the_todo_list_when_user_had_authenticated()
    {
        
        $user = $this->create_get_user_mock();

        Sanctum::actingAs($user);

        $randomString = Str::random(3);
        $response = $this->post('api/todos', [
            'title' => 'title to-do testing #' . $randomString,
            'description' => 'lorums plorums vec desc',
            'date' => null,
        ], ['Accept' => 'application/json']);
        $response->assertOk();

        $this->create_a_new_todo();
        $user = $this->create_get_user_mock();
        Sanctum::actingAs($user);
        $todo = Todo::latest()->first();
        $id = $todo->id;
        $response = $this->put('api/todos/' . $id, [
            'title' => 'title to-do updated testing #',
            'description' => 'lorums plorums vec desc updated',
            'date' => "",
            'toggle_reminder' => false,
        ], ['Accept' => 'application/json']);
        $response->assertOk();
    }

    public function test_delete_the_todo_list_when_user_had_authenticated()
    {
        $user = $this->create_get_user_mock();
        Sanctum::actingAs($user);
        $todo = Todo::latest()->first();
        $id = $todo->id;
        $response = $this->delete('api/todos/' . $id, ['Accept' => 'application/json']);
        $response->assertOk();
    }

    public function test_user_able_to_logout()
    {
        $user = $this->create_get_user_mock();
        Sanctum::actingAs($user);
        $response = $this->get('api/logout', ['Accept' => 'application/json']);
        $response->assertOk();
        $this->clear_user_mock_and_all_user_todos();

    }

    private function clear_user_mock_and_all_user_todos(){
        $this->create_get_user_mock();
        $user = User::where('username', '=', 'mazlan94')->first();
        if($user->todos()->count() > 0){
            $userId = $user->todos()->get()[0]->user_id;
            DB::table('todos')->where('user_id', '=', $userId)->delete();
        }
        $user->delete();
    }

}
