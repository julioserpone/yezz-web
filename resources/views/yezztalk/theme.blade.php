<?php 
$langcountry = "";
if (isset($lang_country))
{
  $langcountry = $lang_country; 
} 

?>
@extends('layouts.app')

@section('htmlheader_title')
themes
@endsection


@section('main-content')

<div class="container spark-screen">


  <legend>{{ trans('message.theme') }}</legend>

  {!! Form::model($theme, ['route'=>['ytthemes.update',$theme->ext_id], 'files' => true, 'method'=>'PUT', 'role'=>'form', 'name' => 'themeFrm', 'id' => 'themeFrm','class' => 'form-horizontal']) !!}
  <div class="row">
    <div class="col-md-8">
      <label for="name" class="control-label">{{ trans('message.title') }}</label>
      {{ Form::text('title', isset($theme) ? $theme->title : old('title'), array('class' => 'form-control', 'id' => 'title','placeholder'=>trans('message.title')  )) }}      
    </div>
    <div class="col-md-4">

     <nav>
       <ul class="pager">
        <li role="presentation" style="padding:5px;margin-left:10px;">
         <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" title="{{ trans('message.likes')}}"></i>
         {{ $theme->likes}}
       </li>
       <li role="presentation" style="padding:5px;margin-left:10px;">
         <i class="fa fa-thumbs-o-down fa-lg" aria-hidden="true" title="{{ trans('message.unlikes')}}"></i>
         {{ $theme->dislikes}}
       </li>
       <li role="presentation" style="padding:5px;margin-left:10px;">
         <i class="fa fa-comment-o fa-lg" aria-hidden="true" title="{{ trans('message.comments')}}"></i>
         {{ $theme->comments}}
       </li>
     </ul>
   </nav>   
 </div>
</div><br/>
<div class="row">
  <div class="col-md-12">
    <label for="summary" class="control-label">{{ trans('message.summary') }}&nbsp;({{ trans('message.max_380_chars') }})
    &nbsp;Char counter:&nbsp;<div id="summaryCharCounter"></div>
    </label>
    {{ Form::textarea('summary', isset($theme) ? $theme->summary : old('summary'), array('class' => 'form-control jqte-test', 'id' => 'summary','placeholder'=>trans('message.summary') , 'maxlength'=> '380', 'onkeyup'=>'countChar(this);' )) }}      
  </div>
</div><br/>
<div class="row">
  <div class="col-md-12">
    <label for="content" class="control-label">{{ trans('message.content') }}</label>
    {{ Form::textarea('content', isset($theme) ? $theme->content : old('content'), array('class' => 'form-control jqte-test', 'id' => 'content','placeholder'=>trans('message.content')  )) }}      
  </div>
</div><br/>

<div class="row">
 <div class="col-md-4">
   <label for="highlight_one" class="control-label">{{ trans('message.highlights') }} 1</label>
   {{ Form::text('highlight_one', isset($theme->highlight_one) ? $theme->highlight_one : old('highlight_one'), array('class' => 'form-control', 'id' => 'highlight_one','placeholder'=>trans('message.highlights')  )) }}
 </div>
 <div class="col-md-4">
  <label for="highlight_two" class="control-label">{{ trans('message.highlights') }} 2</label>
  {{ Form::text('highlight_two', isset($theme->highlight_two) ? $theme->highlight_two : old('highlight_one'), array('class' => 'form-control', 'id' => 'highlight_two','placeholder'=>trans('message.highlights')  )) }}
</div>
<div class="col-md-4">
  <label for="highlight_three" class="control-label">{{ trans('message.highlights') }} 3</label>
  {{ Form::text('highlight_three', isset($theme->highlight_three) ? $theme->highlight_three : old('highlight_three'), array('class' => 'form-control', 'id' => 'highlight_three','placeholder'=>trans('message.highlights')  )) }}
</div>
</div>
<div class="row"> 
 <div class="col-md-4">
   <label for="highlight_one" class="control-label">{{ trans('message.status') }}</label>
   {!! Form::select('status', $statuses, $theme->status ? $theme->status  : old('status'), ['class' => 'form-control','id'=>'status']); !!} 
 </div>
 <div class="col-md-4">
  <label for="highlight_one" class="control-label">{{ trans('message.image') }}&nbsp;(800x600px)</label>
  {!! Form::file('image', null) !!}
