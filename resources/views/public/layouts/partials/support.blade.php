

<div class="row">
  {{--<div class="col-lg-1 col-md-1 hidden-xs item">
  </div>--}}
  <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 item">
    <a href="/faqs/{{$lang_country}}">
      <img src="/img/page/icons/faqs.png" class="yezz-support-icons">
      <h3>FAQs</h3>
    </a>
    <p>{{ trans('message.faq_desc') }}<br></p>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 item">
    <a href="/manuals/{{$lang_country}}">
      <img src="/img/page/icons/downloads.png" class="yezz-support-icons"">
      <h3>{{ trans('message.manuals') }}</h3>
    </a>
    <p>{{ trans('message.declaration_conformity') }}<br>
      {{ trans('message.intranet_distributors') }}<br/>
    </p>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 item">
    <a href="/service-providers/{{$lang_country}}">
      <img src="/img/page/icons/customer-service.png" class="yezz-support-icons">
      <h3>{{ trans('message.service_providers') }}</h3>
    </a>
    <p>{{ trans('message.contacts') }}</p>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 item">
    <a href="/warranty-policy/{{$lang_country}}">
      <img src="/img/page/icons/warranty.png" class="yezz-support-icons">
      <h3>{{ trans('message.warranty_policy') }}</h3>
    </a>
    <p>{{ trans('message.warranty_policy') }}</p>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 item">
    <a href="/authorized-service-centers/{{$lang_country}}">
      <img src="/img/page/icons/service-authorized.png" class="yezz-support-icons">
      <h3>{{ trans('message.authorized_service_centers') }}</h3>
    </a>
    <p>{{ trans('message.authorized_service_centers') }}</p>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 item">
    <a href="/sellers/{{$lang_country}}">
      <img src="/img/page/icons/sellers.png" class="yezz-support-icons">
      <h3>{{ trans('message.sellers') }}</h3>
    </a>
    <p>{{ trans('message.sellers_authorized') }}</p>
  </div>
  {{--<div class="col-lg-1 col-md-1 hidden-xs item">
  </div>--}}
</div>