<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\Controller;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if (!$user || !auth()->user()->can('view tasks')) {
            abort(403);
        }

        // if the user is Admin
        if ($user->hasPermissionTo('view all tasks')) {
            $tasks = Task::all();
        } else {
            $tasks = Task::where('user_id', $user->id)->get();
        }

        return view('tasks', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    public function store(StoreTaskRequest $request)
    {
        if (!auth()->user()->can('create tasks')) {
            abort(403);
        }
        $fields = $request->validate([
            'body' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'status' => 'required|in:In Progress,Completed',
        ]);

        // to avoid the Auth::id() error
        if (request()->is('web/*') || !request()->is('api/*')) {
            $fields['user_id'] = Auth::guard('web')->id();
        } else {
            $fields['user_id'] = Auth::guard('api')->id();
        }

        $task = Task::create($fields);
        $task->category($fields['category']);
        return redirect()->route('home');

    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // dd(request()->route());  // Debugging route details inside the controller

        return view('show',compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task, UpdateTaskRequest $request)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        if (!auth()->user()->can('edit tasks')) {
            abort(403);
        }
        $fields = $request->validate([
            'body' => 'required|string|max:255',
            'category' => 'required|string|max:255',
        ]);
        $task->update($fields);
        $arr = [];
        foreach (explode(",", $fields['category']) as $singleCategory) {
            $createdTask = Category::firstOrCreate(['name' => $singleCategory]);
            $arr[] = $createdTask->id;
        }
        $task->categories()->sync($arr);
        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if (!auth()->user()->can('delete tasks')) {
            abort(403);
        }
        $task->delete();
        return redirect()->route('home');

    }

    public function updateStatus(Task $task)
    {
        if (!auth()->user()->can('edit tasks')) {
            abort(403);
        }
        if ($task->status == 'In Progress') {
            $task->update(['status' => 'Completed']);
        } else {
            $task->update(['status' => 'In Progress']);
        }
        return redirect()->route('home');
    }
}
