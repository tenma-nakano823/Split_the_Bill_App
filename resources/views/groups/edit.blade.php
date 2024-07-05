<x-app-layout>
    <x-slot name="title">グループ編集</x-slot>
    <!--<x-slot name="header">参加中のグループ</x-slot>-->
    <div class="mt-24 px-32 text-center text-blue-500">
        <h1 style="font-size: 36px; font-weight: 900;" >
            グループ編集
        </h1>
    </div>
    <br>
    <div class="px-32">
        <form action="/groups/{{ $group->id }}" id="form_{{ $group->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mt-10 text-left text-blue-500">
                <h1 style="font-size: 24px; font-weight: 700;" >グループ名</h1>
                <input type='text' class="bg-white w-full text-black mx-auto rounded px-4 py-2 text-xl text-right" name='group[name]' value="{{ $group->name }}">
                <p class="name__error" style="color:red">{{ $errors->first('group.name') }}</p>
            </div>
            <div class="mt-10 text-left text-black">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-1 text-left">
                        <h1 class="text-blue-500" style="font-size: 24px; font-weight: 700;">追加するメンバー</h1>
                    </div>
                    <!-- 検索フォーム -->
                    <div class="col-span-1 text-right">
                        <button type="button" 
                            class="bg-white  text-blue-500 border-2 border-blue-500 mx-auto rounded px-4 py-2 text-xl text-center"　
                            id="search-btn">検索</button>
                    </div>
                </div>
                <input type='text' class="bg-white w-full text-black mx-auto rounded px-4 py-2 text-xl text-right" id="search" placeholder="ユーザー名を検索" />
            </div>
            <div class="mt-10 text-left text-black" id="search-results"></div> <!--検索結果-->
            <div class="mt-10 text-left text-black" id="selected-users"> <!--追加するメンバーを保存-->
                @foreach($members as $member)
                    <label>
                        <input type="checkbox" value="{{ $member->user_id }}" name="users_array[]" checked>
                        <a class="mr-5" style="font-size: 20px; font-weight: 500;">{{ $member->name }}</a>
                    </label>
                @endforeach
            </div>
            <p class="user__error" style="color:red">{{ $errors->first('users_array') }}</p>
            <div class="mt-10 px-32 flex justify-center">
                <button type="button" 
                        class="bg-blue-500 w-full text-white mx-auto rounded px-4 py-2 text-xl text-center"　
                        onclick="storeGroup({{ $group->id }})">保存</button>
            </div>
        </form>
        <div class="back">
            <br>
            <div class="px-32 flex justify-center">
                <a href="/home" class="bg-white w-full text-blue-500 border-4 border-blue-500 mx-auto rounded px-4 py-2 text-xl text-center"
                >戻る</a>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function storeGroup(id) {
            'use strict'
    
            if (confirm('既存のメンバーが選択されていない場合、イベントが全て削除されます。\n本当に削除しますか？')) {
                document.getElementById(`form_${id}`).submit();
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#search-btn').on('click', function() {
                var query = $('#search').val();
                var selectedUserIds = [];
                
                $('#selected-users input[type=checkbox]').each(function() {
                    selectedUserIds.push($(this).val());
                });

                $.ajax({
                    url: '{{ route("group.search") }}',
                    type: 'GET',
                    data: { 
                        query: query,
                        selected_user_ids: selectedUserIds 
                    },
                    success: function(data) {
                        $('#search-results').html(data);
                    }
                });
            });

            $(document).on('click', '.add-user', function() {
                var userId = $(this).data('id');
                var userName = $(this).data('name');
                var checkbox = `<label>
                                <input type="checkbox" value="${userId}" name="users_array[]" checked>
                                <a class="mr-5" style="font-size: 20px; font-weight: 500;">${userName}</a></input></label>`;
                $('#selected-users').append(checkbox);
                $(this).parent().remove();
            });
        });
    </script>
</x-app-layout>