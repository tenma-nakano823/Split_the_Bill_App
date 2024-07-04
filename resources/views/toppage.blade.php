<!DOCTYPE html>
<html>
    <head>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <title>グル割り</title>
    </head>
    <body>
        <div class="h-64 bg-blue-400 flex items-center justify-center text-white">
            <h1 style="font-size: 90px;">グル割り</h1>
        </div>
        <div class="mt-32 px-32 text-left text-blue-500 " style="font-size:20px;">
                旅行や飲み会など、割り勘が発生する機会が多いとき、お金のやり取りに手こずることはありませんか？
                グル割りでは、支払った人とその支払いに関与した人を登録するだけで簡単に割り勘計算をしてくれます。
        </div>
        <br>
        <div>
            @if (Route::has('login'))
                @auth
                    <div class="px-32">
                        <a href="{{ url('/home') }}" class="bg-blue-500 w-full h-20 text-white mx-auto rounded px-4 py-2 flex items-center justify-center"
                        >マイページへ</a>
                    </div>
                @else
                    <div class="px-32">
                        <a href="{{ route('login') }}" class="bg-blue-500 w-full h-20 text-white mx-auto rounded px-4 py-2 flex items-center justify-center"
                        >ログイン</a>
                    </div>
                    <br>
                    @if (Route::has('register'))
                        <div class="px-32">
                            <a href="{{ route('register') }}" class="bg-white w-full h-20 text-blue-500 border-4 border-blue-500 mx-auto rounded px-4 py-2 flex items-center justify-center"
                            >新規登録</a>
                        </div>
                    @endif
                @endauth
            @endif
        </div>
    </body>
</html>