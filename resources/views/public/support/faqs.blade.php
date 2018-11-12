@php
	$langcountry = "";
	if (isset($lang_country)) {
	  $langcountry = $lang_country; 
	} 
@endphp

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
					<h2>{{ trans('message.faq_desc') }}</h2>
					@foreach($faqs as $index => $faq)
					<p>
						<a style="text-transform: uppercase; color:#0d0d0d; text-decoration:none;font-weihgt:bold;" data-toggle="collapse" href="#{{$faq->ext_id}}" aria-expanded="false" aria-controls="collapseExample">
							{{$faq->question}}
						</a>
					</p>
					<div class="collapse" id="{{$faq->ext_id}}" style="margin-left:15px;">
						<div class="card card-block" style="color:#0d0d0d;">
							{!! $faq->answer !!}
						</div>
					</div>
					<br/>
					@endforeach
					<br/>
					<h4>{{ trans('message.faqs_subtitle') }}&nbsp;&nbsp;<a href="/contact" class="btn btn-primary">{{ trans('message.contact-us') }}</a></h4>
				</div>
				<br/>
				<div class="col-md-2"></div>
			</div>
			<br/>
		</div>
	</div>

	@include('public.layouts.partials.countries') 

@endsection