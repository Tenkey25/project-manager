<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            プロジェクト編集
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

                <form method="POST" action="{{ route('projects.update', $project) }}">
                    @csrf
                    @method('PUT')

                    {{-- name --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">プロジェクト名</label>
                        <input type="text" name="name"
                               value="{{ old('name', $project->name) }}"
                               class="mt-1 block w-full rounded border-gray-300" />
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- description --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">概要</label>
                        <textarea name="description" rows="4"
                                  class="mt-1 block w-full rounded border-gray-300">{{ old('description', $project->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- status --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">ステータス</label>
                        <select name="status" class="mt-1 block w-full rounded border-gray-300">
                            <option value="todo" @selected(old('status', $project->status) === 'todo')>todo</option>
                            <option value="doing" @selected(old('status', $project->status) === 'doing')>doing</option>
                            <option value="done" @selected(old('status', $project->status) === 'done')>done</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- end_date --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">期限</label>
                        <input type="date" name="end_date"
                               value="{{ old('end_date', optional($project->end_date)->format('Y-m-d') ?? $project->end_date) }}"
                               class="mt-1 block w-full rounded border-gray-300" />
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit"
                                class="inline-flex items-center rounded-md bg-slate-700 px-4 py-2 text-white hover:bg-slate-600 transition">
                            更新
                        </button>

                        @php
                            $from = request('from');
                        @endphp

                        <a
                            href="{{ $from === 'show'
                                ? route('projects.show', $project)
                                : route('projects.index') }}"
                            class="inline-flex items-center rounded-md
                                px-4 py-2 text-slate-600 border border-black
                                hover:bg-slate-100 hover:text-slate-800
                                transition">
                            キャンセル
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
