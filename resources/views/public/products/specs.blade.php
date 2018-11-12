
@extends('public.layouts.sec')

@section('htmlheader_title')
{{$product->model}}
@endsection

@section('main-content')

<img src="/img/products/{{$product->line}}/{{$product->model_id}}/yezz-andy-{{$product->model_id}}-hero-image.jpg" alt="" class="img-responsive yezz-item-catalog" onerror="this.src='/img/page/misc/noimage.png'" style="margin-top: 70px;">
<div class="about-block content pt-0">
	<div class="container-fluid">
		<div> 
			<h2>{{$product->model}}</h2>
		</div>
		<div>
			<h2>{{ trans('message.technical_specs') }}</h2>
		</div>
		<div class="row">
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="panel">
					<div class="panel-heading"><strong>{{ trans('message.dimensions_weight') }}</strong></div>
					<div class="panel-body">
						<span class="custom-title-specs">{{ trans('message.dimensions') }}</span><br/>
						<span class="custom-specs">{{$product->specs->dimensions}}</span><br/>
						<span class="custom-title-specs">{{ trans('message.weight') }}</span><br/>
						<span class="custom-specs">{{$product->specs->weight}}&nbsp;{{ trans('message.gr') }}</span>
					</div>
				</div>
			</div>

			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="panel custom-panel">
					<div class="panel-heading"><strong>{{ trans('message.platform') }}</strong></div>
					<div class="panel-body">
						<span class="custom-title-specs">{{ trans('message.chipset') }}</span><br/>
						<span class="custom-specs">{{$product->specs->chipset}}</span><br/>
						<span class="custom-title-specs">{{ trans('message.cpu') }}</span><br/>
						@if($product->specs->cpu_cores=='dual core')
						<span class="custom-specs">{{ trans('message.dual_core') }}</span>&nbsp;
						@elseif($product->specs->cpu_cores=='quad core')
						<span class="custom-specs">{{ trans('message.quad_core') }}</span>&nbsp;   
						@elseif($product->specs->cpu_cores=='octa core')
						<span class="custom-specs">{{ trans('message.octa_core') }}</span>&nbsp;   
						@endif   
						<span class="custom-specs">{{$product->specs->cpu}}</span><br/>
						<span class="custom-title-specs">{{ trans('message.gpu') }}</span><br/>
						<span class="custom-specs">{{$product->specs->gpu}}</span><br/>
						<span class="custom-title-specs">{{ trans('message.operating_system') }}</span><br/>
						<span class="custom-specs">{{$product->specs->operating_system}}</span>
					</div>                                    
				</div>
			</div>

			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="panel custom-panel">
					<div class="panel-heading"><strong>{{ trans('message.network') }}</strong></div>
					<div class="panel-body">
						<span class="custom-title-specs">{{ trans('message.simCard') }}</span><br/>
						<span class="custom-specs">{{$product->specs->simCard}}</span>
						@if($product->specs->simQty=='dual sim')
						&nbsp;<strong class="custom-specs">{{ trans('message.dual_sim') }}</strong>
						@endif
						<br/>
						<span class="custom-title-specs">{{ trans('message.gsm_edge') }}</span><br/>
						<strong class="custom-specs">{{ trans('message.bands') }}&nbsp;{{$product->specs->gsm_bands}}</strong><br/>
						@if($product->specs->threeg_bands!=null)
						<span class="custom-title-specs">{{ trans('message.threeg') }}&nbsp;{{$product->specs->threeg_speed}}</span><br/>
						<strong class="custom-specs">{{ trans('message.bands') }}&nbsp;{{$product->specs->threeg_bands}}</strong><br/>
						@endif
						@if($product->specs->fourg_bands!=null)
						<span class="custom-title-specs">{{ trans('message.fourg') }}&nbsp;{{$product->specs->fourg_speed}}</span><br/>
						<strong class="custom-specs">{{ trans('message.bands') }}&nbsp;{{$product->specs->fourg_bands}}</strong>
						@endif
					</div>
				</div>
			</div>

			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="panel custom-panel">
					<div class="panel-heading"><strong>{{ trans('message.display') }}</strong></div>
					<div class="panel-body">
						<span class="custom-title-specs">{{ trans('message.type') }}</span><br/>
						<span class="custom-specs">{{$product->specs->displayType}}</span><br/>
						<span class="custom-title-specs">{{ trans('message.size') }}</span><br/>
						<span class="custom-specs">{{$product->specs->displaySize}}</span><br/>
						<span class="custom-title-specs">{{ trans('message.resolution') }}</span><br/>
						<span class="custom-specs">{{$product->specs->resolution}}</span><br/>
						<span class="custom-title-specs">{{ trans('message.multitouch') }}</span><br/>
						@if($product->specs->multitouch==1)
						<span class="custom-specs">{{ trans('message.yes') }}</span>
						@else
						<span class="custom-specs">{{ trans('message.yes') }}</span>
						@endif
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="panel custom-panel">
					<div class="panel-heading"><strong>{{ trans('message.camera') }}</strong></div>
					<div class="panel-body">
						<span class="custom-title-specs">{{ trans('message.rearCamera') }}</span><br/>
						<span class="custom-specs">{{$product->specs->primary_camera}}</span><br/>
						<span class="custom-title-specs">{{ trans('message.frontCamera') }}</span><br/>
						<span class="custom-specs">{{$product->specs->secundary_camera}}</span><br/>
						<span class="custom-title-specs">{{ trans('message.videoRecording') }}</span><br/>
						<span class="custom-specs">{{$product->specs->videoRecording}}</span><br/>
						@if($product->specs->primary_camera_features!=null)
						<span class="custom-title-specs">{{ trans('message.rearCameraFeatures') }}</span><br/>
						@foreach(explode(',', $product->specs->primary_camera_features) as $features) 
						@if($features=='autofocus')
						<span class="custom-specs">{{ trans('message.autofocus') }}</span><br/>
						@endif
						@if($features=='led flash')
						<span class="custom-specs">{{ trans('message.led_flash') }}</span><br/>
						@endif
						@if($features=='photo geotagging')
						<span class="custom-specs">{{ trans('message.photo_geotagging') }}</span><br/>
						@endif
						@if($features=='hdr')
						<span class="custom-specs">{{ trans('message.hdr') }}</span><br/>
						@endif
						@if($features=='panoramic photo' || $features=='Panorama')
						<span class="custom-specs">{{ trans('message.panoramic_photo') }}</span><br/>
						@endif
						@if($features=='touch focus')
						<span class="custom-specs">{{ trans('message.touch_focus') }}</span><br/>
						@endif
						@if($features=='Face Detect')
						<span class="custom-specs">{{ trans('message.face_detection') }}</span><br/>
						@endif
						@if($features=='Smile Shot')
						<span class="custom-specs">{{ trans('message.smile_shot') }}</span><br/>
						@endif
						@if($features=='HDR')
						<span class="custom-specs">HDR</span><br/>
						@endif
						@if($features=='Face beauty')
						<span class="custom-specs">{{trans('message.face_beauty')}}</span><br/>
						@endif
						@if($features=='Continuous Shot')
						<span class="custom-specs">{{trans('message.continuous_shot')}}</span><br/>
						@endif
						

						@endforeach
						@endif
					</div>
				</div>
			</div>

			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="panel custom-panel">
					<div class="panel-heading"><strong>{{ trans('message.memory') }}</strong></div>
					<div class="panel-body">
						@if($product->specs->wlan!=null || $product->specs->wlan!='')
						<span class="custom-title-specs">{{ trans('message.microSD_card_slot') }}</span><br/>
						<span class="custom-specs">{{ trans('message.support_sd') }}&nbsp;{{$product->specs->microSDCS}} 
							{{ trans('message.microSD_cards') }}</span><br/>
							@endif                           
							<span class="custom-title-specs">{{ trans('message.internalMemory') }}</span><br/>
							<span class="custom-specs">{{ $product->specs->internalMemory }}</span><br/>
							<span class="custom-title-specs">{{ trans('message.ram') }}</span><br/>
							<span class="custom-specs">{{ $product->specs->ram }}</span><br/>
						</div>
					</div>
				</div>

				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="panel custom-panel">
						<div class="panel-heading"><strong>{{ trans('message.connectivity') }}</strong></div>
						<div class="panel-body">
							@if($product->specs->wlan!=null || $product->specs->wlan!='')
							<span class="custom-title-specs">{{ trans('message.wlan') }}</span><br/>
							<span class="custom-specs">{{ $product->specs->wlan }}</span><br/>
							@endif  
							@if($product->specs->bluetooth!=null || $product->specs->bluetooth!='')
							<span class="custom-title-specs">{{ trans('message.bluetooth') }}</span><br/>
							<span class="custom-specs">{{ trans('message.bluetooth') }}&nbsp;{{$product->specs->bluetooth}}</span><br/>
							@endif
							@if($product->specs->gps!=null || $product->specs->gps!='')
							<span class="custom-title-specs">{{ trans('message.gps') }}</span><br/>
							<span class="custom-specs">{{$product->specs->gps}}</span><br/>
							@endif
							@if($product->specs->usb!=null || $product->specs->usb!='')   
							<span class="custom-title-specs">{{ trans('message.usb') }}</span><br/>
							<span class="custom-specs">{{$product->specs->usb}}</span><br/>
							@endif
						</div>
					</div>
				</div>

				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="panel custom-panel">
						<div class="panel-heading"><strong>{{ trans('message.battery') }}</strong></div>
						<div class="panel-body">
							<span class="custom-title-specs">{{ trans('message.type') }}</span><br/>
							<span class="custom-specs">{{ $product->specs->batteryType }}</span><br/>
							<span class="custom-title-specs">{{ trans('message.capacity') }}</span><br/>
							<span class="custom-specs">{{ $product->specs->batteryCapacity }}</span><br/>
							<span class="custom-title-specs">{{ trans('message.removable') }}</span><br/>
							@if($product->specs->batteryRemovable==1)
							<span class="custom-specs">{{ trans('message.yes') }}</span>
							@else
							<span class="custom-specs">{{ trans('message.no') }}</span>
							@endif
						</div>
					</div>
				</div>
			</div>
			@if($show_sales_guide==1)
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8 text-center">
					<a href="/sales-guide/{{$lang_country}}/{{$sales_guide}}" target="_blank">
						<img src="/img/page/banners/sales_guide_{{$lang_country}}.jpg" class="img-responsive yezz-item-catalog">
					</a>
				</div>
				
				<div class="col-md-2"></div>
			</div>
			@endif
			<br/>
			@if($countries->count()>0)
			<div class="row">
				<div class="col-md-4 col-sm-12 col-xs-12"></div>
				<div class="col-md-4 col-sm-12 col-xs-12">
					<span>{{ trans('message.available_on') }}</span>&nbsp;
					@foreach($countries as $index => $value)
					<a href="/products/catalog/en-{{$value->country->code}}"> {{$value->country->name}}</a>
					@endforeach
				</div>
				<div class="col-md-4 col-sm-12 col-xs-12"></div>
			</div>
			@endif
			<br/>
		</div>
	</div>    
</div>
	@include('public.layouts.partials.login') 
	@include('public.layouts.partials.register') 
	@include('public.layouts.partials.logout') 

	<!-- Countries Modal -->
	@include('public.layouts.partials.countries')

	@endsection