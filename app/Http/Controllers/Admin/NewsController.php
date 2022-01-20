<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//14にて以下を追記
use App\News;

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
        $path = $request->file('image')->store('public/image');
        $news->image_path = basename($path);
      } else {
          $news->image_path = null;
      }
      // フォームから送信されてきた_tokenを削除する
      unset($form['token']);
      
      // フォームから送信されてきたimageを削除する
      unset($form['imege']);
      
      //データベースに保存する
      $news->fill($form);
      $news->save();
      
      return redirect('admin/news/create');
  }      
}