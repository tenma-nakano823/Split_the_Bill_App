<x-app-layout>
    <x-slot name="title">{{ $group->name }}の新規イベント作成</x-slot>
    <!--<x-slot name="header">参加中のグループ</x-slot>-->
    <h1>新しいイベント</h1>
    <br>
    <form action="/events" method="POST">
        @csrf
        <div class="name">
            <h2>イベント名</h2>
            <input type="hidden" name="event[group_id]" value="{{ $group->id }}"/>
            <input type="text" name="event[name]" placeholder="イベント名" value="{{ old('event.name') }}"/>
            <p class="name__error" style="color:red">{{ $errors->first('event.name') }}</p>
        </div>
        <!--
        <div class="members">
            <h2>member</h2>
            <textarea name="group[member]" placeholder="memberを追加方式で追加_未実装"></textarea>
        </div>
        -->
        <input type="submit" value="[保存]"/>
    </form>
    <div class="back">
        <br>
        [<a href="/groups/{{ $group->id }}">戻る</a>]
    </div>
</x-app-layout>