<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            プロジェクト{{ $mode === 'edit' ? '更新' : '登録' }}
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

                <form method="POST" action="{{ route('projects.store') }}">
                    
                    @csrf
                    @if($mode === 'edit')
                        @method('PATCH')
                    @endif

                    {{-- name --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">プロジェクト名</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="mt-1 block w-full rounded border-gray-300" />
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- description --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">概要</label>
                        <textarea 
                            name="description" 
                            rows="4" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            {{ old('description')}}
                        </textarea>
                    </div>


                    {{-- status --}}
                    <div class="mb-6">
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

                    {{-- 期限 --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">期限</label>
                        <input type="date" name="end_date"
                            value="{{ old('end_date') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                            focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit"
                            class="inline-flex items-center rounded-md
                            bg-slate-700 px-4 py-2 text-white
                            hover:bg-slate-600 transition">
                            登録
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
