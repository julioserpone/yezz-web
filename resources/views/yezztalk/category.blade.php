@extends('layouts.app')

@section('htmlheader_title')
	categories
@endsection


@section('main-content')

    <legend>{{ trans('message.category') }}</legend>
	<div class="container spark-screen">
		
   
 
        <div class="row">
			<div class="col-md-10 col-md-offset-1">
            
        	 <table id="datagrid" class="table table-striped table-bordered" role="grid">
				        <thead>
				            <tr>
				                <th class="text-center">{{ trans('message.language') }}</th>
				                <th class="text-center">{{ trans('message.name') }}</th>
				                <th class="text-center">{{ trans('message.status') }}</th>
				                <th class="text-center">{{ trans('message.themes') }}</th>
				                <th class="text-center">{{ trans('message.likes') }}</th>
				                <th class="text-center">{{ trans('message.unlikes') }}</th>
				                <th class="text-center">{{ trans('message.deleted') }}</th>
				                <th></th>
				            </tr>
				        </thead>
				        
				        <tbody>
				        	@foreach ($categories as $reg)
					            <tr>
					                <td class="text-left">{{ $reg->langName }}</td>
					                <td class="text-left">{{ $reg->name }}</td>
					                <td class="text-left">{{ $reg->statusName }}</td>
					                <td class="text-left">{{ $reg->themes }}</td>
					                <td class="text-left">{{ $reg->likes }}</td>
					                <td class="text-left">{{ $reg->unlikes }}</td>
					                <td class="text-center">{{ ($reg->deleted == 1) ? trans('message.yes') : trans('message.no') }}</td>
					                <td class="text-center">
					                   <div class="btn-toolbar">
					                	 <div class="btn-group">
										    <a id="btnEdit" href="{{ route('ytcategories.edit', $reg->ext_id) }}" data-toggle="editModal" data-target="editModal"><i class="fa fa-edit" aria-hidden="true" title="{{ trans('message.edit')}}"></i></a>
										 </div>
                                            @if($reg->deleted == 1)
										     <div class="btn-group">
										    	<a onclick="restoreCategory({{$reg}})"><i class="fa fa-history fa-1g" aria-hidden="true" title="{{ trans('message.restore')}}"></i></a>
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
						   		  {!! Form::model($category, ['route'=>['ytcategories.update',$category->ext_id], 'method'=>'PUT', 'role'=>'form', 'name' => 'categoryFrm', 'id' => 'categoryFrm','class' => 'form-horizontal']) !!}
			   				@else      
			   				      {!! Form::model(Request::all(),['route'=>['ytcategories.store'], 'method'=>'POST', 'name'=>'categoryFrm', 'id'=> 'categoryFrm', 'role'=>'form','class' => 'form-horizontal']) !!}
			   				@endif
								<!--<form class="form-horizontal"> -->
 									  <fieldset>
									    <legend>{{ trans('message.category') }}</legend>
									    <div class="form-group">
									       {!! csrf_field() !!}
									      <label for="inputEmail" class="col-lg-2 control-label">{{ trans('message.language') }}</label>
									      <div class="col-lg-10">
											{!! Form::select('languages', $languages,  $category->langCode != null ? $category->langCode : old('languages'), ['class' => 'form-control','id'=>'languages']); !!}  			                                
									      </div>
									    </div>
									    <div class="form-group">
									      <label for="inputEmail" class="col-lg-2 control-label">{{ trans('message.status') }}</label>
									      <div class="col-lg-10">
											{!! Form::select('statuses', $statuses, isset($status) && $status->id ? $status->id  : old('statuses'), ['class' => 'form-control','id'=>'statuses']); !!}  			                                
									      </div>
									    </div>
								        <div class="form-group">
									      <label for="inputPassword" class="col-lg-2 control-label">{{ trans('message.name') }}</label>
									      <div class="col-lg-10">
			                                {{ Form::text('name', isset($category->name) ? $category->name : old('name'), array('class' => 'form-control', 'id' => 'name','placeholder'=>trans('message.name')  )) }}
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

<script type="text/javascript">
 var entity = null;  
 var $_token = "{{ csrf_token() }}";
 var action = null;
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
			              window.location.pathname = "/ytcategories/create"; 
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
          	window.location.href ="/ytcategories/view";
          }
         });     
    


});

function restoreCategory(data)
{   
    $.ajax({
          type: 'POST', 
          url: "/ytcategories/"+data.ext_id+"/restore",
          headers: {"X-CSRF-Token": $_token },
          success: function(result) {
          	window.location.href ="/ytcategories/view";
          }

    });
}


$( "#btnRemove" ).click(function(){ 
	action = "remove";
	entity = "{{ $category->ext_id }}";
	url    = "remove";

	var name   = "{{ $category->name }}";
	var message = " "+ <?php echo '\''.trans('message.remove_this').'\''  ?> + " "+name;
    $('#msgModal-message').text(message);
    $('#msgModal').modal('show');  
})


$(document).ready(function(){
   //entity = "{{ $category }}"; 	
   var openForm = "{{ $openForm }}";

   if (openForm){
   	  $('#editModal').modal('show');
   }
  

});

</script>
@endsection
