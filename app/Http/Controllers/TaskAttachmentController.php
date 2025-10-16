<?php

namespace App\Http\Controllers;

use App\Models\TaskAttachment;
use Illuminate\Http\Request;

class TaskAttachmentController extends Controller
{
    public function download($id){
        $attachment = TaskAttachment::findOrFail($id);
        return response()->download($attachment->path);
    }

    public function upload(Request $request){
        $attachment = TaskAttachment::create([
            'task_id' => $request->task_id,
            'path' => $request->file('path')->store('attachments'),
        ]);

        return response()->json([
            'data' => $attachment,
            'message' => 'Attachment uploaded successfully',
        ], 201);
    }
}
