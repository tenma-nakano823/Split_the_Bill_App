<x-app-layout>
    <x-slot name="title">{{ $event->name }}</x-slot>
    <!--<x-slot name="header">参加中のグループ</x-slot>-->
    <br>
    <form action="/events/{{ $event->id }}" method="POST">
        @csrf
        @method('PUT')
        <div class='px-32'>
            <div class="mt-10 text-left text-blue-500">
                <h1 style="font-size: 24px; font-weight: 700;" >イベント名</h1>
                <input type='text' class="bg-white w-full text-black mx-auto rounded px-4 py-2 text-xl text-right" name="event[name]" placeholder="イベント名" value="{{ $event->name }}"/>
                <p class="name__error" style="color:red">{{ $errors->first('event.name') }}</p>
            </div>
        </div>
        <div class="px-32">
            <div class="mt-10 text-left text-blue-500">
                <h1 style="font-size: 24px; font-weight: 700;">支払う金額</h1>
            </div>
            <input type="hidden" name="group_id" value="{{ $event->group_id }}"/>
            <input type="hidden" name="member_event_pay[event_id]" value="{{ $event->id }}"/>
            @foreach($members as $member)
                <div class="my-5 grid grid-cols-1 flex items-center">
                    <div class="col-span-1 text-left">
                        <p class="text-black" style="font-size: 24px;">{{ $member->name }}</p>
                    </div>
                    <div class="col-span-1">
                        <input type="hidden" name="member_event_pays_array[{{ $loop->index }}][member_id]" value="{{ $member->id }}"/>
                        <input type="text" class="bg-white w-full text-black mx-auto rounded px-4 py-2 text-xl text-right" name="member_event_pays_array[{{ $loop->index }}][amount]" value="{{ $memberEventPays[$loop->index]->amount }}" placeholder="円"/>
                    </div>
                </div>
            @endforeach
            <p class="name__error" style="color:red">{{ $errors->first('member_event_pays_array.*.amount') }}</p>
        </div>
        <br>
        <div class="px-32">
            <div class="mt-5 text-left text-blue-500">
                <h1 style="font-size: 24px; font-weight: 700;">割り勘に参加するメンバー</h1>
            </div>
            @foreach($members as $member)
                <label>
                    <input type="checkbox" value="{{ $member->id }}" name="member_event_paids_array[]"
                        @if($isCheckeds[$loop->index]) checked @endif>
                        <a class="mr-5" style="font-size: 20px; font-weight: 500;">{{$member->name}}</a>
                    </input>
                </label>
            @endforeach  
            <p class="user__error" style="color:red">{{ $errors->first('member_event_paids_array') }}</p>
        </div>
        <br>
        <div class="px-32">
            <div class="mt-5 text-left text-blue-500">
                <h1 style="font-size: 24px; font-weight: 700;">端数調整人</h1>
                <h1 style="font-size: 20px; font-weight: 500;">※必ず一人のみ選択してください</h1>
            </div>
            @foreach($members as $member)
                <label>
                    <input type="radio" value="{{ $member->id }}" name="fraction_adjust"
                        @if($isFractionAdjusts[$loop->index]) checked @endif>
                        <a class="mr-5" style="font-size: 20px; font-weight: 500;">{{$member->name}}</a>
                    </input>
                </label>
            @endforeach  
            <p class="user__error" style="color:red">{{ $errors->first('fraction_adjust') }}</p>
        </div>
        <div class="mt-10 px-32">
            <input type="submit" class="bg-blue-500 w-full text-white mx-auto rounded px-4 py-2 text-xl text-center" value="保存">
        </div>
    </form>
    <div class="mt-5 px-32 flex justify-center">
        <a href="/groups/{{ $event->group_id }}" class="bg-white w-full text-blue-500 border-4 border-blue-500 mx-auto rounded px-4 py-2 text-xl text-center"
        >戻る</a>
    </div>
</x-app-layout>