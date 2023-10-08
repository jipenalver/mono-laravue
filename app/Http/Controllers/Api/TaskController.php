<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use App\Models\TaskTag;
use Illuminate\Http\Request;
use App\Models\TaskAttachment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreUpdateRequest;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $type = '')
    {
        $task = Task::select(
            '*',
            DB::raw('(select GROUP_CONCAT(task_tags.tag) from task_tags where task_tags.task_id = tasks.id) as tags'),
            DB::raw('(select GROUP_CONCAT(task_attachments.attachment_path) from task_attachments where task_attachments.task_id = tasks.id) as attachments')
        )
            ->where('user_id', $request->user()->id);

        if ($type == '') {
            $task->whereNull('date_completed')
                ->whereNull('date_archived');
        }

        if ($type == 'completed') {
            $task->whereNotNull('date_completed');
        }
        if ($type == 'archives') {
            $task->whereNotNull('date_archived');
        }

        // When filtering tasks, I want to receive a 200 response with the array of my filtered tasks or an empty array if there are no tasks yet.
        if ($request->keyword) {
            $task->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->keyword . '%')
                    ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->priority) {
            $task->where('priority', $request->priority);
        }

        if ($request->due_date) {
            $dueDate = explode(',', $request->due_date);
            $task->whereBetween('due_date', [$dueDate[0], $dueDate[1]]);
        }

        if ($request->date_completed) {
            $dateCompleted = explode(',', $request->date_completed);
            $task->whereBetween('date_completed', [$dateCompleted[0], $dateCompleted[1]]);
        }

        if ($request->date_archived) {
            $dateArchived = explode(',', $request->date_archived);
            $task->whereBetween('date_archived', [$dateArchived[0], $dateArchived[1]]);
        }

        // When sorting tasks, I want to receive a 200 response with the array of my sorted tasks or an empty array if there are no tasks yet.
        if ($request->column && $request->order) {
            $task->orderBy($request->column, $request->order);
        }

        // When viewing all tasks, I want to receive a 200 response with an array of my tasks or an empty array if there are no tasks yet.
        $response = [
            'tasks' => $task->paginate(5)
        ];
        return response($response, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        // When viewing a non-existent task, I want to receive a 404 response.
        $task = Task::findOrFail($id);

        // When viewing a task I did not create, I want to receive a 401 response.
        if ($task->user_id != $request->user()->id) {
            return response('', 401);
        }

        $taskTags = TaskTag::where('task_id', $task->id)
            ->select('id', 'tag')
            ->get();
        $taskAttachments = TaskAttachment::where('task_id', $task->id)
            ->select('id', 'attachment_path')
            ->get();

        // When viewing a single task, I want to receive a 200 response with the task data.
        $response = [
            'task' => $task,
            'tags' => $taskTags,
            'attachments' => $taskAttachments
        ];
        return response($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateRequest $request)
    {
        // When creating a task with an invalid title and/or description, I want to receive a 422 response with error messages.
        $validated = $request->validated();

        $task = Task::create($validated);

        // When creating a task with a valid title, description, due date, and priority, I want to receive a 200 response with the task data.
        $response = [
            'task' => $task
        ];
        return response($response, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateRequest $request, string $id)
    {
        // When editing a task with invalid inputs, I want to receive a 422 response with error messages.
        $validated = $request->validated();

        // When editing a non-existent task, I want to receive a 404 response.
        $task = Task::findOrFail($id);

        // When editing a task I do not own, I want to receive a 401 response.
        if ($task->user_id != $request->user()->id) {
            return response('', 401);
        }

        $task->update($validated);

        // When editing a task with valid inputs, I want to receive a 200 response with the updated task data.
        $response = [
            'task' => $task
        ];
        return response($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        // When removing a non-existent task, I want to receive a 404 response.
        $task = Task::findOrFail($id);

        // When removing a task I do not own, I want to receive a 401 response.
        if ($task->user_id != $request->user()->id) {
            return response('', 401);
        }

        $task->delete();

        // When removing a task, I want to receive a 204 response.
        return response('', 204);
    }
}
