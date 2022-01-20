<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//14　課題にて追記
use App\news;

class ProfileController extends Controller
{
    
    public function add()
    {
        return view('admin.profile.create');
    }
    
    public function create()
    {
        
    //14　課題にて以下を追記
    //Varidationをおこなう
    $this->validate($request, News::$rules);
    $profile = new Ptofile;
    $form =$request->all();
    
    //フォームから送信されてきた_tokenを削除する
    unset($form['token']);
    
    //データベースに保存する
    $profile->fill($form);
    $profile->save();
    
    return redirect('admin/profile/create');
    }
    
    public function edit()
    {
        return view('admin.profile.edit');
    }
    
    public function update()
    {
        return redirect('admin/profile/edit');
    }
}
