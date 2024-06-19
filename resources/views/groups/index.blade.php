<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Groups</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1>Group Name</h1>
        <a href='/groups/create'>New Group</a>
        <div class='groups'>
            @foreach ($groups as $group)
                <div class='group'>
                    <h2 class='name'>
                        <a href="/groups/{{ $group->id }}">{{ $group->name }}</a>
                    </h2>
                    <div class="edit">
                        <a href="/groups/{{ $group->id }}/edit">編集</a>
                    </div>
                </div>
            @endforeach
        </div>
    </body>
</html>