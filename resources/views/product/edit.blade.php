@extends('layouts.app')

@section('htmlheader_title')
Products
@endsection


@section('main-content')



<legend><a href="/admin/products/view">{{ trans('message.products') }}</a>&nbsp;/&nbsp;{{$product->model}}</legend>
<div class="container spark-screen">
  <div class="row">
   <div class="col-md-6 col-xs-12">


     @if($isEdit)
     {!! Form::model($product, ['route'=>['admin.products.update',$product->ext_id], 'method'=>'PUT', 'role'=>'form','files' => true, 'name' => 'productFrm', 'id' => 'productFrm','class' => 'form-horizontal']) !!}
     @else      
     {!! Form::model(Request::all(),['route'=>['admin.products.store'], 'method'=>'POST', 'name'=>'productFrm', 'id'=> 'productFrm', 'files' => true,'role'=>'form','class' => 'form-horizontal']) !!}
     @endif

     <fieldset>
      {!! csrf_field() !!}

      <div class="form-group">
        <label for="model" class="col-lg-2 control-label">{{ trans('message.operating_system') }}</label>
        <div class="col-lg-10">
          {!! Form::select('operatingSystems', $operatingSystems, isset($product) && $product->osCode ? $product->osCode  : old('operatingSystems'), ['class' => 'form-control','id'=>'operatingSystems']); !!}            

        </div>
      </div>

      <div class="form-group">
        <label for="model" class="col-lg-2 control-label">{{ trans('message.category') }}</label>
        <div class="col-lg-10">
          {!! Form::select('category', $categories, isset($product) && $product->category ? $product->category  : old('category'), ['class' => 'form-control','id'=>'category']); !!}            

        </div>
      </div>

      <div class="form-group">

        <label for="inputModel" class="col-lg-2 control-label">{{ trans('message.model') }}</label>
        <div class="col-lg-10">
          {{ Form::text('model', isset($product->model) ? $product->model : old('model'), array('class' => 'form-control', 'id' => 'model','placeholder'=>trans('message.model')  )) }}

        </div>
      </div>
      <div class="form-group">

        <label for="inputModelId" class="col-lg-2 control-label">{{ trans('message.model') }} Id</label>
        <div class="col-lg-10">
          {{ Form::text('model_id', isset($product->model_id) ? $product->model_id : old('model_id'), array('class' => 'form-control', 'id' => 'model_id','placeholder'=>trans('message.model')." Id"  )) }}

        </div>
      </div>
      <div class="form-group">

        <label for="inputLine" class="col-lg-2 control-label">{{ trans('message.line') }}</label>
        <div class="col-lg-10">
          {{ Form::text('line', isset($product->line) ? $product->line : old('line'), array('class' => 'form-control', 'id' => 'line','placeholder'=>trans('message.model')  )) }}

        </div>
      </div>

      <div class="form-group">

        <label for="inputTop" class="col-lg-2 control-label">{{ trans('message.top') }}</label>
        <div class="col-lg-10">
          {{ Form::text('top', isset($product->top) ? $product->top : old('top'), array('class' => 'form-control', 'id' => 'top','placeholder'=>trans('message.top')  )) }}

        </div>
      </div>

      <div class="form-group">
        <label for="inputManualsEN" class="col-lg-2 control-label">{{ trans('message.manual') }}</label>
        <div class="col-lg-10">
          {!! Form::file('manual_en', null) !!}
          @if(isset($manual_en->name))
          <a href="/downloads/manuals/{{$manual_en->name}}" target="_blank">{{$manual_en->name}}</a>
           &nbsp;
           <a href="/admin/product/deletemanual/{{$product->ext_id}}" title="{{ trans('message.delete')}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
          @endif
        </div>
      </div>


      <div class="form-group">

        <label for="inputSalesGuideEN" class="col-lg-2 control-label">{{ trans('message.sales_guide') }} EN</label>
        <div class="col-lg-10">
          {!! Form::file('sales_guide_en', null) !!}
           @if($product->sales_guide_en!=null && $product->sales_guide_en!="")
          <a href="/sales-guide/en/{{$product->sales_guide_en}}">{{$product->sales_guide_en}}</a>&nbsp;
           <a href="/admin/product/deletesgen/{{$product->ext_id}}" title="{{ trans('message.delete')}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label for="inputSalesGuideES" class="col-lg-2 control-label">{{ trans('message.sales_guide') }} ES</label>
        <div class="col-lg-10">
          {!! Form::file('sales_guide_es', null) !!}
           @if($product->sales_guide_es!=null && $product->sales_guide_es!="")
          <a href="/sales-guide/es/{{$product->sales_guide_es}}">{{$product->sales_guide_es}}</a>&nbsp;
          <a href="/admin/product/deletesges/{{$product->ext_id}}" title="{{ trans('message.delete')}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label for="front_image" class="col-lg-2 control-label">Images</label>

        <div class="col-md-5 col-xs-12">
          <label for="front_image" class="control-label">Front View&nbsp;(240x310px) .png</label>
          {!! Form::file('front_image', null) !!}
          <br/>

          <img src="/img/products/{{$product->line}}/{{$product->model_id}}/yezz-{{$product->model_id}}-front-view.png" onclick="openImageModal();" style="width:50%;margin-top:20px;cursor:zoom-in;" alt="{{$product->model}}" onerror="this.src='/img/page/misc/no-image-icon.png'">
        </div>

        <div class="col-md-5 col-xs-12">
          <label for="front_image" class="control-label">Banner&nbsp;(2560x1438px) .jpg</label>
          {!! Form::file('banner_image', null) !!}
          <br/>
          <img src="/img/products/{{$product->line}}/{{$product->model_id}}/yezz-andy-{{$product->model_id}}-hero-image.jpg" onclick="openImageModal();" style="width:50%;margin-top:20px;cursor:zoom-in;" alt="{{$product->model}}" onerror="this.src='/img/page/misc/no-image-icon.png'">
        </div>


      </div>


      @if($isEdit)
      <div class="form-group">
        <div class="col-md-4">
          <label class="control-label">Created by</label>
          <br/>
          <span style="font-size: 11px;">{{isset($product->created_by)? $product->created_by : '' }} - {{isset($product->created_at)? $product->created_at: ''  }}</span>
        </div>
        <div class="col-md-4">
          <label class="control-label">Updated by</label> 
          <br/>
          <span style="font-size: 11px;">{{isset($product->updated_by)? $product->updated_by : '' }} - {{isset($product->updated_at) ? $product->updated_at : ''}}</span>
        </div>
      </div>
      @endif


      <div class="form-group">
        <div class="col-lg-10 col-lg-offset-2">
          <button type="reset" class="btn btn-default">{{ trans('message.cancel') }}</button>
          <button type="submit" id="btnSave" class="btn btn-primary">{{ trans('message.save') }}</button>
        </div>
      </div>
    </fieldset>
    {!! Form::close() !!}

  </div>
  <div class="col-md-6 col-xs-12 ">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">{{ trans('message.countries') }}&nbsp;&nbsp;&nbsp;
          {!! Form::select('countries', $countries,  old('countries'), ['class' => 'form-control','id'=>'countries','multiple' => 'multiple']); !!} 
          @if($isEdit)
          <a class="btn btn-primary" onclick="addCountries();" style="color:#fff;"><i class="fa fa-plus fa-1g" aria-hidden="true" title="{{ trans('message.add')}}"></i>&nbsp;{{ trans('message.add')}}</a></h3>
          @else
          <button class="btn btn-primary  disabled" style="color:#fff;"><i class="fa fa-plus fa-1g" aria-hidden="true" title="{{ trans('message.add')}}"></i>&nbsp;{{ trans('message.add')}}</button></h3>
          @endif  
        </div>
        <div class="panel-body">
          <div class="container-fluid">
            @if($isEdit)
            <table id="gridCountries" class="display" cellspacing="0" width="100%"> 
              <tbody>
               @if($pcountries!=null)
               @foreach($pcountries as $con)
               <tr>
                <td>{{$con->name}}</td>
                <td>
                  @if($con->deleted)
                  <a href="/admin/productcountry/restore/{{$product->ext_id}}/{{$con->ext_id}}">
                   <i class="fa fa-history fa-1g" aria-hidden="true" title="{{ trans('message.restore')}}"></i>
                 </a>
                 @else
                 <a href="/admin/productcountry/delete/{{$product->ext_id}}/{{$con->ext_id}}">
                  <i class="fa fa-trash fa-1g" aria-hidden="true" title="{{ trans('message.delete')}}">
                  </i>
                </a>
                @endif   
              </td>
            </tr>
            @endforeach
            @endif
          </tbody> 
        </table>
        @endif 
      </div>
    </div>
  </div>     
