<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile_history extends Model
{
    //以下を17の課題で追記
    protected $guarded = array('id');
    
    public static $rules =array(
          'profile_id' => 'required',
          'edited_at'=> 'required',
    );
}
