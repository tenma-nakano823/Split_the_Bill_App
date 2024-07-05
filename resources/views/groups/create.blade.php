<x-app-layout>
    <x-slot name="title">グループ作成</x-slot>
    <!--<x-slot name="header">参加中のグループ</x-slot>-->
    <div class="mt-24 px-32 text-center text-blue-500">
        <h1 style="font-size: 36px; font-weight: 900;" >
            新しいグループ
        </h1>
    </div>
    <br>
    <form action="/groups" method="POST">
        @csrf
        <div class="mt-10 px-32 text-left text-blue-500">
            <h1 style="font-size: 24px; font-weight: 700;" >グループ名</h1>
            <input type='text' class="bg-white w-full text-black mx-auto rounded px-4 py-2 text-xl text-right" name='group[name]' placeholder="グループ名" value="{{ old('group.name') }}">
            <p class="name__error" style="color:red">{{ $errors->first('group.name') }}</p>
        </div>
        <div>
            <?php
                $user = Auth::user();
            ?>
            <div class="mt-10 px-32 text-left text-black">
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
            <div class="mt-10 px-32 text-left text-black" id="search-results"></div> <!--検索結果-->
            <div class="mt-10 px-32 text-left text-black" id="selected-users"> <!--追加するメンバーを保存-->
                @if(isset($user))
                    <label>
                        <input type="checkbox" value="{{ $user->id }}" name="users_array[]" checked> <!--グループ作成人のみ最初からメンバーに追加-->
                        <a class="mr-5" style="font-size: 20px; font-weight: 500;">{{ $user->name }}</a>
                    </label>
                @endif
            </div>
            <p class="user__error" style="color:red">{{ $errors->first('users_array') }}</p>
        </div>
        <div class="mt-10 px-32">
            <input type="submit" class="bg-blue-500 w-full text-white mx-auto rounded px-4 py-2 text-xl text-center" value="保存">
        </div>
    </form>
    <div class="back">
        <br>
        <div class="px-32 flex justify-center">
            <a href="/home" class="bg-white w-full text-blue-500 border-4 border-blue-500 mx-auto rounded px-4 py-2 text-xl text-center"
            >戻る</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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