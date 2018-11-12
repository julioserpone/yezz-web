@extends('layouts.app')

@section('htmlheader_title')
Seller
@endsection


@section('main-content')
<div class="container spark-screen">


  <legend>{{ trans('message.service_providers') }}</legend>

  <div class="row">
    <div class="col-md-10 col-md-offset-1">

     <table id="datagrid" class="table table-striped table-bordered" role="grid">
      <thead>
        <tr>
          <th class="text-center">{{ trans('message.country') }}</th>
          <th class="text-center">{{ trans('message.name') }}</th>
          <th class="text-center">{{ trans('message.email') }}</th>
          <th class="text-center">{{ trans('message.phone') }}&nbsp;</th>
          <th class="text-center">{{ trans('message.address') }}&nbsp;1</th>
          <th class="text-center">{{ trans('message.attention') }}</th>
          <th></th>
        </tr>
      </thead>

      <tbody>
        @foreach ($service_providers as $reg)
        <tr>
          <td class="text-center">{{ $reg->country }}</td>
          <td class="text-left">{{ $reg->name }}</td>
          <td class="text-left">{{ $reg->email }}</td>
          <td class="text-left">{{ $reg->phone }}</td>
          <td class="text-left">{{ $reg->address }}</td>
          <td class="text-left">{{ $reg->attention }}</td>
          <td class="text-center">
           <div class="btn-toolbar">
             <div class="btn-group">
              <a id="btnEdit" href="/admin/serviceproviders/edit/{{$reg->ext_id}}" data-toggle="editModal" data-target="editModal"><i class="fa fa-edit" aria-hidden="true" title="{{ trans('message.edit')}}"></i></a>
            </div>
            <div class="btn-group">
              <a onclick="showDeleteModal({{$reg}})"><i class="fa fa-trash fa-1g" aria-hidden="true" title="{{ trans('message.delete')}}"></i></a>
            </div>    
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
          {!! Form::model($service_provider, ['route'=>['admin.serviceproviders.update',$service_provider->ext_id], 'method'=>'PUT', 'role'=>'form', 'name' => 'serviceproviderFrm', 'id' => 'sellerFrm','files' => true,'class' => 'form-horizontal']) !!}
          @else      
          {!! Form::model(Request::all(),['route'=>['admin.serviceproviders.store'],'files' => true, 'method'=>'POST', 'name'=>'serviceproviderFrm', 'id'=> 'sellerFrm', 'role'=>'form','class' => 'form-horizontal']) !!}
          @endif

          <fieldset>
            {!! csrf_field() !!}
            <legend>{{ trans('message.service_provider') }}</legend>
            
            <div class="form-group">
              <label for="region" class="col-lg-2 control-label">{{ trans('message.country') }}</label>
              <div class="col-lg-10">

                {!! Form::select('countries', $countries, isset($service_provider) && $service_provider->lang_code ? $service_provider->lang_code : old('languages'), ['class' => 'form-control','id'=>'languages']); !!}            

              </div>
            </div>

            <div class="form-group">
              <label for="inputAnswer" class="col-lg-2 control-label">{{ trans('message.name') }}</label>
              <div class="col-lg-10">
                {{ Form::text('name', isset($service_provider->name) ? $service_provider->name : old('name'), array('class' => 'form-control', 'id' => 'name','placeholder'=>trans('message.name')  )) }}

              </div>
            </div>
            <div class="form-group">
              <label for="inputPriority" class="col-lg-2 control-label">{{ trans('message.email') }}</label>
              <div class="col-lg-10">
                {{ Form::text('email', isset($service_provider->email) ? $service_provider->email1 : old('email1'), array('class' => 'form-control', 'id' => 'email1','placeholder'=>trans('message.email')  )) }}

              </div>
            </div>

            <div class="form-group">
              <label for="inputPriority" class="col-lg-2 control-label">{{ trans('message.phone') }}</label>
              <div class="col-lg-10">
                {{ Form::text('phone_number', isset($service_provider->phone_number) ? $service_provider->phone_number : old('phone_number'), array('class' => 'form-control', 'id' => 'phone_number','placeholder'=>trans('message.phone')  )) }}

              </div>
            </div>
            <div class="form-group">
              <label for="inputPriority" class="col-lg-2 control-label">{{ trans('message.address') }}</label>
              <div class="col-lg-10">
                {{ Form::text('address', isset($service_provider->address) ? $service_provider->address : old('address'), array('class' => 'form-control', 'id' => 'address','placeholder'=>trans('message.address')  )) }}

              </div>
            </div>
               

            <div class="form-group">
              <label for="inputPriority" class="col-lg-2 control-label">{{ trans('message.attention') }}</label>
              <div class="col-lg-10">
                {{ Form::text('attention', isset($service_provider->attention) ? $service_provider->attention : old('attention'), array('class' => 'form-control', 'id' => 'attention','placeholder'=>trans('message.attention')  )) }}

              </div>
            </div>
             <div class="form-group">
              <div class="col-md-2 col-lg-2"></div>
              <div class="col-md-5">
                <label>{{ trans('message.latitude') }}</label>
                {{ Form::text('latitude', isset($service_provider->latitude) ? $service_provider->latitude : old('latitude'), array('class' => 'form-control', 'id' => 'latitude','placeholder'=>trans('message.latitude')  )) }}                  
              </div>
              <div class="col-md-5">
                <label>{{ trans('message.longitude') }}</label>
                {{ Form::text('longitude', isset($service_provider->longitude) ? $service_provider->longitude : old('longitude'), array('class' => 'form-control', 'id' => 'longitude','placeholder'=>trans('message.longitude')  )) }}                  

              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">

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
  var isEdit = <?php echo $open ?>;


  $("#msgYes").click(function() {   

    $.ajax({
      type: 'POST', 
      url: url,
      headers: {"X-CSRF-Token": $_token },
      success: function(result) {
        if(result.code==200)
          window.location.reload();
      }
    });
  });

  $("#btnRemove").click(function() {

    action = "remove";
    url    = "/admin/seller/destroy/"+entity.ext_id;

    var answer   = entity.answer;
    var message = " "+ <?php echo '\''.trans('message.remove_this').'\''  ?> + "";

    $('#msgModal-message').text(message);
    $('#msgModal').modal('show');  

  });

  /*====================================
  =            Functions JS            =
  ====================================*/
  
  function showDeleteModal(data) {

    action = "delete";
    entity = data.ext_id;
    url    = "/admin/serviceproviders/delete/"+entity;
    var message = " "+ <?php echo '\''.trans('message.delete_this').'\''  ?> + " ";

    $('#msgModal-message').text(message);
    $('#msgModal').modal('show');  
  }

  function edit(data) {

    action = "edit";
    entity = data;
    $('#editModal').modal('show'); 
    setFormValue("sellerFrm",data);

  }

  function getFormValue() {

    var id = "sellerFrm";
    return {
      token    : document.getElementById(id).elements[1].value,
      language : document.getElementById(id).elements[2].value,
      position : document.getElementById(id).elements[3].value,
      name     : document.getElementById(id).elements[4].value,
      url      : document.getElementById(id).elements[5].value,
      image_url: document.getElementById(id).elements[6].value,
      image    : document.getElementById(id).elements[7].value,
    }
  }

  function setFormValue(id,data) {

    $("#languages").val(data.langCode);
    $("#question").val(data.question);
    $("#answer").val(data.answer);
    $("#priority").val(data.priority);
  }  
  
  /*=====  End of Functions JS  ======*/
  
  /*======================================
  =            Document Ready            =
  ======================================*/
  
  $(document).ready(function() {

    var spinner = $( "#spinner" ).spinner();
    var pos = "{{ $service_provider->position }}";
    spinner.spinner( "value", pos );
    
    if(isEdit){
      $('#editModal').modal('show'); 
    }
    
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
                            window.location.href = "/admin/serviceproviders/create"
                            /*action = "create";
                            document.getElementById("sellerFrm").reset();
                            $('#btnRemove').hide();
                            $('#editModal').modal('show'); 
                            */
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
