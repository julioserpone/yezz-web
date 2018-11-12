@extends('public.layouts.sec')

@section('htmlheader_title')
Contact
@endsection

<?php $visible=1; ?>

@section('main-content')
<div class="content container">
	<br/>
	<br/>
	<br/>
	<br/>



 <div class="row">
  <div class="col-md-12">
    <h1>
      @if($section=='technical-support')
      {{ trans('message.technical-support') }}   
      @endif
      @if($section=='retail-sale')
      {{ trans('message.retail-sale') }} 
      @endif
      @if($section=='wholesale')
      {{ trans('message.wholesale') }} 
      <?php $visible=0; ?>
      @endif
      @if($section=='additional-support')
      {{ trans('message.additional-support') }} 
      <?php $visible=0; ?>
      @endif
      /
      @if($form=='product-information')
      {{ trans('message.product-information') }}
      @endif
      @if($form=='setup')
      {{ trans('message.setup') }}
      @endif
      @if($form=='repair')
      {{ trans('message.repair') }}
      @endif
      @if($form=='product-availability')
      {{ trans('message.product-availability') }}
      @endif
      @if($form=='spare-parts-and-accesories')
      {{ trans('message.spare-parts-and-accesories') }}
      @endif
      @if($form=='after-sales-service')
      {{ trans('message.after-sales-service') }}
      @endif
      @if($form=='product-distribution')
      {{ trans('message.product-distribution') }}
      @endif
      @if($form=='advertising')
      {{ trans('message.advertising') }}
      @endif
      @if($form=='public-relations')
      {{ trans('message.public-relations') }}
      @endif
    </h1>
  </div>
</div>

<form id="contactForm">

  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <span style="font-size:14px;">{{ trans('message.complete_the_following') }}</span>
    </div>
    <div class="col-md-2"></div>
  </div>
  <br/>
  <br/>
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
          <div class="form-group">
           <input type="text" class="form-control" id="name" placeholder="{{ trans('message.name') }}" data-label="{{trans('message.name')}}">
         </div>
       </div>
       <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
          <input type="text" class="form-control" id="email" placeholder="{{ trans('message.email') }}" data-label="{{ trans('message.email') }}">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 col-sm-12 col-xs-12">
       <div class="form-group">
         <input type="text" class="form-control" id="city" placeholder="{{ trans('message.city') }}" data-label="{{ trans('message.city') }}">
       </div>
     </div>
     <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="form-group">

        <select class="form-control bfh-countries" data-country="US" data-flags="true" id="country"></select>
      </div>
    </div>
  </div>
  <?php if($visible==1) :?>
    <div class="row">
     <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="form-group">
        {!! Form::select('productList', $productList,  old('productList'), ['class' => 'form-control','id'=>'productList']); !!}         
      </div>
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
     <div class="form-group">
       <input type="text" class="form-control" id="imei" placeholder="{{ trans('message.imei') }}" data-label="IMEI">
     </div>
   </div>
 </div>
<?php endif ?>
<div class="row">
 <div class="col-md-12 col-sm-12 col-xs-12">
  <div class="form-group">
    <textarea class="form-control" id="comment" style="height:200px;" data-label="{{ trans('message.comment') }}"></textarea>      
  </div>
</div>
</div>
<div class="row">
 <div class="col-md-12 col-sm-12 col-xs-12 text-center">
  <div class="form-group">
    <a class="btn btn-primary btn-lg" id="send">{{ trans('message.send') }}</a>
  </div>
 </div>
</div>

</div>
</div>
<div class="col-md-2"></div>
</div>

</form>
<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-8"><a href="/contact/{{$lang_country}}" class="btn btn-primary"><i class="fa fa-angle-left" aria-hidden="true"></i>
 {{trans('message.back')}}</a></div>
  <div class="col-md-2"></div>
</div>
<br/>
<br/>
<br/>
</div>

<!-- Countries Modal -->
@include('public.layouts.partials.countries') 
<!-- END Countries Modal -->

<script type="text/javascript">
 var emailFormat = true;
 var $_token = "{{ csrf_token() }}";

 $(document).ready(function(){
  menuHandle('contact');


  $('head').append( $('<link rel="stylesheet" type="text/css" />').attr('href', '/yezz-bower/bootstrap-formhelpers/dist/css/bootstrap-formhelpers.css') );
  $('head').append( $('<script type="text/javascript" />').attr('src','/yezz-bower/bootstrap-formhelpers/dist/js/bootstrap-formhelpers.js'));

});


 $("#send").click(function() 
 {   
  var fields = getFormValues('contactForm');
  if (fields!=null)
  {
    $.ajax({
      type: 'POST', 
      url: '/contact/mail',
      data: fields,
      headers: {"X-CSRF-Token": $_token },
      success: function(result) {
        if(result.code==200){
          clearForm();
          swal("{{trans('message.thanks_for_contacting_us')}}", "{{trans('message.your_inquiry')}}", "success");
        }
      }
    });     
  }
});


 function getFormValues(form){
   var obj = {};
   var msg = {};
   var error = "";
   var ctrl = document.getElementById(form);
   $.each(ctrl, function(item){ 
    var _id   = $(this).attr('id');
    var value = $(this).val();
    if(_id!=null){
      if(value=="" || value==null)
      {
       error+= '\n'+$('#'+_id).data('label');


     }else{
      obj[_id] = value;

      if(_id=='country')
      {
        obj[_id]=$("#country option:selected").text();
      } 
    }


  }

  if(error!="")
  {
   obj = null; 
   swal({
    title: "Are you sure?",
    text: "{{trans('message.following_fields')}}"+error,
    type: "warning",
    confirmButtonClass: "btn-danger",
    confirmButtonText: "OK",
    closeOnConfirm: false,
    closeOnCancel: false
  }); 
 }else{
  obj['section'] = "{{$section}}";
  obj['form'] = "{{$form}}";
}


}); 

   return obj;
 }


 function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}


$('#email').focusout(function(){
 if(validateEmail(this.value))
 {
  emailFormat = true;
}else{
  emailFormat = false;
  $(this).css("color", "red");

}

});

$('#email').focus(function(){
  $("#email").css("color", "#909090");
});


function clearForm(){

  var ctrl = document.getElementById('contactForm');
  $.each(ctrl, function(item){ 
    if($(this).attr('type')=="text")
    {
      $(this).val("");
    }

  });
}

</script>
@endsection