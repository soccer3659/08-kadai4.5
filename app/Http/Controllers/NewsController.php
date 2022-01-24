<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


//以下を19にて追記
use Illuminate\Support\Facades\HTML;
use App\News;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        //以下sortメソッドで「投稿日時順に新しい方から並べる」並べ換えをしている。
        $posts = News::all()->sortByDesc('updated_at');
        
        if (count($posts) > 0) {
            //以下で最新の記事を変数$headlineに代入し、
            //$postsは代入された最新の記事以外の記事が格納されていることになります。
            //最新の記事とそれ以外の記事とで表記を変えたいため。
            $headline = $posts->shift();
        } else {
            $headline = null;
        }
        
        //news/index.blade.php ファイルを渡している
        //また　Viewテンプレートに　headline、posts、という変数を渡している
        return view('news.index', ['headline' => $headline, 'posts' => $posts]);
    
    }
}
