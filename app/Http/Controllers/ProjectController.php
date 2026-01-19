<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Project::class, 'project');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $projects = Project::query()
        ->ownedBy(auth()->id())
        ->withcount([
            'tasks as tasks_todo_count' => fn ($q) => $q->where('status', 'todo'),
            'tasks as tasks_doing_count' => fn ($q) => $q->where('status', 'doing'),
            'tasks as tasks_done_count' => fn ($q) => $q->where('status', 'done'),
        ])
        ->search($request->q)
        ->status($request->status)
        ->sort($request->input('sort', 'created_desc'))
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return view('projects.index', compact('projects'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create',[
            'mode' => 'create',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();

        Project::create([
            ...$validated,
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('projects.index')
            ->with('success', 'プロジェクトを登録しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load('tasks');

        return view('projects.show', compact('project'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {

        return view('projects.edit', compact('project'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->validated());

        $from = $request->input('from') ?? $request->query('from');

        if ($from === 'show') {
            return redirect()
                ->route('projects.show', $project)
                ->with('success', 'プロジェクトを更新しました');
        }

        return redirect()
            ->route('projects.index')
            ->with('success', 'プロジェクトを更新しました');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        
        // 紐づくタスクを先に SoftDelete
        $project->tasks()->delete();

        // プロジェクトを SoftDelete
        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'プロジェクトを削除しました');
    }

    /**
     * プロジェクト詳細画面にてタスクのステータスのみを切り替えるメソッド
     */
    public function updateStatus(Request $request, Project $project)
    {

        $request->validate([
            'status' => ['required', 'in:todo,doing,done'],
        ]);

        $project->update([
            'status' => $request->status,
        ]);

        return back();
    }
}
