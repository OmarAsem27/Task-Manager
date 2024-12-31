<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->latest()->get();
        return view('tasks', get_defined_vars());
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
        return redirect('/tasks');

    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
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
        return redirect('/tasks');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect('/tasks');

    }

    public function updateStatus(Task $task)
    {

        if ($task->status == 'In Progress') {
            $task->update(['status' => 'Completed']);
        } else {
            $task->update(['status' => 'In Progress']);
        }
        return redirect('/tasks');
    }
}
