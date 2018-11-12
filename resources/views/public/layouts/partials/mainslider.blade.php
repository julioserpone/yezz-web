
<!--Template slider start-->
<div id="promo-block">
  <div id="slider">
    @foreach($banners as $banner)
    @php
      $media = $banner->getMedia('banners');
    @endphp
    <div class="item">
      <a href="{{ $banner->url }}">
        <img src="{{ $media[0]->getUrl() }}" alt="{{ $banner->description }}" class="img-responsive" style="margin: 0 auto; width: 100%;">
      </a>
    </div>
    @endforeach
  </div>
</div>
<!-- Template Slider End -->


