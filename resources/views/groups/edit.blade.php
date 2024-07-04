<x-app-layout>
    <x-slot name="title">グループ編集</x-slot>
    <!--<x-slot name="header">参加中のグループ</x-slot>-->
    <div class="mt-24 px-32 text-center text-blue-500">
        <h1 style="font-size: 36px; font-weight: 900;" >
            グループ編集
        </h1>
    </div>
    <br>
    <div class="content">
        <form action="/groups/{{ $group->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mt-10 px-32 text-left text-blue-500">
                <h1 style="font-size: 24px; font-weight: 700;" >グループ名</h1>
                <input type='text' class="bg-white w-full text-black mx-auto rounded px-4 py-2 text-xl text-right" name='group[name]' value="{{ $group->name }}">
                <p class="name__error" style="color:red">{{ $errors->first('group.name') }}</p>
            </div>
            <div class="mt-10 px-32 text-left text-black">
                <h1 class="text-blue-500" style="font-size: 24px; font-weight: 700;">メンバー</h1>
                @foreach($members as $member)
                    <input type='hidden' name='users_array[]'value="{{ $member->user_id }}">
                    <a class="mr-5" style="font-size: 20px; font-weight: 500;">{{ $member->name }}</a>
                @endforeach
            </div>
            <div class="mt-10 px-32">
                <input type="submit" class="bg-blue-500 w-full text-white mx-auto rounded px-4 py-2 text-xl text-center" value="保存">
            </div>
        </form>
        <div class="back">
            <br>
            <div class="px-32 flex justify-center">
                <a href="/home" class="bg-white w-full text-blue-500 border-4 border-blue-500 mx-auto rounded px-4 py-2 text-xl text-center"
                >戻る</a>
            </div>
        </div>
    </div>
</x-app-layout>