</div>
</div>

<!-- Specifications-->
@if($isEdit)
<form id="specsFrm" class="form-horizontal">    
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">{{ trans('message.specifications') }}</h3>
    </div>
    <div class="panel-body">
      <div class="container-fluid">
       <div class="row">
         <div class="col-md-8">
           <label for="name" class="control-label">{{ trans('message.language') }}</label>
           {!! Form::select('languages', $languages, isset($language) && $language->id ? $language->id  : old('languages'), ['class' => 'form-control','id'=>'languages']); !!}         
         </div>
         <div class="col-md-4">

         </div>
       </div> 
       <div class="row">
        <div class="col-md-4">
          <label for="name" class="control-label">{{ trans('message.name') }}</label>
          {{ Form::text('name', isset($spec) ? $spec->name : old('name'), array('class' => 'form-control', 'id' => 'name','placeholder'=>trans('message.name')  )) }}
        </div>
        <div class="col-md-4">
         <label for="name" class="control-label">{{ trans('message.dimensions') }}</label>
         {{ Form::text('dimensions', isset($spec) ? $spec->dimensions : old('dimensions'), array('class' => 'form-control', 'id' => 'dimensions','placeholder'=>trans('message.dimensions')  )) }}  
       </div>
       <div class="col-md-4">
         <label for="name" class="control-label">{{ trans('message.weight') }}</label>
         {{ Form::text('weight', isset($spec) ? $spec->weight : old('weight'), array('class' => 'form-control', 'id' => 'weight','placeholder'=>trans('message.weight')  )) }}  
       </div>
     </div>
     <div class="row">
      <div class="col-md-4">
        <label for="name" class="control-label">{{ trans('message.chipset') }}</label>
        {{ Form::text('chipset', isset($spec) ? $spec->chipset : old('chipset'), array('class' => 'form-control', 'id' => 'chipset','placeholder'=>trans('message.chipset')  )) }}
      </div>
      <div class="col-md-4">
       <label for="name" class="control-label">{{ trans('message.cpu_cores') }}</label>
       {{ Form::text('cpu_cores', isset($spec) ? $spec->cpu_cores : old('cpu_cores'), array('class' => 'form-control', 'id' => 'cpu_cores','placeholder'=>trans('message.cpu_cores')  )) }}  
     </div>
     <div class="col-md-4">
       <label for="name" class="control-label">{{ trans('message.cpu') }}</label>
       {{ Form::text('cpu', isset($spec) ? $spec->cpu : old('cpu'), array('class' => 'form-control', 'id' => 'cpu','placeholder'=>trans('message.cpu')  )) }}  
     </div>
   </div>


   <div class="row">
    <div class="col-md-4">
     <label for="name" class="control-label">{{ trans('message.gpu') }}</label>
     {{ Form::text('gpu', isset($spec) ? $spec->gpu : old('gpu'), array('class' => 'form-control', 'id' => 'gpu','placeholder'=>trans('message.gpu')  )) }}  

   </div>
   <div class="col-md-4">
    <label for="simCard" class="control-label">{{ trans('message.simCard') }}</label>
    {{ Form::text('simCard', isset($spec) ? $spec->simCard : old('simCard'), array('class' => 'form-control', 'id' => 'simCard','placeholder'=>trans('message.simCard')  )) }}
  </div>
  <div class="col-md-4">
   <label for="gsmQty" class="control-label">{{ trans('message.simQty') }}</label>
   {{ Form::text('simQty', isset($spec) ? $spec->simQty : old('simQty'), array('class' => 'form-control', 'id' => 'simQty','placeholder'=>trans('message.simQty')  )) }}  
 </div>
