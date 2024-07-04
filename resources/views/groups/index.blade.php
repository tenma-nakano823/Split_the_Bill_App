<x-app-layout>
    <x-slot name="title">グル割り</x-slot>
    <!--<x-slot name="header">参加中のグループ</x-slot>-->
    <div class="mt-10 px-32 flex justify-center">
        <a href='/groups/create' class="bg-blue-500 w-full text-white mx-auto rounded px-4 py-2 text-xl text-center"
        >新規グループ作成</a>
    </div>
    <div class="mt-32 px-32 text-left text-blue-500">
        <h1 style="font-size: 24px; font-weight: 900;" >
            参加中のグループ
        </h1>
    </div>
    <br>
    <div class='px-32 mx-auto'>
        @foreach ($groups as $group)
            <br>
            <div class='bg-white border-2 border-blue-500 mx-auto rounded px-4 py-2'>
                <div class="w-full grid grid-cols-2">
                    <div class="col-span-1 bg-white text-left">
                        <a style="font-size: 32px;" href="/groups/{{ $group->id }}">{{ $group->name }}</a>
                        <h5 class='members'>
                            @foreach($group->members as $member)
                                @foreach($users as $user)
                                    @if($user->id == $member->user_id)
                                    <a class="mr-2" style="font-size: 16px;">{{ $user->name }}</a>
                                    @endif
                                @endforeach
                            @endforeach
                        </h5>
                    </div>
                    <div class="col-span-1 bg-white flex items-center justify-end">
                        <a href="/groups/{{ $group->id }}/edit">
                            <svg class="h-8 w-8 text-blue-500"  width="24" height="24" viewBox="0 0 24 24" 
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  
                            <path stroke="none" d="M0 0h24v24H0z"/>  
                            <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4" />  
                            <line x1="13.5" y1="6.5" x2="17.5" y2="10.5" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>