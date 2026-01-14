<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
            プロジェクト一覧
            </h2>

            <a href="{{ route('projects.create') }}"
                class="inline-flex items-center rounded-md border border-white/20 bg-white/10 px-4 py-2
                text-sm font-medium text-white hover:bg-white/20 transition">
                新規登録
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 成功メッセージ --}}
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-600 px-4 py-3 text-white shadow">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <div class="p-6">
                    @if ($projects->count() === 0)
                        <p class="text-gray-600">まだプロジェクトはありません。</p>
                    @else
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b">
                                    <th class="py-2">ID</th>
                                    <th class="py-2">名前</th>
                                    <th class="py-2">ステータス</th>
                                    <th class="py-2">作成日</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    <tr class="border-b">
                                        <td class="py-2">{{ $project->id }}</td>
                                        <td class="py-2">{{ $project->name }}</td>
                                        <td class="py-2">{{ $project->status }}</td>
                                        <td class="py-2">{{ $project->created_at?->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $projects->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>