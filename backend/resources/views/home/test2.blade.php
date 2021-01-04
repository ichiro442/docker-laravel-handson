<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div id="app">
 
    <div class="spinner" v-show="loading">
        <div class="double-bounce1"></div>
        <div class="double-bounce2"></div>
    </div>
 
    <div class="l-content">
        <div class="p-wrap" v-show="!loading">
            <p class="tar"><a href="https://webservice.recruit.co.jp/"><img src="https://webservice.recruit.co.jp/banner/hotpepper-s.gif" alt="ホットペッパー Webサービス" width="135" height="17" title="ホットペッパー Webサービス"></a></p>
 
            <div class="p-form" :class="{ 'is-fix': scrollY >= formOffset }">
                <div class="p-form-inner">
                    <input type="text" name="gourmet_keyword" placeholder="フリーワード検索（店名 地名、駅名など）" class="p-keyword" v-model="keyword" @input="inputting">
                    <a href="" class="p-geo-btn" @click="getGeo">現在地を取得して検索</a>
                    <p class="p-range" v-show="geoActive"><select name="range" v-model="range" @change="getGourmet">
                        <option value="1">300m圏内</option>
                        <option value="2">500m圏内</option>
                        <option value="3" selected>1000m圏内</option>
                        <option value="4">2000m圏内</option>
                        <option value="5">3000m圏内</option>
                    </select></p>
                </div>
                <div class="p-result-txt m-normal-txt">
                    <p v-if="keyword">キーワード：『{{ keyword }}』</p>
                    <p v-if="range == 1">現在地から300m圏内</p>
                    <p v-else-if="range == 2">現在地から500m圏内</p>
                    <p v-else-if="range == 4">現在地から2000m圏内</p>
                    <p v-else-if="range == 5">現在地から3000m圏内</p>
                    <p v-show="geoActive" v-else>現在地から1000m圏内</p>
                </div>
            </div>
 
            <div class="p-loader" :class="{ 'is-hide': getting }"><div></div><div></div><div></div></div>
 
            <p class="m-normal-txt" v-if="gourmetList.length == 0">{{ message }}</p>
 
            <div class="p-result-area" :class="{ 'is-fix': scrollY >= formOffset }" v-if="gourmetList.length > 1">
                <p class="m-normal-txt tar">{{ gourmetCount }}件表示中</p>
                <ul class="p-list">
                    <li v-for="item of gourmetList">
                        <div class="p-name-wrap">
                            <p class="p-shop-logo"><img :src="item.logo" alt=""></p>
                            <div class="p-name-content">
                                <p class="p-category">{{ item.category }}</p>
                                <p class="p-name">{{ item.name }}</p>
                            </div>
                        </div>
                        <div class="p-content">
                            <div class="p-main-img">
                                <p><a :href="item.category" target="_blank" rel="noopener noreferrer">
                                    <img :src="item.photo" :alt="item.name"><br>
                                    <span class="mt20 spmt20 m-blank">店舗ページを見る</span>
                                </a></p>
                            </div>
                            <table class="p-table">
                                <tr>
                                    <th>住所</th>
                                    <td>{{ item.address }}<br>
                                    <a :href="item.map" target="_blank" rel="noopener noreferrer" class="m-txt-hover p-map-link" class="m-blank">Google Mapで見る</a></td>
                                </tr>
                                <tr>
                                    <th>アクセス</th>
                                    <td>{{ item.access }}</td>
                                </tr>
                                <tr>
                                    <th>営業時間</th>
                                    <td>{{ item.open }}</td>
                                </tr>
                                <tr>
                                    <th>ランチ</th>
                                    <td>{{ item.lunch }}</td>
                                </tr>
                                <tr>
                                    <th>クレジット<br class="nopc">カード</th>
                                    <td>{{ item.card }}</td>
                                </tr>
                                <tr>
                                    <th>禁煙・喫煙</th>
                                    <td>{{ item.smoking }}</td>
                                </tr>
                                <tr>
                                    <th>Wi-Fi</th>
                                    <td>{{ item.wifi }}</td>
                                </tr>
                                <tr>
                                    <th>駐車場</th>
                                    <td>{{ item.parking }}</td>
                                </tr>
                                <tr>
                                    <th>平均予算</th>
                                    <td>{{ item.average }}</td>
                                </tr>
                                <tr v-if="item.memo">
                                    <th>料金備考</th>
                                    <td>{{ item.memo }}</td>
                                </tr>
                                <tr>
                                    <th>クーポン</th>
                                    <td><a :href="item.coupon" target="_blank" rel="noopener noreferrer" class="m-blank m-txt-hover">クーポンを見る</a></td>
                                </tr>
                            </table>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div><!-- l-content -->
 
