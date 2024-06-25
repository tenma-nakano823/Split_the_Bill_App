<x-app-layout>
    <x-slot name="title">{{ $group->name }}のイベント</x-slot>
    <!--<x-slot name="header">参加中のグループ</x-slot>-->
    <h1 class="title">イベント一覧</h1>
    <br>
    [<a href='/groups/{{ $group->id }}/events/create'>新規イベント作成</a>]
    <div class="content">
        @foreach ($group->events as $event)
            <br>
            <div class='event'>
                <h2 class='name'><a href="/events/{{ $event->id }}">{{ $event->name }}</a></h2>
                <div class="edit">
                    [<a href="/events/{{ $event->id }}/edit">編集</a>]
                </div>
            </div>
        @endforeach
    </div>
    <div class="footer">
        <br>
        [<a href="/home">戻る</a>]
    </div>
</x-app-layout>