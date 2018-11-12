
@extends('public.layouts.sec')

@section('htmlheader_title')
Home
@endsection


@section('main-content')

<div class="about-block content content-center">
  <div class="panel-body" style="min-height:600px;">
    <div class="container-fluid">
      <div class="row" style="border:1px 0 0 0;border-style:thin;">
        <div class="col-md-12">
          <h1>{{ trans('message.compare-products') }}</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3 m-03 custom-column-pad">
          {!! Form::select('compare1',$productList,  old('compare1'), ['class' => 'form-control','id'=>'compare1']); !!}         
        </div>
        <div class="col-md-3 m-03 custom-column-pad">
         {!! Form::select('compare2', $productList,  old('compare2'), ['class' => 'form-control','id'=>'compare2']); !!}         
       </div>
       <div class="col-md-3 m-03 custom-column-pad">
         {!! Form::select('compare3', $productList,  old('compare3'), ['class' => 'form-control','id'=>'compare3']); !!}         
       </div>
       <div class="col-md-3 m-03 custom-column-pad">
         {!! Form::select('compare4', $productList,  old('compare4'), ['class' => 'form-control','id'=>'compare4']); !!}         
       </div>
     </div>




     <div class="row">
       <div class="col-md-3 col-xs-3">
         <img id="img-1" src="" class="img-responsive custom-specs-img custom-hidden" onerror="this.src='/img/page/misc/noimage.png'">
       </div>
       <div class="col-md-3 col-xs-3">
         <img id="img-2" src="" class="img-responsive custom-specs-img custom-hidden" onerror="this.src='/img/page/misc/noimage.png'">
         
       </div>
       <div class="col-md-3 col-xs-3">
         <img id="img-3" src="" class="img-responsive custom-specs-img custom-hidden" onerror="this.src='/img/page/misc/noimage.png'">
         
       </div>
       <div class="col-md-3 col-xs-3">
         <img id="img-4" src="" class="img-responsive custom-specs-img custom-hidden" onerror="this.src='/img/page/misc/noimage.png'">
         
       </div>
     </div>

     <div class="row">
      <div class="col-md-3 m-03 col-xs-3">
        <h5 class="custom-specs-model"><span id="line-1"></span>&nbsp;<span id="model-1"></span>
        </h5>
      </div>
      <div class="col-md-3 m-03 col-xs-3">
        <h5 class="custom-specs-model"><span id="line-2"></span>&nbsp;<span id="model-2"></span>
        </h5>
      </div>
      <div class="col-md-3 m-03 col-xs-3">
       <h5 class="custom-specs-model"><span id="line-3"></span>&nbsp;<span id="model-3"></span>
       </h5>
     </div>
     <div class="col-md-3 m-03 col-xs-3">
       <h5 class="custom-specs-model"><span id="line-4"></span>&nbsp;<span id="model-4"></span>
       </h5>
     </div>
   </div>
   <br/>
   <div class="row text-left"
