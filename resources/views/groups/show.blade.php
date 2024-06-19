<!DOCTYPE HTML>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Groups</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <a href='/groups/{{ $group->id }}/events/create'>新しいイベント</a>
        <div class="content">
                    @foreach ($group->events as $event)
                        <div class='event'>
                            <h2 class='name'>
                                <h3>イベントの名前</h3>
                                <a href="/groups/{{ $group->id }}/events/{{ $event->id }}">{{ $event->name }}</a>
                            </h2>
                            <div class="edit">
                                <a href="/groups/{{ $group->id }}/events/{{ $event->id }}/edit">編集</a>
                            </div>
                        </div>
                    @endforeach
        </div>
        <div class="footer">
            <a href="/">戻る</a>
        </div>
    </body>
</html>