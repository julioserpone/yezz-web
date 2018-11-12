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
		
   
        <legend>{{ trans('message.themes') }}</legend>
 
        <div class="row">
            
        	 <table id="datagrid" class="table table-striped table-bordered" role="grid">
				        <thead>
				            <tr>
				                <th class="text-center">{{ trans('message.category') }}</th>
				                <th class="text-center">{{ trans('message.title') }}</th>
				                <th class="text-center">{{ trans('message.status') }}</th>
				                <th class="text-center">{{ trans('message.comments') }}</th>
				                <th class="text-center">{{ trans('message.likes') }}</th>
				                <th class="text-center">{{ trans('message.unlikes') }}</th>
				                <th class="text-center">{{ trans('message.createdBy') }}</th>
				                <th class="text-center">{{ trans('message.updatedBy') }}</th>
				                <th class="text-center">{{ trans('message.deleted') }}</th>
				                <th></th>
				            </tr>
				        </thead>
				        
				        <tbody>
				        	@foreach ($themes as $reg)
					            <tr>
					                <td class="text-left">{{ $reg->catName }}</td>
					                <td class="text-left">{{ $reg->title }}</td>
					                <td class="text-left">{{ $reg->statusName }}</td>
					                <td class="text-left">{{ $reg->comments }}</td>
					                <td class="text-left">{{ $reg->likes }}</td>
					                <td class="text-left">{{ $reg->unlikes }}</td>
					                <td class="text-left">{{ $reg->createdBy }}</td>
					                <td class="text-left">{{ $reg->updatedBy }}</td>
					                <td class="text-center">{{ ($reg->deleted == 1) ? trans('message.yes') : trans('message.no') }}</td>
					                 <td class="text-center">
					                   <div class="btn-toolbar">
					                	 <div class="btn-group">
										    <a id="btnEdit" href="{{ route('ytthemes.edit', $reg->ext_id) }}" data-toggle="editModal" data-target="editModal"><i class="fa fa-edit" aria-hidden="true" title="{{ trans('message.edit')}}"></i></a>
										 </div>
                                            @if($reg->deleted == 1)
										     <div class="btn-group">
										    	<a onclick="restoreTheme({{$reg}})"><i class="fa fa-history fa-1g" aria-hidden="true" title="{{ trans('message.restore')}}"></i></a>
										    </div>
										    @else
											<div class="btn-group">
										    	<a onclick="showDeleteModal({{$reg}})"><i class="fa fa-trash fa-1g" aria-hidden="true" title="{{ trans('message.delete')}}"></i></a>
										 	</div>    
										    @endif
										 </div>
					                </td>
					            </tr>
				            @endforeach
				        </tbody>
				    </table>

		</div>

	</div>

