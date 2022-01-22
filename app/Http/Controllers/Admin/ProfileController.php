<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//14　課題にて追記
use App\Profile;
//17　課題にて追記
use App\Profile_history;
use Carbon\Carbon;


class ProfileController extends Controller
{
    
    public function add()
    {
        return view('admin.profile.create');
    }
    
    public function create(Request $request)
    {
        
    //14　課題にて以下を追記
    //Varidationをおこなう
    $this->validate($request, Profile::$rules);
    $profile = new Profile;
    $form =$request->all();
    //フォームから送信されてきた_tokenを削除する
    unset($form['token']);
    
    //データベースに保存する
    $profile->fill($form);
    $profile->save();
    
    return redirect('admin/profile/create');
    }
    
    //16　課題で追加　編集画面
    public function edit(Request $request)
    {
        //Profile Modelからデータを取得する
        $profile = Profile::find($request->id);
        if (empty($profile)) {
            abort(404);
        }
        return view('admin.profile.edit', ['profile_form' => $profile]);
    }
    
    //編集画面から送信され多フォームデータを処理する部分    
    public function update(Request $request)
    {   
        //Validationえおかける
        $this->validate($request, Profile::$rules);
        //Profile Modelからデータを取得する
        $profile = Profile::find($request->id);
        //送信されてきたフォームデータを格納する
        $profile_form = $request->all();
        unset($profile_form['_token']);
        
        //該当するデータを上書きして保存する　下記は$profile->fill($profile); $profile->save();を短縮したもの
        $profile->fill($profile_form)->save();
        
        //以下を17 課題で追記
        //ProfileControllerのupdate Actionで、Profile Modelを保存するタイミングで、
        //同時に History Modelにも編集履歴を追加するよう実装します。
        $history = new Profile_history();
        $history->profile_id = $profile->id;
        $history->edited_at = Carbon::now();
        $history->save();
        
        return redirect('admin/profile/create');
    }
}





