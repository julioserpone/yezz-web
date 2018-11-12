@extends('layouts.app')

@section('htmlheader_title')
	Regions
@endsection


@section('main-content')

	<div class="container spark-screen">
		
   
        <legend>{{ trans('message.region') }}</legend>
 
        <div class="row">
			<div class="col-md-10 col-md-offset-1">
            
        	 <table id="datagrid" class="table table-striped table-bordered" role="grid">
				        <thead>
				            <tr>
				                <th class="text-center">{{ trans('message.code') }}</th>
				                <th class="text-center">{{ trans('message.name') }}</th>
				                <th class="text-center">{{ trans('message.active') }}</th>
				                <th class="text-center">{{ trans('message.deleted') }}</th>
				                <th></th>
				            </tr>
				        </thead>
				        
				        <tbody>
				        	@foreach ($regions as $reg)
					            <tr>
					                <td class="text-center">{{ $reg->code }}</td>
					                <td class="text-left">{{ $reg->name }}</td>
					                <td class="text-center">{{ ($reg->active == 1) ? trans('message.yes') : trans('message.no') }}</td>
					                <td class="text-center">{{ ($reg->deleted == 1) ? trans('message.yes') : trans('message.no') }}</td>
					                <td class="text-center">
					                   <div class="btn-toolbar">
					                	 <div class="btn-group">
										    <a id="btnEdit" href="{{ route('regions.edit', $reg->code) }}" data-toggle="editModal" data-target="editModal"><i class="fa fa-edit" aria-hidden="true" title="{{ trans('message.edit')}}"></i></a>
										 </div>
                                            @if($reg->deleted == 1)
										     <div class="btn-group">
										    	<a onclick="restoreRegion({{$reg}})"><i class="fa fa-history fa-1g" aria-hidden="true" title="{{ trans('message.restore')}}"></i></a>
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

		</div></div>

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
						   	    
			   		       @if($isEdit)
						   		  {!! Form::model($region, ['route'=>['regions.update',$region->code], 'method'=>'PUT', 'role'=>'form', 'name' => 'regionFrm', 'id' => 'regionFrm','class' => 'form-horizontal']) !!}
			   				@else      
			   				      {!! Form::model(Request::all(),['route'=>['regions.store'], 'method'=>'POST', 'name'=>'regionFrm', 'id'=> 'regionFrm', 'role'=>'form','class' => 'form-horizontal']) !!}
			   				@endif
								<!--<form class="form-horizontal"> -->
									  <fieldset>
									    <legend>{{ trans('message.region') }}</legend>
									    <div class="form-group">
									       {!! csrf_field() !!}
									      <label for="inputEmail" class="col-lg-2 control-label">{{ trans('message.code') }}</label>
									      <div class="col-lg-10">
			                                {{ Form::text('code', isset($region->code) ? $region->code : old('code'), array('class' => 'form-control', 'id' => 'code','placeholder'=>trans('message.code')  )) }}

									      </div>
									    </div>
									    <div class="form-group">
									      <label for="inputPassword" class="col-lg-2 control-label">{{ trans('message.name') }}</label>
									      <div class="col-lg-10">
			                                {{ Form::text('name', isset($region->name) ? $region->name : old('name'), array('class' => 'form-control', 'id' => 'name','placeholder'=>trans('message.name')  )) }}
									        <div class="checkbox">
									                <label>{{ Form::checkbox('active', 'value'  , null , array('id'=>'active'))  }} {{ trans('message.active') }}
			                                        </label>
									        </div>
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
<div class="modal fade" id="msgModal" tabindex="-1" role="dialog">
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

<script>

	var entity = null;  
	var $_token = "{{ csrf_token() }}";
	var action = null;
	var url    = null; 
	var redirectTo = null;

	$("#btnNew").click(function() {   
		{{ $isEdit= false }}
    	$('#editModal').modal('show');  
	});

	$("#btnEdit").click(function() {   
		{{ $isEdit= true }}
 	});

	$("#msgYes").click(function() {   
    
    	$.ajax({
        	type: 'POST', 
        	url: url,
        	headers: {"X-CSRF-Token": $_token },
         	success: function(result) {
          		window.location.pathname = "regions/view";
          	}
       	});     
	});

	$("#btnRemove").click(function() { 

		action = "remove";
		entity = "{{ $region->code }}";
		url    = "remove";

		var name   = "{{ $region->name }}";
		var message = " "+ <?php echo '\''.trans('message.remove_this').'\''  ?> + " "+name;
	    $('#msgModal-message').text(message);
	    $('#msgModal').modal('show');  
	});


	/*====================================
	=            Functions JS            =
	====================================*/
	
	function showDeleteModal(data) {

		action = "delete";
		entity = data.code;
		url    = entity+"/delete";
		var message = " "+ <?php echo '\''.trans('message.delete_this').'\''  ?> + " "+data.name;
	    $('#msgModal-message').text(message);
	    $('#msgModal').modal('show');  
	}

	function restoreRegion(data)
	{   
	    $.ajax({
	        type: 'POST', 
	        url: ""+data.code+"/restore",
	        headers: {"X-CSRF-Token": $_token },
	        success: function(result) {
	        	window.location.pathname = "regions/view";
	        }
	    });
	}
	
	/*=====  End of Functions JS  ======*/
	

	$(window).load(function() {
		
		var openEdit = "{{ isset($openEdit) ? $openEdit : false }}";

	  	if(openEdit) {
	  		$('#editModal').modal('show');  
	  	}
	});


	/*======================================
	=            Document Ready            =
	======================================*/
	
	$(document).ready(function() {
		
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

	 	var datagrid = $('#datagrid').dataTable({
		  	       			responsive: true,
		  	       			dom: 'Bfrtip',
	               			buttons: [
					        	{
					            	text: '<i class="fa fa-plus-circle fa-lg" title="<?php echo trans('message.new')  ?>"></i> ',
					            	action: function ( e, dt, node, config ) {
					              		window.location.pathname = "regions/create"; 
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
	});
	
	
	/*=====  End of Document Ready  ======*/
	
</script>
@endsection