</div>




<div class="row">
  <div class="col-md-4">
   <label for="hspa" class="control-label">{{ trans('message.gsm_bands') }}</label>
   {{ Form::text('gsm_bands', isset($spec) ? $spec->gsm_bands : old('gsm_bands'), array('class' => 'form-control', 'id' => 'gsm_bands','placeholder'=>trans('message.gsm_bands')  )) }} 
 </div>
 <div class="col-md-4">
   <label for="hspa" class="control-label">{{ trans('message.t3g_speed') }}</label>
   {{ Form::text('threeg_speed', isset($spec) ? $spec->threeg_speed : old('threeg_speed'), array('class' => 'form-control', 'id' => 'threeg_speed','placeholder'=>trans('message.t3g_speed')  )) }} 
 </div>
 <div class="col-md-4">
   <label for="hspa" class="control-label">{{ trans('message.t3g_bands') }}</label>
   {{ Form::text('threeg_bands', isset($spec) ? $spec->threeg_bands : old('threeg_bands'), array('class' => 'form-control', 'id' => 'threeg_bands','placeholder'=>trans('message.t3g_bands')  )) }} 
 </div>
</div>



<div class="row">
  <div class="col-md-4">
   <label for="hspa" class="control-label">{{ trans('message.t4g_speed') }}</label>
   {{ Form::text('fourg_speed', isset($spec) ? $spec->fourg_speed : old('fourg_speed'), array('class' => 'form-control', 'id' => 'fourg_speed','placeholder'=>trans('message.t4g_speed')  )) }} 
 </div>
 <div class="col-md-4">
   <label for="hspa" class="control-label">{{ trans('message.t4g_bands') }}</label>
   {{ Form::text('fourg_bands', isset($spec) ? $spec->fourg_bands : old('fourg_bands'), array('class' => 'form-control', 'id' => 'fourg_bands','placeholder'=>trans('message.t4g_bands')  )) }} 
 </div>
 <div class="col-md-4">
   <label for="hspa" class="control-label">{{ trans('message.operating_system') }}</label>
   {{ Form::text('operating_system', isset($spec) ? $spec->operating_system : old('operating_system'), array('class' => 'form-control', 'id' => 'operating_system','placeholder'=>trans('message.operating_system')  )) }} 
 </div>
