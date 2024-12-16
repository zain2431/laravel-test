<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateTaskRequest;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::where('user_id', '=', Auth::user()->id)->get();
        if (count($tasks) > 0) {
            return response()->json($tasks, 200);
        } else {
            return response()->json(['message' => 'No tasks found'], 404);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTaskRequest $request)
    {
        Task::create($request->validated()+['user_id'=>Auth::user()->id,'status'=>'pending']);
        return response()->json([
            'message' => 'Task created successfully'
        ], 
        200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return response()->json([
            'message' => 'Task',
            'data' => $task
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return response()->json([
            'task' => $task,
            'message' => 'Task'
        ],status:200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        return response()->json([
            'message' => 'Task updated successfully'
        ], 
        200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if($task->user_id == Auth::user()->id)
        {
            $task->delete();
            return response()->json([
                'message' => 'Task deleted successfully'
            ], 
            200);
        }
        return response()->json([
            'message' => 'Unauthorized to delete this task'
        ], 401);  // Unauthorized to delete this task. 401 Unauthorized HTTP status code.
    }
}