<!-- Dialog Modal-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="msgModal-title"></h4>
      </div>
      <div class="modal-body">
			   <div class="row">
						<div class="col-md-10 col-md-offset-1">
						 	    
			   		       @if($isEdit)
						   		  {!! Form::model($theme, ['route'=>['ytthemes.update',$theme->ext_id], 'method'=>'PUT', 'role'=>'form', 'name' => 'themeFrm', 'id' => 'themeFrm','class' => 'form-horizontal']) !!}
			   				@else      
			   				      {!! Form::model(Request::all(),['route'=>['ytthemes.store'],'files' => true, 'method'=>'POST', 'name'=>'themeFrm', 'id'=> 'themeFrm', 'role'=>'form','class' => 'form-horizontal']) !!}
			   				@endif
								<!--<form class="form-horizontal"> -->
 									  <fieldset>
									    <legend>{{ trans('message.theme') }}</legend>
									    <div class="form-group">
									       {!! csrf_field() !!}
									      <label for="inputEmail" class="col-lg-2 control-label">{{ trans('message.category') }}</label>
									      <div class="col-lg-10">
											{!! Form::select('categories', $categories,  $theme->catCode != null ? $theme->catCode : old('categories'), ['class' => 'form-control','id'=>'categories']); !!}  			                                
									      </div>
									    </div>
									    <div class="form-group">
									      <label for="inputEmail" class="col-lg-2 control-label">{{ trans('message.status') }}</label>
									      <div class="col-lg-10">
											{!! Form::select('statuses', $statuses, $theme->status ? $theme->status  : old('statuses'), ['class' => 'form-control','id'=>'statuses']); !!}  			                                
									      </div>
									    </div>
								        <div class="form-group">
									      <label for="inputPassword" class="col-lg-2 control-label">{{ trans('message.title') }}</label>
									      <div class="col-lg-10">
			                                {{ Form::text('title', isset($theme->title) ? $theme->title : old('title'), array('class' => 'form-control', 'id' => 'title','placeholder'=>trans('message.title')  )) }}
									      </div>
									    </div>
									    <div class="form-group">
									      <label for="inputSummary" class="col-lg-2 control-label">{{ trans('message.summary') }}&nbsp;({{ trans('message.max_380_chars') }})</label>
									      <div class="col-lg-10">
			                                {{ Form::textarea('summary', isset($theme->summary) ? $theme->summary : old('summary'), array('class' => 'form-control jqte-test"', 'id' => 'summary','placeholder'=>trans('message.summary')  )) }}
									      </div>
									    </div>
									    <div class="form-group">
									      <label for="inputPassword" class="col-lg-2 control-label">{{ trans('message.content') }}</label>
									      <div class="col-lg-10">
			                                {{ Form::textarea('content', isset($theme->content) ? $theme->content : old('content'), array('class' => 'form-control jqte-test"', 'id' => 'content','placeholder'=>trans('message.content')  )) }}
									      </div>
									    </div>
									    <div class="form-group">
									      <label for="inputPassword" class="col-lg-2 control-label">{{ trans('message.highlights') }} 1</label>
									      <div class="col-lg-10">
			                                {{ Form::text('highlight_one', isset($theme->highlight_one) ? $theme->highlight_one : old('highlight_one'), array('class' => 'form-control', 'id' => 'highlight_one','placeholder'=>trans('message.highlights')  )) }}
									      </div>
									    </div>
									     <div class="form-group">
									      <label for="inputPassword" class="col-lg-2 control-label">{{ trans('message.highlights') }} 2</label>
									      <div class="col-lg-10">
			                                {{ Form::text('highlight_two', isset($theme->highlight_two) ? $theme->highlight_two : old('highlight_one'), array('class' => 'form-control', 'id' => 'highlight_two','placeholder'=>trans('message.highlights')  )) }}
									      </div>
									    </div>
									    <div class="form-group">
									      <label for="inputPassword" class="col-lg-2 control-label">{{ trans('message.highlights') }} 3</label>
									      <div class="col-lg-10">
			                                {{ Form::text('highlight_three', isset($theme->highlight_three) ? $theme->highlight_three : old('highlight_three'), array('class' => 'form-control', 'id' => 'highlight_three','placeholder'=>trans('message.highlights')  )) }}
									      </div>
									    </div>
  										<div class="form-group">
									      <label for="inputImage" class="col-lg-2 control-label">{{ trans('message.image') }}&nbsp;(800x600px)</label>
									      <div class="col-lg-10">
									      {!! Form::file('image', null) !!}
									      </div>
									    </div>
									    <div class="form-group">
									      <div class="col-lg-10 col-lg-offset-2">
									       @if($isEdit)
									        <a  id="btnRemove" class="btn btn-warning">{{ trans('message.remove') }}</a>
									        @endif
									        <button type="reset" class="btn btn-default" data-dismiss="modal">{{ trans('message.cancel') }}</button>
									        <button type="submit" class="btn btn-primary">{{ trans('message.save') }}</button>
									      </div>
									    </div>
									  </fieldset>
			                  {!! Form::close() !!}
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

<script type="text/javascript">
 $('head').append( $('<link rel="stylesheet" type="text/css" />').attr('href', '/yezz-bower/jqueryte/dist/jquery-te-1.4.0.css') );
 $('head').append( $('<script type="text/javascript" />').attr('src','/yezz-bower/jqueryte/dist/jquery-te-1.4.0.min.js'));

 var entity  = null;  
 var $_token = "{{ csrf_token() }}";
 var action  = null;
 var url    = null; 
 var redirectTo = null;

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
	  	       dom: 'Bfrtip',
               buttons: [
			        {
			            text: '<i class="fa fa-plus-circle fa-lg" title="<?php echo trans('message.new')  ?>"></i> ',
			            action: function ( e, dt, node, config ) {
			              window.location.pathname = "/ytthemes/create"; 
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
	                 }
		        ],
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

function restoreTheme(data)
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

</script>
@endsection