>    <div class="col-md-12">
      <span class="custom-specs-section custom-hidden custom-hidden" id="section-dimensions">{{ trans('message.dimensions_weight') }}</span>
    </div>
  </div>     

  <div class="row text-left">
    <div class="col-md-3 m-03 col-xs-3">

      <span class="custom-specs-title custom-hidden" id="label-dimensions-1">{{ trans('message.dimensions') }}</span>
      <br/> 
      <span id="dimensions-1" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-dimensions-2">{{ trans('message.dimensions') }}</span>
      <br/> 
      <span id="dimensions-2" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-dimensions-3"">{{ trans('message.dimensions') }}</span>
      <br/> 
      <span id="dimensions-3" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title  custom-hidden" id="label-dimensions-4">{{ trans('message.dimensions') }}</span>
      <br/> 
      <span id="dimensions-4" class="custom-specs-item"></span>
    </div>
  </div>


  <div class="row text-left">
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-weight-1">{{ trans('message.weight') }}</span>
      <br/> 
      <span id="weight-1" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-weight-2">{{ trans('message.weight') }}</span>
      <br/> 
      <span id="weight-2" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-weight-3">{{ trans('message.weight') }}</span>
      <br/> 
      <span id="weight-3" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-weight-4">{{ trans('message.weight') }}</span>
      <br/> 
      <span id="weight-4" class="custom-specs-item"></span>
    </div>
  </div>
  <br/>
  <div class="row text-left">
    <div class="col-md-12">
      <span class="custom-specs-section custom-hidden" id="section-chipset">{{ trans('message.platform') }}</span>
    </div>
  </div>     

  <div class="row text-left">
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-chipset-1">{{ trans('message.chipset') }}</span>
      <br/> 
      <span id="chipset-1" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-chipset-2">{{ trans('message.chipset') }}</span>
      <br/> 
      <span id="chipset-2" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-chipset-3">{{ trans('message.chipset') }}</span>
      <br/> 
      <span id="chipset-3" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-chipset-4">{{ trans('message.chipset') }}</span>
      <br/> 
      <span id="chipset-4" class="custom-specs-item"></span>
    </div>
  </div>



  <div class="row text-left">
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-cpu-1">{{ trans('message.cpu') }}</span>
      <br/> 
      <span id="cpu-1" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-cpu-2">{{ trans('message.cpu') }}</span>
      <br/> 
      <span id="cpu-2" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-cpu-3">{{ trans('message.cpu') }}</span>
      <br/> 
      <span id="cpu-3" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-cpu-4">{{ trans('message.cpu') }}</span>
      <br/> 
      <span id="cpu-4" class="custom-specs-item"></span>
    </div>
  </div>

  <div class="row text-left">
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-gpu-1">{{ trans('message.gpu') }}</span>
      <br/> 
      <span id="gpu-1" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-gpu-2">{{ trans('message.gpu') }}</span>
      <br/> 
      <span id="gpu-2" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-gpu-3">{{ trans('message.gpu') }}</span>
      <br/> 
      <span id="gpu-3" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-gpu-4">{{ trans('message.gpu') }}</span>
      <br/> 
      <span id="gpu-4" class="custom-specs-item"></span>
    </div>
  </div>
  <div class="row text-left">
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-operating_system-1">{{ trans('message.operating_system') }}</span>
      <br/> 
      <span id="operating_system-1" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-operating_system-2">{{ trans('message.operating_system') }}</span>
      <br/> 
      <span id="operating_system-2" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-operating_system-3">{{ trans('message.operating_system') }}</span>
      <br/> 
      <span id="operating_system-3" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-operating_system-4">{{ trans('message.operating_system') }}</span>
      <br/> 
      <span id="operating_system-4" class="custom-specs-item"></span>
    </div>
  </div>

  <br/>

  <div class="row text-left">
    <div class="col-md-12">
      <span class="custom-specs-section custom-hidden" id="section-simCard">{{ trans('message.network') }}</span>
    </div>
  </div>     
  <div class="row text-left">
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-simCard-1">{{ trans('message.simCard') }}</span>
      <br/> 
      <span id="simCard-1" class="custom-specs-item"></span>&nbsp;<span id="simQty-1" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-simCard-2">{{ trans('message.simCard') }}</span>
      <br/> 
      <span id="simCard-2" class="custom-specs-item"></span>&nbsp;<span id="simQty-2" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-simCard-3">{{ trans('message.simCard') }}</span>
      <br/> 
      <span id="simCard-3" class="custom-specs-item"></span>&nbsp;<span id="simQty-3" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-simCard-4">{{ trans('message.simCard') }}</span>
      <br/> 
      <span id="simCard-4" class="custom-specs-item"></span>&nbsp;<span id="simQty-4" class="custom-specs-item"></span>
    </div>
  </div>


  <div class="row text-left">
    <div class="col-md-3 m-03 col-xs-3 custom-hidden" id="label-gsm_bands-1">
      <span class="custom-specs-title">{{ trans('message.gsm_edge') }}</span>
      <br/>{{ trans('message.bands') }} 
      <span id="gsm_bands-1" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3 custom-hidden" id="label-gsm_bands-2">
      <span class="custom-specs-title">{{ trans('message.gsm_edge') }}</span>
      <br/>{{ trans('message.bands') }} 
      <span id="gsm_bands-2" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3 custom-hidden" id="label-gsm_bands-3">
      <span class="custom-specs-title">{{ trans('message.gsm_edge') }}</span>
      <br/>{{ trans('message.bands') }} 
      <span id="gsm_bands-3" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3 custom-hidden" id="label-gsm_bands-4">
      <span class="custom-specs-title">{{ trans('message.gsm_edge') }}</span>
      <br/>{{ trans('message.bands') }} 
      <span id="gsm_bands-4" class="custom-specs-item"></span>
    </div>
  </div>

  <div class="row text-left">
    <div class="col-md-3 m-03 col-xs-3 custom-hidden" id="label-threeg_bands-1">
      <span class="custom-specs-title">3G</span>&nbsp;<span id="three_g-1"></span>
      <br/>{{ trans('message.bands') }} 
      <span id="threeg_bands-1" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3 custom-hidden" id="label-threeg_bands-2">
      <span class="custom-specs-title">3G</span>&nbsp;<span id="three_g-2"></span>
      <br/>{{ trans('message.bands') }} 
      <span id="threeg_bands-2" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3 custom-hidden" id="label-threeg_bands-3">
      <span class="custom-specs-title">3G</span>&nbsp;<span id="three_g-3"></span>
      <br/>{{ trans('message.bands') }} 
      <span id="threeg_bands-3" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3 custom-hidden" id="label-threeg_bands-4">
      <span class="custom-specs-title">3G</span>&nbsp;<span id="three_g-4"></span>
      <br/>{{ trans('message.bands') }} 
      <span id="threeg_bands-4" class="custom-specs-item"></span>
    </div>
  </div>
  <div class="row text-left">
    <div class="col-md-3 m-03 col-xs-3 custom-hidden" id="label-fourg_bands-1">
      <span class="custom-specs-title">4G</span>&nbsp;<span id="four_g-1"></span>
      <br/>{{ trans('message.bands') }} 
      <span id="fourg_bands-1" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3 custom-hidden" id="label-fourg_bands-2">
      <span class="custom-specs-title">4G</span>&nbsp;<span id="four_g-2"></span>
      <br/>{{ trans('message.bands') }} 
      <span id="fourg_bands-2" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3 custom-hidden" id="label-fourg_bands-3">
      <span class="custom-specs-title">4G</span>&nbsp;<span id="four_g-3"></span>
      <br/>{{ trans('message.bands') }} 
      <span id="fourg_bands-3" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3 custom-hidden" id="label-fourg_bands-4">
      <span class="custom-specs-title">4G</span>&nbsp;<span id="four_g-4"></span>
      <br/>{{ trans('message.bands') }} 
      <span id="fourg_bands-4" class="custom-specs-item"></span>
    </div>
  </div>

  <br/>
  <div class="row text-left">
    <div class="col-md-12">
    <span class="custom-specs-section custom-hidden" id="section-displayType">{{ trans('message.display') }}</span>
    </div>
  </div>     
  <div class="row text-left">
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-displayType-1">{{ trans('message.displayType') }}</span>
      <br/><span id="displayType-1" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-displayType-2">{{ trans('message.displayType') }}</span>
      <br/><span id="displayType-2" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-displayType-3">{{ trans('message.displayType') }}</span>
      <br/><span id="displayType-3" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-displayType-4">{{ trans('message.displayType') }}</span>
      <br/><span id="displayType-4" class="custom-specs-item"></span>
    </div>
  </div>
  <div class="row text-left">
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-displaySize-1">{{ trans('message.displaySize') }}</span>
      <br/><span id="displaySize-1" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-displaySize-2">{{ trans('message.displaySize') }}</span>
      <br/><span id="displaySize-2" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-displaySize-3">{{ trans('message.displaySize') }}</span>
      <br/><span id="displaySize-3" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-displaySize-4">{{ trans('message.displaySize') }}</span>
      <br/><span id="displaySize-4" class="custom-specs-item"></span>
    </div>
  </div>
  <div class="row text-left">
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-resolution-1">{{ trans('message.resolution') }}</span>
      <br/><span id="resolution-1" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-resolution-2">{{ trans('message.resolution') }}</span>
      <br/><span id="resolution-2" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-resolution-3">{{ trans('message.resolution') }}</span>
      <br/><span id="resolution-3" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-resolution-4">{{ trans('message.resolution') }}</span>
      <br/><span id="resolution-4" class="custom-specs-item"></span>
    </div>
  </div>
  <br/>

  <div class="row text-left">
    <div class="col-md-12">
      <span class="custom-specs-section custom-hidden" id="section-primary_camera">{{ trans('message.camera') }}</span>
    </div>
  </div>     
  <div class="row text-left">
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-primary_camera-1">{{ trans('message.rearCamera') }}</span>
      <br/><span id="primary_camera-1" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-primary_camera-2">{{ trans('message.rearCamera') }}</span>
      <br/><span id="primary_camera-2" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-primary_camera-3">{{ trans('message.rearCamera') }}</span>
      <br/><span id="primary_camera-3" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-primary_camera-4">{{ trans('message.rearCamera') }}</span>
      <br/><span id="primary_camera-4" class="custom-specs-item"></span>
    </div>
  </div>


  <div class="row text-left">
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-secundary_camera-1">{{ trans('message.frontCamera') }}</span>
      <br/><span id="secundary_camera-1" class="custom-specs-item"></span>

    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-secundary_camera-2">{{ trans('message.frontCamera') }}</span>
      <br/><span id="secundary_camera-2" class="custom-specs-item"></span>

    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-secundary_camera-3">{{ trans('message.frontCamera') }}</span>
      <br/><span id="secundary_camera-3" class="custom-specs-item"></span>

    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-secundary_camera-4">{{ trans('message.frontCamera') }}</span>
      <br/><span id="secundary_camera-4" class="custom-specs-item"></span>
    </div>
  </div>
  <br/>
  <div class="row text-left">
    <div class="col-md-12">
      <span class="custom-specs-section custom-hidden" id="section-microSDCS">{{ trans('message.memory') }}</span>
    </div>
  </div>    
  <div class="row text-left">
    <div class="col-md-3 m-03 col-xs-3 custom-hidden" id="label-microSDCS-1">
      <span class="custom-specs-title">{{ trans('message.microSD_card_slot') }}</span>
      <br/>{{ trans('message.up_to') }}&nbsp;<span id="microSDCS-1" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3 custom-hidden" id="label-microSDCS-2">
      <span class="custom-specs-title">{{ trans('message.microSD_card_slot') }}</span>
      <br/>{{ trans('message.up_to') }}&nbsp;<span id="microSDCS-2" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3 custom-hidden" id="label-microSDCS-3">
      <span class="custom-specs-title">{{ trans('message.microSD_card_slot') }}</span>
      <br/>{{ trans('message.up_to') }}&nbsp;<span id="microSDCS-3" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3 custom-hidden" id="label-microSDCS-4">
      <span class="custom-specs-title">{{ trans('message.microSD_card_slot') }}</span>
      <br/>{{ trans('message.up_to') }}&nbsp;<span id="microSDCS-4" class="custom-specs-item"></span>
    </div>
  </div>
  <div class="row text-left">
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-internalMemory-1">{{ trans('message.internalMemory') }}</span>
      <br/><span id="internalMemory-1" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-internalMemory-2">{{ trans('message.internalMemory') }}</span>
      <br/><span id="internalMemory-2" class="custom-specs-item"></span>

    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-internalMemory-3">{{ trans('message.internalMemory') }}</span>
      <br/><span id="internalMemory-3" class="custom-specs-item"></span>

    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-internalMemory-4">{{ trans('message.internalMemory') }}</span>
      <br/><span id="internalMemory-4" class="custom-specs-item"></span>
    </div>
  </div>
  <div class="row text-left">
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-ram-1">{{ trans('message.ram') }}</span>
      <br/><span id="ram-1" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-ram-2">{{ trans('message.ram') }}</span>
      <br/><span id="ram-2" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-ram-3">{{ trans('message.ram') }}</span>
      <br/><span id="ram-3" class="custom-specs-item"></span>
    </div>
    <div class="col-md-3 m-03 col-xs-3">
      <span class="custom-specs-title custom-hidden" id="label-ram-4">{{ trans('message.ram') }}</span>
      <br/><span id="ram-4" class="custom-specs-item"></span>
    </div>
  </div>

  <br/>
  <div class="row text-left">
    <div class="col-md-12">
      <span class="custom-specs-section custom-hidden" id="section-wlan">{{ trans('message.connectivity') }}</span>
    </div>
  </div>     
  <div class="row text-left">
    <div class="col-md-3 m-03 col-xs-3">
     <span class="custom-specs-title custom-hidden" id="label-wlan-1">{{ trans('message.wlan') }}</span>
     <br/><span id="wlan-1" class="custom-specs-item"></span>
   </div>
   <div class="col-md-3 m-03 col-xs-3">
     <span class="custom-specs-title custom-hidden" id="label-wlan-2">{{ trans('message.wlan') }}</span>
     <br/><span id="wlan-2" class="custom-specs-item"></span>
   </div>
   <div class="col-md-3 m-03 col-xs-3">
     <span class="custom-specs-title custom-hidden" id="label-wlan-3">{{ trans('message.wlan') }}</span>
     <br/><span id="wlan-3" class="custom-specs-item"></span>
   </div>
   <div class="col-md-3 m-03 col-xs-3">
     <span class="custom-specs-title custom-hidden" id="label-wlan-4">{{ trans('message.wlan') }}</span>
     <br/><span id="wlan-4" class="custom-specs-item"></span>
   </div>
 </div>
 <div class="row text-left">
  <div class="col-md-3 m-03 col-xs-3">
    <span class="custom-specs-title custom-hidden" id="label-bluetooth-1">{{ trans('message.bluetooth') }}</span>
    <br/><span id="bluetooth-1" class="custom-specs-item"></span>
  </div>
  <div class="col-md-3 m-03 col-xs-3">
    <span class="custom-specs-title custom-hidden" id="label-bluetooth-2">{{ trans('message.bluetooth') }}</span>
    <br/><span id="bluetooth-2" class="custom-specs-item"></span>
  </div>
  <div class="col-md-3 m-03 col-xs-3">
    <span class="custom-specs-title custom-hidden" id="label-bluetooth-3">{{ trans('message.bluetooth') }}</span>
    <br/><span id="bluetooth-3" class="custom-specs-item"></span>
  </div>
  <div class="col-md-3 m-03 col-xs-3">
    <span class="custom-specs-title custom-hidden" id="label-bluetooth-4">{{ trans('message.bluetooth') }}</span>
    <br/><span id="bluetooth-4" class="custom-specs-item"></span>
  </div>
