<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
                タスク更新
            </h2>

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

                    @include('tasks._form', [
                        'task' => $task,
                        'action' => route('tasks.update', $task),
                        'method' => 'PUT',
                        'submitLabel' => '更新',
                        'showProjectSelect' => false,
                    ])
                    
                </div>
            </div>

        </div>
    </div>
    
</x-app-layout>
