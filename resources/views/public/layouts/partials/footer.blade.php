
<div class="pre-footer" id="contact">
  <div class="container">
    <div class="row">
      <!-- BEGIN BOTTOM ABOUT BLOCK -->
      <div class="col-md-3 col-sm-6 pre-footer-col text-left">
        <h2 style="border-bottom:0px;">{{ trans('message.products') }}</h2><br/>
        <p><a href="/products/catalog/{{$lang_country}}/#m_series_lte">{{ trans('message.serie_m_lte') }}</a></p>
        <p><a href="/products/catalog/{{$lang_country}}/#e_series_lte">{{ trans('message.serie_e_lte') }}</a></p>
        <p><a href="/products/catalog/{{$lang_country}}/#feature_phones">{{ trans('message.feature_phones') }}</a></p>
        <p><a href="/products/catalog/{{$lang_country}}/">{{ trans('message.see_more') }}</a></p>
      </div>
      <!-- END BOTTOM ABOUT BLOCK -->
      <!-- BEGIN TWITTER BLOCK -->
      <div class="col-md-3 col-sm-6 pre-footer-col text-left">
        <h2 class="margin-bottom-0 text-left">{{ trans('message.support') }}</h2><br/>
        <p><a href="/faqs/{{$lang_country}}">{{ trans('message.faqs') }}</a></p>
        <p><a href="/manuals/{{$lang_country}}">{{ trans('message.manuals') }}</a></p>
        <p><a href="/service-providers/{{$lang_country}}">{{ trans('message.service_providers') }}</a></p>
        <p><a href="/contact/{{$lang_country}}">{{ trans('message.contact-us') }}</a></p>
      </div>
      <div class="col-md-3 col-sm-6 pre-footer-col text-left">
        <h2 class="margin-bottom-0">{{ trans('message.legal') }}</h2><br/>
        <p><a href="/privacy">{{ trans('message.terms_of_privacy') }}</a></p>
        <p><a href="/unsolicited-idea-submission-policy">{{ trans('message.unsolicited_idea') }}</a></p>
      </div>
      <!-- END TWITTER BLOCK -->
      <div class="col-md-3 col-sm-6 pre-footer-col text-left">
        <div class="pre-footer-subscribe-box">
          <h2>{{ trans('message.suscribe') }}</h2><br/>
          <address class="margin-bottom-20">
            {{ trans('message.join-our') }}
          </address>
          <form action="javascript:void(0);">
            <div class="input-group">
              <input type="text" placeholder="youremail@mail.com" class="form-control" id="txtEmail">
              <span class="input-group-btn">
                <button class="btn btn-primary" id="send">{{ trans('message.suscribe') }}</button>
              </span>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- END PRE-FOOTER -->
<!-- BEGIN FOOTER -->
<div class="footer">
  <div class="container">
    <div class="row">
      <!-- BEGIN COPYRIGHT -->
      <!-- END COPYRIGHT -->
      <!-- BEGIN SOCIAL ICONS -->
      <div class="col-md-6 col-sm-6 pull-left">
        <ul class="social-icons">
          <li><a href="https://www.facebook.com/YezzMobile/" class="facebook" data-original-title="facebook" target="_blank"></a></li>
          <li><a href="https://www.instagram.com/yezzmobile/" class="instagram" data-original-title="instagram" target="_blank"></a></li>
        </ul>
      </div>
      <div class="col-md-6 col-sm-6">
        <div class="copyright"></div>
      </div>
      <!-- END SOCIAL ICONS -->
    </div>
  </div>
</div>
<!-- END FOOTER -->
<a href="#promo-block" class="go2top scroll"><i class="fa fa-arrow-up"></i></a>

<script type="text/javascript">
  var $_token = "{{ csrf_token() }}";
  
  $(document).ready(function(){

    $( '#send' ).click(function(){   
      var email = $('#txtEmail').val();

      if (validateEmail(email)) {
        subscribe(email);
      } else {
        $("#txtEmail").css("color", "red");
      }

    });


    function validateEmail(email) {
      var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    }


    function subscribe(email){
      var data  ={ email : email};

      $.ajax({
        type: 'POST', 
        url: '/subscribe',
        headers: {"X-CSRF-Token": $_token },
        data : data,
        success: function(result) {
          if(result.code==201){
            swal("{{ trans('message.thanks_for_subscribing') }}!", "{{ trans('message.youll_be_start') }}", "success")
          }else if(result.code==200){
            swal({
              title: "{{trans('message.email_registered')}}!",
              type: "warning",
              confirmButtonClass: "btn-warning",
              confirmButtonText: "OK",
              closeOnConfirm: true
            })
          }
        }
      });  
      $('#txtEmail').val('');
    }

   $('#txtEmail').focus(function(){
        $("#txtEmail").css("color", "#909090");
   });

  });
</script>