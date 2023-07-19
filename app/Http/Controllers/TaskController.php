<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index() {
        return response()->json([
            'tasks' => Task::paginate(2)
        ], 201);
    }

    public function show(Task $task) {
        return response()->json([
            'task' => new TaskResource($task)
        ]);
    }

    private function validateRequest(Request $request) {
          $validator = Validator::make($request->all(), [
            'title' => 'required|max:20',
            'description' => 'required|max:255',
            'due_date' => 'required|date_format:Y-m-d',
        ]);

        return $validator;
    }

    public function update(Request $request, Task $task) {
        $validate = $this->validateRequest($request);
        if ($validate->fails()) {
            return response()->json([
                'message' => 'Invalid user input!',
                'error' => $validate->errors()->toJson()
            ], 422);
        }

        $task = $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        return response('Task updated successfully!');
        
    }

    public function store(Request $request) {
        $validate = $this->validateRequest($request);
         if ($validate->fails()) {
            return response()->json([
                'message' => 'Invalid user input!',
                'error' => $validate->errors()->toJson()
            ], 422);
        }

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'user_id' => $request->user()->id
        ]);

        return response('Task created successfully!');
    }
    
    
    public function destroy(Task $task) {
        $delete = $task->delete();
        if($delete) {
            return response('Deleted Successfully');
        } else {
            return response('Server maintenance!', 500);
        } 
    }
}