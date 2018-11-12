@extends('layouts.app')

@section('htmlheader_title')
{{ trans('message.softwares') }}
@endsection

@section('main-content')
<div class="container spark-screen">
  <legend>{{ trans('message.softwares') }}</legend>

  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <table id="datagrid" class="table table-striped table-bordered" role="grid">
        <thead>
          <tr>
            <th class="text-center">{{ trans('message.product') }}</th>
            <th class="text-center">{{ trans('message.system_operative') }}</th>
            <th class="text-center">{{ trans('message.part_number') }}</th>
            <th class="text-center">{{ trans('message.hardware_version') }}</th>
            <th class="text-center">{{ trans('message.status') }}</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($softwares as $item)
          <tr>
            <td class="text-center">{{ $item->product->model }}</td>
            <td class="text-center">{{ $item->system_operative->name }}</td>
            <td class="text-center">{{ $item->part_number }}</td>
            <td class="text-left">{{ $item->hardware_version }}</td>
            <td class="text-center"><label class="label label-{{ ($item->trashed()?'danger':'success')}}">{{ ($item->trashed()) ? trans('message.inactive') : trans('message.active') }}</label></td>
            <td class="text-center">
              <div class="btn-toolbar">
                <div class="btn-group">
                  <a id="btnEdit" href="{{ route('softwares.edit', [$item->id]) }}">
                    <i class="fa fa-edit" aria-hidden="true" title="{{ trans('message.edit')}}"></i>
                  </a>
                </div>
                <div class="btn-group">
                  @if ($item->trashed())
                    <a href="{{ route('softwares.active', [$item->id]) }}">
                      <i class="fa fa-eye" aria-hidden="true" title="{{ trans('message.active')}}"></i>
                    </a>
                  @else
                    <a href="{{ route('softwares.destroy', [$item->id]) }}">
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
              {!! Form::model(Request::all(),['route'=>['softwares.store'],'files' => true, 'method'=>'POST', 'name'=>'myForm', 'id'=> 'myForm', 'role'=>'form','class' => 'form-horizontal']) !!}
            @else      
              {!! Form::model($software, ['route'=>['softwares.update',$software->id], 'method'=>'PUT', 'role'=>'form', 'name' => 'myForm', 'id' => 'myForm','files' => true,'class' => 'form-horizontal']) !!}
            @endif
            <fieldset>
              {!! csrf_field() !!}
              <legend>{{ trans('message.software') }}</legend>
              <div class="form-group">
                <label for="system_operatives_id" class="col-lg-2 control-label">{{ trans('message.system_operative') }}</label>
                <div class="col-lg-10">
                  {!! Form::select('system_operatives_id', $system_operatives, isset($software->system_operatives_id) ? $software->system_operatives_id : old('system_operatives_id'), ['class' => 'form-control','id'=>'system_operatives_id']); !!}
                </div>
              </div>
              <div class="form-group">
                <label for="information" class="col-lg-2 control-label">{{ trans('message.information') }}</label>
                <div class="col-lg-10">
                  {{ Form::text('information', isset($software->information) ? $software->information : old('information'), array('class' => 'form-control', 'id' => 'information','placeholder'=>trans('message.information')  )) }}
                </div>
              </div>
              <div class="form-group">
                <label for="product_id" class="col-lg-2 control-label">{{ trans('message.product') }}</label>
                <div class="col-lg-10">
                  {!! Form::select('product_id', $products, isset($software) && $software->product_id ? $software->product_id : old('product_id'), ['id' => 'product_id', 'class' => 'form-control select2', 'style' => 'width:100%']) !!}
                </div>
              </div>
              <div class="form-group">
                <label for="part_number" class="col-lg-2 control-label">{{ trans('message.part_number') }}</label>
                <div class="col-lg-10">
                  {{ Form::text('part_number', isset($software->part_number) ? $software->part_number : old('part_number'), array('class' => 'form-control', 'id' => 'part_number','placeholder'=>trans('message.part_number')  )) }}
                </div>
              </div>
              <div class="form-group">
                <label for="hardware_version" class="col-lg-2 control-label">{{ trans('message.hardware_version') }}</label>
                <div class="col-lg-10">
                  {{ Form::text('hardware_version', isset($software->hardware_version) ? $software->hardware_version : old('hardware_version'), array('class' => 'form-control', 'id' => 'hardware_version','placeholder'=>trans('message.hardware_version')  )) }}
                </div>
              </div>
              <div class="form-group">
                <label for="file_software" class="col-lg-2 control-label">{{ trans('message.file_software') }}</label>
                <div class="col-lg-10">
                  {!! Form::file('file_software', null) !!}
                </div>
              </div>
              <div class="form-group">
                <div class="col-lg-2"> </div>
                <div class="col-lg-2"> 
                  @if(isset($software))
                    <a class="btn btn-success" href="{{ $software->getFirstMediaUrl('softwares') }}" target="_blank">Download</a>
                  @endif
                </div>
              </div>
              <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                  <a  id="btnRemove" class="btn btn-warning" data-id="{{ isset($software)?$software->id:'' }}">{{ trans('message.remove') }}</a>
                  <button type="reset" class="btn btn-danger" data-dismiss="modal">{{ trans('message.cancel') }}</button>
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
            window.location.assign("{{ route('softwares.index') }}");
          } else {
            window.location.reload();
          }
        }
      }
    });
  });

  $("#btnRemove").click(function() { 
    action = "delete";
    url    = "/admin/softwares/delete/"+$(this).attr('data-id');
    var message = "{{ trans('message.remove_this') }}";
    $('#msgModal-message').text(message);
    $('#msgModal').modal('show');

  });

  /*====================================
  =            Functions JS            =
  ====================================*/
  
  function showDeleteModal(data) {
    action = "delete";
    url    = "/admin/softwares/delete/"+data.id;
    var message = "{{ trans('message.delete_this') }}";

    $('#msgModal-message').text(message);
    $('#msgModal').modal('show');  
  }
  
  /*=====  End of Functions JS  ======*/
  
  /*=======================================
  =            Document Ready            =
  =======================================*/
  
  $(document).ready(function() {
    
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
          document.getElementById("myForm").reset();
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
