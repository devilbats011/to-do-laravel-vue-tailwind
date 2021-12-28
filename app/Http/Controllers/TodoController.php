<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
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

    
        Todo::create([
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
        // dd($request->all());
        $validatedTodo = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'date' => 'nullable|string|max:255',
            // 'toggle_reminder' => 'required|boolean'
        ]);
        // dd([$request['toggle_reminder'] == false,$request['toggle_reminder'] == true]);
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

    public function sortByLastest(){
        return response()->json(Todo::orderBy('created_at', 'desc'))->status(200);
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

        // public function txt(){
    //     Storage::disk('local')->append('log\audit-log.txt', "xxee");
    //     dd("check flet at ....\to-do-laravel\storage\app\log\{filename}");
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
