<x-app-layout>
    <x-slot name="title">{{ $group->name }}のイベント編集</x-slot>
    <!--<x-slot name="header">参加中のグループ</x-slot>-->
    <h1 class="title">イベント編集</h1>
    <br>
    <div class="content">
        <form action="/events/{{ $event->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class='content__name'>
                <h2>イベント名</h2>
                <input type='text' name='event[name]' value="{{ $event->name }}">
            </div>
            <input type="submit" value="[保存]">
        </form>
        <div class="back">
            <br>
            [<a href="/groups/{{ $event->group->id }}">戻る</a>]
        </div>
    </div>
</x-app-layout>