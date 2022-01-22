<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //14　課題にて追記
        protected $guarded =array('id');
        
        public static $rules = array(
            'name' => 'required',
            'gender' => 'required',
            'hobby' => 'required',
            'introduction' => 'required',
            
        );
        
        //以下を17の課題で追記　Profile Modelに関連付けを行う
        public function profile_histories()
        {
            return $this->hasMany('App\Profile_history');
        }
}