</div>


<div class="row">
  <div class="col-md-4">
    <label for="displayType" class="control-label">{{ trans('message.displayType') }}</label>
    {{ Form::text('displayType', isset($spec) ? $spec->displayType : old('displayType'), array('class' => 'form-control', 'id' => 'displayType','placeholder'=>trans('message.displayType')  )) }}
  </div>
  <div class="col-md-4">
   <label for="displaySize" class="control-label">{{ trans('message.displaySize') }}</label>
   {{ Form::text('displaySize', isset($spec) ? $spec->displaySize : old('displaySize'), array('class' => 'form-control', 'id' => 'displaySize','placeholder'=>trans('message.displaySize')  )) }}  
 </div>
 <div class="col-md-4">
   <label for="resolution" class="control-label">{{ trans('message.resolution') }}</label>
   {{ Form::text('resolution', isset($spec) ? $spec->resolution : old('resolution'), array('class' => 'form-control', 'id' => 'resolution','placeholder'=>trans('message.resolution')  )) }}  
 </div>
</div>
<div class="row">
  <div class="col-md-4">
    <label for="rearCamera" class="control-label">{{ trans('message.rearCamera') }}</label>
    {{ Form::text('primary_camera', isset($spec) ? $spec->primary_camera : old('primary_camera'), array('class' => 'form-control', 'id' => 'primary_camera','placeholder'=>trans('message.rearCamera')  )) }}
  </div>
  <div class="col-md-4">
   <label for="frontCamera" class="control-label">{{ trans('message.frontCamera') }}</label>
   {{ Form::text('secundary_camera', isset($spec) ? $spec->secundary_camera : old('secundary_camera'), array('class' => 'form-control', 'id' => 'secundary_camera','placeholder'=>trans('message.frontCamera')  )) }}  
 </div>
 <div class="col-md-4">
   <label for="rearCameraFeatures" class="control-label">{{ trans('message.rearCameraFeatures') }}</label>
   {{ Form::text('primary_camera_features', isset($spec) ? $spec->primary_camera_features : old('primary_camera_features'), array('class' => 'form-control', 'id' => 'primary_camera_features','placeholder'=>trans('message.rearCameraFeatures')  )) }}  
 </div>