</div>
<div class="col-md-4">
  <img src="/img/yezztalk/{{$theme->ext_id}}.jpg" onclick="openImageModal();" style="width:100%;margin-top:20px;cursor:zoom-in;" alt="{{$theme->title}}" onerror="this.src='/img/page/misc/no-image-icon.png'">
</div>
</div><br/>
<div class="row">
 <div class="col-md-4">

 </div>
 <div class="col-md-4 text-center">
  <button class="btn btn-primary" type="submit">{{ trans('message.save') }}</button>  
</div>
<div class="col-md-4">

</div>
</div>
{!! Form::close() !!}


<br/><br/>

<table id="datagrid" class="table table-striped table-bordered" role="grid">
  <thead>
    <tr>
     <th class="text-center">{{ trans('message.comments') }}</th>
     <th>{{ trans('message.banned') }}</th>
     <th></th>
   </tr>
 </thead>
 <tbody>

   @foreach ($comments as $com)
   <tr><td>
    <div class="row comment-container">

     <div class="col-md-2 avatar">

      <img src="../../img/avatar04.png"/>
      <dir class="text">
       <h4 class="username">{{ $com->username}}</h4>
       <span>{{ $com->name}}</span>

       <div class="starred">
         <i class="fa fa-star" aria-hidden="true"></i>
         <i class="fa fa-star" aria-hidden="true"></i>
         <i class="fa fa-star" aria-hidden="true"></i>
         <i class="fa fa-star-o" aria-hidden="true"></i>
         <i class="fa fa-star-o" aria-hidden="true"></i>
       </div>
     </dir>
   </div>
   <div class="col-md-10 comment">
    {{ $com->comment}}
    <div class="comment-info">
     <ul>
      <li>
       <i class="fa fa-thumbs-o-up" aria-hidden="true" title="{{ trans('message.likes')}}"></i>
       {{ $com->likes}}
     </li>
     <li>
       <i class="fa fa-thumbs-o-down" aria-hidden="true" title="{{ trans('message.unlikes')}}"></i>
       {{ $com->unlikes}}
     </li>
     <li>
       <i class="fa fa-comment-o" aria-hidden="true" title="{{ trans('message.comments')}}"></i>
       {{ $com->comments}}
     </li>
   </ul>
   <div class="comment-timestamp"><span class="comment-posted">Posted {{ $com->created_at->format('d-m-Y')}}</div>
 </div>
</div> 

</div>
</td>
<td>{{$com->banreason}}</td>
<td> 
 @if($com->banned==0)
 <a onclick="ban({{$com}})" style="color:red;"><i class="fa fa-ban fa-1g" aria-hidden="true" title="{{ trans('message.ban')}}"></i></a>	  
 @else
 <a onclick="unban({{$com}})"><i class="fa fa-history fa-1g" aria-hidden="true" title="{{ trans('message.restore')}}"></i></a>	  
 @endif    
</td>
</tr>
@endforeach
</tbody>
</table>

</div>

<!-- Dialog Modal-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="msgModal-title"></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-10 col-md-offset-1">


          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Dialog Modal-->
<div class="modal fade modal-lg" id="msgModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="msgModal-title"></h4>
      </div>
      <div class="modal-body">
        <h4 id="msgModal-message"></h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('message.cancel') }}</button>
        <button type="button" id="msgYes" class="btn btn-primary">{{ trans('message.yes') }}</button>
      </div>
    </div>
  </div>
</div>


<!-- Dialog Modal-->
<div class="modal fade" id="frmModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="msgModal-title"></h4>
      </div>
      <div class="modal-body">
        <h4 id="msgModal-message"></h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('message.cancel') }}</button>
        <button type="button" id="msgYes" class="btn btn-primary">{{ trans('message.yes') }}</button>
      </div>
    </div>
  </div>
</div>

<!-- Iamge Modal-->
<div class="modal fade" id="imgModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="msgModal-title"></h4>
      </div>
      <div class="modal-body">
       <img src="/img/yezztalk/{{$theme->ext_id}}.jpg" style="width:100%;" alt="{{$theme->title}}">
     </div>
     <div class="modal-footer">
      <button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('message.close') }}</button>
    </div>
  </div>
</div>
</div>

