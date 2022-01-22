<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
     //14で以下を追記
    protected $guarded = array('id');
    //以下を14で追記
    public static $rules = array(
        'title' => 'required',
        'body' => 'required',
    );
    
    //以下を17で追記　News　Modelに関連付けを行う
    public function histories()
    {
        return $this->hasMany('App\History');
    }
    
}


