<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
                プロジェクト名：{{ $task->project->name }}
            </h2>

            <div class="flex items-center gap-3">       
                <a href="{{ route('tasks.edit', ['task' => '$task','from' => 'show']) }}"
                    class="inline-flex items-center rounded-md border border-white/20 bg-white/10 px-4 py-2
                    text-sm font-medium text-white hover:bg-white/20 transition">
                    プロジェクト編集
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

    {{-- 成功メッセージ --}}
    @if (session('success'))
        <div class="mt-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-lg bg-green-600 px-6 py-4 text-white shadow">
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- タスク詳細カード --}}
    <div class="mt-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white/10 border border-white/20 rounded-lg p-6 text-white space-y-4">

            {{-- 上段：タスク名 + 操作ボタン --}}
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold">
                    {{$task -> title}}
                </h3>

                <h5 class="text-lg justify-end translate-y-[12px]">
                    期限：</br>
                   {{ $task->due_date?->format('Y/m/d') ?? '未設定' }}
                </h5>

            </div>

            {{-- 担当メンバー --}}           
            <div class="flex flex-wrap gap-2">
                @forelse ($task->assignees as $user)             
                <span class="px-3 py-1 text-sm rounded-full bg-indigo-500/20 text-indigo-200 border border-indigo-400/30">
                    {{ $user->name }}
                </span>
                @empty
                    <p class="text-sm text-gray-500">担当者は未設定です</p>
                @endforelse
            </div>

            {{-- 区切り線 --}}
            <hr class="border-white/20">

            {{-- タスク詳細ラベル --}}
            <div class="text-base font-semibold text-white/80 translate-y-[12px]">
                タスク詳細
            </div>

            {{-- 詳細内容ボックス --}}
            <div class="mt-0.5 bg-black/20 border border-white/10 rounded-md p-4 text-sm leading-relaxed">
                {{ $task->description }}
            </div>

            <div class="mt-3 flex justify-end gap-2">

            {{-- 編集 --}}
            <a href="{{ route('tasks.edit', ['task' => $task, 'from' => 'taskshow']) }}"
                class="inline-flex items-center justify-center
                        w-9 h-9 rounded-md
                        bg-white/10 text-white
                        hover:bg-white/20 transition"
                title="タスク編集">
                    {{-- 鉛筆アイコン --}}
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-8.5 h-8.5 translate-x-[3.5px] translate-y-[3.6px]"
                        fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11 4h2a2 2 0 012 2v2m-4-4L5 10v4h4l6-6m-4-4l4 4" />
                    </svg>
            </a>

            {{-- 削除 --}}
            @can('delete', $task)
            <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                onsubmit="return confirm('このタスクを削除しますか？')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center justify-center
                        w-9 h-9 rounded-md
                        bg-rose-600/20 text-rose-400
                        hover:bg-rose-600/30 hover:text-rose-300
                        transition"
                    title="タスク削除">
                    {{-- ゴミ箱アイコン --}}
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6"
                        fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                                a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                                M9 7h6m2 0H7m2-3h6a1 1 0 011 1v1H8V5a1 1 0 011-1z"/>
                    </svg>
                </button>
            </form>
            @endcan
        </div>
    </div>

    <div class="mt-6 flex justify-center">
        <a href="{{ route('projects.show', $task->project) }}"
        class="inline-flex items-center px-4 py-2 rounded-md
                bg-gray-200 text-gray-700 border border-gray-200
                text-sm font-medium
                hover:bg-gray-300 hover:border-gray-300
                transition">
            ← プロジェクト詳細へ戻る
        </a>
    </div>
</x-app-layout>
