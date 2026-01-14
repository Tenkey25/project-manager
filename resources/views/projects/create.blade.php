<h1>プロジェクト登録</h1>

<form method="POST" action="{{ route('projects.store') }}">
    @csrf

    <div>
        <label>名前</label>
        <input type="text" name="name">
    </div>

    <div>
        <label>ステータス</label>
        <select name="status">
            <option value="todo">TODO</option>
            <option value="doing">DOING</option>
            <option value="done">DONE</option>
        </select>
    </div>

    <button type="submit">登録</button>
</form>