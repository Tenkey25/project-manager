<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">プロジェクト管理</h3>

                    <div class="space-y-2">
                        <a href="{{ route('projects.index') }}"
                        class="inline-block px-4 py-2 bg-slate-700 hover:bg-slate-600 transition text-white rounded">
                            プロジェクト一覧
                        </a>
                        <a href="{{ route('projects.create') }}"
                        class="inline-block px-4 py-2 bg-slate-700 hover:bg-slate-600 transition text-white rounded">
                            プロジェクト登録
                        </a>
                        <a href="{{ route('tasks.create') }}"
                        class="inline-block px-4 py-2 bg-slate-700 hover:bg-slate-600 transition text-white rounded">
                            タスク登録
                        </a>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