<!-- Dialog Modal-->
<div class="modal fade" id="frmBan" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="msgModal-title"></h4>
      </div>
      <div class="modal-body">
        <h4 id="msgModal-message"></h4>
        <label for="name" class="control-label">{{ trans('message.select_motive') }}</label>
        {!! Form::select('reason', $reasons,  $theme->reason != null ? $theme->reason : old('reason'), ['class' => 'form-control','id'=>'reason']); !!}  		
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('message.cancel') }}</button>
        <button type="button" id="banOkButton" class="btn btn-primary">{{ trans('message.ok') }}</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
 $('head').append( $('<link rel="stylesheet" type="text/css" />').attr('href', '/yezz-bower/jqueryte/dist/jquery-te-1.4.0.css') );
 $('head').append( $('<script type="text/javascript" />').attr('src','/yezz-bower/jqueryte/dist/jquery-te-1.4.0.min.js'));

 var entity  = null;  
 var $_token = "{{ csrf_token() }}";
 var action  = null;
 var url    = null; 
 var redirectTo = null;
 var comment_ext_id = null;

 var lang = {search : " "+ <?php echo '\''.trans('message.search').'\''  ?> + " ",
 zeroRecords:    " "+ <?php echo '\''.trans('message.zeroRecords').'\''  ?> + " ",
 paginate: {
  first:      " "+ <?php echo '\''.trans('message.first').'\''  ?> + " ",
  previous:   " "+ <?php echo '\''.trans('message.previous').'\''  ?> + " ",
  next:       " "+ <?php echo '\''.trans('message.next').'\''  ?> + " ",
  last:       " "+ <?php echo '\''.trans('message.last').'\''  ?> + " "
}
};

var datagrid = $('#datagrid').dataTable({
 responsive: true,
 language : lang    

});

$(window).load(function() {

});


$( "#btnNew" ).click(function() 
  {   {{ $isEdit= false }}
  $('#editModal').modal('show');  
});

$( "#btnEdit" ).click(function() 
  {   {{ $isEdit= true }}
});

function showDeleteModal(data){
	action = "delete";
	entity = data.ext_id;
	url    = entity+"/delete";
	var message = " "+ <?php echo '\''.trans('message.delete_this').'\''  ?> + " "+data.name;
  $('#msgModal-message').text(message);
  $('#msgModal-entity').text(data.name);
  $('#msgModal').modal('show');  
}

$( "#msgYes" ).click(function() 
{   


  $.ajax({
    type: 'POST', 
    url: url,
    headers: {"X-CSRF-Token": $_token },
    success: function(result) {
     window.location.href ="/ytthemes/view";
   }
 });     



});

function restoretheme(data)
{   
  $.ajax({
    type: 'POST', 
    url: "/ytthemes/"+data.ext_id+"/restore",
    headers: {"X-CSRF-Token": $_token },
    success: function(result) {
     window.location.href ="/ytthemes/view";
   }

 });
}


$( "#btnRemove" ).click(function(){ 
	action = "remove";
	entity = "{{ $theme->ext_id }}";
	url    = "remove";

	var name   = "{{ $theme->name }}";
	var message = " "+ <?php echo '\''.trans('message.remove_this').'\''  ?> + " "+name;
  $('#msgModal-message').text(message);
  $('#msgModal').modal('show');  
})


$(document).ready(function(){

  var openForm = "{{ $openForm }}";

  if (openForm){
    $('#editModal').modal('show');
  }
  

});
$("#summary").jqte();
$("#content").jqte();

function ban(data)
{
  comment_ext_id = data.ext_id;
  $('#frmBan').modal('toggle');
}

$( "#banOkButton" ).click(function(){ 
  
   var reason_id = $('#reason').val();
   $.ajax({
    type: 'POST', 
    url: "/ytthemes/comment/"+comment_ext_id+"/delete",
    headers: {"X-CSRF-Token": $_token },
    data : {reason : reason_id , parent : "{{ $theme->ext_id }}" },
    success: function(result) {
         if(result.code == 200){
        location.reload();
     }
    }

  
  });
 });  

function unban(data)
{
   $.ajax({
    type: 'POST', 
    url: "/ytthemes/comment/"+data.ext_id+"/restore",
    headers: {"X-CSRF-Token": $_token },
    success: function(result) {
          if(result.code == 200){
        location.reload();
     }
    }
  });
}


function countChar(val) 
{
        var len = val.value.length;
        if (len >= 380) {
          val.value = val.value.substring(0, 380);
        } else {
          $('#summaryCharCounter').text(380 - len);
        }
      };

function openImageModal()
{
  $('#imgModal').modal('toggle');
}

</script>
@endsection
