
@extends('public.layouts.sec')

@section('htmlheader_title')
Home
@endsection


@section('main-content')
<div class="about-block content" id="support">
 <div class="container-fluid">
   <div class="row search-parent">
     <img src="/img/page/yezztalk/banner_master.jpg" class="img-responsive">
   </div>
 </div>


 <div class="container-fluid">
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 col-sm-12 col-xs-12">
      <h2>{{ trans('message.warranty_policy') }}</h2>
    </div>
    <div class="col-md-2"></div>
  </div>

  <br/>

</div>
<div class="row" style="min-height: 300px;">
  <div class="col-md-2"></div>
  <div class="col-md-8 col-sm-12 col-xs-12">
    <div class="col-sm-6 links">
      <a  href="/downloads/warranty/yezz-smartphone-warranty-policy-en.pdf" target="_blank">
        {{ trans('message.smartphone_wp') }} (EN)  
      </a>
    </div>

    <div class="col-sm-6">
      <a href="/downloads/warranty/yezz-smartphone-warranty-policy-es.pdf" target="_blank">
        {{ trans('message.smartphone_wp') }} (ES)  
      </a>
    </div>
    <br/>
  </div>
  <div class="col-md-2"></div>
</div>

<!-- Countries Modal -->
  @include('public.layouts.partials.countries') 
  <!-- END Countries Modal -->
@endsection