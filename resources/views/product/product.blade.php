@extends('layouts.app')

@section('htmlheader_title')
	Products
@endsection


@section('main-content')
	<div class="container spark-screen">
    
   
        <legend>{{ trans('message.products') }}</legend>
 
        <div class="row">
      <div class="col-md-12">
                 <table id="datagrid" class="table table-striped table-bordered" role="grid">
                <thead>
                    <tr>
                        <th class="text-center">{{ trans('message.model') }}</th>
                        <th class="text-center">{{ trans('message.operating_system') }}</th>
                        <th class="text-center">{{ trans('message.line') }}</th>
                        <th class="text-center">{{ trans('message.category') }}</th>
                        <th class="text-center">{{ trans('message.specifications') }}</th>
                        <th class="text-center">{{ trans('message.countries') }}</th>
                        <th class="text-center">{{ trans('message.manuals') }}</th>
                        <th class="text-center">{{ trans('message.sales_guide') }} EN</th>
                        <th class="text-center">{{ trans('message.sales_guide') }} ES</th>
                        <th class="text-center">{{ trans('message.top') }}</th>
                        <th class="text-center">{{ trans('message.deleted') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($products as $prod)
                      <tr>
                          <td class="text-left">{{ $prod->model }}</td>
                          <td class="text-left">{{ $prod->osName }}</td>
                          <td class="text-left">{{ $prod->line }}</td>
                          <td class="text-left">{{ $prod->category }}</td>
                          <td class="text-center">{{ $prod->specs }}</td>
                          <td class="text-center">{{ $prod->countries }}</td>
                          <td class="text-center">{{ $prod->manuals }}</td>
                          <td class="text-left" style="font-size: 13px;">{{ $prod->sales_guide_en }}</td>
                          <td class="text-left" style="font-size: 13px;">{{ $prod->sales_guide_es }}</td>
                          <td class="text-center">{{ $prod->top }}</td>
                          <td class="text-center">{{ ($prod->deleted == 1) ? trans('message.yes') : trans('message.no') }}</td>
                          <td class="text-center">
                             <div class="btn-toolbar">
                                <div class="btn-group">
                                    <a id="btnEdit" href="/admin/products/{!!$prod->ext_id!!}/edit/" data-toggle="editModal" data-target="editModal"><i class="fa fa-edit" aria-hidden="true" title="{{ trans('message.edit')}}"></i></a>
                                 </div>
                                 <div class="btn-group">
                                    @if($prod->deleted == 1)
                                      <a onclick="restoreProduct({{$prod}})"><i class="fa fa-history fa-1g" aria-hidden="true" title="{{ trans('message.restore')}}"></i></a>
                                    @else
                                      <a onclick="showDeleteModal({{$prod}})"><i class="fa fa-trash fa-1g" aria-hidden="true" title="{{ trans('message.delete')}}"></i></a>
                                    @endif
                                 </div>
                            </div>    
                          </td>

                      </tr>
                    @endforeach
                </tbody>
            </table>
      

    </div></div>

  </div>





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
$(function () {
  $(document).ready(function() {

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
                        window.location.pathname = "/admin/products/create"; 
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
  });
 var entity = null;  
 var $_token = "{{ csrf_token() }}";
 var action = null;
 var url    = null; 
 var redirectTo = null;

function showDeleteModal(data){
  action = "delete";
  entity = data.ext_id;
  url    = "/admin/products/"+entity+"/delete";
  var message = " "+ <?php echo '\''.trans('message.delete_this').'\''  ?> + " ";

    $('#msgModal-message').text(message);
    $('#msgModal-entity').text(data.model);

    $('#msgModal').modal('show');  
}

$( "#btnSave" ).click(function() 
{   
   var actionType = null;
   var data = getFormValue();
   
   switch(action) {
        case "edit":
             actionType = "PUT";
             url = entity.ext_id+"/update";
            break;
        case "create":
             actionType = "POST";
             url = "/admin/products/store"
            break;
        
     }
    

    $.ajax({
          type: actionType, 
          url: url,
          headers: {"X-CSRF-Token": $_token },
          data : data,
          success: function(result) {
              if(result.code!=500){
                   window.location.reload();
               }
          }
         });     
    

});

$( "#msgYes" ).click(function() 
{   
    $.ajax({
          type: 'POST', 
          url: url,
          headers: {"X-CSRF-Token": $_token },
          success: function(result) {
                window.location.reload();
           }
         });     

});

function restoreProduct(data)
{   
    $.ajax({
          type: 'POST', 
          url: ""+data.ext_id+"/restore",
          headers: {"X-CSRF-Token": $_token },
          success: function(result) {
               window.location.reload();
          }

    });
}


$( "#btnRemove" ).click(function(){ 
      action = "remove";
      url    = "/admin/products/"+entity.ext_id+"/remove";
      
      var answer   = entity.answer;
      var message = " "+ <?php echo '\''.trans('message.remove_this').'\''  ?> + "";
      $('#msgModal-message').text(message);
      $('#msgModal').modal('show');  
 });


function editProduct(data){
  action = "edit";
  entity = data;
  $('#btnRemove').show();
  $('#editModal').modal('show'); 
  setFormValue("productFrm",data);
  
}

function getFormValue(){
  var id = "productFrm";
  return {
            token    : document.getElementById(id).elements[1].value,
            language : document.getElementById(id).elements[2].value,
            question : document.getElementById(id).elements[3].value,
            answer   : document.getElementById(id).elements[4].value,
            priority : document.getElementById(id).elements[5].value
          }
}

function setFormValue(id,data){
     $("#languages").val(data.langCode);
     $("#question").val(data.question);
     $("#answer").val(data.answer);
     $("#priority").val(data.priority);
}

</script>
@endsection
