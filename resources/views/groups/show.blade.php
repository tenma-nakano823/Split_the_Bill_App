<x-app-layout>
    <x-slot name="title">{{ $group->name }}のイベント</x-slot>
    <!--<x-slot name="header">参加中のグループ</x-slot>-->
    <div class="mt-24 px-32 text-center text-blue-500">
        <h1 style="font-size: 72px; font-weight: 900;" >
            {{ $group->name }}
        </h1>
    </div>
    <br>
    <div class="px-32">
        <h1 class="mt-5 text-left text-blue-500" style="font-size: 24px; font-weight: 700;">明細</h1>
        <div class="grid grid-cols-3 gap-4">
            <div class="col-span-1 bg-gray-300 text-center">名前</div>
            <div class="col-span-1 bg-red-300 text-center">支出</div>
            <div class="col-span-1 bg-blue-300 text-center">割り勘支出</div>
        </div>
        @foreach ($members as $member)
            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-1 bg-white text-right">{{ $member->name }}</div>
                <?php
                    $member->lend = number_format($member->lend);
                    $member->borrow = number_format($member->borrow);
                ?>
                <div class="col-span-1 bg-white text-right text-red-400">¥{{ $member->lend }}</div>
                <div class="col-span-1 bg-white text-right text-blue-400">¥{{ $member->borrow }}</div>
            </div>
        @endforeach
        <h1 class="mt-5 text-left text-blue-500" style="font-size: 24px; font-weight: 700;">効率的な清算方法</h1>
        @foreach ($resultArray as $result)
            <br>
            <div class="grid grid-cols-4 gap-4">
                <div class="col-span-1 bg-white text-center">{{ $result['give_name'] }}</div>
                <div class="col-span-1 bg-white text-center">---></div>
                <div class="col-span-1 bg-white text-center">{{ $result['get_name'] }}</div>
                <div class="col-span-1 bg-white text-right">¥{{ $result['money'] }}</div>
            </div>
        @endforeach
        <div class="mt-10 flex justify-center">
            <a href='/groups/{{ $group->id }}/events/create' class="bg-blue-500 w-full text-white mx-auto rounded px-4 py-2 text-xl text-center"
            >新規イベント作成</a>
        </div>
        <br>
        <h1 class="mt-5 text-left text-blue-500" style="font-size: 24px; font-weight: 700;">{{ $group->name }}のイベント一覧</h1>
        @if(!$events->isEmpty())
            <div class='divide-y divide-blue-400'>
                @foreach ($events as $event)
                    <div class="py-10 grid grid-cols-10 flex items-center">
                        <div class="col-span-6 text-left">
                            <p style="font-size: 24px;">{{ $event->name }}</p>
                        </div>
                        <div class="col-span-2"></div>
                        <div class="col-span-1 flex justify-center">
                            <a href="/events/{{ $event->id }}/edit">
                                <svg class="h-8 w-8 text-blue-500"  width="24" height="24" viewBox="0 0 24 24" 
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  
                                <path stroke="none" d="M0 0h24v24H0z"/>  
                                <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4" />  
                                <line x1="13.5" y1="6.5" x2="17.5" y2="10.5" />
                                </svg>
                            </a>
                        </div>
                        <div class="col-span-1 flex justify-end">
                            <script>
                                function deleteEvent(id) {
                                    'use strict'
                            
                                    if (confirm('作成したイベントを削除します。\n本当に削除しますか？')) {
                                        document.getElementById(`form_${id}`).submit();
                                    }
                                }
                            </script>
                            <form action="/events/{{ $event->id }}" id="form_{{ $event->id }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="deleteEvent({{ $event->id }})">
                                <svg class="h-8 w-8 text-red-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"/>
                                    <line x1="4" y1="7" x2="20" y2="7" />
                                    <line x1="10" y1="11" x2="10" y2="17" />
                                    <line x1="14" y1="11" x2="14" y2="17" />
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                            </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center">
                <a class="text-gray-400 " style="font-size: 52px;">イベントなし</a>
            </div>
        @endif
    </div>
    <div class="back">
        <br>
        <div class="px-32 flex justify-center">
            <a href="/home" class="bg-white w-full text-blue-500 border-4 border-blue-500 mx-auto rounded px-4 py-2 text-xl text-center"
            >戻る</a>
        </div>
    </div>
</x-app-layout>