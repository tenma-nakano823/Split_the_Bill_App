<x-app-layout>
    <x-slot name="title">{{ $event->name }}</x-slot>
    <!--<x-slot name="header">参加中のグループ</x-slot>-->
    <h1>{{ $event->name }}</h1>
    <br>
    <form action="/member_event_pays" method="POST">
        @csrf
        <div class="pay">
            <h2>支払う金額</h2>
            <input type="hidden" name="group_id" value="{{ $event->group_id }}"/>
            <input type="hidden" name="member_event_pay[event_id]" value="{{ $event->id }}"/>
            @foreach($members as $member)
                <h5>{{ $member->name }}</h5>
                <input type="hidden" name="member_event_pays_array[{{ $loop->index }}][member_id]" value="{{ $member->id }}"/>
                <input type="text" name="member_event_pays_array[{{ $loop->index }}][amount]" placeholder="円"/>
            @endforeach
            <p class="name__error" style="color:red">{{ $errors->first('member_event_pays_array.*.amount') }}</p>
        </div>
        <br>
        <div class="paid">
            <h2>割り勘に参加するメンバー</h2>
            @foreach($members as $member)
                <label>
                    <input type="checkbox" value="{{ $member->id }}" name="member_event_paids_array[]">
                        {{$member->name}}
                    </input>
                </label>
            @endforeach  
            <p class="user__error" style="color:red">{{ $errors->first('member_event_paids_array') }}</p>
        </div>
        <br>
        <div class="fraction">
            <h2>端数調整人</h2>
            <h5>※必ず一人選択してください</h5>
            @foreach($members as $member)
                <label>
                    <input type="radio" value="{{ $member->id }}" name="fraction_adjust">
                        {{$member->name}}
                    </input>
                </label>
            @endforeach  
            <p class="user__error" style="color:red">{{ $errors->first('fraction_adjust') }}</p>
        </div>
        <input type="submit" value="[保存]"/>
    </form>
    <script>
        function deletePost(id) {
            'use strict'
    
            if (confirm('作成したイベントを削除します。\n本当に削除しますか？')) {
                document.getElementById(`form_${id}`).submit();
            }
        }
    </script>
    <form action="/events/{{ $event->id }}" id="form_{{ $event->id }}" method="post">
        @csrf
        @method('DELETE')
        <div class="back">
            <button type="button" onclick="deletePost({{ $event->id }})">[戻る]</button>
        </div>
    </form>
</x-app-layout>