@extends('layouts.app')

@section('htmlheader_title')
{{ trans('message.banners') }}
@endsection

@section('main-content')
<div class="container spark-screen">
  <legend>{{ trans('message.banners') }}</legend>

  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <table id="datagrid" class="table table-striped table-bordered" role="grid">
        <thead>
          <tr>
            <th class="text-center">{{ trans('message.language') }}</th>
            <th class="text-center">{{ trans('message.position') }}</th>
            <th class="text-center">{{ trans('message.status') }}</th>
            <th class="text-center">{{ trans('message.description') }}</th>
            <th class="text-center">{{ trans('message.url') }}</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($banners as $item)
          <tr>
            <td class="text-center">{{ $item->language->name }}</td>
            <td class="text-center">{{ $item->position }}</td>
            <td class="text-center"><label class="label label-{{ ($item->trashed()?'danger':'success')}}">{{ ($item->trashed()) ? trans('message.inactive') : trans('message.active') }}</label></td>
            <td class="text-left">{{ $item->description }}</td>
            <td class="text-center">{{ $item->url }}</td>
            <td class="text-center">
              <div class="btn-toolbar">
                <div class="btn-group">
                  <a id="btnEdit" href="{{ route('banners.edit', [$item->id]) }}">
                    <i class="fa fa-edit" aria-hidden="true" title="{{ trans('message.edit')}}"></i>
                  </a>
                </div>
                <div class="btn-group">
                  @if ($item->trashed())
                    <a href="{{ route('banners.active', [$item->id]) }}">
                      <i class="fa fa-eye" aria-hidden="true" title="{{ trans('message.active')}}"></i>
                    </a>
                  @else
                    <a href="{{ route('banners.destroy', [$item->id]) }}">
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
              {!! Form::model(Request::all(),['route'=>['banners.store'],'files' => true, 'method'=>'POST', 'name'=>'bannerFrm', 'id'=> 'bannerFrm', 'role'=>'form','class' => 'form-horizontal']) !!}
            @else      
              {!! Form::model($banner, ['route'=>['banners.update',$banner->id], 'method'=>'PUT', 'role'=>'form', 'name' => 'bannerFrm', 'id' => 'bannerFrm','files' => true,'class' => 'form-horizontal']) !!}
            @endif
            <fieldset>
              {!! csrf_field() !!}
              <legend>{{ trans('message.banner') }}</legend>
              <div class="form-group">
                <label for="languages" class="col-lg-2 control-label">{{ trans('message.language') }}</label>
                <div class="col-lg-10">
                  {!! Form::select('languages', $languages, isset($banner) && $banner->language->lang_code ? $banner->language->lang_code : old('languages'), ['class' => 'form-control','id'=>'languages']); !!}
                </div>
              </div>
              <div class="form-group">
                <label for="position" class="col-lg-2 control-label">{{ trans('message.position') }}</label>
                <div class="col-lg-10">
                  {{ Form::text('position', isset($banner->position) ? $banner->position : old('position'), array('class' => 'form-control', 'id' => 'position','placeholder'=>trans('message.position')  )) }}
                </div>
              </div>
              <div class="form-group">
                <label for="product_id" class="col-lg-2 control-label">{{ trans('message.product') }}</label>
                <div class="col-lg-10">
                  {!! Form::select('product_id', $products, isset($banner) && $banner->product_id ? $banner->product_id : old('product_id'), ['id' => 'product_id', 'class' => 'form-control select2', 'style' => 'width:100%']) !!}
                </div>
              </div>
              <div class="form-group">
                <label for="description" class="col-lg-2 control-label">{{ trans('message.description') }}</label>
                <div class="col-lg-10">
                  {{ Form::text('description', isset($banner->description) ? $banner->description : old('description'), array('class' => 'form-control', 'id' => 'description','placeholder'=>trans('message.description')  )) }}
                </div>
              </div>
              <div class="form-group">
                <label for="url" class="col-lg-2 control-label">{{ trans('message.url') }}</label>
                <div class="col-lg-10">
                  {{ Form::text('url', isset($banner->url) ? $banner->url : old('url'), array('class' => 'form-control', 'id' => 'url','placeholder'=>trans('message.url')  )) }}
                </div>
              </div>
              <div class="form-group">
                <label for="image" class="col-lg-2 control-label">{{ trans('message.image') }}</label>
                <div class="col-lg-10">
                  {!! Form::file('image', null) !!}
                </div>
              </div>
              <div class="form-group">
                <div class="col-lg-2"> </div>
                <div class="col-lg-2"> 
                  <img src="{{ isset($banner) ? $banner->getFirstMediaUrl('banners') : '' }}" style="width: 400px;">
                </div>
              </div>
              <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                  <a  id="btnRemove" class="btn btn-warning" data-id="{{ isset($banner)?$banner->id:'' }}">{{ trans('message.remove') }}</a>
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
            window.location.assign("{{ route('banners.index') }}");
          } else {
            window.location.reload();
          }
        }
      }
    });
  });

  $("#btnRemove").click(function() { 
    action = "delete";
    url    = "/admin/banners/delete/"+$(this).attr('data-id');
    var message = "{{ trans('message.remove_this') }}";
    $('#msgModal-message').text(message);
    $('#msgModal').modal('show');

  });

  /*====================================
  =            Functions JS            =
  ====================================*/
  
  function showDeleteModal(data) {
    action = "delete";
    url    = "/admin/banners/delete/"+data.id;
    var message = "{{ trans('message.delete_this') }}";

    $('#msgModal-message').text(message);
    $('#msgModal').modal('show');  
  }

  function restoreBanner(data) {   
  
    $.ajax({
      type: 'POST', 
      url: "admin/banners/restore/"+data.id,
      headers: {"X-CSRF-Token": $_token },
      success: function(result) {console.log(result)
       window.location.reload();
     }
    });
  }
  
  /*=====  End of Functions JS  ======*/
  
  /*=======================================
  =            Document Ready            =
  =======================================*/
  
  $(document).ready(function() {
    
    var pos = parseInt("{{ isset($banner)? $banner->position : 0 }}");
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
          document.getElementById("bannerFrm").reset();
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
