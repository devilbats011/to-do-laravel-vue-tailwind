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
        $UserAllToDos = Todo::where('user_id',Auth::id())->orderByDesc('created_at')->paginate(5);
        return response()->json([
            "message" => "get All To-Do",
            "data" => $UserAllToDos,
        ]);
    }

    private function sendReminderEmailTodo(Todo $todo,$id) {
        $data = [$todo,$id];
        $checkDate = empty($todo['date']) ? "date is empty" : "date not empty";
         Storage::disk('local')->append('error_log/error_check.txt', $todo['date']." <-date| reminder-> ".$todo['toggle_reminder'].'| empty?: '.$checkDate.'| carbon date:'.Carbon::parse($todo['date'],'Asia/Kuala_Lumpur')->toString().' | date now:'.Carbon::now('Asia/Kuala_Lumpur'));
        $date = $todo['date'];
        if($todo['toggle_reminder'] == 1 && empty($date) == false) {
            SendReminderEmailJob::dispatch($data)->delay(Carbon::parse($date,'Asia/Kuala_Lumpur'));
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
        /** @var \App\Models\user */
        $user = Auth::user();
        
        $todo = Todo::create([
            'user_id'=> $user->id,
            'title' => $validatedTodo['title'],
            'description' => $validatedTodo['description'],
            'date' => $validatedTodo['date'] ,
            'toggle_reminder' => $request['toggle_reminder'],
        ]);

        $milestonesArray = $user->handleMilestones();
    
        event(new EventTodoLog( $validatedTodo['title'],"Store New Todo item"));
        $this->sendReminderEmailTodo($todo,$user->id);

        return response()->json([
            'message' => 'Sucessfully added One to-do list',
            'message_status' => 'SUCCESS',
            'to' => 'display',
            'milestones' => $milestonesArray,
            // below is milesstones data for reference
            // 'notficition_status' => $noti_status,
            // 'achievements' => $achievementCount,
            // 'badge_id' => $badge->id,
            // 'badge_name' => $badge->name,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatetodoRequest  $request
  
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $todo = Todo::find($id);
                /** @var \App\Models\user */
                $user = Auth::user();
        if ($user->cannot('update', $todo)) {
           
            return response()->json([
                'message' => 'Other user cannot update other user todo list',
                'message_status' => 'DENIED',
                'to' => 'display'
            ],403);
        }

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

        
        $todo['title'] = $validatedTodo['title'];
        $todo['description'] = $validatedTodo['description'];
        $todo['date'] = $validatedTodo['date'];
        $todo['toggle_reminder'] = $request['toggle_reminder'];
        $todo->save();

        event(new EventTodoLog( $todo['title'] ,"Updated a Todo item"));
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
        // if ($request->user()->cannot('update', $id)) {
        /** @var \App\Models\user */
        $user = Auth::user();
        $todo = Todo::find($id);
        if ($user->cannot('delete', $todo)) {
            return response()->json([
                'message' => 'Other user cannot delete other user todo list',
                'message_status' => 'DENIED',
                'to' => 'display'
            ],403);
        }
      
        $todo->delete();

        event(new EventTodoLog( $todo['title'],"Deleted a Todo item"));
        return response()->json([
            'message' => 'Sucessfully Deleted the to-do list',
            'to' => 'display'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $status  = $request->get('permission') === "ALLOW" ? 200 : 403;
        $data = response()->json([
            'check-todo-count' =>
        [
            'permission' => $request->get('permission'),
            'message' => $request->get('message'),
            'redirect' => $request->get('redirect'),
            'to' => $request->get('to'),
        ]
        ],$status);

        return $data;
    }

}
