<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $project->name }}
            </h2>

            <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}"
               class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition">
                タスク追加
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Project info --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-500 dark:text-gray-400">ステータス</span>
                        <span class="px-2 py-1 text-xs rounded bg-gray-100 dark:bg-gray-700">
                            {{ $project->status }}
                        </span>
                    </div>

                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        作成日: {{ $project->created_at->format('Y-m-d H:i') }}
                    </div>
                </div>
            </div>

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
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($project->tasks as $task)
                                        <tr>
                                            <td class="py-3">{{ $task->title }}</td>
                                            <td class="py-3">{{ $task->status }}</td>
                                            <td class="py-3">
                                                {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '-' }}
                                            </td>
                                            <td class="py-3">{{ $task->created_at->format('Y-m-d') }}</td>
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
