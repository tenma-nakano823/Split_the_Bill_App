<x-app-layout>
    <x-slot name="title">Split the Bill</x-slot>
    <!--<x-slot name="header">参加中のグループ</x-slot>-->
    <h1>参加中のグループ</h1>
    <br>
    [<a href='/groups/create'>新規グループ作成</a>]
    <div class='bg-red-300 mx-auto'>
        @foreach ($groups as $group)
            <br>
            <div class='group'>
                <h2 class='name'>
                    <a href="/groups/{{ $group->id }}">{{ $group->name }}</a>
                </h2>
                参加メンバー:
                <h5 class='members'>
                @foreach($group->members as $member)
                    @foreach($users as $user)
                        @if($user->id == $member->user_id){{ $user->name }}@endif
                    @endforeach
                @endforeach
                
                </h5>
                <div class="edit">
                    [<a href="/groups/{{ $group->id }}/edit">編集</a>]
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>