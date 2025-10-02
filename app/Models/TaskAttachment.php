<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id','original_name','file_name','file_path','storage_disk',
        'file_size','mime_type','version','is_active'
    ];

    public $timestamps = false; // karena kita pakai uploaded_at

    protected $dates = ['uploaded_at'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
