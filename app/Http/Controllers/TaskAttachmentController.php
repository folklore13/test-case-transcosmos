<?php

namespace App\Http\Controllers;

use App\Models\TaskAttachment;
use App\Http\Requests\StoreTaskAttachmentRequest;

class TaskAttachmentController extends Controller
{
    public function download($id){
        $attachment = TaskAttachment::findOrFail($id);
        return response()->download($attachment->path);
    }

    public function upload(StoreTaskAttachmentRequest $request){
        $data = $request->validated();
        $file = $data['file'];

        $attachment = TaskAttachment::create([
            'task_id' => $data['task_id'],
            'path' => $file->store('attachments'),
        ]);

        return response()->json([
            'data' => $attachment,
            'message' => 'Attachment uploaded successfully',
        ], 201);
    }
}