</div>
<div class="row">
  <div class="col-md-4">
    <label for="videoRecording" class="control-label">{{ trans('message.videoRecording') }}</label>
    {{ Form::text('videoRecording', isset($spec) ? $spec->videoRecording : old('videoRecording'), array('class' => 'form-control', 'id' => 'videoRecording','placeholder'=>trans('message.videoRecording')  )) }}
  </div>
  <div class="col-md-4">
   <label for="multitouch" class="control-label">{{ trans('message.multitouch') }}</label>
   {{ Form::text('multitouch', isset($spec) ? $spec->multitouch : old('multitouch'), array('class' => 'form-control', 'id' => 'multitouch','placeholder'=>trans('message.multitouch')  )) }}  
 </div>
 <div class="col-md-4">
   <label for="microSDCS" class="control-label">{{ trans('message.microSDCS') }}</label>
   {{ Form::text('microSDCS', isset($spec) ? $spec->microSDCS : old('microSDCS'), array('class' => 'form-control', 'id' => 'microSDCS','placeholder'=>trans('message.microSDCS')  )) }}  
 </div>
</div>
<div class="row">
  <div class="col-md-4">
    <label for="internalMemory" class="control-label">{{ trans('message.internalMemory') }}</label>
    {{ Form::text('internalMemory', isset($spec) ? $spec->internalMemory : old('internalMemory'), array('class' => 'form-control', 'id' => 'internalMemory','placeholder'=>trans('message.internalMemory')  )) }}
  </div>
  <div class="col-md-4">
   <label for="ram" class="control-label">{{ trans('message.ram') }}</label>
   {{ Form::text('ram', isset($spec) ? $spec->ram : old('ram'), array('class' => 'form-control', 'id' => 'ram','placeholder'=>trans('message.ram')  )) }}  
 </div>
 <div class="col-md-4">
   <label for="wlan" class="control-label">{{ trans('message.wlan') }}</label>
   {{ Form::text('wlan', isset($spec) ? $spec->wlan : old('wlan'), array('class' => 'form-control', 'id' => 'wlan','placeholder'=>trans('message.wlan')  )) }}  
 </div>
</div>
<div class="row">
  <div class="col-md-4">
    <label for="bluetooth" class="control-label">{{ trans('message.bluetooth') }}</label>
    {{ Form::text('bluetooth', isset($spec) ? $spec->bluetooth : old('bluetooth'), array('class' => 'form-control', 'id' => 'bluetooth','placeholder'=>trans('message.bluetooth')  )) }}
  </div>
  <div class="col-md-4">
   <label for="gps" class="control-label">{{ trans('message.gps') }}</label>
   {{ Form::text('gps', isset($spec) ? $spec->gps : old('gps'), array('class' => 'form-control', 'id' => 'gps','placeholder'=>trans('message.gps')  )) }}  
 </div>
 <div class="col-md-4">
   <label for="usb" class="control-label">{{ trans('message.usb') }}</label>
   {{ Form::text('usb', isset($spec) ? $spec->usb : old('usb'), array('class' => 'form-control', 'id' => 'usb','placeholder'=>trans('message.usb')  )) }}  
 </div>
