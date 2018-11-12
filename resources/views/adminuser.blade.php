@extends('layouts.app')

@section('htmlheader_title')
{{ trans('message.users') }}
@endsection

@section('main-content')

<legend>{{ trans('message.users') }}</legend>
<div class="container spark-screen">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <table id="datagrid" class="table table-striped table-bordered" role="grid">
        <thead>
          <tr>
            <th class="text-center">{{ trans('message.name') }}</th>
            <th class="text-center">{{ trans('message.email') }}</th>
            <th class="text-center">{{ trans('message.role') }}</th>
            <th class="text-center">{{ trans('message.gender') }}</th>
            <th class="text-center">{{ trans('message.deleted') }}</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $usr)
          <tr>
            <td class="text-left">{{ $usr->name }}</td>
            <td class="text-left">{{ $usr->email }}</td>
            <td class="text-left">{{ $usr->rol->name }}</td>
            <td class="text-left">{{ $usr->gender }}</td>
            <td class="text-center">{{ ($usr->trashed()) ? trans('message.yes') : trans('message.no') }}</td>
            <td class="text-center">
              <div class="btn-toolbar">
                <div class="btn-group">
                  <a id="btnEdit" href="{{ route('users.edit', [$usr->id]) }}">
                    <i class="fa fa-edit" aria-hidden="true" title="{{ trans('message.edit')}}"></i>
                  </a>
                </div>
                <div class="btn-group">
                  @if ($usr->trashed())
                    <a href="{{ route('users.active', [$usr->id]) }}">
                      <i class="fa fa-eye" aria-hidden="true" title="{{ trans('message.active')}}"></i>
                    </a>
                  @else
                    <a href="{{ route('users.destroy', [$usr->id]) }}">
                      <i class="fa fa-eye-slash" aria-hidden="true" title="{{ trans('message.inactive')}}"></i>
                    </a>
                  @endif
                </div>
                <div class="btn-group">
                  <a onclick="showDeleteModal({{$usr}})"><i class="fa fa-trash fa-1g" aria-hidden="true" title="{{ trans('message.delete')}}"></i></a>
                </div>    
              </div>    
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">{{ trans('message.user') }}</h4>
        </div>
        <div class="modal-body">

          @if(!$isEdit)
            {!! Form::model(Request::all(),['route'=>['users.store'],'files' => true, 'method'=>'POST', 'name'=>'myform', 'id'=> 'myform', 'role'=>'form','class' => 'form-horizontal']) !!}
          @else      
            {!! Form::model($user, ['route'=>['users.update',$user->id], 'method'=>'PUT', 'role'=>'form', 'name' => 'myform', 'id' => 'myform','files' => true,'class' => 'form-horizontal']) !!}
          @endif

          <fieldset>
            {!! csrf_field() !!}
            <div class="form-group">
              <label for="model" class="col-lg-2 control-label">{{ trans('message.role') }}</label>
              <div class="col-lg-10">
                {!! Form::select('rol_id', $roles, isset($user) ? $user->rol->id : old('rol_id')
                ,['class' => 'form-control']); !!}

              </div>
            </div>
            <div class="form-group">
              <label for="inputLine" class="col-lg-2 control-label">{{ trans('message.name') }}</label>
              <div class="col-lg-10">
                {{ Form::text('name', isset($user->name) ? $user->name : old('name'), array('class' => 'form-control', 'id' => 'name','placeholder'=>trans('message.name')   )) }}
              </div>
            </div>
            <div class="form-group">
              <label for="inputModel" class="col-lg-2 control-label">{{ trans('message.email') }}</label>
              <div class="col-lg-10">
                {{ Form::text('email', isset($user->email) ? $user->email : old('email'), array('class' => 'form-control', 'id' => 'email','placeholder'=>trans('message.email')  )) }}
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword" class="col-lg-2 control-label">{{ trans('message.password') }}</label>
              <div class="col-lg-10">
                {{ Form::password('password', array('class' => 'form-control', 'id'=>'password', 'placeholder'=>trans('message.password'))) }}
              </div>
            </div>
            <div class="form-group">
              <label for="model" class="col-lg-2 control-label">{{ trans('message.gender') }}</label>
              <div class="col-lg-10">
                {!! Form::select('gender', ['M' => 'M', 'F'=>'F'] , isset($user) && $user->gender ? $user->gender  : old('gender'), ['class' => 'form-control']); !!}
              </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                  <a  id="btnRemove" class="btn btn-warning" data-id="{{ isset($user)?$user->id:'' }}">{{ trans('message.remove') }}</a>
                  <button type="reset" class="btn btn-default" data-dismiss="modal">{{ trans('message.cancel') }}</button>
                  <button type="submit" class="btn btn-primary">{{ trans('message.save') }}</button>
                </div>
              </div>
          </fieldset>
          {!! Form::close() !!}
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
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
            window.location.assign("{{ route('users.index') }}");
          } else {
            window.location.reload();
          }
        }
      }
    });
  });

  $("#btnRemove").click(function() { 
    action = "delete";
    url    = "/admin/users/delete/"+$(this).attr('data-id');
    var message = "{{ trans('message.remove_this') }}";
    $('#msgModal-message').text(message);
    $('#msgModal').modal('show');

  });

  /*====================================
  =            Functions JS            =
  ====================================*/
  
  function showDeleteModal(data) {
    action = "delete";
    url    = "/admin/users/delete/"+data.id;
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
          $("#myform").find('input:text, input:password, input:file, select, textarea').val('');
          $("#myform").find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
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
