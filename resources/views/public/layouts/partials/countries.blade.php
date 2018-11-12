
<div class="modal fade" id="langModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        
      </div>
      <div class="modal-body text-left">
        <div class="row">
          <div class="col-md-12 text-center"><h3>{{ trans('message.language') }}</h3></div>  
        </div><br/>
        <div class="row">
         <div class="col-md-6 text-center"><a href="/en"><span class="icon-flag" style="background-image: url( /img/countries/us.jpg )"></span>{{trans('message.english')}}</a></div>
         <div class="col-md-6 text-center"><a href="/es"><span class="icon-flag" style="background-image: url( /img/countries/es.jpg )"></span>{{trans('message.spanish')}}</a></div>
       </div><br/>
     </div>
     <div class="modal-footer">
      <button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('message.close') }}</button>
    </div>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->