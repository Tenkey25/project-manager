<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            タスク登録
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 rounded bg-red-600 px-4 py-3 text-white">
                        入力内容にエラーがあります。
                    </div>
                @endif

                <form method="POST" action="{{ route('tasks.store') }}">
                    @csrf

                    {{-- project --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">プロジェクト</label>
                        <select name="project_id" class="mt-1 block w-full rounded border-gray-300">
                            <option value="">選択してください</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}" @selected(old('project_id', $selectedProjectId) == $project->id)>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('project_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- title --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">タイトル</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="mt-1 block w-full rounded border-gray-300" />
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- description --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">詳細</label>
                        <textarea name="description" rows="4"
                                  class="mt-1 block w-full rounded border-gray-300">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- status --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">ステータス</label>
                        <select name="status" class="mt-1 block w-full rounded border-gray-300">
                            <option value="todo" @selected(old('status', 'todo') === 'todo')>todo</option>
                            <option value="doing" @selected(old('status') === 'doing')>doing</option>
                            <option value="done" @selected(old('status') === 'done')>done</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- due_date --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">期限</label>
                        <input type="date" name="due_date" value="{{ old('due_date') }}"
                               class="mt-1 block w-full rounded border-gray-300" />
                        @error('due_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="inline-flex items-center rounded-md bg-slate-700 px-4 py-2 text-white hover:bg-slate-600 transition">
                        登録
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
