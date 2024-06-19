<!DOCTYPE HTML>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>Group</title>
    </head>
    <body>
        <h1>Group Name</h1>
        <form action="/groups" method="POST">
            @csrf
            <div class="name">
                <h2>グループ名</h2>
                <input type="text" name="group[name]" placeholder="グループ名" value="{{ old('group.name') }}"/>
                <p class="name__error" style="color:red">{{ $errors->first('group.name') }}</p>
            </div>
            <!--
            <div class="members">
                <h2>member</h2>
                <textarea name="group[member]" placeholder="memberを追加方式で追加_未実装"></textarea>
            </div>
            -->
            <input type="submit" value="保存"/>
        </form>
        <div class="back">[<a href="/">戻る</a>]</div>
    </body>
</html>