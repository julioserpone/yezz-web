<?php 
$langcountry = "";
if (isset($lang_country))
{
  $langcountry = $lang_country; 
} 

?>
@extends('public.layouts.sec')

@section('htmlheader_title')
  trans('message.support')
@endsection


@section('main-content')

<div class="about-block content pb-0" id="yezztalk">
  <div class="container-fluid">
    <div class="row">
      <img src="{{ asset('img/page/yezztalk/banner_master.jpg') }}" class="img-responsive" data-bgrepeat="no-repeat">
    </div>
    <br/>
    <div class="services-block content-center" id="support">
      <div class="container">
        <h2 class="title-support">{{ trans('message.support') }}</h2>
        @include('public.layouts.partials.support') 
    </div>
  </div>
</div>
<br/>
<br/>

{{-- @include('public.layouts.partials.login') 
@include('public.layouts.partials.register') 
@include('public.layouts.partials.logout') 
--}}
<!-- Countries Modal -->
@include('public.layouts.partials.countries') 
<!-- END Countries Modal -->
<script type="text/javascript">
 $(document).ready(function(){
  menuHandle('support');
});
</script>
@endsection