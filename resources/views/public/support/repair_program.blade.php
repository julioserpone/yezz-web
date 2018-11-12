<?php 
$chat = true;
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
<div class="about-block content" id="support">
  <div class="container-fluid" style="margin-top: 50px;">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-sm-8 col-xs-12 text-center"><h3>ANDY 5.5M LTE VR - Exchange and Repair Extension Program</h3></div>
      <div class="col-md-2"></div>
    </div>
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-sm-8 col-xs-12 text-center"><h4>DDM BRANDS LLC STATEMENT</h4></div>
      <div class="col-md-2"></div>
    </div>
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-sm-8 col-xs-12">
        <p>DDM BRANDS LLC, who are responsible for the manufacturing of the Yezz brand, announce, that as a precaution, it is recalling the 4G Smartphone Andy 5.5M LTE VR, due to concerns regarding the SAR values of LTE Band 7 (2600 MHz) that may pose a safety risk.</p> 
        <p>Customer safety is of the utmost priority to DDM BRANDS and we will repair or exchange the affected Andy 5.5M LTE VR, free of charge. </p>
      </div>
      <div class="col-md-2"></div>
    </div>
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-sm-4 col-xs-12">
        <h3>Identifying your Andy 5.5M LTE VR</h3>
        <p>Remove the battery cover and battery to reference the phone label for pertinent model and FCC information.</p> 
        <p>Model: ANDY 5.5M LTE VR</p>
        <p>FCC ID: A4JANDY55MVR</p>
      </div>
      <div class="col-md-2"></div>
    </div>

    <div class="row">
      <div class="col-md-2"></div>

      <div class="col-md-8 text-center">
        <img src="/img/page/misc/5.5mrecall.jpg"/>
      </div>
      <div class="col-md-2"></div>
    </div>
    

    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-sm-8">
        <h3>Process of Repair</h3>
        <p>Contact Yezz customer service at cacusa@sayyezz.com to request a postage paid box to send your Andy 5.5M LTE VR to the local Yezz repair center. The technician will determine if your phone is eligible to disable the LTE Band 7 or exchange the product based on your country*. The repair process takes approximately 7-12 working days from the time your Andy 5.5M LTE VR is received at the repair center.
        </p>
      </div>
      <div class="col-md-2"></div>
    </div>
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <p>Note: If your Andy 5.5M LTE VR has any damage, which prevents the repair, such as a cracked screen, that issue will need to be resolved during service. You will be notified about any additional repair charges that are required.</p>

        <p>Please back up your data before your Andy 5.5M LTE VR is serviced.</p>

        <p>*Countries eligible for Exchange, listed below, are countries that have Mobile Operator Networks with an active LTE Band 7 (2600 MHz). If your country is not listed below, your Andy 5.5M LTE VR is not eligible for exchange.</p>
        <ul>
          <li>Chile (Claro, Entel, Movistar)</li>
          <li>Colombia (Claro, Tigo)</li>
          <li>Costa Rica (Kolbi/ICE)</li>
        </ul>
      </div>
      <div class="col-md-2"></div>
    </div>

  </div>
</div>

<!-- Countries Modal -->
@include('public.layouts.partials.countries') 
<!-- END Countries Modal -->
<script type="text/javascript">
 $(document).ready(function(){
  menuHandle('support');
});

</script>


@endsection