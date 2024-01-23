<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::where('completed',false)->orderBy('priority','desc')->orderBy('due_date')->get();

        dump($tasks);
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
           'title'=>'require|max:255',
           'description'=>'nullable',
           'priority'=>'require|max:255',
           'due_date'=>'require|max:255',
        ]);
        Task::create([
            'title'=>$request->input('title');
            'description'=>$request->input('description');
            'priority'=>$request->input('priority');
            'due_date'=>$request->input('due_date');
        ]);

        return redirect()->route('tasks.index')-with('success',"Task Created Successfully");
    }

    public function edit()
    {
        return view('tasks.create');
    }

}
