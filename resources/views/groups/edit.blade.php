<x-app-layout>
    <x-slot name="title">グループ編集</x-slot>
    <!--<x-slot name="header">参加中のグループ</x-slot>-->
    <h1 class="title">グループ編集</h1>
    <br>
    <div class="content">
        <form action="/groups/{{ $group->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class='content__name'>
                <h2>グループ名</h2>
                <input type='text' name='group[name]' value="{{ $group->name }}">
                <p class="name__error" style="color:red">{{ $errors->first('group.name') }}</p>
            </div>
            <div>
                <h2>メンバー</h2>
                @foreach($members as $member)
                    <input type='hidden' name='users_array[]' value="{{ $member->user_id }}">
                    {{ $member->name }}
                @endforeach
            </div>
            <input type="submit" value="[保存]">
        </form>
        <div class="back">
            <br>
            [<a href="/home">戻る</a>]
        </div>
    </div>
</x-app-layout>