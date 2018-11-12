

<div class="modal fade" id="modalLogin">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">{{ trans('message.siginsession') }}</h4>
      </div>
      <div class="modal-body">

              <div class="login-box-body">
              @if (session('login_error')!=null)
              <p style="color:red;">{{ trans('message.credentials_error') }}</p>
              @endif
              <form action="{{ url('/user/login') }}" method="post">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="form-group has-feedback">
                      <input type="email" class="form-control" placeholder="{{ trans('message.email') }}" name="email"/>
                      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                      <input type="password" class="form-control" placeholder="{{ trans('message.password') }}" name="password"/>
                      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  </div>
                  <div class="row">
                      <div class="col-md-1"></div>
                      <div class="col-md-11">
                          <div class="checkbox icheck">
                              <label>
                                  <input type="checkbox" name="remember"> {{ trans('message.remember') }}
                              </label>
                          </div>
                      </div><!-- /.col -->
                  </div>
                  <div class="row">
                      <div class="col-xs-12">
                          <button type="submit" class="btn btn-primary btn-block">{{ trans('message.buttonsign') }}</button>
                      </div><!-- /.col -->
                  </div>
              </form>

              
              <br/>
              <a href="{{ url('/password/reset') }}">{{ trans('message.forgotpassword') }}</a><br>
              <a onclick="openRegisterModal();" class="text-center">{{ trans('message.registermember') }}</a>

          </div><!-- /.login-box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('message.close') }}</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




