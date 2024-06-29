<x-app-layout>
    <x-slot name="title">{{ $group->name }}のイベント</x-slot>
    <!--<x-slot name="header">参加中のグループ</x-slot>-->
    <h1 class="text-xl text-center">{{ $group->name }}</h1>
    <br>
    <div class="content">
        <h1 class="text-xl text-left">明細</h1>
        <div class="grid grid-cols-5 gap-4">
            <div class="col-span-1"></div>
            <div class="col-span-1 bg-gray-300 text-center">Name</div>
            <div class="col-span-1 bg-red-300 text-center">Lend</div>
            <div class="col-span-1 bg-blue-300 text-center">Borrow</div>
            <div class="col-span-1"></div>
        </div>
        @foreach ($members as $member)
            <div class="grid grid-cols-5 gap-4">
                <div class="col-span-1"></div>
                <div class="col-span-1 bg-white text-right">{{ $member->name }}</div>
                <?php
                    $member->lend = number_format($member->lend);
                    $member->borrow = number_format($member->borrow);
                ?>
                <div class="col-span-1 bg-white text-right text-red-400">¥{{ $member->lend }}</div>
                <div class="col-span-1 bg-white text-right text-blue-400">¥{{ $member->borrow }}</div>
                <div class="col-span-1"></div>
            </div>
        @endforeach
        <h1 class="text-xl text-left">効率的な清算方法</h1>
        @foreach ($resultArray as $result)
            <br>
            <div class="grid grid-cols-6 gap-4">
                <div class="col-span-1"></div>
                <div class="col-span-1 bg-white text-center">{{ $result['give_name'] }}</div>
                <div class="col-span-1 bg-white text-center">---></div>
                <div class="col-span-1 bg-white text-center">{{ $result['get_name'] }}</div>
                <div class="col-span-1 bg-white text-right">¥{{ $result['money'] }}</div>
                <div class="col-span-1"></div>
            </div>
        @endforeach
        <br>
        <div class="center">
            <div class="bg-blue-500 w-4/5 text-white mx-auto rounded px-4 py-2 text-xl text-center">
                <a href='/groups/{{ $group->id }}/events/create'>新規イベント作成</a>
            </div>
        </div>
        <br>
        <h1 class="text-xl text-left">{{ $group->name }}のイベント一覧</h1>
        @foreach ($group->events as $event)
            <br>
            <div class='bg-white w-4/5 mx-auto rounded px-4 py-2'>
                <div class="grid grid-cols-2">
                    <div class="col-span-1 bg-white text-left">{{ $event->name }}</div>
                    <div class="col-span-1 bg-white text-right">
                        [<a href="/events/{{ $event->id }}/edit">編集</a>]
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="footer">
        <br>
        [<a href="/home">戻る</a>]
    </div>
</x-app-layout>