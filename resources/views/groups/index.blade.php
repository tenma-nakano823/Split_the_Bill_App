<x-app-layout>
    <x-slot name="title">トップページタイトル</x-slot>
    <x-slot name="header">トップページヘッダー</x-slot>
    <h1>Group Name</h1>
    <a href='/groups/create'>New Group</a>
    <div class='groups'>
        @foreach ($groups as $group)
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
                    <a href="/groups/{{ $group->id }}/edit">編集</a>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>