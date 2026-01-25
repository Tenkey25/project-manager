<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'status',
        'assigned_user_id',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];
    
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignees()
    {
        return $this->belongsToMany(
            User::class,
            'task_assignees' // 中間テーブル名
        )->withTimestamps();
    }

}
