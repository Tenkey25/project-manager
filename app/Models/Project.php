<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'name', 'status' ,'description' ,'end_date'];

    protected $casts = [
        'end_date' => 'date',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

}

