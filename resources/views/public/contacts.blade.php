
<?php 
$langcountry = "";
if (isset($lang_country))
{
  $langcountry = $lang_country; 
} 

?>
@extends('public.layouts.sec')

@section('htmlheader_title')
Home
@endsection


@section('main-content')
<div class="content">
	<div class="row">
		<div class="col-md-12">
			<h1 class="title-support">{{ trans('message.contact-us') }}</h1>
		</div>
	</div>
	<div class="row pb-10">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<span style="font-size:18px;">{{ trans('message.send_us_your_inqfeed') }}</span>
		</div>
		<div class="col-md-2"></div>
	</div>
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<span style="font-size:14px;">{{ trans('message.choose_a_category_1001') }}</span>
		</div>
		<div class="col-md-2"></div>
	</div>

	@include('public.layouts.partials.contact') 

</div>


<!-- Countries Modal -->
@include('public.layouts.partials.countries') 
<!-- END Countries Modal -->
<script type="text/javascript">

	$(document).ready(function(){
		menuHandle('contact');

	});

</script>
@endsection