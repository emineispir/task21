<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\DeleteTaskRequest;
use App\Http\Requests\Task\ShowTaskRequest;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index() {
        $test = Task::factory()->create();

        $tasks = Task::orderBy('status')->get();
        return TaskResource::collection($tasks);
    }

    public function show(ShowTaskRequest $request, Task $task) {
        return TaskResource::make($task);
    }

    public function store(StoreTaskRequest $request) {
        try {
            $task = Task::create($request->validated());
        } catch (Throwable $exception) {
            Log::info('Task creation failed. ' . $exception->getMessage());
            abort(404, 'Task creation failed. ' . $exception->getMessage());
            throw $exception;
        }

        return TaskResource::make($task)->response()->setStatusCode(201);
    }

    public function update(UpdateTaskRequest $request, Task $task) {
        try {
            $task->update($request->all());
        } catch (Throwable $exception) {
            Log::info('Task update failed. ' . $exception->getMessage());
            abort(404, 'Task update failed. ' . $exception->getMessage());
            throw $exception;
        }

        return TaskResource::make($task->fresh());
    }

    public function destroy(DeleteTaskRequest $request, Task $task) {
        try {
            $task->delete();
        } catch (Throwable $exception) {
            Log::info('Task delete failed. ' . $exception->getMessage());
            abort(404, 'Task delete failed. ' . $exception->getMessage());
            throw $exception;
        }
        return TaskResource::make($task);
    }
}
