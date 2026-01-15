<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $projects = Project::query()->latest()->get();  //プロジェクト選択欄にセットするデータ

        // project_id がクエリで渡された時だけセット。なければ null。
        $selectedProjectId = $request->query('project_id') ?: null;

        //DBにプロジェクトが未登録
        if ($projects->isEmpty()) {
            return redirect()
                ->route('projects.create')
                ->with('success', '先にプロジェクトを登録してください。');
        }

        return view('tasks.create', [
            'projects' => $projects,
            'selectedProjectId' => $selectedProjectId,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->validated());

        return redirect()
            ->route('projects.show', $task->project_id)
            ->with('success', 'タスクを登録しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $projects = Project::orderBy('id', 'desc')->get();

        return view('tasks.edit', [
            'task' => $task,
            'projects' => $projects,
            'selectedProjectId' => $task->project_id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        // プロジェクト詳細へ遷移
        return redirect()
            ->route('projects.show', $task->project_id)
            ->with('success', 'タスクを更新しました');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {

        // 念のため project を先に確定（削除後に参照しない）
        $project = $task->project; // belongsTo

        // タスクを SoftDelete
        $task->delete();

        // project が取れないデータが混ざってても落ちないようにする
        if (!$project) {
            return redirect()
                ->route('projects.index')
                ->with('success', 'タスクを削除しました');
        }

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'タスクを削除しました');
        }
}