</div><!-- app -->
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
var app = new Vue({
    el: '#app',
    data: {
        loading: true, // 読み込み時のローディングアイコン
        message: 'キーワードを入力や、現在地を計測してお店を検索してください！', // message
        geoActive: false, //現在地が有効かどうか
        getting: true, // 取得中アイコン
        scrollY: 0, // スクロール値
        timer: null, // タイマー
        keyword: '', // キーワード
        lat: '', // 緯度
        lon: '', // 経度
        range: '', // 範囲
        gourmetCount: 0, // 検索件数
        gourmetList: [] // 検索結果
    },
    computed: {
        formOffset: function(){ // フォームの位置
            var rect = document.querySelector('.p-form').getBoundingClientRect();
            return window.pageYOffset + rect.top;
        }
    },
    created: function(){
        // イベント登録
        window.addEventListener('scroll', this.scEvent);
    },
    beforeDestroy: function(){
        // イベント解除
        window.removeEventListener('scroll', this.scEvent);
    },
    methods: {
        //scイベントで現在のスクロール値を取得
        scEvent: function() {
            if (this.timer === null) {
                this.timer = setTimeout(function () {
                    this.scrollY = window.scrollY
 
                    clearTimeout(this.timer)
                    this.timer = null
                }.bind(this), 50)
            }
        },
        inputting: function(){
            this.getting = false;
 
            if (this.timer === null) {
                this.timer = setTimeout(function () {
                    this.getGourmet(this.keyword, this.lat, this.lon, this.range);
 
                    clearTimeout(this.timer)
                    this.timer = null
                }.bind(this), 500)
            }
        },
        getGeo: function(e){
            e.preventDefault();
 
            if( navigator.geolocation ){
                let $this = this;
                navigator.geolocation.getCurrentPosition(function(position){
                    $this.geoActive = true;
 
                    $this.lat = position.coords.latitude, // 緯度
                    $this.lon = position.coords.longitude; // 経度
 
                    $this.getGourmet($this.keyword, $this.lat, $this.lon, $this.range);
                }, function(error){
                    if( error.code == 1 ){
                        alert( "位置情報取得が許可されていません。" );
                    } else if( error.code == 2 ) {
                        alert( "位置情報取得に失敗しました。" );
                    } else {
                        alert( "タイムアウトしました。" );
                    }
                });
            } else {
                alert( "この端末では位置情報取得ができません。" );
            }
        },
        getGourmet: function(){
            this.getting = false;
 
            const params = new URLSearchParams();
            params.append('keyword', this.keyword);
            params.append('lat', this.lat);
            params.append('lon', this.lon);
            params.append('range', this.range);
 
            let $this = this;
            axios.post({{ resource_path(backend/resources/views/home/api) }}, params).then(function (response) { // 成功時
                $this.getting = true;
                $this.gourmetList = [];
 
                let result = response.data.results;
                $this.gourmetCount = ( result.results_available > 100 ) ? 100 : result.results_available;
 
                let shops = result.shop;
                for( let shop of shops ){
                    $this.gourmetList.push({
                        name: shop.name, // 店名
                        url: shop.urls.pc, // 店舗url
                        logo: shop.logo_image, // ロゴ
                        category: shop.genre.name, // カテゴリ
                        photo: shop.photo.pc.l, // メイン画像
                        address: shop.address, // 住所
                        map: 'https://maps.google.co.jp/maps?q=' + encodeURI(shop.name), // マップ
                        access: shop.mobile_access, // アクセス
                        open: shop.open, // 営業時間
                        lunch: shop.lunch, // ランチ
                        card: shop.card, // クレジットカード
                        smoking: shop.non_smoking, // 喫煙・禁煙
                        wifi: shop.wifi, // wifi
                        parking: shop.parking, // 駐車場
                        average: shop.budget.average, // 平均予算
                        memo: shop.budget_memo, // 料金備考
                        coupon: shop.coupon_urls.pc, // クーポン
                    })
                }
 
            }).catch(function (error) { // 失敗時
                $this.getting = true;
                $this.message = error;
            })
        }
    },
    mounted: function() {
        setTimeout(() => {
            this.loading = false;
        }, 1000);
    }
});
</script>
</body>
</html>