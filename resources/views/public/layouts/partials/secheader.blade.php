<?php 
$langcountry = "";
if (!empty($lang_country))
{
  $langcountry = $lang_country; 
} 

?>
<div class="header header-mobi-ext" style="margin-bottom: 0px;">
    <div class="container">
      <div class="row">
        <!-- Logo BEGIN -->
        <div class="col-md-2 col-sm-2">
          <a class="site-logo" href="/{{$langcountry}}"><img src="/img/page/yezz-logo.png" alt="Yezz World" height="42" width="130"></a>
        </div>
        <!-- Logo END -->
        <a href="javascript:void(0);" class="mobi-toggler"><i class="fa fa-bars"></i></a>
        <!-- Navigation BEGIN -->
        <div class="col-md-10 pull-right">
          <ul class="header-navigation">
            <li><a href="/{{$langcountry}}"><span>{{ trans('message.home') }}</span></a></li>
            <li id="menu-products"><a href="/products/catalog/{{$langcountry}}" id="a-products"><span>{{ trans('message.products') }}</span></a></li>
            <li><a href="http://journal.sayyezz.com" target="_blank"><span>{{ trans('message.journal') }}</span></a></li>
            <li id="menu-support"><a href="/support/{{$langcountry}}"   id="a-support"><span>{{ trans('message.support') }}</span></a></li>
            <li id="menu-contact"><a href="/contact/{{$langcountry}}" id="a-contact">{{ trans('message.contact-us') }}</a></li>
            <li><a href="https://yezzstore.com/?o=sy"><span>{{ trans('message.store') }}</span></a></li>
            <li><a href="#" onclick="showCountriesModal();"><i class="fa fa-globe"></i><span id="lang_country">{{$langcountry}}</span></a></li>
          </ul>
        </div>
        <!-- Navigation END -->
      </div>
    </div>
  </div>



            