<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//14にて以下を追記
use App\News;

//17にて以下を追記
use App\History;
use Carbon\Carbon;

//最終で以下を追記
use Storage;

class NewsController extends Controller
{
  public function add()
  {
      return view('admin.news.create');
  }

  // 以下を追記
  
  public function create(Request $request)
  {
      //14にて以下を追記
      //Varidationを行う
      
      $this->validate($request, News::$rules);
      $news = new News;
      $form = $request->all();
      // フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する
      if (isset($form['image'])) {
        //以下2行を最終にて変更
        //$path = $request->file('image')->store('public/image');
        //$news->image_path = basename($path);
        $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
        $news->image_path = Storage::disk('s3')->url($path);
      } else {
          $news->image_path = null;
      }
      // フォームから送信されてきた_tokenを削除する
      unset($form['token']);
      
      // フォームから送信されてきたimageを削除する
      unset($form['image']);
      
      //データベースに保存する
      $news->fill($form);
      $news->save();
      
      return redirect('admin/news/create');
  }
  
  //15にて以下を追記
  public function index(Request $request)
  {
    //$requestの中のcond titleの値を$cond_titleの中に代入している
    $cond_title = $request->cond_title;
    if ($cond_title != '') {
      //検索されたら検索結果を取得する　(whereメソッドを使う)
      $posts = News::where('title', $cond_title)->get();
      } else {
        //それ以外のときは全てのニュースを取得する
        $posts = News::all();
      }
      return view('admin.news.index', ['posts' =>$posts, 'cond_title' => $cond_title]);
  }
  
  //16にて以下を追加  編集画面
  public function edit(Request $request)
  {
    //News Modelからデータを取得する
    $news = News::find($request->id);
    if (empty($news)) {
      abort(404);
    }
    return view('admin.news.edit', ['news_form' => $news]);
  }
  
  //編集画面から送信されたフォームデータを処理する部分です
  public function update(Request $request)
  {
      // Validationをかける
      $this->validate($request, News::$rules);
      // News Modelからデータを取得する
      $news = News::find($request->id);
      // 送信されてきたフォームデータを格納する
      $news_form = $request->all();
      if ($request->remove == 'true') {
          $news_form['image_path'] = null;
      } elseif ($request->file('image')) {
        //最終カリキュラムにて以下2行を修正　画像の保存先をs3へ。
          //$path = $request->file('image')->store('public/image');
          //$news_form['image_path'] = basename($path);
            $path = Storage::disk('s3')->putFile('/', $news_form['image'],'public');
            $news_form['image_path'] = Storage::disk('s3')->url($path);
      } else {
          $news_form['image_path'] = $news->image_path;
      }

      unset($news_form['image']);
      unset($news_form['remove']);
      unset($news_form['_token']);
      //該当するデータを上書きして保存する 下記は$news->fill($form);　$news->save();を短縮したもの
      $news->fill($news_form)->save();
    
    //以下を17で追記
    //update Actionで、News Modelを保存するタイミングで、
    //同時に History Modelにも編集履歴を追加するための追記
    $history = new History();
    $history->news_id = $news->id;
    $history->edited_at = Carbon::now();
    $history->save();
    //
    
    return redirect('admin/news/');
  }
  
  //削除に対応する
  public function delete(Request $request)
  {
    //該当するNews Modelを取得
    $news = News::find($request->id);
    //削除する
    $news->delete();
    return redirect('admin/news/');
  }
  
}