</div>
<div class="row">
  <div class="col-md-4">
    <label for="batteryType" class="control-label">{{ trans('message.batteryType') }}</label>
    {{ Form::text('batteryType', isset($spec) ? $spec->batteryType : old('batteryType'), array('class' => 'form-control', 'id' => 'batteryType','placeholder'=>trans('message.batteryType')  )) }}
  </div>
  <div class="col-md-4">
   <label for="batteryRemovable" class="control-label">{{ trans('message.batteryRemovable') }}</label>
   {{ Form::text('batteryRemovable', isset($spec) ? $spec->batteryRemovable : old('batteryRemovable'), array('class' => 'form-control', 'id' => 'batteryRemovable','placeholder'=>trans('message.batteryRemovable')  )) }}  
 </div>
 <div class="col-md-4">
   <label for="batteryCapacity" class="control-label">{{ trans('message.batteryCapacity') }}</label>
   {{ Form::text('batteryCapacity', isset($spec) ? $spec->batteryCapacity : old('batteryCapacity'), array('class' => 'form-control', 'id' => 'batteryCapacity','placeholder'=>trans('message.batteryCapacity')  )) }}  
 </div>
</div>
@if($isEdit)
<div class="row">
  <div class="col-md-4">
    <label class="control-label">Created by</label>
    <br/>
    <span>{{isset($spec->created_by)? $spec->created_by : '' }} - {{isset($spec->created_at)? $spec->created_at: ''  }}</span>
  </div>
  <div class="col-md-4">
    <label class="control-label">Updated by</label> 
    <br/>
    <span>{{isset($spec->updated_by)? $spec->updated_by : '' }} - {{isset($spec->updated_at) ? $spec->updated_at : ''}}</span>
  </div>
</div>
@endif

<div class="row">
  <div class="col-md-4">

  </div>
  <div class="col-md-4">
    <div style="margin-top:15px;">
      <a    id="spcRemove" class="btn btn-warning" onclick="removeSpec({{$product}})">{{ trans('message.remove') }}</a>
      <button type="reset" class="btn btn-default">{{ trans('message.cancel') }}</button>
      <a id="spcSave" class="btn btn-primary">{{ trans('message.save') }}</a>
    </div>
  </div>
  <div class="col-md-4">



  </div>
</div>




</div>
</div>

</div>

</form>
@endif

<!-- end specifications-->

<!-- Highlights-->

@if($isEdit)
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">{{ trans('message.highlights') }}</h3>
  </div>
  <div class="panel-body">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <table id="gridHighlights" class="display" cellspacing="0" width="100%"> 
            <thead> 
              <tr> 
                <th>{{ trans('message.language') }}</th> 
                <th>{{ trans('message.content') }}</th> 
                <th></th> 
              </tr>
            </thead> 
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endif

<!-- end Highlights-->

@include('product.editHighlight') 

<div class="modal fade" id="msgModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="msgModal-title"></h4>
      </div>
      <div class="modal-body">
        <h4 id="msgModal-message"></h4><strong id="msgModal-entity"></strong>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('message.cancel') }}</button>
        <button type="button" id="msgYes" class="btn btn-primary">{{ trans('message.yes') }}</button>
      </div>
    </div>
  </div>
</div>


<script>

  var $_token = "{{ csrf_token() }}";
  var entity = null;  
  var hlEntity = null;  
  var spEntity = null;  
  var spAction = "";
  var action = null;
  var url    = null; 
  var redirectTo = null;
  var gridHl = null;
  var dataSet = null;
  var product = "{{$product->ext_id}}"; 
  /**
   *
   * Funcion para agregar un pais al producto, usado en el control multiselect
   *
   */
  function addCountries() {

    var countries = $('#countries').val();

    if(countries!=null) {
      url ="/admin/productcountry/add/"+product;
      var obj = {countries : countries};
      $.ajax({
        type: 'POST', 
        url: url,
        headers: {"X-CSRF-Token": $_token },
        data : obj,
        success: function(result) {
          if(result.code!=500 || result.code!=400) {
            window.location.reload();
          }
        }
      });
    }
  }

  /*=========================================================================
  =            Funciones para edicion y eliminacion de highlight            =
  =========================================================================*/
  
  function editHighlight(id) {
    
    hlAction = "edit";
    var _id = '#btn'+id;
    var text     = $(_id).data('text');
    var langCode = $(_id).data('lang');
    var product = "{{$product->ext_id}}";

  
    hlEntity = { ext_id   : id,
    text     : text,
    langCode : langCode}; 

    setFrmHighlight(hlEntity);
    $('#mdlHighlight').modal('show'); 
  }

  function deleteHighlight(ext_id) {

    action   = "deleteHighlight";
    entity   = {ext_id: ext_id};
    url      = "/highlights/"+ext_id+"/delete";

    var _id  = '#btn'+ext_id;
    var text = $(_id).data('text');
    var message = " "+ <?php echo '\''.trans('message.delete_this').'\''  ?> + " ";

    $('#msgModal-message').text(message);
    $('#msgModal-entity').text(text);
    $('#msgModal').modal('show');  
  }
 
  /*=====  End of Funciones para edicion y eliminacion de highlight  ======*/
  
  function removeSpec(entity) {

    action = "remove";
    url    = "/specifications/"+spEntity+"/remove";

    var message = " "+ <?php echo '\''.trans('message.remove_this').'\''  ?> + "";

    $('#msgModal-message').text(message);
    $('#msgModal').modal('show');  
  }

