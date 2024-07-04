<x-app-layout>
    <x-slot name="title">{{ $group->name }}の新規イベント作成</x-slot>
    <!--<x-slot name="header">参加中のグループ</x-slot>-->
    <div class="mt-24 px-32 text-center text-blue-500">
        <h1 style="font-size: 36px; font-weight: 900;" >
            新しいイベント
        </h1>
    </div>
    <br>
    <form action="/events" method="POST">
        @csrf
        <div class="name">
            <div class="mt-10 px-32 text-left text-blue-500">
                <h1 style="font-size: 24px; font-weight: 700;" >イベント名</h1>
                <input type="hidden" name="event[group_id]" value="{{ $group->id }}"/>
                <input type='text' class="bg-white w-full text-black mx-auto rounded px-4 py-2 text-xl text-right" name="event[name]" placeholder="イベント名" value="{{ old('event.name') }}"/>
                <p class="name__error" style="color:red">{{ $errors->first('event.name') }}</p>
            </div>
        </div>
        <!--
        <div class="members">
            <h2>member</h2>
            <textarea name="group[member]" placeholder="memberを追加方式で追加_未実装"></textarea>
        </div>
        -->
        <div class="mt-10 px-32">
            <input type="submit" class="bg-blue-500 w-full text-white mx-auto rounded px-4 py-2 text-xl text-center" value="保存">
        </div>
    </form>
    <div class="back">
        <br>
        <div class="px-32 flex justify-center">
            <a href="/groups/{{ $group->id }}" class="bg-white w-full text-blue-500 border-4 border-blue-500 mx-auto rounded px-4 py-2 text-xl text-center"
            >戻る</a>
        </div>
    </div>
</x-app-layout>