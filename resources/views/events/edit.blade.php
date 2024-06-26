<x-app-layout>
    <x-slot name="title">{{ $event->name }}</x-slot>
    <!--<x-slot name="header">参加中のグループ</x-slot>-->
    <br>
    <form action="/events/{{ $event->id }}" method="POST">
        @csrf
        @method('PUT')
        <div class='content__name'>
            <h2>イベント名</h2>
            <input type='text' name='event[name]' value="{{ $event->name }}">
        </div>
        <div class="pay">
            <h2>支払う金額</h2>
            <input type="hidden" name="group_id" value="{{ $event->group_id }}"/>
            <input type="hidden" name="member_event_pay[event_id]" value="{{ $event->id }}"/>
            @foreach($members as $member)
                <h5>{{ $member->name }}</h5>
                <input type="hidden" name="member_event_pays_array[{{ $loop->index }}][member_id]" value="{{ $member->id }}"/>
                <input type="text" name="member_event_pays_array[{{ $loop->index }}][amount]" value="{{ $memberEventPays[$loop->index]->amount }}"placeholder="円"/>
            @endforeach
            <p class="name__error" style="color:red">{{ $errors->first('member_event_pays_array.*.amount') }}</p>
        </div>
        <br>
        <div class="paid">
            <h2>割り勘に参加するメンバー</h2>
            @foreach ($members as $member)
                <label>
                    <input type="checkbox" value="{{ $member->id }}" name="member_event_paids_array[]"
                        @if($isCheckeds[$loop->index]) checked @endif>
                        {{$member->name}}
                    </input>
                </label>
            @endforeach  
            <p class="user__error" style="color:red">{{ $errors->first('member_event_paids_array') }}</p>
        </div>
        <input type="submit" value="[保存]"/>
    </form>
    <div class="back">
        <br>
        [<a href="/groups/{{ $event->group_id }}">戻る</a>]
    </div>
</x-app-layout>