$(document).ready(function() {

  $('head').append( $('<link rel="stylesheet" type="text/css" />').attr('href', '/yezz-bower/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') );

  /*var entity = null;  
  var hlEntity = null;  
  var spEntity = null;  
  var spAction = "";
  var $_token = "{{ csrf_token() }}";
  var action = null;
  var url    = null; 
  var redirectTo = null;
  var gridHl = null;
  var dataSet = null;
  var product = "{{$product->ext_id}}"; */

  $.getScript('/yezz-bower/bootstrap-multiselect/dist/js/bootstrap-multiselect.js', function() {
    $('#countries').multiselect();
  });

  function loadHighlights(dataSet) {

    var lang = {
        search : " "+ <?php echo '\''.trans('message.search').'\''  ?> + " ",
        zeroRecords:    " "+ <?php echo '\''.trans('message.zeroRecords').'\''  ?> + " ",
        paginate: {
          first:      " "+ <?php echo '\''.trans('message.first').'\''  ?> + " ",
          previous:   " "+ <?php echo '\''.trans('message.previous').'\''  ?> + " ",
          next:       " "+ <?php echo '\''.trans('message.next').'\''  ?> + " ",
          last:       " "+ <?php echo '\''.trans('message.last').'\''  ?> + " "
        }
      };

    addToolbar(dataSet);

    var gridHl = $('#gridHighlights').dataTable({
      responsive: true,
      dom: 'Bfrtip',
      buttons: [
      {
        text: '<i class="fa fa-plus-circle fa-lg" title="<?php echo trans('message.new')  ?>"></i> ',
        action: function ( e, dt, node, config ) {
          hlAction = "create";
          resetForm('highlightFrm');
          $('#mdlbtnRemove').hide();
          $('#mdlHighlight').modal('show'); 
        }
      },
      {
        extend: 'excel',
        text: '<i class="fa fa-file-excel-o fa-lg" title="<?php echo trans('message.exporttoExcel')  ?>"></i> ',
        exportOptions: {
          modifier: {
            page: 'current'
          }
        }
      }],
      language : lang,
      data: dataSet,
      columns: [
        { data: "langName" },
        { data: "text" },
        { data: "toolbar" }
      ]

    });
  }

  function addToolbar(data) {
    
    var dataSet = data;
    
    $.each(dataSet, function(index, obj) {
      dataSet[index].toolbar = buildToolbar(obj);
    }); 
  }

  function buildToolbar(obj) {

    var toolbar = '<div class="btn-toolbar"><div class="btn-group">'+
      '<a id="btn'+obj.ext_id+'" onclick="editHighlight(&quot;'+obj.ext_id+'&quot;)" data-text="'+obj.text+'" data-lang="'+obj.langCode+'"  data-toggle="editHighlight" data-target="editModal">'+
      '<i class="fa fa-edit" aria-hidden="true" title="{{ trans('message.edit')}}"></i>'+
      '</a>'+
      '</div>'+
      '<div class="btn-group"><a onclick="restoreHighlights(&quot;'+obj.ext_id+'&quot;)">';

    toolbar+= (obj.deleted == 1) ?  '<i class="fa fa-history fa-1g" aria-hidden="true" title="{{ trans('message.restore')}}"></i></a>'
      :
      '<a onclick="deleteHighlight(&quot;'+obj.ext_id+'&quot;)" data-text="'+obj.text+'"><i class="fa fa-trash fa-1g" aria-hidden="true" title="{{ trans('message.delete')}}"></i></a>';

    toolbar+='</div></div>';

    return toolbar;
  }

  function getHighlights() {

    $.ajax({
      type: 'GET', 
      url: '/highlights?product='+"{{$product->ext_id}}",
      headers: {"X-CSRF-Token": $_token },
      async: false,
      success: function(result) {
        loadHighlights(result);
      }
    }); 
  }

  function restoreHighlights(ext_id) {   
  
    $.ajax({
      type: 'POST', 
      url: "/highlights/"+ext_id+"/restore",
      headers: {"X-CSRF-Token": $_token },
      success: function(result) {
        window.location.reload();
      }
   });
  }

  function resetForm(id){
    document.getElementById(id).reset();
  }


  $( "#btnSave" ).click(function() {   
 
    var actionType = null;
    var data = getFormValue();

    switch(action) {
      case "edit":
        actionType = "PUT";
        url = entity.ext_id+"/update";
        break;
      case "create":
        actionType = "POST";
        url = "/admin/products/store"
        break;
    }

    $.ajax({
      type: actionType, 
      url: url,
      headers: {"X-CSRF-Token": $_token },
      data : data,
      success: function(result) {
        if(result.code!=500) {
          window.location.reload();
        }
      }
    });
  });


  $("#msgYes").click(function() {   
  
    $.ajax({
      type: 'POST', 
      url: url,
      headers: {"X-CSRF-Token": $_token },
      success: function(result) {
        window.location.reload();
      }
    });
  });

  $( "#spcSave" ).click(function() {   
    
    var _data = getFormValues('specsFrm');

    switch(spAction) {
      case "edit" :
        actionType = "PUT";
        url = "/specifications/"+spEntity+"/update";
        break;
      case "create":
        actionType = "POST";
        url = "/specifications/store"
      break;
    }

    $.ajax({
      type: actionType, 
      url: url,
      data : _data,
      headers: {"X-CSRF-Token": $_token },
      success: function(result) {
        if(result.code==200 ) {
          spEntity = result.ext_id;
          spAction = 'edit';
          console.log('guardado de especificaciones')
          swal(
            'Saved!',
            '',
            'success'
          )
        }
      }
    });     
  });

  $("#languages").change(function () {

    $( "#languages option:selected" ).each(function() {
      
      var langCode = $( this ).val();
      resetForm('specsFrm');
      spAction = "edit";
      $.ajax({
        type: 'GET', 
        url: '/specifications/edit?language='+langCode+'&product='+product,
        headers: {"X-CSRF-Token": $_token },
        success: function(result) {

          if (result!=null) {
            if(result.code==200) {
              spEntity = result.specs.ext_id;
              populate("specsFrm",result.specs);
            } else {
              spAction = "create";
            }
          }
          $('#languages').val(langCode);
        }
      });   
    });
  }).change();


  function populate(frm, data) {   
  
    $.each(data, function(key, value) { 
      var _id = '#'+key;
      if(key=="multitouch" || key=="batteryRemovable") {
        if (value==1) {
          value = " "+ <?php echo '\''.trans('message.yes').'\''  ?> + "";
        } else {
          value = " "+ <?php echo '\''.trans('message.no').'\''  ?> + "";
        }
      }

      $(_id).val(value);
    });  
  }


  function getFormValues(form){
 
    var obj = {};
    var ctrl = document.getElementById(form);

    $.each(ctrl, function(item) { 
      var _id   = $(this).attr('id');
      var value = $(this).val();
      
      if(_id!=null) {
        if(_id=="multitouch" || _id=="batteryRemovable") {
          if (value.toLowerCase() =='yes') {
            value = "1";
          } else {
            value = "0";
          }
        }
        obj[_id] = value;
      }
    }); 
    
    if(obj!=null) obj['product'] = product;
    
    return obj;
  }


  getHighlights();

});
  
</script>
@endsection
