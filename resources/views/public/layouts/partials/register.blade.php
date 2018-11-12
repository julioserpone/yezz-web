

<div class="modal fade" id="modalRegister">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        
      </div>
      <div class="modal-body">


      <div class="register-box">
        
        <div class="register-box-body">
            <p class="login-box-msg">{{ trans('message.registermember') }}</p>
            <form action="{{ url('/user/register') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="{{ trans('message.fullname') }}" name="name" value="{{ old('name') }}"/>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="{{ trans('message.email') }}" name="email" value="{{ old('email') }}"/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="{{ trans('message.password') }}" name="password"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="{{ trans('message.retrypepassword') }}" name="password_confirmation"/>
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-1">
                        <label>
                            <div class="checkbox_register icheck">
                                <label>
                                    <input type="checkbox" name="terms">
                                </label>
                            </div>
                        </label>
                    </div><!-- /.col -->
                    <div class="col-xs-8">
                        <div class="form-group">
                            <button type="button" class="btn btn-block btn-flat lowercase" data-toggle="modal" data-target="#termsModal">{{ trans('message.terms') }}</button>
                        </div>
                    </div><!-- /.col -->
                </div>
                <div class="row">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block btn-flat btn-md">{{ trans('message.register') }}</button>
                    </div><!-- /.col -->
                  
                </div>
            </form>

            

            <a onclick="openRegisterModal();" class="text-center">{{ trans('message.membreship') }}</a>
        </div><!-- /.form-box -->
    </div><!-- /.register-box -->
            

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('message.close') }}</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




