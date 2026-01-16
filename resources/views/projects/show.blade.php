<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
                プロジェクト名：{{ $project->name }}
            </h2>

            <div class="flex items-center gap-3">

                <a href="{{ route('projects.edit', $project) }}"
                    class="inline-flex items-center rounded-md border border-white/20 bg-white/10 px-4 py-2
                    text-sm font-medium text-white hover:bg-white/20 transition">
                    プロジェクト編集
                </a>

                @can('delete', $project)
                    <form action="{{ route('projects.destroy', $project) }}" method="POST"
                        onsubmit="return confirm('このプロジェクトを削除しますか？紐づくタスクも削除されます。')">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 rounded-md
                                bg-rose-600 text-white border border-rose-600
                                text-sm font-medium
                                hover:bg-rose-700 hover:border-rose-700
                                transition">
                            プロジェクト削除
                        </button>
                    </form>
                @endcan
            </div>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- 成功メッセージ --}}
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-600 px-4 py-3 text-white shadow">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Project info --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-500 dark:text-gray-400">プロジェクトステータス</span>
                        <span class="px-2 py-1 text-xs rounded bg-gray-100 dark:bg-gray-700">
                            {{ $project->status }}
                        </span>
                    </div>

                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        作成日: {{ $project->created_at->format('Y-m-d H:i') }}
                    </div>

                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        概要: {{ $project->description }}
                    </div>
                </div>
            </div>

            {{-- Tasks --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">タスク一覧</h3>

                        <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-md
                                bg-slate-700 text-white
                                text-sm font-medium
                                hover:bg-slate-700 transition">
                            <span class="text-lg leading-none">＋</span>
                            タスク追加
                        </a>
                    </div>

                    @if($project->tasks->isEmpty())
                        <p class="text-gray-500">まだタスクがありません。</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="text-left text-gray-500 border-b">
                                    <tr>
                                        <th class="py-3 pr-6 font-medium">タイトル</th>
                                        <th class="py-3 pr-6 font-medium">ステータス</th>
                                        <th class="py-3 pr-6 font-medium">期限</th>
                                        <th class="py-3 pr-6 font-medium">作成日</th>
                                        <th class="py-3 font-medium">操作</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y">
                                    @foreach($project->tasks as $task)
                                        <tr>
                                            <td class="py-4 pr-6">
                                                {{ $task->title }}
                                            </td>

                                            <td class="py-4 pr-6">
                                                {{ $task->status }}
                                            </td>

                                            <td class="py-4 pr-6">
                                                {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '-' }}
                                            </td>

                                            <td class="py-4 pr-6">
                                                {{ $task->created_at->format('Y-m-d') }}
                                            </td>

                                            <td class="py-4">
                                                <div class="flex items-center gap-2 whitespace-nowrap">
                                                    @can('update', $task)
                                                        <a href="{{ route('tasks.edit', $task) }}"
                                                        class="inline-flex items-center px-3 py-1 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-800 hover:bg-gray-50 transition">
                                                            編集
                                                        </a>
                                                    @endcan

                                                    @can('delete', $task)
                                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                                            onsubmit="return confirm('このタスクを削除しますか？')">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                    class="inline-flex items-center px-3 py-1 rounded-md bg-rose-600 text-white text-sm font-medium hover:bg-rose-700 transition">
                                                                削除
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6 flex justify-center">
                <a href="{{ route('projects.index') }}"
                class="inline-flex items-center px-4 py-2 rounded-md
                        bg-gray-200 text-gray-700 border border-gray-200
                        text-sm font-medium
                        hover:bg-gray-300 hover:border-gray-300
                        transition">
                    ← プロジェクト一覧へ戻る
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