</div>
<div class="row text-left">
  <div class="col-md-3 m-03 col-xs-3">
    <span class="custom-specs-title custom-hidden" id="label-gps-1">{{ trans('message.gps') }}</span>
    <br/><span id="gps-1" class="custom-specs-item"></span>
  </div>
  <div class="col-md-3 m-03 col-xs-3">
    <span class="custom-specs-title custom-hidden" id="label-gps-2">{{ trans('message.gps') }}</span>
    <br/><span id="gps-2" class="custom-specs-item"></span>
  </div>
  <div class="col-md-3 m-03 col-xs-3">
    <span class="custom-specs-title custom-hidden" id="label-gps-3">{{ trans('message.gps') }}</span>
    <br/><span id="gps-3" class="custom-specs-item"></span>
  </div>
  <div class="col-md-3 m-03 col-xs-3">
    <span class="custom-specs-title custom-hidden" id="label-gps-4">{{ trans('message.gps') }}</span>
    <br/><span id="gps-4" class="custom-specs-item"></span>
  </div>
</div>
<br/>

<div class="row text-left">
  <div class="col-md-12">
    <span class="custom-specs-section custom-hidden" id="section-batteryCapacity">{{ trans('message.battery') }}</span>
  </div>
</div>     
<div class="row text-left">
  <div class="col-md-3 m-03 col-xs-3">
    <span class="custom-specs-title custom-hidden" id="label-batteryCapacity-1">{{ trans('message.batteryCapacity') }}</span>
    <br/><span id="batteryCapacity-1" class="custom-specs-item"></span>
  </div>
  <div class="col-md-3 m-03 col-xs-3">
    <span class="custom-specs-title custom-hidden" id="label-batteryCapacity-2">{{ trans('message.batteryCapacity') }}</span>
    <br/><span id="batteryCapacity-2" class="custom-specs-item"></span>
  </div>
  <div class="col-md-3 m-03 col-xs-3">
    <span class="custom-specs-title custom-hidden" id="label-batteryCapacity-3">{{ trans('message.batteryCapacity') }}</span>
    <br/><span id="batteryCapacity-3" class="custom-specs-item"></span>
  </div>
  <div class="col-md-3 m-03 col-xs-3">
    <span class="custom-specs-title custom-hidden" id="label-batteryCapacity-4">{{ trans('message.batteryCapacity') }}</span>
    <br/><span id="batteryCapacity-4" class="custom-specs-item"></span>
  </div>
