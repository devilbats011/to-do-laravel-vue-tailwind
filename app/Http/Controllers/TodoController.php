<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Todo;
use Illuminate\Http\Request;
use App\Providers\EventTodoLog;
use App\Jobs\SendReminderEmailJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TodoController extends Controller
{
    public function index()
    {
        $UserAllToDos = Todo::where('user_id',Auth::id())->orderByDesc('created_at')->get();
        return response()->json([
            "message" => "get All To-Do",
            "data" => $UserAllToDos
        ]);
    }

    private function sendReminderEmailTodo(Todo $todo,$id) {
       
        // $user = User::find($this->userId);
        
        $data = [$todo,$id];
        //  $checkDate = empty($todo['date']) ? "date is empty" : "date not empty";
        //  Storage::disk('local')->append('error_log/error_check.txt', $todo['date']." <-date| reminder-> ".$todo['toggle_reminder'].'| empty?: '.$checkDate.'| carbon date:'.Carbon::parse($todo['date'])->toString());
        $date = $todo['date'];
        if($todo['toggle_reminder'] == 1 && empty($date) == false) {
            SendReminderEmailJob::dispatch($data)->delay(Carbon::parse($date));
        }
        return null;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoretodoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedTodo = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'date' => 'nullable|string|max:255',
        ]);

    
        $request['toggle_reminder'] = !empty($request['date']) ? true : false;

        $user = Auth::user();
        
    
         $todo = Todo::create([
            'user_id'=> $user->id,
            'title' => $validatedTodo['title'],
            'description' => $validatedTodo['description'],
            'date' => $validatedTodo['date'] ,
            'toggle_reminder' => $request['toggle_reminder'],
        ]);

        /** @var \App\Models\user */
        $user = Auth::user();
        $milestonesArray = $this->milestones($user);
        $count = $user['count'];
        $sum = 1 + $count;
        $user['count'] = $sum;
        $user->save();
        
        //updated|created|user name|date write the log|achieviement|user_type
     
        event(new EventTodoLog( $validatedTodo['title'],"Store New Todo item"));
        $this->sendReminderEmailTodo($todo,$user->id);

        return response()->json([
            'message' => 'Sucessfully added One to-do list',
            'message_status' => 'SUCCESS',
            'to' => 'display',
            'count' => $sum,
            'milestones' =>[
                'badge_1' => $milestonesArray['badge_1'],
                'badge_2' => $milestonesArray['badge_2'],
                'badge_3' => $milestonesArray['badge_3'],
                'achievements' => $milestonesArray['achievements']
            ],
           
         
        ]);
    }

    private function milestones($_user){
        $badge_1 = $_user['badge_1'];
        $badge_2 = $_user['badge_2'];
        $badge_3 = $_user['badge_3'];
        $number = ($_user['count']+1)/10;

        if(is_int($number)){
            $_user['achievements'] = $number;
        }
        
        // none,pass,achieved
        $pass = "pass";
        if($_user['achievements'] == 2 && $badge_1 == "none"){
            $_user['badge_1'] = $pass;
        }
        else if($_user['achievements'] == 5 && $badge_2 == "none"){
            $_user['badge_2'] = $pass;
        }
        else if($_user['achievements'] == 10 && $badge_3 == "none"){
            $_user['badge_3'] = $pass;
        }
        $_user->save();
        
        return [
            'badge_1' => $_user['badge_1'],
            'badge_2' => $_user['badge_2'],
            'badge_3' => $_user['badge_3'],
            'achievements' => $_user['achievements']
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatetodoRequest  $request
  
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedTodo = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'date' => 'nullable|string|max:255',
           
        ]);
      
        if ($request['toggle_reminder'] == false ){
            $request['date'] = null; 
            $request['toggle_reminder'] = 0;    
        }
        else {
            $request['toggle_reminder'] = 1;  
        }

        $todo = Todo::find($id);
        $todo['title'] = $validatedTodo['title'];
        $todo['description'] = $validatedTodo['description'];
        $todo['date'] = $validatedTodo['date'];
        $todo['toggle_reminder'] = $request['toggle_reminder'];
        $todo->save();

        event(new EventTodoLog( $todo['title'] ,"Updated a Todo item"));
        //Auth::user()->email,$todo
        $this->sendReminderEmailTodo($todo,Auth::id());

        return response()->json([
            'message' => 'Sucessfully Updated the to-do list',
            'message_status' => 'SUCCESS',
            'to' => 'display'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *

     * @return \Illuminate\Http\Response
     */
    public function destroy($id) //todo $todo
    {
        $todo = Todo::find($id);
        $todo->delete();

        event(new EventTodoLog( $todo['title'],"Deleted a Todo item"));
        return response()->json([
            'message' => 'Sucessfully Deleted the to-do list',
            'to' => 'display'
        ]);
    }
    
    public function test(Request $info)
    {
        return response()->json(["request" =>
        [
            'finally' => $info->get('finally'),
            'count' => $info->get('count')
        ]]);
    }

    public function pagination(){
        return response()->json(Todo::paginate())->status(200);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\todo  $todo
     * @return \Illuminate\Http\Response
     */
    // public function show(todo $todo)
    // {

    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\todo  $todo
     * @return \Illuminate\Http\Response
     */
    // public function edit(todo $todo)
    // {
    //     return null;
    // }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return response()->json(["check-todo-count" =>
        [
            'permission' => $request->get('permission'),
            'redirect' => $request->get('redirect'),
            'to' => $request->get('to'),
            'count' => $request->get('count'),
        ]]);
    }

}
