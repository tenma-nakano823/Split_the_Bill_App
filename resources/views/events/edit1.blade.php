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
            <div class="pay">
                <h2>支払う金額</h2>
                <!--<input type="hidden" name="group_id" value="{{ $event->group_id }}"/>-->
                <input type="hidden" name="member_event_pay[event_id]" value="{{ $event->id }}"/>
                @foreach($member_event_pays as $member_event_pay)
                    <h5>{{ $member_event_pay->id }}</h5>
                    <input type="hidden" name="member_event_pays_array[{{ $loop->index }}][member_id]" value="{{ $member_event_pay->member_id }}"/>
                    <input type="text" name="member_event_pays_array[{{ $loop->index }}][amount]" value="{{ $member_event_pay->amount }}" placeholder="円"/>
                @endforeach
                <!--エラー：$member_event_payが複数扱いされてる-->
                <p class="name__error" style="color:red">{{ $errors->first('member_event_pays_array.*.amount') }}</p>
            </div>
            <br>
            <div class="paid">
                <h2>割り勘に参加するメンバー</h2>
                <?php
                foreach ($members as $member) {//配列にする必要あり
                    $isChecked = in_array($member->id, $member_event_paids->member_id);
                }
                ?>
                @foreach ($members as $member)
                    <label>
                        <input type="checkbox" value="{{ $member->id }}" name="member_event_paids_array[]">
                            @if($isChecked) checked @endif>
                            {{$member->name}}
                        </input>
                    </label>
                @endforeach  
                <p class="user__error" style="color:red">{{ $errors->first('member_event_paids_array') }}</p>
            </div>
            <input type="submit" value="[保存]">
        </form>
        <div class="back">
            <br>
            [<a href="/groups/{{ $event->group->id }}">戻る</a>]
        </div>
    </div>
</x-app-layout>