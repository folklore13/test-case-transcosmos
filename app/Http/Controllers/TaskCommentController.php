<?php

namespace App\Http\Controllers;

use App\Models\TaskComment;
use App\Http\Requests\StoreTaskCommentRequest;
use App\Http\Requests\UpdateTaskCommentRequest;

class TaskCommentController extends Controller
{
    public function store(StoreTaskCommentRequest $request)
    {
        $data = $request->validated();
        $comment = TaskComment::create([
            'task_id' => $data['task_id'],
            'user_id' => $data['user_id'],
            'comment' => $data['comment'],
        ]);
        
        return response()->json([
            'data' => $comment,
            'message' => 'Comment created successfully',
        ], 201);
    }

    public function update(UpdateTaskCommentRequest $request, $id)
    {
        $data = $request->validated();
        $comment = TaskComment::findOrFail($id);
        $comment->update([
            'task_id' => $data['task_id'],
            'comment' => $data['comment'],
        ]);
        
        return response()->json([
            'data' => $comment,
            'message' => 'Comment updated successfully',
        ], 200);
    }

    public function destroy($id)
    {
        $comment = TaskComment::findOrFail($id);
        $comment->delete();
        
        return response()->json([
            'message' => 'Comment deleted successfully',
        ], 204);
    }
}
