
@extends('public.layouts.sec')

@section('htmlheader_title')
Yezztalk 
@endsection

<?php $logged = 0; ?>

@section('main-content')
<br/>                
<div class="about-block content">
  

</div>
<br/>
<div class="main">
  <div class="container">
    <ul class="breadcrumb">
      <li><a href="index.html">{{ trans('message.home') }}</a></li>
      <li><a href="/yezztalk">{{ trans('message.yezztalk') }}</a></li>
      <li><a href="/yezztalk/category/{{$theme->cat_code}}">{{ trans('message.category') }}</a></li>
      <li class="active">{{ $theme->title}}</li>
    </ul>
    <!-- BEGIN SIDEBAR & CONTENT -->
    <div class="row margin-bottom-40">
      <!-- BEGIN CONTENT -->
      <div class="col-md-12 col-sm-12">
        <h1>{{ $theme->title}}</h1>
        <div class="content-page">
          <div class="row">
            <!-- BEGIN LEFT SIDEBAR -->            
            <div class="col-md-9 col-sm-9 blog-item">
              <div class="blog-item-img">
                <!-- BEGIN CAROUSEL -->            
                <div class="front-carousel">
                  <div id="myCarousel" class="carousel slide">
                    <!-- Carousel items -->
                    <div class="carousel-inner">
                      <div class="item active">
                        <img src="/img/yezztalk/{{$theme->ext_id}}.jpg" alt="{{$theme->title}}">
                      </div>
                    </div>
                  </div>                
                </div>
                <!-- END CAROUSEL -->             
              </div>
              <br/>
              {!!html_entity_decode($theme->content)!!}
              <blockquote>
                <p>{{ $theme->highlight_one }}</p>  
              </blockquote>    
              <ul class="blog-info">
                <li><i class="fa fa-user"></i>{{ trans('message.by') }}&nbsp;{{ $theme->createdBy}}</li>
                <li><i class="fa fa-calendar"></i>{{ $theme->created_at->format('d-m-Y')}}</li>
                <li><i class="fa fa-comments"></i>{{ $theme->comments}}</li>
                <li><i class="fa fa-tag"></i>{{ $theme->category_name }}</li>
                @if(isset($user))
                  @if($user!=null)
                    <?php $logged = 1; ?>
                <li>
                     <button class="btn btn-primary" onclick="postLike('like');"><i class="fa fa-thumbs-o-up" style="color:#fff;">&nbsp;<span id="likeCounter"></span></i></button>
                </li>
                <li>
                     <button class="btn btn-primary" onclick="postLike('dislike');"><i class="fa fa-thumbs-o-down" style="color:#fff;">&nbsp;<span id="dislikeCounter"></span></i></button>
                </li>
                 @endif              
                @else
                <li>
                     <button class="btn btn-primary" onclick="openLoginModal();"><i class="fa fa-thumbs-o-up" style="color:#fff;">&nbsp;<span id="likeCounter"></span></i></button>
                </li>
                <li>
                     <button class="btn btn-primary" onclick="openLoginModal();"><i class="fa fa-thumbs-o-down" style="color:#fff;">&nbsp;<span id="dislikeCounter"></span></i></button>
                </li>
                @endif

              </ul>

              <h2>{{ trans('message.comments') }}</h2>
              <div class="comments">
                @foreach($comments as $index=>$com)
                <div class="media">                    
                  <a href="javascript:;" class="pull-left">
                    <img src="/theme/frontend/pages/img/people/img1-small.jpg" alt="" class="media-object">
                  </a>
                  <div class="media-body">
                    <h4 class="media-heading">{{$com->username}} 
                       <span>
                           @if($logged==1)
                             <a style="color:#cc3304" onclick="postCommentLike({{$com}},{{$index}},'like','com')"><i class="fa fa-thumbs-o-up"></i>&nbsp;<em id="like{{$index}}">{{$com->likes}}</em></a>&nbsp;|&nbsp;
                             <a style="color:#cc3304" onclick="postCommentLike({{$com}},{{$index}},'dislike','com')"><i class="fa fa-thumbs-o-down"></i>&nbsp;<em id="dislike{{$index}}">{{$com->dislikes}}</em></a>&nbsp;|&nbsp;
                             {{ $com->created_at->format('d-m-Y')}} / 
                             <a onclick="openReplyModal({{ "'". $com->ext_id."'"}});">Reply</a>
                            @else
                             <a style="color:#cc3304" onclick="openLoginModal();"><i class="fa fa-thumbs-o-up"></i>&nbsp;<em id="like{{$index}}">{{$com->likes}}</em></a>&nbsp;|&nbsp;
                             <a style="color:#cc3304" onclick="openLoginModal();"><i class="fa fa-thumbs-o-down"></i>&nbsp;<em id="dislike{{$index}}">{{$com->dislikes}}</em></a>&nbsp;|&nbsp;
                             {{ $com->created_at->format('d-m-Y')}} / 
                             <a onclick="openLoginModal();">{{ trans('message.reply') }}</a>
                            @endif 
                       </span>
                    </h4>
                    <p>{{$com->comment}}</p>
                    <!-- Nested media object -->
                    @if(count($com->related)>0)
                    @foreach($com->related as $index=>$sub)
                    <?php $extid = json_encode($sub->ext_id) ?>
                    <?php $myid  = $index.''.str_random(5) ?>
                    <?php $param_id = json_encode($myid) ?>
                    <div class="media">
                      <a href="javascript:;" class="pull-left">
                        <img src="/theme/frontend/pages/img/people/img2-small.jpg" alt="" class="media-object">
                      </a>
                      <div class="media-body">
                        <h4 class="media-heading">{{ $sub->username}}
                        <span>
                           <a style="color:#cc3304" onclick="postCommentLike({{$extid}} ,{{$param_id}},'like','sub')"><i class="fa fa-thumbs-o-up"></i>&nbsp;
                             <em id="like{{$myid}}">{{$sub->likes}}</em></a>&nbsp;|&nbsp;
                            <a style="color:#cc3304" onclick="postCommentLike({{$extid}},{{$param_id}},'dislike','sub')"><i class="fa fa-thumbs-o-down"></i>&nbsp;
                             <em id="dislike{{$myid}}">{{$sub->dislikes}}</em></a>&nbsp;|&nbsp;
                             {{ $sub->created_at}}
                         </span>
                        </h4>
                        <p>{{ $sub->comment}}</p>
                      </div>
                    </div>
                    <!--end media-->  
                    @endforeach
                    @endif
                  </div>
                </div>
                @endforeach
              </div>

              <div class="post-comment padding-top-40">
                <h3>{{ trans('message.leave_comment') }}</h3>
                @if(isset($user))
                @if($user!=null)
                {!! Form::model(Request::all(),['route'=>['yezztalk.comment.store'], 'method'=>'POST', 'name'=>'commentFrm', 'id'=> 'commentFrm', 'role'=>'form','class' => 'form-horizontal']) !!}
                <div class="form-group">
                 <label>{{ trans('message.message') }}</label>
                 <textarea class="form-control" rows="8" id="comment" name="comment"></textarea>
               </div>
               <p><button class="btn btn-primary" type="submit">{{ trans('message.post_comment') }}</button></p>
                 {{ Form::hidden('theme', $theme->ext_id , array('class' => 'form-control', 'id' => 'theme')) }}
                 {{ Form::hidden('parent', 0 , array('class' => 'form-control', 'id' => 'parent')) }}
               {!! Form::close() !!}
              @endif
             @else
             <p><button class="btn btn-primary" onclick="openLoginModal();">{{ trans('message.login_post_comment') }}</button></p>
             @endif
           </div>     


         </div>
         <!-- END LEFT SIDEBAR -->
         <!-- BEGIN RIGHT SIDEBAR -->
         @include('public.yezztalk.layouts.partials.rightbar') 
         <!-- END RIGHT SIDEBAR -->
       </div>
     </div>

     @include('public.yezztalk.layouts.partials.reply') 
     @include('public.layouts.partials.login') 
     @include('public.layouts.partials.register') 
     @include('public.layouts.partials.logout') 

     <script type="text/javascript">
      var theme = {!! $theme !!};
      var $_token = "{{ csrf_token() }}";

      $('#likeCounter').text(theme.likes);
      $('#dislikeCounter').text(theme.dislikes);

      $('head').append( $('<link rel="stylesheet" type="text/css" />').attr('href', '/theme/global/plugins/fancybox/source/jquery.fancybox.css') );


      $('head').append( $('<script type="text/javascript" />').attr('src','/theme/global/plugins/fancybox/source/jquery.fancybox.pack.js'));
      $('head').append( $('<script type="text/javascript" />').attr('src','/theme/frontend/layout/scripts/layout.js'));


      $('document').ready(function(){
        var login_error = {{ session('login_error')!=null ? 1 : 0 }};

        /*Open Login modal if error exist */
        if(login_error==1)
        {
         $('#modalLogin').modal('toggle');
       }




     });
       function postLike(type)
       {
          $.ajax({
                  type: 'POST', 
                  url: "/yezztalk/theme/"+type+"/"+theme.ext_id,
                  headers: {"X-CSRF-Token": $_token },
                  success: function(result) {
                       if(result.code==200){
                           $('#likeCounter').text(result.likes);
                           $('#dislikeCounter').text(result.dislikes);
                       }
                  }
           });
       }



     function postCommentLike(data, index, type, level)
       {
        var _ext_id = null;
        var _type   = null;
               
        switch(level){
          case "com":
              _ext_id = data.ext_id;
          break;
          case "sub":
              _ext_id = data;
          break;
        }

        likeTag    = '#like'+index;
        dislikeTag = '#dislike'+index;
        $.ajax({
                  type: 'POST', 
                  url: "/yezztalk/comment/"+type+"/"+_ext_id,
                  headers: {"X-CSRF-Token": $_token },
                  success: function(result) {
                    console.log(result);
                       if(result.code==200){
                           $(likeTag).text(result.likes);
                           $(dislikeTag).text(result.dislikes);
                       }
                  }
           });
          
       }

   </script>

   @endsection