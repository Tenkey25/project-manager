<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
                タスク名：{{ $task->title }}
            </h2>

            <div class="flex items-center gap-3">       
                <a href="{{ route('tasks.edit', ['task' => '$task','from' => 'show']) }}"
                    class="inline-flex items-center rounded-md border border-white/20 bg-white/10 px-4 py-2
                    text-sm font-medium text-white hover:bg-white/20 transition">
                    タスク編集
                </a>
                @can('delete', $task)
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
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

</x-app-layout>

<h2>タスク名：{{ $task->title }}</h2>

<ul>
@forelse ($task->assignees as $user)
    <li>
        {{ $user->name }}
    </li>
@empty
    <p class="text-sm text-gray-500">担当者は未設定です</p>
@endforelse
</ul>
