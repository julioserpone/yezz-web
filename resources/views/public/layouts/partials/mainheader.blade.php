
<?php 
$langcountry = "";
if (isset($lang_country))
{
  $langcountry = $lang_country; 
  
} 

?>

<div class="header header-mobi-ext">
  <div class="container">
    <div class="row">
      <!-- Logo BEGIN -->
      <div class="col-md-2 col-sm-2">
        <a class="scroll site-logo" href="{{ route('app') }}"><img src="/img/page/yezz-logo.png" alt="Yezz World" height="42" width="130"></a>
      </div>
      <!-- Logo END -->
      <a href="javascript:void(0);" class="mobi-toggler"><i class="fa fa-bars"></i></a>
      <!-- Navigation BEGIN -->
      <div class="col-md-10 pull-right">
        <ul class="header-navigation">
          <li class="current"><a href="{{ route('app') }}"><span>{{ trans('message.home') }}</span></a></li>
          <li><a href="#products"><span>{{ trans('message.products') }}</span></a></li>
          <li><a href="#journal"><span>{{ trans('message.journal') }}</span></a></li>
          <li><a href="#support"><span>{{ trans('message.support') }}</span></a></li>
          <li><a href="#contact"><span>{{ trans('message.contact-us') }}</span></a></li>
          <li><a href="https://www.amazon.com/s?marketplaceID=ATVPDKIKX0DER&me=A1LIYX2D7F303K&merchant=A1LIYX2D7F303K"><span>{{ trans('message.store') }}</span></a></li>
          <li><a href="#" onclick="showCountriesModal();"><i class="fa fa-globe"></i><span id="lang_country">{{$langcountry}}</span></a></li>
        </ul>
      </div>
      <!-- Navigation END -->
    </div>
  </div>
</div>