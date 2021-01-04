<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/top.css') }}">
</head>
<body>
<header><h1>絞り込みの結果</h1>
    <div class="back_btn flex">
        <a class="" href="{{ url('/hello/add')}}">戻る</a>
    </div>
</header>
<main>
    <div class="search_words flex">
        <p class="search_word"> キーワード：{{$keyword}}</p>
        <p>{{$results_available}}件表示中</p>
    </div>
    <?php foreach( $shops as $shop ){ ?>
            <ul>
                <li><img src="{{ $shop['logo_image']}}" alt=""></li>
                <li>店舗名：{{$shop['name']}}</li>
                <li>住所：{{$shop['address']}}</li>
                <li>最寄り駅：{{$shop['station_name']}}</li>
                <li>ディナー予算：{{print current( $shop['budget'] )}}</li>
                <li>営業時間：{{$shop['open']}}</li>
                <li><a href="{{print current( $shop['urls'] )}}"  target="_blank" rel="noopener noreferrer">このお店をHotPepperで見る</a></li>
                <br>
            </ul>
    <?php } ?>
</main>

</body>
</html>