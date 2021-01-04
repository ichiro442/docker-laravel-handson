<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
  // public function add(){

  //   return view('home.top');
  //   //homeフォルダーのtop.balde.phpnに飛ばすという意味
  // }
  public function add(Request $req)
  {
      $data = [
          'msg'  => '',
      ];

      return view('home.top', $data);
  }


  /**
   * 結果画面
   * 
   */
  public function result(Request $req)
  {
    
      $keyword = $req->keyword;
      $data = [
          'msg'  => $keyword,
      ];
      $baseurl = 'http://webservice.recruit.co.jp/hotpepper/gourmet/v1/';
      $params = [
          'key' => '4b7463156688d77d',
          'format' => 'json',
          'keyword' => $keyword,
          'count' => 20,
      ];
      $url = $baseurl . '?' . http_build_query($params, '', '&');
      
      // リクエストを送り結果を取得
      $result = file_get_contents($url);
      
      // 取得した翻訳結果のjsonをPHPの連想配列に変換
      $json = json_decode($result, true);
  
      $shops = $json['results']['shop'];
  
          // エラーがあった場合
      if( isset($json['results']['error']) ){
        echo $json['results']['error'][0]['message'];
        exit;
      }
  
      // 取得件数
      $results_available = $json['results']['results_available'];
      if( $results_available > 100 ){
          $results_available = 100;
      } elseif( $results_available == 0 ) {
          echo '指定の条件ではお店が見つかりませんでした。';
          exit;
      }
  
      return view('home.result',$data,compact('keyword','shops' ,'json','results_available'));
  }
  // public function top(Request $request){ 
  //      // $keyword = $_POST['keyword'] ? $_POST['keyword'] : '';  
  //   $keyword = 'ハンバーグ';
  //   // $keyword = $request->input('keyword');
  // //   if ($request->has('keyword')) {
  // //     var_dump("true");
  // // }
  //   // $keyword = $_POST;
  //   // var_dump($keyword);
  //   $baseurl = 'http://webservice.recruit.co.jp/hotpepper/gourmet/v1/';
  //   $params = [
  //       'key' => '4b7463156688d77d',
  //       'format' => 'json',
  //       'keyword' => $keyword,
  //       'count' => 20,
  //   ];
  //   $url = $baseurl . '?' . http_build_query($params, '', '&');
    
  //   // リクエストを送り結果を取得
  //   $result = file_get_contents($url);
    
  //   // 取得した翻訳結果のjsonをPHPの連想配列に変換
  //   $json = json_decode($result, true);

  //   $shops = $json['results']['shop'];

  //       // エラーがあった場合
  //   if( isset($json['results']['error']) ){
  //     echo $json['results']['error'][0]['message'];
  //     exit;
  //   }

  //   // 取得件数
  //   $results_available = $json['results']['results_available'];
  //   if( $results_available > 100 ){
  //       $results_available = 100;
  //   } elseif( $results_available == 0 ) {
  //       echo '指定の条件ではお店が見つかりませんでした。';
  //       exit;
  //   }
  //    return view('home.top',compact('keyword','shops' ,'json','results_available'));
  // }
  // public function reeultpage(Request $request){
  //   $keyword = $request->keyword;
  //   $data = [
  //       'msg'  => 'ようこそ、' . $message . ' さん！',
  //   ];
  //   return view('home.resultpage', compact('keyword','data'));
  // }
  // public function test2(Request $request){
  //   // $keyword = $_POST['keyword'] ? $_POST['keyword'] : '';  
  //   $keyword = 'ハンバーグ';
  //   // $keyword = $request->input('keyword');
  // //   if ($request->has('keyword')) {
  // //     var_dump("true");
  // // }
  //   // $keyword = $_POST;
  //   // var_dump($keyword);
  //   $baseurl = 'http://webservice.recruit.co.jp/hotpepper/gourmet/v1/';
  //   $params = [
  //       'key' => '4b7463156688d77d',
  //       'format' => 'json',
  //       'keyword' => $keyword,
  //       'count' => 20,
  //   ];
  //   $url = $baseurl . '?' . http_build_query($params, '', '&');
    
  //   // リクエストを送り結果を取得
  //   $result = file_get_contents($url);
    
  //   // 取得した翻訳結果のjsonをPHPの連想配列に変換
  //   $json = json_decode($result, true);

  //   $shops = $json['results']['shop'];

  //       // エラーがあった場合
  //   if( isset($json['results']['error']) ){
  //     echo $json['results']['error'][0]['message'];
  //     exit;
  //   }

  //   // 取得件数
  //   $results_available = $json['results']['results_available'];
  //   if( $results_available > 100 ){
  //       $results_available = 100;
  //   } elseif( $results_available == 0 ) {
  //       echo '指定の条件ではお店が見つかりませんでした。';
  //       exit;
  //   }
  //    return view('home.resultpage',compact('keyword','shops' ,'json','results_available'));
  // }
  // public function test3(){
  //   // $keyword = $_POST['keyword'] ? $_POST['keyword'] : '';
  //   return view('home.top');
  // }
}