<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
/*        
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasks = $user->tasklist()->orderBy('created_at', 'desc');
            
            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
        }
*/        
        if (\Auth::check()) {
            $tasks = Task::all();
            //$tasks = Task::where('user_id', '\Auth::user()->name')->get();
            
            return view('tasks.index', [
                'tasks' => $tasks,
            ]);            
        }        
        return view('welcome',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;
        
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
/*
        $this->validate($request, [
            'content'=>'required|max:191',
            'status'=>'required|max:10',
        ]);
        
        $task = new Task;
        $task->status = $request->status;
        $task->content = $request->content;
        //$task->user_id = 1;
        $task->save();
        
        return redirect('/');
*/      
        $this->validate($request, [
            'content' => 'required|max:191',
            'status' => 'required|max:10',
        ]);
        
        $request->user()->tasklist()->create([
            'content' => $request->content,
            'status' => $request->status,
        ]);
        
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        
        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = task::find($id);
        
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status'=>'required|max:10',
            'content'=>'required|max:191',
        ]);
        
        $task = Task::find($id);
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task=Task::find($id);
        $task->delete();
        
        return redirect('/');
    }
    
    
}
