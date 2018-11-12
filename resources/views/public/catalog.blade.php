
@extends('public.layouts.sec')

@section('htmlheader_title')
{{ trans('message.catalog') }}
@endsection

@section('main-content')

<div class="about-block content content-center" id="products">
  <div class="panel-body">
    <div class="container-fluid">
      <div class="row mt-50">
        <div class="col-md-12">
          <a href="{{ route('products.compare') }}/{{$lang_country}}" class="btn btn-primary">{{ trans('message.compare') }}</a>
        </div>
      </div>
      @foreach($categories as $category)
        <div id="{{ $category->anchor}}" class="custom-title-container">
          <h2 class="custom-series-title">{{ $category->description }}</h2>
        </div>
        <div class="row">
          @foreach($category->catalogs(10) as $product)
            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
              <a href="/products/{{$product->model_id}}/{{$lang_country}}">
                <img src="/img/products/{{$product->line}}/{{$product->model_id}}/yezz-{{$product->model_id}}-front-view.png" alt="" class="img-responsive yezz-item-catalog" onerror="this.src='/img/page/misc/noimage.png'">
                <h3>{{$product->model}}</h3>
              </a>
            </div>
          @endforeach
        </div>
      @endforeach
    </div>
  </div>
</div>

<!-- Countries Modal -->
@include('public.layouts.partials.countries') 
<!-- END Countries Modal -->

@endsection