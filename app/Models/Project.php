<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'name', 'status', 'description', 'end_date'];

    protected $casts = [
        'end_date' => 'date',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members')
            ->withPivot('role')
            ->withTimestamps();
    }

    // 自分のプロジェクトだけ
    public function scopeOwnedBy($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    // キーワード検索（name / description）
    public function scopeSearch($query, ?string $keyword)
    {
        if (!$keyword) {
            return $query;
        }

        return $query->where(function ($sub) use ($keyword) {
            $sub->where('name', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%");
        });
    }

    // ステータス絞り込み
    public function scopeStatus($query, ?string $status)
    {
        if (!$status) {
            return $query;
        }

        return $query->where('status', $status);
    }

    // 並び替え
    public function scopeSort($query, ?string $sort)
    {
        return match ($sort) {
            'created_asc' => $query->orderBy('created_at', 'asc'),
            'end_asc'     => $query->orderByRaw('end_date IS NULL, end_date asc'),
            'end_desc'    => $query->orderByRaw('end_date IS NULL, end_date desc'),
            default       => $query->orderBy('created_at', 'desc'),
        };
    }
}

