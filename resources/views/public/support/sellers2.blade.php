<?php 
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
 <div class="container-fluid">

   <div class="row">
      <img src="/img/page/misc/sellers.jpg" class="img-responsive" data-bgrepeat="no-repeat">
    </div>

  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 col-sm-12 col-xs-12">
      <h2>{{ trans('message.sellers') }}</h2>
    </div>
    <div class="col-md-2"></div>
  </div>
  

  <div class="row">
    <label class="col-md-4 text-right" style="vertical-align: middle;">
      {{ trans('message.select_acountry') }}
    </label>
    <div class="col-md-4 col-sm-12 col-xs-12">

      <select class="form-control bfh-selectbox bfh-countries" data-flags="true" id="cbxCountry">
        @foreach($countries as $item)
        <option value="{{$item->code}}">{{$item->name}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <br/><br/>
  <div class="row">
 

    <div class="content">
      <style type="text/css">
        .cel_space{
          margin-top: 12px;
        }
        .custom_h3{
          color:#DD4632;
        }
      </style>
      <div class="content" id="countries_list"></div> 

    </div>



  </div>
  <div class="col-md-2"></div>
</div><br/><br/>


<div class="content">
  <style type="text/css">
    .cel_space{
      margin-top: 12px;
    }
    .custom_h3{
      color:#DD4632;
    }
  </style>
  <div class="content" id="seller_list"></div> 

</div>
<br/>
</div>
</div>


</div>

<!-- Countries Modal -->
@include('public.layouts.partials.countries') 
<!-- END Countries Modal -->
<script type="text/javascript">
 var $_token = "{{ csrf_token() }}";
 var current_country = "{{$current}}";
 var sellers  = {!! $sellers !!};

 $(document).ready(function(){


  $('select').on('change', function() {
    var code =  this.value; 

    $.ajax({
      type: 'GET', 
      url: "/sellers/"+code+"/list",
      headers: {"X-CSRF-Token": $_token },
      success: function(result) {
        if(result.code==200){
         showItems(result.data);
       }
     }
   });

  });

  if(current_country!=null){
    $('#cbxCountry').val(current_country);
  }


  if(sellers!=null)
  {
    showItems(sellers);
  }

});

 var spList = document.getElementById("seller_list");
 var row;
 var column = 1;
 var count = 0;
 var index = 0;
 var total;

 function showItems(data)
 {
  build(data); 
 }

function build(data)
{
  spList.innerHTML = "";
  column = 1;
  index  = 0;
  row    = document.createElement('div');
  total  = data.length;
  
  jQuery.each(data, function(i, val) 
  {
    
    index = i+1;
    writeInfo(val, column);
    column=column+1;
    
  });
}

function writeInfo(item,col)
{
  if(col==1)
  {
   writeEmpty(); 
   col=2;
   column = 2;
 }

 if(col>1 && col<6)
 {
  writeColumn(item);

}
if(col==6)
{
  spList.appendChild(row);
  row = document.createElement('div');
  writeEmpty();
  writeColumn(item);
  column=2;
}
if(total==index)
{
  spList.appendChild(row);
}

}

function writeColumn(item)
{
  var col = document.createElement('div');
  col.className = "col-md-2 col-sm-3 col-xs-12 cel_space";
  var h3 = document.createElement('h3');
  h3.className = "custom_h3";
  h3.innerHTML = item.name;
  col.appendChild(h3);

  if(item.phone1!=null && item.phone1!="")
  { 
   var line = document.createElement('span');
   line.innerHTML = "<br/>Phone: "+item.phone1;
   col.appendChild(line);
 }
 if(item.email1!=null && item.email1!="")
 { 
   var line = document.createElement('span');
   line.innerHTML = "<br/>Email: <a href='mailto:"+item.email1+"'>"+item.email1+"</a>";
   col.appendChild(line);
 }
 if(item.attention!=null && item.attention!="")
 { 
   var line = document.createElement('span');
   line.innerHTML = "<br/>{{trans('message.attention')}}: "+item.attention;
   col.appendChild(line);
 }

 row.appendChild(col);

}

function writeEmpty()
{
  row.className = "row";
  var col = document.createElement('div');
  col.className = "col-md-2 col-sm-3 col-xs-12 cel_space";
  col.innerHTML = "&nbsp;";
  row.appendChild(col);

  }


</script>


@endsection