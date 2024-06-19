<!DOCTYPE HTML>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>Event</title>
    </head>
    <body>
        <h1 class="title">編集画面</h1>
        <div class="content">
            <form action="/groups/{{ $group->id }}/events/{{ $event->id }}" method="POST">
                @csrf
                @method('PUT')
                <div class='content__name'>
                    <h2>イベント名</h2>
                    <input type='text' name='event[name]' value="{{ $event->name }}">
                </div>
                <input type="submit" value="保存">
            </form>
            <div class="back">[<a href="/groups/{{ $group->id }}">戻る</a>]</div>
        </div>
    </body>
</html>