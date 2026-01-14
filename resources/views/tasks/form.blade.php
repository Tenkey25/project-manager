<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ $mode === 'edit' ? 'タスク編集' : 'タスク登録' }}
            </h2>

            @if(isset($task))
                <a href="{{ route('projects.show', $task->project_id) }}">
                    戻る
                </a>
            @else
                <a href="{{ route('projects.index') }}">
                    戻る
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- エラーメッセージ --}}
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-600 px-4 py-3 text-white shadow">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- 成功メッセージ --}}
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-600 px-4 py-3 text-white shadow">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ $mode === 'edit'
                        ? route('tasks.update', $task)
                        : route('tasks.store') }}"
                    class="space-y-5">

                    @csrf
                    @if($mode === 'edit')
                        @method('PATCH')
                    @endif

                        {{-- プロジェクト --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">プロジェクト</label>
                            <select name="project_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                focus:border-indigo-500 focus:ring-indigo-500">

                                <option value=""
                                    @selected(old('project_id', $selectedProjectId) === null || old('project_id', $selectedProjectId) === '')>
                                    選択してください
                                </option>

                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}"
                                        @selected((string)old('project_id', $selectedProjectId) === (string)$project->id)>
                                        {{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- タイトル --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">タイトル</label>
                            <input type="text" name="title"
                                value="{{ old('title', $task?->title) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        {{-- 説明 --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">説明</label>
                            <textarea name="description" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $task?->description) }}</textarea>
                        </div>

                        {{-- ステータス --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">ステータス</label>
                            <select name="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach (['todo' => 'todo', 'doing' => 'doing', 'done' => 'done'] as $value => $label)
                                    <option value="{{ $value }}"
                                        @selected(old('status', $task?->status ?? 'todo') === $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- 期限 --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">期限</label>
                            <input type="date" name="due_date"
                                value="{{ old('due_date', $task?->due_date?->format('Y-m-d')) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        {{-- ボタン --}}
                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ $mode === 'edit'
                                ? route('projects.show', $selectedProjectId)
                                : route('dashboard') }}"
                                class="inline-flex items-center rounded-md border border-gray-800 bg-white px-4 py-2 text-sm font-medium text-gray-800
                                hover:bg-gray-100 transition">
                                キャンセル
                            </a>

                            <button type="submit"
                                class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2
                                text-sm font-medium text-white hover:bg-indigo-700 transition">
                                {{ $mode === 'edit' ? '更新' : '登録' }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
