@extends('layouts.app')

@section('htmlheader_title')
{{ trans('message.categories') }}
@endsection

@section('main-content')
<div class="container spark-screen">
  <legend>{{ trans('message.categories') }}</legend>

  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <table id="datagrid" class="table table-striped table-bordered" role="grid">
        <thead>
          <tr>
            <th class="text-center">{{ trans('message.name') }}</th>
            <th class="text-center">{{ trans('message.position') }}</th>
            <th class="text-center">{{ trans('message.status') }}</th>
            <th class="text-center">{{ trans('message.anchor') }}</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($categories as $item)
          <tr>
            <td class="text-center">{{ $item->name }}</td>
            <td class="text-center">{{ $item->position }}</td>
            <td class="text-center"><label class="label label-{{ ($item->trashed()?'danger':'success')}}">{{ ($item->trashed()) ? trans('message.inactive') : trans('message.active') }}</label></td>
            <td class="text-left">{{ $item->anchor }}</td>
            <td class="text-center">
              <div class="btn-toolbar">
                <div class="btn-group">
                  <a id="btnEdit" href="{{ route('categories.edit', [$item->id]) }}">
                    <i class="fa fa-edit" aria-hidden="true" title="{{ trans('message.edit')}}"></i>
                  </a>
                </div>
                <div class="btn-group">
                  @if ($item->trashed())
                    <a href="{{ route('categories.active', [$item->id]) }}">
                      <i class="fa fa-eye" aria-hidden="true" title="{{ trans('message.active')}}"></i>
                    </a>
                  @else
                    <a href="{{ route('categories.destroy', [$item->id]) }}">
                      <i class="fa fa-eye-slash" aria-hidden="true" title="{{ trans('message.inactive')}}"></i>
                    </a>
                  @endif
                </div>
                <div class="btn-group">
                  <a onclick="showDeleteModal({{$item}})"><i class="fa fa-trash fa-1g" aria-hidden="true" title="{{ trans('message.delete')}}"></i></a>
                </div>    
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
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

            @if(!$isEdit)
              {!! Form::model(Request::all(),['route'=>['categories.store'],'files' => true, 'method'=>'POST', 'name'=>'categoryFrm', 'id'=> 'categoryFrm', 'role'=>'form','class' => 'form-horizontal']) !!}
            @else      
              {!! Form::model($category, ['route'=>['categories.update',$category->id], 'method'=>'PUT', 'role'=>'form', 'name' => 'categoryFrm', 'id' => 'categoryFrm','files' => true,'class' => 'form-horizontal']) !!}
            @endif
            <fieldset>
              {!! csrf_field() !!}
              <legend>{{ trans('message.category') }}</legend>
              <div class="form-group">
                <label for="name" class="col-lg-2 control-label">{{ trans('message.name') }}</label>
                <div class="col-lg-10">
                  {{ Form::text('name', isset($category->name) ? $category->name : old('name'), array('class' => 'form-control', 'id' => 'name','placeholder'=>trans('message.name')  )) }}
                </div>
              </div>
              <div class="form-group">
                <label for="position" class="col-lg-2 control-label">{{ trans('message.position') }}</label>
                <div class="col-lg-10">
                  {{ Form::text('position', isset($category->position) ? $category->position : old('position'), array('class' => 'form-control', 'id' => 'position','placeholder'=>trans('message.position')  )) }}
                </div>
              </div>
              <div class="form-group">
                <label for="anchor" class="col-lg-2 control-label">{{ trans('message.anchor') }}</label>
                <div class="col-lg-10">
                  {{ Form::text('anchor', isset($category->anchor) ? $category->anchor : old('anchor'), array('class' => 'form-control', 'id' => 'anchor','placeholder'=>trans('message.anchor')  )) }}
                </div>
              </div>
              <div class="form-group">
                <label for="description" class="col-lg-2 control-label">{{ trans('message.description') }} (SP)</label>
                <div class="col-lg-10">
                  {{ Form::text('description_es', isset($category) ? $category->getTranslation('description', 'es') : old('description_es'), array('class' => 'form-control', 'id' => 'description_es','placeholder'=>trans('message.description')  )) }}
                </div>
              </div>
              <div class="form-group">
                <label for="description" class="col-lg-2 control-label">{{ trans('message.description') }} (EN)</label>
                <div class="col-lg-10">
                  {{ Form::text('description_en', isset($category) ? $category->getTranslation('description', 'en') : old('description_en'), array('class' => 'form-control', 'id' => 'description_en','placeholder'=>trans('message.description')  )) }}
                </div>
              </div>
              <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                  <a  id="btnRemove" class="btn btn-warning" data-id="{{ isset($category)?$category->id:'' }}">{{ trans('message.remove') }}</a>
                  <button type="reset" class="btn btn-default" data-dismiss="modal">{{ trans('message.cancel') }}</button>
                  <button type="submit" class="btn btn-primary">{{ trans('message.save') }}</button>
                </div>
              </div>
              </fieldset>
              <!--/form-->
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

  var entity = null;  
  var $_token = "{{ csrf_token() }}";
  var action = null;
  var url    = null; 
  var redirectTo = null;
  var is_edit = parseInt("{{ $open }}");
  var lang = {
    search : "{{ trans('message.search') }}",
    zeroRecords: "{{ trans('message.zeroRecords') }}",
    paginate: {
      first:      "{{ trans('message.first') }}",
      previous:   "{{ trans('message.previous') }}",
      next:       "{{ trans('message.next') }}",
      last:       "{{ trans('message.last') }}"
    }
  };

  $("#msgYes").click(function() {   
  
    $.ajax({
      type: 'post', 
      url: url,
      datatype: 'json',
      headers: {"X-CSRF-TOKEN": $_token },
      success: function(result) {
        if(result.code==200) {
          if (action == 'delete') {
            window.location.assign("{{ route('categories.index') }}");
          } else {
            window.location.reload();
          }
        }
      }
    });
  });

  $("#btnRemove").click(function() { 
    action = "delete";
    url    = "/admin/categories/delete/"+$(this).attr('data-id');
    var message = "{{ trans('message.remove_this') }}";
    $('#msgModal-message').text(message);
    $('#msgModal').modal('show');

  });

  /*====================================
  =            Functions JS            =
  ====================================*/
  
  function showDeleteModal(data) {
    action = "delete";
    url    = "/admin/categories/delete/"+data.id;
    var message = "{{ trans('message.delete_this') }}";

    $('#msgModal-message').text(message);
    $('#msgModal').modal('show');  
  }

  /*=====  End of Functions JS  ======*/
  
  /*=======================================
  =            Document Ready            =
  =======================================*/
  
  $(document).ready(function() {
    
    var pos = parseInt("{{ isset($category)? $category->position : 0 }}");
    var spinner = $( "#position" ).spinner();
    spinner.spinner( "value", pos );
    
    if(is_edit){
      $('#editModal').modal('show'); 
    }
    
    var datagrid = $('#datagrid').dataTable({
      responsive: true,
      dom: 'Bfrtip',
      buttons: [
      {
        text: "<i class='fa fa-plus-circle fa-lg' title={{ trans('message.new') }}></i>",
        action: function ( e, dt, node, config ) {
          action = "create";
          document.getElementById("categoryFrm").reset();
          $('#btnRemove').hide();
          $('#editModal').modal('show'); 
        }
      },
      {
        extend: 'excel',
        text: "<i class='fa fa-file-excel-o fa-lg' title='{{ trans('message.exporttoExcel') }}''></i>",
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
