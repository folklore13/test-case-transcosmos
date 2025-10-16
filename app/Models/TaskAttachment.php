<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TaskAttachment extends Model
{
    /** @use HasFactory<\Database\Factories\TaskAttachmentFactory> */
    use HasFactory, HasUuids;

    protected $guarded = ['id'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
