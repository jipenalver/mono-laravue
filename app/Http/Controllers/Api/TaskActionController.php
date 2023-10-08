<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\DueDateRequest;

class TaskActionController extends Controller
{
    public function complete(Request $request, string $id)
    {
        // When marking a non-existent task as completed, I want to receive a 404 response
        $task = Task::findOrFail($id);

        // When marking a task I do not own as completed, I want to receive a 401 response.
        if ($task->user_id != $request->user()->id) {
            return response('', 401);
        }

        $task->date_completed = now();
        $task->save();

        // When marking a task as completed, I want to receive a 200 response with the updated task data.
        $response = [
            'task' => $task
        ];
        return response($response, 200);
    }

    public function incomplete(Request $request, string $id)
    {
        $task = Task::find($id);

        // When marking a task I do not own as incomplete, I want to receive a 401 response.
        if ($task->user_id != $request->user()->id) {
            return response('', 401);
        }

        $task->date_completed = null;
        $task->save();

        // When marking a task as incomplete, I want to receive a 200 response with the updated task data.
        $response = [
            'task' => $task
        ];
        return response($response, 200);
    }

    public function due(DueDateRequest $request, string $id)
    {
        // When adding an invalid due date to a task, I want to receive a 422 response with error messages.
        $validated = $request->validated();

        // When adding a due date to a non-existent task, I want to receive a 404 response.
        $task = Task::findOrFail($id);

        $task->due_date = $validated['due_date'];
        $task->save();

        // When adding a valid due date to a task, I want to receive a 200 response with the updated task data.
        $response = [
            'task' => $task
        ];
        return response($response, 200);
    }

    public function archive(Request $request, string $id)
    {
        // When archiving a non-existent task, I want to receive a 404 response.
        $task = Task::findOrFail($id);

        // When archiving a task I do not own, I want to receive a 401 response.
        if ($task->user_id != $request->user()->id) {
            return response('', 401);
        }

        $task->date_archived = now();
        $task->save();

        // When archiving a task, I want to receive a 200 response with the updated task data.
        $response = [
            'task' => $task
        ];
        return response($response, 200);
    }

    public function restore(Request $request, string $id)
    {
        // When restoring a non-existent task, I want to receive a 404 response.
        $task = Task::findOrFail($id);

        // When restoring a task I do not own, I want to receive a 401 response.
        if ($task->user_id != $request->user()->id) {
            return response('', 401);
        }

        $task->date_archived = null;
        $task->save();

        // When restoring a task, I want to receive a 200 response with the updated task data
        $response = [
            'task' => $task
        ];
        return response($response, 200);
    }
}
