
@extends('public.layouts.sec')

@section('htmlheader_title')
Yezztalk
@endsection


@section('main-content')

<div class="about-block content" id="yezztalk">

    
    <br/>
    <div class="row">
     <div class="col-md-3 col-sm-12 col-xs-12">
       <img src="/img/page/yezztalk/banner_01_{{$lang}}.jpg" class="img-responsive" data-bgrepeat="no-repeat">
     </div>
     <div class="col-md-3 col-sm-12 col-xs-12">
       <img src="/img/page/yezztalk/banner_02_{{$lang}}.jpg" class="img-responsive" data-bgrepeat="no-repeat">
     </div>
     <div class="col-md-3 col-sm-12 col-xs-12">
       <img src="/img/page/yezztalk/banner_03_{{$lang}}.jpg" class="img-responsive" data-bgrepeat="no-repeat">
     </div>

     <div class="col-md-3 col-sm-12 col-xs-12">
       <img src="/img/page/yezztalk/banner_04_en.jpg" class="img-responsive" data-bgrepeat="no-repeat">
     </div>
   </div>



 </div>
</div>  
<br/>
<div class="container-fluid">
<div class="main">
  <div class="container">
    <!-- BEGIN SIDEBAR & CONTENT -->
    <div class="row margin-bottom-40">
      <!-- BEGIN CONTENT -->
      <div class="col-md-12 col-sm-12">
        <h2>{{ trans('message.yezztalk') }}</h2>
        <div class="content-page">
          <div class="row">
            <!-- BEGIN LEFT SIDEBAR -->            
            <div class="col-md-9 col-sm-9 blog-posts">
              @foreach($themes as $item)
              <div class="row">
                <div class="col-md-4 col-sm-4">
                  <img class="img-responsive" alt="" src="/img/yezztalk/{{$item->ext_id}}.jpg">
                </div>
                <div class="col-md-8 col-sm-8">
                  <h2><a href="/yezztalk/theme/{{$item->ext_id}}">{{$item->title}}</a></h2>
                  <ul class="blog-info">
                    <li><i class="fa fa-calendar"></i>{{ $item->created_at->format('d-m-Y')}}</li>
                    <li><i class="fa fa-comments"></i>{{ $item->comments}}</li>
                    <li><i class="fa fa-tags"></i>{{ $item->category_name }}</li>
                    <li><i class="fa fa-thumbs-o-up"></i>{{ $item->likes }}</li>
                    <li><i class="fa fa-thumbs-o-down"></i>{{ $item->dislikes }}</li>
                  </ul>
                   {!!html_entity_decode($item->summary)!!}&nbsp; 
                  <a href="/yezztalk/theme/{{$item->ext_id}}" class="more">{{ trans('message.read_more') }} <i class="icon-angle-right"></i></a>
                </div>
              </div>
              <hr class="blog-post-sep">
              @endforeach
              <!--ul class="pagination">
                <li><a href="javascript:;">Prev</a></li>
                <li><a href="javascript:;">1</a></li>
                <li><a href="javascript:;">2</a></li>
                <li class="active"><a href="javascript:;">3</a></li>
                <li><a href="javascript:;">4</a></li>
                <li><a href="javascript:;">5</a></li>
                <li><a href="javascript:;">Next</a></li>
              </ul-->               
            </div>
            <!-- END LEFT SIDEBAR -->
            <!-- BEGIN RIGHT SIDEBAR -->
            @include('public.yezztalk.layouts.partials.rightbar') 
            <!-- END RIGHT SIDEBAR -->
          </div>
        </div>
      </div>
      <!-- END CONTENT -->
    </div>
    <!-- END SIDEBAR & CONTENT -->
  </div>
</div>





</div><!-- container-fluid -->
<br/>
@include('public.layouts.partials.login') 
@include('public.layouts.partials.register') 
@include('public.layouts.partials.logout') 
<script type="text/javascript">
 $(document).ready(function(){
  menuHandle('yezztalk');
});
</script>
@endsection