<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index()
    {
        $task = Task::where('completed',false)->orderBy('priority','desc')->orderBy('due_date')->get();

        dump($task);
        return view('task.index', compact('task'));
    }
}
