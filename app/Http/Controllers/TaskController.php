<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::where('completed',false)->orderBy('priority','desc')->orderBy('due_date')->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
           'title'=>'required|max:255',
           'description'=>'nullable',
           'priority'=>'required|max:255',
           'due_date'=>'required|max:255',
        ]);
        Task::create([
            'title'=>$request->input('title'),
            'description'=>$request->input('description'),
            'priority'=>$request->input('priority'),
            'due_date'=>$request->input('due_date'),
        ]);

        return redirect()->route('tasks.index')->with('success',"Task Created Successfully");
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        //validating data from the form
        $request->validate([
            'title'=>'required|max:255',
            'description'=>'nullable',
            'priority'=>'required|in:low,medium,high',
            'due_date'=>'required|max:255',
        ]);
        $task->update([
            'title'=>$request->input('title'),
            'description'=>$request->input('description'),
            'priority'=>$request->input('priority'),
            'due_date'=>$request->input('due_date'),
        ]);

        return redirect()->route('tasks.index')->with('success',"Task Updated Successfully");
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('delete',"Task Deleted Successfully");
    }

    public function completed(Task $task)
    {
        $task->update([
           'completed' => true,
           'completed_at' => now(),
        ]);

        return redirect()->route('tasks.index')->with('delete',"Task Completed Successfully");
    }

    public function showCompletedTasks()
    {
        $completedTasks = Task::where('completed',true)->get();

        return view('tasks.completedtasks', compact('completedTasks'));
    }
}
