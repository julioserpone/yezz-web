@extends('layouts.app')

@section('htmlheader_title')
Journal
@endsection


@section('main-content')
<div class="container spark-screen">


  <legend>{{ trans('message.journal') }}</legend>

  <div class="row">
    <div class="col-md-10 col-md-offset-1">

     <table id="datagrid" class="table table-striped table-bordered" role="grid">
      <thead>
        <tr>
          <th class="text-center">{{ trans('message.language') }}</th>
          <th class="text-center">{{ trans('message.position') }}</th>
          <th class="text-center">{{ trans('message.name') }}</th>
          <th class="text-center">{{ trans('message.url') }}</th>
          <th></th>
        </tr>
      </thead>

      <tbody>
        @foreach ($journals as $reg)
        <tr>
          <td class="text-center">{{ $reg->language }}</td>
          <td class="text-left">{{ $reg->position }}</td>
          <td class="text-left">{{ $reg->name }}</td>
          <td class="text-center">{{ $reg->url }}</td>
          <td class="text-center">
           <div class="btn-toolbar">
             <div class="btn-group">
              <a id="btnEdit" href="/admin/journal/edit/{{$reg->ext_id}}" data-toggle="editModal" data-target="editModal"><i class="fa fa-edit" aria-hidden="true" title="{{ trans('message.edit')}}"></i></a>
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
          {!! Form::model($journal, ['route'=>['admin.journal.update',$journal->ext_id], 'method'=>'PUT', 'role'=>'form', 'name' => 'journalFrm', 'id' => 'journalFrm','files' => true,'class' => 'form-horizontal']) !!}
          @else      
          {!! Form::model(Request::all(),['route'=>['admin.journal.store'],'files' => true, 'method'=>'POST', 'name'=>'journalFrm', 'id'=> 'journalFrm', 'role'=>'form','class' => 'form-horizontal']) !!}
          @endif

          <!--form  id="journalFrm" class="form-horizontal" role="form"-->




          <fieldset>
            {!! csrf_field() !!}
            <legend>{{ trans('message.journal') }}</legend>
            <div class="form-group">
              <label for="region" class="col-lg-2 control-label">{{ trans('message.language') }}</label>
              <div class="col-lg-10">

                {!! Form::select('languages', $languages, isset($journal) && $journal->lang_code ? $journal->lang_code : old('languages'), ['class' => 'form-control','id'=>'languages']); !!}            

              </div>
            </div>
            <div class="form-group">

              <label for="inputQuestion" class="col-lg-2 control-label">{{ trans('message.position') }}</label>
              <div class="col-md-6 col-lg-6">
               <input id="spinner" name="position"></div>
             </div>
             <div class="form-group">
              <label for="inputAnswer" class="col-lg-2 control-label">{{ trans('message.name') }}</label>
              <div class="col-lg-10">
                {{ Form::text('name', isset($journal->name) ? $journal->name : old('name'), array('class' => 'form-control', 'id' => 'name','placeholder'=>trans('message.name')  )) }}

              </div>
            </div>

            <div class="form-group">
              <label for="inputPriority" class="col-lg-2 control-label">{{ trans('message.url') }}</label>
              <div class="col-lg-10">
                {{ Form::text('url', isset($journal->url) ? $journal->url : old('url'), array('class' => 'form-control', 'id' => 'url','placeholder'=>trans('message.url')  )) }}

              </div>
            </div>
            <div class="form-group">
              <label for="inputImage" class="col-lg-2 control-label">{{ trans('message.image') }}</label>
              <div class="col-lg-10">
                {!! Form::file('image', null) !!}
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-2"> </div>
              <div class="col-lg-2"> 
              <img src="/img/page/journal/{{$journal->image_url}}" style="width: 400px;">
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                <a  id="btnRemove" class="btn btn-warning">{{ trans('message.remove') }}</a>
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
    url    = "/admin/journal/destroy/"+entity.ext_id;
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
    url    = "/admin/journal/destroy/"+entity;
    var message = " "+ <?php echo '\''.trans('message.delete_this').'\''  ?> + " ";

    $('#msgModal-message').text(message);
    $('#msgModal').modal('show');  
  }

  function restorefaq(data) {   
  
    $.ajax({
      type: 'POST', 
      url: ""+data.ext_id+"/restore",
      headers: {"X-CSRF-Token": $_token },
      success: function(result) {console.log(result)
       window.location.reload();
     }
    });
  }

  function edit(data) {

    action = "edit";
    entity = data;
    $('#btnRemove').show();
    $('#editModal').modal('show'); 
    setFormValue("journalFrm",data);

  }

  function getFormValue() {

    var id = "journalFrm";
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
  

  /*=======================================
  =            Document Ready            =
  =======================================*/
  
  $(document).ready(function() {
    
    var pos = "{{ $journal->position }}";
    var spinner = $( "#spinner" ).spinner();
    spinner.spinner( "value", pos );
    
    if(isEdit){
      $('#editModal').modal('show'); 
    }
    
    var datagrid = $('#datagrid').dataTable({
      responsive: true,
      dom: 'Bfrtip',
      buttons: [
      {
        text: '<i class="fa fa-plus-circle fa-lg" title="<?php echo trans('message.new')  ?>"></i> ',
        action: function ( e, dt, node, config ) {
          action = "create";
          document.getElementById("journalFrm").reset();
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
