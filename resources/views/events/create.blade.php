<!DOCTYPE HTML>
<html lang="ja">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>新しいイベント</h1>
        <form action="/groups/{{ $group->id }}/events" method="POST">
            @csrf
            <div class="name">
                <h2>イベント名</h2>
                <input type="text" name="event[name]" placeholder="グループ名" value="{{ old('event.name') }}"/>
                <p class="name__error" style="color:red">{{ $errors->first('event.name') }}</p>
            </div>
            <!--
            <div class="members">
                <h2>member</h2>
                <textarea name="group[member]" placeholder="memberを追加方式で追加_未実装"></textarea>
            </div>
            -->
            <input type="submit" value="保存"/>
        </form>
        <div class="back">[<a href="/groups/{{ $group->id }}">戻る</a>]</div>
    </body>
</html>