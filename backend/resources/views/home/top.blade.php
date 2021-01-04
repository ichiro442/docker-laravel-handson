<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oshibori</title>
    <link rel="stylesheet" href="{{ asset('css/top.css') }}">
</head>
<body>
<header class="">
    <h1>Oshibori</h1>
</header>
<main class="flex">
    <div class="main_box flex">
        <form action="{{ url('/hello/result')}}" method="POST" class="flex">
        {{ csrf_field() }}
            <div> <input class="search_text" type="text" name="keyword"></textarea></div>
            <div><input class="submit" type="submit" name="add"></div>
        </form>
        <div class="">
            <img src="https://webservice.recruit.co.jp/banner/hotpepper-s.gif" alt="ホットペッパー Webサービス" width="135" height="17" title="ホットペッパー Webサービス"></a>
        </div>
    </div>
</main>
</body>
</html>