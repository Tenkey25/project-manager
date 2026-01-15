<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::query()
            ->latest()          // created_at desc
            ->paginate(10);     // まずは10件ずつ

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();

        Project::create($validated);

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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
}
