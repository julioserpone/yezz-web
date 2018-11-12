
<!-- Dialog Modal-->
<div class="modal fade" id="mdlHighlight" tabindex="-1" role="dialog" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="msgModal-title"></h4>
      </div>
      <div class="modal-body">
			   <div class="row">
						<div class="col-md-10 col-md-offset-1">
						   	    
			   		      <form id="highlightFrm" class="form-horizontal">
									  <fieldset>
									    <legend>{{ trans('message.highlights') }}</legend>
									    <div class="form-group">
									       {!! csrf_field() !!}
									      <label for="inputLanguages" class="col-lg-2 control-label">{{ trans('message.language') }}</label>
									      <div class="col-lg-10">
			                                {!! Form::select('languageshl', $languages, isset($language) && $language->id ? $language->id  : old('languages'), ['class' => 'form-control','id'=>'languageshl']); !!}         

									      </div>
									    </div>
                      <div class="form-group">
                        <label for="inputText" class="col-lg-2 control-label">{{ trans('message.type') }}</label>
                        <div class="col-lg-10">
                                      {!! Form::select('highlightType', $highlightType, isset($language) && $language->id ? $language->id  : old('highlightType'), ['class' => 'form-control','id'=>'highlightType']); !!}    
                        </div>

                      </div>
									    <div class="form-group">
									      <label for="inputText" class="col-lg-2 control-label">{{ trans('message.content') }}</label>
									      <div class="col-lg-10">
			                                {{ Form::textarea('text','' , array('class' => 'form-control', 'id' => 'text','placeholder'=>trans('message.content')  )) }}
									      </div>

									    </div>
									   
									    <div class="form-group">
									      <div class="col-lg-10 col-lg-offset-2">
									        <a  onclick="removeHighlights()" class="btn btn-warning">{{ trans('message.remove') }}</a>
									        <button type="reset" class="btn btn-default" data-dismiss="modal">{{ trans('message.cancel') }}</button>
									        <a id="hlSave" class="btn btn-primary">{{ trans('message.save') }}</a>
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

<script>

  var product = "{{$product->ext_id}}";
  var hlData = null;

  $('#hlSave').click(function() {

    var data = getFrmHighlight();
    var actionType = null;
    switch(hlAction) {
      case "edit":
        actionType = "PUT";
        url = "/highlights/"+hlEntity.ext_id+"/update";
        break;
      case "create":
        actionType = "POST";
        url = "/highlights/store"
        break;
    }

    $.ajax({
      type: actionType, 
      url: url,
      headers: {"X-CSRF-Token": $_token },
      data : data,
      async : false,
      success: function(result) {
        if(result.code!=500) {
          window.location.reload();
        }
      }
    });     
  });

  function getFrmHighlight() {

    var id = "highlightFrm";
    return {
      language : document.getElementById(id).elements[2].value,
      type     : document.getElementById(id).elements[3].value,
      text     : document.getElementById(id).elements[4].value,
      product  : product
    }
  }

  function setFrmHighlight(data) {

    $("#languageshl").val(data.langCode);
    $("#text").val(data.text);

  }

  function removeHighlights() {

    url = "/highlights/"+hlEntity.ext_id+"/remove";
    var text = getFrmHighlight().text;
    var message = " "+ <?php echo '\''.trans('message.remove_this').'\''  ?> + " ";
    console.log('eliminar HL')
    $('#msgModal-message').text(message);
    $('#msgModal-entity').text(text);
    $('#msgModal').modal('show');  
  }
</script>

