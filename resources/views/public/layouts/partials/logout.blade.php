

<div class="modal fade" id="modalLogout">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      @if (session('name')!=null)
      <h4>{{ Auth::user()->name }}</h4>
      @endif
  </div>
  <div class="modal-body">

   <div class="row">
       <div class="col-md-6 col-xs-12">
        <img src="{{asset('/img/user2-160x160.jpg')}}" class="user-image image-responsive" alt="User Image"/>    
    </div>
    <div class="col-md-6 col-xs-12">
       <ul style="list-style-type: none;">
           <li style="margin: 10px 0 20px 0;">
            <a href="{{ url('/user/profile') }}" class="btn btn-primary btn-flat">{{ trans('message.profile') }}</a>
        </li>       
        <li style="margin: 10px 0 20px 0;">
            <a href="{{ url('/logout') }}" class="btn btn-primary btn-flat">{{ trans('message.signout') }}</a>
        </li>
    </ul> 
</div>
</div>



</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('message.close') }}</button>
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->




