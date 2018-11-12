

<div class="modal fade" id="modalReply">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

        <h3>{{ trans('message.leave_comment') }}</h4>

        </div>
        <div class="modal-body">


          <div class="post-comment padding-top-40">
            @if(isset($user))
            @if($user!=null)
            {!! Form::model(Request::all(),['route'=>['yezztalk.comment.store'], 'method'=>'POST', 'name'=>'replyFrm', 'id'=> 'replyFrm', 'role'=>'form','class' => 'form-horizontal']) !!}
            <div class="row">
              <div class="col-md-1"></div>
              <div class="form-group col-md-10">
               <label>{{ trans('message.message') }}</label>
               <textarea class="form-control" rows="8" id="comment" name="comment"></textarea>
             </div>
             <div class="col-md-1"></div>
           </div>
           <div class="row">
              <div class="col-md-1"></div>
              <div class="form-group col-md-10">
           <p><button class="btn btn-primary" type="submit">{{ trans('message.post_comment') }}</button></p>
           {{ Form::hidden('theme', $theme->ext_id , array('class' => 'form-control', 'id' => 'theme')) }}
           <input class="form-control" id="parent_comment" name="parent" type="hidden">
           {!! Form::close() !!}
           @endif
           @else
           <p><button class="btn btn-primary" onclick="openLoginModal();">{{ trans('message.login_post_comment') }}</button></p>
           @endif
           </div>
           <div class="col-md-1"></div>
           </div>
         </div>    



       </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('message.close') }}</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




