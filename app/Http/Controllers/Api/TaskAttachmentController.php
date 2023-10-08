<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use App\Models\TaskAttachment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TaskAttachment\UpdateRequest;

class TaskAttachmentController extends Controller
{
    public function update(UpdateRequest $request, $id)
    {
        // When uploading invalid files, I want to receive a 422 response with error messages.
        $request->validated();

        // When uploading files to a non-existent task, I want to receive a 404 response.
        $task = Task::findOrFail($id);

        // When uploading files to a task I do not own, I want to receive a 401 response.
        if ($task->user_id != $request->user()->id) {
            return response('', 401);
        }

        $taskAttachments = TaskAttachment::where('task_id', $task->id);

        $taskAttachmentsArray = $taskAttachments->get();

        $hasUpdate = false;
        if ($request->attachments) {
            $taskAttachments->delete();

            foreach ($taskAttachmentsArray as $taskAttachment) {
                if (!is_null($taskAttachment->attachment_path)) {
                    Storage::disk('public')->delete($taskAttachment->attachment_path);
                }
            }

            $taskAttachments = [];
            foreach ($request->attachments as $attachment) {
                $attachment_path = $attachment->storePublicly('attachments', 'public');

                $taskAttachments[] = [
                    'attachment_path'   => $attachment_path,
                    'task_id'           => $task->id,
                    'updated_at'        => now(),
                    'created_at'        => now(),
                ];
            }

            TaskAttachment::insert($taskAttachments);
            $hasUpdate = true;
        }

        // When uploading valid files, I want to receive a 200 response with the task data that includes an array of attachments.
        $response = [
            'task'                      => $task,
            'attachments'               => $hasUpdate ? $taskAttachments : $taskAttachmentsArray,
        ];
        return response($response, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $taskAttachments = TaskAttachment::where('task_id', $id)
            ->select('id', 'attachment_path')
            ->get();

        $response = [
            'attachments' => $taskAttachments,
        ];
        return response($response, 200);
    }
}
