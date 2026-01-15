<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
                プロジェクト名：{{ $project->name }}
            </h2>

            <div class="flex items-center gap-3">
                <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}"
                class="inline-flex items-center px-4 py-2 rounded-md
                        border border-white/20 bg-white/10
                        text-sm font-medium text-white
                        hover:bg-white/20 transition">
                    タスク追加
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
                </div>
            </div>

            {{-- 成功メッセージ --}}
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-600 px-4 py-3 text-white shadow">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tasks --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg mb-4">タスク一覧</h3>

                    @if($project->tasks->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">まだタスクがありません。</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="text-left text-gray-600 dark:text-gray-300">
                                    <tr>
                                        <th class="py-2">タイトル</th>
                                        <th class="py-2">ステータス</th>
                                        <th class="py-2">期限</th>
                                        <th class="py-2">作成日</th>
                                        <th class="py-2 text-center w-32 whitespace-nowrap">操作</th>

                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($project->tasks as $task)
                                        <tr>
                                            <td class="py-3">
                                                {{ $task->title }}
                                            </td>
                                            <td class="py-3">{{ $task->status }}</td>
                                            <td class="py-3">
                                                {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '-' }}
                                            </td>
                                            <td class="py-3">{{ $task->created_at->format('Y-m-d') }}</td>
                                            <td class="py-2">
                                                <div class="flex justify-center items-center gap-2 whitespace-nowrap">
                                                    <a href="{{ route('tasks.edit', $task) }}"
                                                    class="inline-flex items-center rounded-md
                                                    border border-gray-800 bg-white
                                                    px-3 py-1 text-sm font-medium text-gray-800
                                                    hover:bg-gray-100 transition">
                                                        編集
                                                    </a>

                                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                                        onsubmit="return confirm('このタスクを削除しますか？')">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                            class="inline-flex items-center rounded-md
                                                                bg-rose-600 text-white border border-rose-600
                                                                px-3 py-1 text-sm font-medium text-white
                                                                hover:bg-rose-700 hover:border-rose-700 transition">
                                                                削除
                                                        </button>
                                                    </form>

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

        </div>
    </div>
</x-app-layout>
