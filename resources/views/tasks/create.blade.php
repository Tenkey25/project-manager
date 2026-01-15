<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            タスク登録
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                @include('tasks._form', [
                    'task' => null,
                    'action' => route('tasks.store'),
                    'method' => 'POST',
                    'submitLabel' => '登録',
                    'showProjectSelect' => true,
                    'projects' => $projects,
                    'selectedProjectId' => $selectedProjectId ?? '',
                ])
            </div>
        </div>
    </div>
</x-app-layout>