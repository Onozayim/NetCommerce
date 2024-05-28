<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskSingleResource;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function create(Request $request) {
        $validator = Validator::make($request->only('name', 'description', 'company_id', 'user_id'),[
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'company_id' => ['required', 'integer', 'exists:companies,id'],
            'user_id' => ['required', 'integer', 'exists:users,id']
        ]);

        if ($validator->fails()) {
            Log::info($validator->errors());
            return response()->json($validator->errors());
        }

        $tasks_count = Task::where('user_id', $request->input('user_id'))->where('is_completed', 0)->count();

        if($tasks_count >= 5) 
            return response()->json(["user_id" => ["An user can't have more than 5 incomplete tasks"]]);

        $task = Task::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'company_id' => $request->input('company_id'),
            'user_id' => $request->input('user_id')
        ]);

        $task->load('user', 'company');

        return TaskSingleResource::make($task);
    }
}
