<x-app-layout>
    <x-slot name="title">グループ作成</x-slot>
    <!--<x-slot name="header">参加中のグループ</x-slot>-->
    <h1>新しいグループ</h1>
    <br>
    <form action="/groups" method="POST">
        @csrf
        <div class="name">
            <h2>グループ名</h2>
            <input type="text" name="group[name]" placeholder="グループ名" value="{{ old('group.name') }}"/>
            <p class="name__error" style="color:red">{{ $errors->first('group.name') }}</p>
        </div>
        <!--
        <div class="members">
            <h2>member</h2>
            <textarea name="group[member]" placeholder="memberを追加方式で追加_未実装"></textarea>
        </div>
        -->
        <div>
            <h2>追加するメンバー</h2>
            @foreach($users as $user)
    
                <label>
                    {{-- valueを'$subjectのid'に、nameを'配列名[]'に --}}
                    <input type="checkbox" value="{{ $user->id }}" name="users_array[]"
                        @if(Auth::user()->name == $user->name) checked @endif>
                        {{$user->name}}
                    </input>
                </label>
                
            @endforeach     
            <p class="user__error" style="color:red">{{ $errors->first('users_array') }}</p>
        </div>
        <input type="submit" value="[保存]"/>
    </form>
    <div class="back">
        <br>
        [<a href="/home">戻る</a>]
    </div>
</x-app-layout>  