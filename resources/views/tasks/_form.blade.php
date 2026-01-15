<!-- タスク登録・編集共通フォーム -->

@if ($errors->any())
    <div class="mb-4 rounded bg-red-600 px-4 py-3 text-white">
        入力内容にエラーがあります。
    </div>
@endif

<form method="POST" action="{{ $action }}">
    @csrf
    @if (($method ?? 'POST') !== 'POST')
        @method($method)
    @endif

    {{-- project (create時だけ表示) --}}
    @if (!empty($showProjectSelect) && $showProjectSelect === true)
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">プロジェクト</label>
            <select name="project_id" class="mt-1 block w-full rounded border-gray-300">
                <option value=""
                    @selected(old('project_id', $selectedProjectId ?? '') === '' || old('project_id', $selectedProjectId ?? null) === null)>
                    選択してください
                </option>

                @foreach ($projects as $project)
                    <option value="{{ $project->id }}"
                        @selected((string) old('project_id', $selectedProjectId ?? '') === (string) $project->id)>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
            @error('project_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    @endif

    {{-- title --}}
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">タイトル</label>
        <input
            type="text"
            name="title"
            value="{{ old('title', $task->title ?? '') }}"
            class="mt-1 block w-full rounded border-gray-300"
        />
        @error('title')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- description --}}
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">詳細</label>
        <textarea
            name="description"
            rows="4"
            class="mt-1 block w-full rounded border-gray-300"
        >{{ old('description', $task->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- status --}}
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">ステータス</label>
        <select name="status" class="mt-1 block w-full rounded border-gray-300">
            <option value="todo" @selected(old('status', $task->status ?? 'todo') === 'todo')>todo</option>
            <option value="doing" @selected(old('status', $task->status ?? '') === 'doing')>doing</option>
            <option value="done" @selected(old('status', $task->status ?? '') === 'done')>done</option>
        </select>
        @error('status')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- due_date --}}
    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700">期限</label>
        <input
            type="date"
            name="due_date"
            value="{{ old('due_date', optional($task->due_date ?? null)->format('Y-m-d') ?? ($task->due_date ?? '')) }}"
            class="mt-1 block w-full rounded border-gray-300"
        />
        @error('due_date')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-between">
        <button
            type="submit"
            class="inline-flex items-center rounded-md
                bg-slate-700 px-4 py-2 text-white
                hover:bg-slate-600 transition">
            {{ $submitLabel ?? '更新' }}
        </button>

        <a
            href="{{ route('dashboard') }}"
            class="inline-flex items-center rounded-md
                px-4 py-2 text-slate-600 border border-black
                hover:bg-slate-100 hover:text-slate-800
                transition">
            キャンセル
        </a>
    </div>

</form>
