@extends('public.layouts.app')

@section('htmlheader_title')
Home
@endsection
@section('main-content')

@include('public.layouts.partials.mainslider')

<!-- Products block BEGIN -->
<div class="about-block content content-center pt-0" id="products">
  <div class="panel-body">
    <div class="container-fluid">
      @foreach($categories as $category)
        <div id="{{ $category->anchor }}" class="custom-title-container">
          <h2 class="custom-series-title">{{ $category->description }}</h2>
        </div>
        <div class="row">
          @foreach($category->catalogs() as $product)
            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
              <a href="/products/{{$product->model_id}}/{{$lang_country}}">
                <img src="/img/products/{{$product->line}}/{{$product->model_id}}/yezz-{{$product->model_id}}-front-view.png" alt="" class="img-responsive yezz-item-catalog" onerror="this.src='/img/page/misc/noimage.png'">
                <h3>{{$product->model}}</h3>
              </a>
            </div>
          @endforeach
        </div>
        <br>
        <h4>{{ trans('message.see_more') }} <a href="/products/catalog/{{$lang_country}}/#{{ $category->anchor }}" class="btn btn-primary" type="submit">{{ $category->description }}</a></h4>
      @endforeach
    </div>
  </div>
</div>
<!-- Products block END -->

<!-- Journal block BEGIN -->
<div class="portfolio-block content content-center pt-0 pb-10" id="journal">
  <div class="container">
    <h2 class="margin-bottom-50"> <strong>{{ trans('message.journal') }}</strong></h2>
  </div>
  <div class="row">
    @foreach($journals as $reg)  
    <div class="item col-md-3 col-sm-6 col-xs-12">
      <img src="/img/page/journal/{{$reg->image_url}}" alt="NAME" class="img-responsive" onerror="this.src='/img/page/misc/noimage.png'">
      <a href="{{$reg->url}}" class="zoom valign-center" target="_self">
        <div class="valign-center-elem">
          <b>{{ trans('message.details') }}</b>
        </div>
      </a>
    </div>
    @endforeach
  </div>
</div>
<!-- Journal block END -->

<!-- Support block BEGIN -->
<div class="services-block content content-center pt-20" id="support">
  <div class="container">
    <a class="title-support" href="/support/{{$lang_country}}">
      <h2> <span>{{ trans('message.support') }}</span></h2>
    </a>

      @include('public.layouts.partials.support') 

  </div>
</div>
<!-- Services block END -->
  
  <!-- Prices block Contact-us -->
  <div class="prices-block content content-center pt-0" id="contact">
    <div class="container container-fluid">
      <h2 class="margin-bottom-50"><strong>{{ trans('message.contact-us') }}</strong></h2>
      <div class="row">
        @include('public.layouts.partials.contact') 
      </div>
    </div>
  </div>

  @include('public.layouts.partials.login') 
  @include('public.layouts.partials.register') 
  @include('public.layouts.partials.logout') 

  <!-- Countries Modal -->
  @include('public.layouts.partials.countries') 
  <!-- END Countries Modal -->
  
  @endsection





