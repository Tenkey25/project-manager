<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
            プロジェクト一覧
            </h2>

            <a href="{{ route('projects.create') }}"
                class="inline-flex items-center rounded-md border border-white/20 bg-white/10 px-4 py-2
                text-sm font-medium text-white hover:bg-white/20 transition">
                プロジェクト登録
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

            {{-- 検索 / フィルター --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg bg-indigo-50/70 mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('projects.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                            {{-- Keyword --}}
                            <div class="md:col-span-6">
                                <label for="q" class="block text-sm font-medium text-gray-700">キーワード</label>
                                <input
                                    id="q"
                                    name="q"
                                    type="text"
                                    value="{{ request('q') }}"
                                    placeholder="プロジェクト名 / 説明で検索"
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-indigo-50/60 shadow-sm
                                        focus:border-slate-500 focus:ring-slate-500"
                                >
                            </div>

                            {{-- Status --}}
                            <div class="md:col-span-3">
                                <label for="status" class="block text-sm font-medium text-gray-700">ステータス</label>
                                <select
                                    id="status"
                                    name="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-indigo-50/60 shadow-sm
                                        focus:border-slate-500 focus:ring-slate-500"
                                >
                                    <option value="">すべて</option>
                                    <option value="todo"  @selected(request('status') === 'todo')>todo</option>
                                    <option value="doing" @selected(request('status') === 'doing')>doing</option>
                                    <option value="done"  @selected(request('status') === 'done')>done</option>
                                </select>
                            </div>

                            {{-- Sort --}}
                            <div class="md:col-span-3">
                                <label for="sort" class="block text-sm font-medium text-gray-700">並び替え</label>
                                <select
                                    id="sort"
                                    name="sort"
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-indigo-50/60 shadow-sm
                                        focus:border-slate-500 focus:ring-slate-500"
                                >
                                    <option value="created_desc" @selected(request('sort','created_desc') === 'created_desc')>作成日（新しい順）</option>
                                    <option value="created_asc"  @selected(request('sort') === 'created_asc')>作成日（古い順）</option>
                                    <option value="end_asc"      @selected(request('sort') === 'end_asc')>期限（近い順）</option>
                                    <option value="end_desc"     @selected(request('sort') === 'end_desc')>期限（遠い順）</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 justify-end">
                            <a href="{{ route('projects.index') }}"
                                class="inline-flex items-center px-4 py-2 rounded-md
                                    bg-gray-200 text-gray-700 border border-gray-200
                                    text-sm font-medium
                                    hover:bg-gray-300 hover:border-gray-300
                                    transition">
                                クリア
                            </a>

                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 rounded-md
                                    bg-slate-800 text-white text-sm font-medium
                                    hover:bg-slate-700 transition">
                                検索
                            </button>
                        </div>

                    </form>
                </div>
            </div>


            {{-- プロジェクト一覧テーブル --}}
            <div class="overflow-hidden shadow bg-slate-50 sm:rounded-lg">
                <div class="p-6">
                    @if ($projects->count() === 0)
                        <p class="text-gray-600">まだプロジェクトはありません。</p>
                    @else
                        <table class="w-full text-left text-gray-500">
                            <thead>
                                <tr class="border-b">
                                    <th class="py-3 pr-6">ID</th>
                                    <th class="py-3 pr-6">名前</th>
                                    <th class="py-3 pr-6">ステータス</th>
                                    <th class="py-3 pr-6">期限</th>
                                    <th class="py-3 pr-6">作成日</th>
                                    <th class="py-3 pr-6">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    <tr class="border-b">
                                        <td class="py-2">{{ $project->id }}</td>
                                        <td class="py-2">
                                            <a href="{{ route('projects.show', $project) }}"
                                                class="font-medium text-indigo-600 dark:text-indigo-400
                                                hover:text-indigo-800 dark:hover:text-indigo-300
                                                hover:underline transition">
                                            {{ $project->name }}
                                            </a>
                                        </td>
                                        <td class="py-2">
                                            @can('update', $project)
                                                <form action="{{ route('projects.updateStatus', $project) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')

                                                    <select
                                                        name="status"
                                                        onchange="this.form.submit()"
                                                        class="rounded border-gray-300 text-sm"
                                                    >
                                                        <option value="todo"  @selected($project->status === 'todo')>todo</option>
                                                        <option value="doing" @selected($project->status === 'doing')>doing</option>
                                                        <option value="done"  @selected($project->status === 'done')>done</option>
                                                    </select>
                                                </form>
                                            @else
                                                <span class="text-gray-700">{{ $project->status }}</span>
                                            @endcan
                                        </td>
                                        <td class="py-2">{{ $project->end_date?->format('Y-m-d') }}</td>
                                        <td class="py-2">{{ $project->created_at?->format('Y-m-d') }}</td>
                                        <td class="py-2">
                                            <div class="flex items-center gap-2 whitespace-nowrap">
                                                @can('update', $project)
                                                    <a href="{{ route('projects.edit', ['project' => $project, 'from' => 'index']) }}"
                                                    class="inline-flex items-center rounded-md
                                                            border border-gray-800 bg-slate-50
                                                            px-3 py-1 text-sm font-medium text-gray-800
                                                            hover:bg-gray-100 transition">
                                                        編集
                                                    </a>
                                                @endcan

                                                @can('delete', $project)
                                                    <form action="{{ route('projects.destroy', $project) }}" method="POST"
                                                        onsubmit="return confirm('このプロジェクトを削除しますか？')">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                                class="inline-flex items-center rounded-md
                                                                    bg-rose-600 text-white border border-rose-600
                                                                    px-3 py-1 text-sm font-medium
                                                                    hover:bg-rose-700 hover:border-rose-700 transition">
                                                            削除
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>                                                
                                        </td>
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

            {{-- ホームへ戻るボタン --}}
            <div class="mt-6 flex justify-center">
                <a href="{{ route('dashboard') }}"
                class="inline-flex items-center px-4 py-2 rounded-md
                        bg-gray-200 text-gray-700 border border-gray-200
                        text-sm font-medium
                        hover:bg-gray-300 hover:border-gray-300
                        transition">
                    ← ホームへ戻る
                </a>
            </div>

        </div>
    </div>
</x-app-layout>