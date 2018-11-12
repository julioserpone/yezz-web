@extends('public.layouts.sec')

@section('htmlheader_title')
{{ trans('message.manuals') }}
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
			<div class="col-md-12 col-sm-12 col-xs-12">
				<h2 class="title-support">{{ trans('message.manuals') }}</h2>
			</div>
		</div>
		<div class="row text-center">
			@foreach($manuals as $index => $manual)
			<div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
				<div class="manuals-products">
					<a href="/downloads/manuals/{{$manual->name}}" target="_blank">
						<img src="/img/products/{{$manual->product->line}}/{{$manual->product->model_id}}/yezz-{{$manual->product->model_id}}-front-view.png" alt="" class="img-responsive yezz-item-catalog" onerror="this.src='/img/page/misc/noimage.png'">
						<h3>{{$manual->product->model}}</h3>
					</a>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>

<!-- Countries Modal -->
@include('public.layouts.partials.countries') 
<!-- END Countries Modal -->

@endsection