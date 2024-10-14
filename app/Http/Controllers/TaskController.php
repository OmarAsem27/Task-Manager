<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $tasks = Task::latest()->get();
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
            'category' => 'required|string|max:255'
        ]);
        // $task = new Task;
        // dd($task);
        // $task->body = $fields['body'];
        // $task->category = $fields['category'];
        // $task->save();
        $task = Task::create($fields);
        // $task->categories()->create(['name' => $fields['category']]);
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
        $fields = $request->validate([
            'body' => 'required|string|max:255',
            'category' => 'required|string|max:255'
        ]);
        $task->update($fields);
        return redirect('/tasks');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect('/tasks');

    }
}