</div>
<div class="row text-left">
  <div class="col-md-3 m-03 col-xs-3">
    <span class="custom-specs-title custom-hidden" id="label-batteryRemovable-1">{{ trans('message.batteryRemovable') }}</span>
    <br/><span id="batteryRemovable-1" class="custom-specs-item"></span>
  </div>
  <div class="col-md-3 m-03 col-xs-3">
    <span class="custom-specs-title custom-hidden" id="label-batteryRemovable-2">{{ trans('message.batteryRemovable') }}</span>
    <br/><span id="batteryRemovable-2" class="custom-specs-item"></span>
  </div>
  <div class="col-md-3 m-03 col-xs-3">
    <span class="custom-specs-title custom-hidden" id="label-batteryRemovable-3">{{ trans('message.batteryRemovable') }}</span>
    <br/><span id="batteryRemovable-3" class="custom-specs-item"></span>
  </div>
  <div class="col-md-3 m-03 col-xs-3">
    <span class="custom-specs-title custom-hidden" id="label-batteryRemovable-4">{{ trans('message.batteryRemovable') }}</span>
    <br/><span id="batteryRemovable-4" class="custom-specs-item"></span>
  </div>
</div>


</div>
</div>
</div>


<script type="text/javascript">
  $('#panel-1').hide();
  $('#panel-2').hide();
  $('#panel-3').hide();
  $('#panel-4').hide();


  var img = {line : '', model_id: ''};

  $("#compare1").change(function () {
    $( "#compare1 option:selected" ).each(function() {
      var product_extId = $( this ).val();

      if (product_extId !=0) getProduct(product_extId, 1);

    });


  })
  .change();


  $("#compare2").change(function () {
    $( "#compare2 option:selected" ).each(function() {
      var product_extId = $( this ).val();

      if (product_extId !=0) getProduct(product_extId, 2);

    });    
  })
  .change();



  $("#compare3").change(function () {
    $( "#compare3 option:selected" ).each(function() {
      var product_extId = $( this ).val();

      if (product_extId !=0) getProduct(product_extId, 3);

    });    
  })
  .change();




  $("#compare4").change(function () {
    $( "#compare4 option:selected" ).each(function() {
      var product_extId = $( this ).val();

      if (product_extId !=0) getProduct(product_extId, 4);

    });    
  })
  .change();

  function getProduct(ext_id, column)
  {
    
    if(ext_id!=0){

     $.ajax({
      type: 'GET', 
      url: '/api/product/'+ext_id, 
      success: function(result) {
        if (result!=null)
        {
          if(result.code==200){
            populateSpecs(result.data, column);
          }
        }
      }
    });
   }
 }


 function populateSpecs(data, column){



  $.each(data, function(key, value){

   if(value==null){value="";} 

   var _id      = '#'+key+"-"+column;
   var _label   = '#label-'+key+"-"+column;
   var _section = '#section-'+key;

   if(key=="multitouch" || key=="batteryRemovable"){
     if (value==1){
      value = " "+ <?php echo '\''.trans('message.yes').'\''  ?> + "";
    }else{
      value = " "+ <?php echo '\''.trans('message.no').'\''  ?> + "";
    }
  }

  if(key=="line")
  {
    img.line = value;
  }    
  if(key=="model_id")
  {
    img.model_id = value;
  } 
  if(key=="weight")
  {
    value = value+" gr.";
  }     

  $('#img-'+column).attr('src', '/img/products/'+img.line+'/'+img.model_id+'/yezz-'+img.model_id+"-front-view.png");
  
  if($('#img-'+column).hasClass('custom-hidden')){
    $('#img-'+column).removeClass('custom-hidden');
  }


  var exists = $(_section).length;
  
  if(exists>0 && $(_section).hasClass('custom-hidden'))
  {
    $(_section).removeClass('custom-hidden');
  }


  exists = $(_label).length;
  if(exists>0)
  {
    $(_label).removeClass('custom-hidden');
  }


  $(_id).text(value);


});


}

function showSections(column)
{

}



</script>

@endsection

<!-- Countries Modal -->
@include('public.layouts.partials.countries') 
<!-- END Countries Modal -->