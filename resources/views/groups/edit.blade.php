<!DOCTYPE HTML>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>Group</title>
    </head>
    <body>
        <h1 class="title">編集画面</h1>
        <div class="content">
            <form action="/groups/{{ $group->id }}" method="POST">
                @csrf
                @method('PUT')
                <div class='content__name'>
                    <h2>グループ名</h2>
                    <input type='text' name='group[name]' value="{{ $group->name }}">
                </div>
                <input type="submit" value="保存">
            </form>
            <div class="back">[<a href="/">戻る</a>]</div>
        </div>
    </body>
</html>