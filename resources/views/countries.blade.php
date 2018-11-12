@extends('layouts.app')

@section('htmlheader_title')
Countries
@endsection


@section('main-content')
<div class="container spark-screen">
  
 
 <legend>{{ trans('message.country') }}</legend>
 
 <div class="row">
  <div class="col-md-12 col-md-offset-1">
    
   <table id="datagrid" class="table table-striped table-bordered" role="grid">
    <thead>
      <tr>
        <th class="text-center">{{ trans('message.code') }}</th>
        <th class="text-center">{{ trans('message.name') }}</th>
        <th class="text-center">{{ trans('message.region') }}</th>
        <th class="text-center">{{ trans('message.language') }}</th>
        <th class="text-center">{{ trans('message.deleted') }}</th>
        <th></th>
      </tr>
    </thead>
    
    <tbody>
      @foreach ($countries as $reg)
      <tr>
        <td class="text-center">{{ $reg->code }}</td>
        <td class="text-left">{{ $reg->name }}</td>
        <td class="text-left">{{ $reg->regionName }}</td>
        <td class="text-center">{{ $reg->langName }}</td>
        <td class="text-center">{{ ($reg->deleted == 1) ? trans('message.yes') : trans('message.no') }}</td>
        <td class="text-center">
         <div class="btn-toolbar">
           <div class="btn-group">
            <a id="btnEdit" onclick="edit({{$reg}})" data-toggle="editModal" data-target="editModal"><i class="fa fa-edit" aria-hidden="true" title="{{ trans('message.edit')}}"></i></a>
          </div>
          @if($reg->deleted == 1)
          <div class="btn-group">
            <a onclick="restorecountry({{$reg}})"><i class="fa fa-history fa-1g" aria-hidden="true" title="{{ trans('message.restore')}}"></i></a>
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
          <form  id="countryFrm" class="form-horizontal" role="form">
            
            <fieldset>
              <legend>{{ trans('message.country') }}</legend>
              <div class="form-group">
               {!! csrf_field() !!}
               <label for="inputEmail" class="col-lg-2 control-label">{{ trans('message.code') }}</label>
               <div class="col-lg-10">
                {{ Form::text('code', isset($country->code) ? $country->code : old('code'), array('class' => 'form-control', 'id' => 'code','placeholder'=>trans('message.code')  )) }}

              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword" class="col-lg-2 control-label">{{ trans('message.name') }}</label>
              <div class="col-lg-10">
                {{ Form::text('name', isset($country->name) ? $country->name : old('name'), array('class' => 'form-control', 'id' => 'name','placeholder'=>trans('message.name')  )) }}
                
              </div>
            </div>

            <div class="form-group">
              <label for="region" class="col-lg-2 control-label">{{ trans('message.region') }}</label>
              <div class="col-lg-10">
                {!! Form::select('regions', $regions, isset($region) && $region->id ? $region->id  : old('regions'), ['class' => 'form-control','id'=>'regions']); !!}            
                
              </div>
            </div>
            <div class="form-group">
              <label for="region" class="col-lg-2 control-label">{{ trans('message.language') }}</label>
              <div class="col-lg-10">
                {!! Form::select('languages', $languages, isset($language) && $language->id ? $language->id  : old('languages'), ['class' => 'form-control','id'=>'languages']); !!}            
                
              </div>
            </div>
            
            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                <a  id="btnRemove" class="btn btn-warning">{{ trans('message.remove') }}</a>
                <button type="reset" class="btn btn-default" data-dismiss="modal">{{ trans('message.cancel') }}</button>
                <a id="btnSave" class="btn btn-primary">{{ trans('message.save') }}</a>
              </div>
            </div>
          </fieldset>
        </form>
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

  $("#btnSave").click(function() {   

    var actionType = null;
    var data = getFormValue();

    switch(action) {
      case "edit":
        actionType = "PUT";
        url = data.code+"/update";
        break;
      case "create":
        actionType = "POST";
        url = "/countries/store"
        break;
    }

    $.ajax({
      type: actionType, 
      url: url,
      headers: {"X-CSRF-Token": $_token },
      data : data,
      success: function(result) {
        if(result.code==200) {
          window.location.reload();
        }
      }
    });
  });

  $("#msgYes").click(function() {   

    $.ajax({
      type: 'POST', 
      url: url,
      headers: {"X-CSRF-Token": $_token },
      success: function(result) {
        window.location.pathname = "countries/view";
      }
    });     
  });

  $("#btnRemove").click(function() {

    action = "remove";
    url    = "/countries/"+entity.code+"/remove";
    
    var name   = entity.name;
    var message = " "+ <?php echo '\''.trans('message.remove_this').'\''  ?> + "";

    $('#msgModal-message').text(message);
    $('#msgModal-entity').text(entity.name);
    $('#msgModal').modal('show');

  });

  /*====================================
  =            Functions JS            =
  ====================================*/
  
  function showDeleteModal(data){
    action = "delete";
    entity = data.code;
    url    = entity+"/delete";
    var message = " "+ <?php echo '\''.trans('message.delete_this').'\''  ?> + " ";

    $('#msgModal-message').text(message);
    $('#msgModal-entity').text(data.name);

    $('#msgModal').modal('show');  
  }  
  
  function restorecountry(data) {   
    
    $.ajax({
      type: 'POST', 
      url: ""+data.code+"/restore",
      headers: {"X-CSRF-Token": $_token },
      success: function(result) {
        window.location.pathname = "countries/view";
      }
    });
  }

  function edit(data) {

    action = "edit";
    entity = data;
    $('#btnRemove').show();
    $('#editModal').modal('show'); 
    setFormValue("countryFrm",data);
    
  }

  function getFormValue() {

    var id = "countryFrm";

    return {
      token   : document.getElementById(id).elements[1].value,
      code    : document.getElementById(id).elements[2].value,
      name    : document.getElementById(id).elements[3].value,
      region  : document.getElementById(id).elements[4].value,
      language: document.getElementById(id).elements[5].value
    }
  }

  function setFormValue(id,data) {

    $("#code").val(data.code);
    $("#name").val(data.name);
    $("#regions").val(data.regionCode);
    $("#languages").val(data.langCode);
  }
  /*=====  End of Functions JS  ======*/
  

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
                            action = "create";
                            document.getElementById("countryFrm").reset();
                            $('#btnRemove').hide();
                            $('#editModal').modal('show'); 
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
