<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use App\Models\TaskTag;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskTag\UpdateRequest;

class TaskTagController extends Controller
{
    public function update(UpdateRequest $request, $id)
    {
        // When adding invalid tags, I want to receive a 422 response with error messages.
        $request->validated();

        // When adding tags to a non-existent task, I want to receive a 404 response.
        $task = Task::findOrFail($id);

        // When adding tags to a task I do not own, I want to receive a 401 response.
        if ($task->user_id != $request->user()->id) {
            return response('', 401);
        }

        $taskTags = TaskTag::where('task_id', $task->id);

        $taskTagsArray = $taskTags->get();

        $hasUpdate = false;
        if ($request->tags) {
            $taskTags->delete();

            $taskTags = [];
            foreach ($request->tags as $tag) {
                $taskTags[] = [
                    'tag'               => $tag,
                    'task_id'           => $task->id,
                    'updated_at'        => now(),
                    'created_at'        => now(),
                ];
            }

            TaskTag::insert($taskTags);
            $hasUpdate = true;
        }

        // When adding valid tags to a task, I want to receive a 200 response with the task data that includes an array of tags.
        $response = [
            'task'                      => $task,
            'tags'                      => $hasUpdate ? $taskTags : $taskTagsArray,
        ];
        return response($response, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $taskTags = TaskTag::where('task_id', $id)
            ->select('id', 'tag')
            ->get();

        $response = [
            'tags' => $taskTags,
        ];
        return response($response, 200);
    }
}
