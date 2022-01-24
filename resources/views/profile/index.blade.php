@extends('layouts.profile_front')

@section('content')
     <div class="container">
         <hr color="#c0c0c0">
         @if (!is_null($headline))
            <div classs="row">
              <div class="headline col-md-10 mx-auto">
                  <div class="row">
                      <div class="col-md-6">
                          <div class="caption mx-auto">
                              <div class="name">
                                  <h1>{{ str_limit('氏名：' . $headline->name, 20) }}</h1>
                              </div>
                              <div class="gender">
                                  <h1>{{ str_limit('性別：' . $headline->gender, 20) }}</h1>
                              </div>
                              <div class="hobby">
                                  <h1>{{ str_limit('趣味：' . $headline->hobby, 40) }}</h1>
                              </div>
                              <div class="introduction">
                                  <h1>{{ str_limit('自己紹介：' . $headline->introduction, 650) }}</h1>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
         @endif
     </div>
@endsection