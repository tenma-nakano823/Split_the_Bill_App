<x-app-layout>
    <x-slot name="title">{{ $group->name }}のイベント</x-slot>
    <!--<x-slot name="header">参加中のグループ</x-slot>-->
    <h1 class="title">イベント一覧</h1>
    <br>
    [<a href='/groups/{{ $group->id }}/events/create'>新規イベント作成</a>]
    <div class="content">
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white col-span-1">Name</div>
            <div class="bg-white col-span-1">Lend</div>
            <div class="bg-white col-span-1">Borrow</div>
        </div>
        @foreach ($members as $member)
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white col-span-1">{{ $member->name }}</div>
                <div class="bg-white col-span-1">{{ $member->lend }}</div>
                <div class="bg-white col-span-1">{{ $member->borrow }}</div>
            </div>
        @endforeach
        @foreach ($group->events as $event)
            <br>
            <div class='event'>
                <h2 class='name'>{{ $event->name }}</h2>
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