<h2>プロジェクトメンバー</h2>

<ul>
@foreach ($task->project->members as $member)
    <li>
        {{ $member->name }}
        <span class="text-sm text-gray-500">
            ({{ $member->pivot->role }})
        </span>
    </li>
@endforeach
</ul>