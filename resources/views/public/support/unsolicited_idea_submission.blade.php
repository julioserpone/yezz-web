
@extends('public.layouts.sec')

@section('htmlheader_title')
Home
@endsection


@section('main-content')
<div class="about-block content" id="support">
 <div class="container-fluid">
   <div class="row search-parent">
     <img src="/img/page/yezztalk/banner_master.jpg" class="img-responsive">
   </div>
 </div>
 <div class="container-fluid">
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 col-sm-12 col-xs-12">
      <h2>{{ trans('message.unsolicited_idea') }}</h2>
    </div>
    <div class="col-md-2"></div>
  </div>
  <br/>
</div>
<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-8 col-sm-12 col-xs-12">
    <p>YEZZ or any of its employees do not accept or consider unsolicited ideas, including ideas for new advertising campaigns, new promotions, new or improved products or technologies, product enhancements, processes, materials, marketing plans or new product names. Please do not submit any unsolicited ideas, original creative artwork, suggestions or other submissions in any form to YEZZ or any of its employees. The sole purpose of this policy is to avoid misunderstandings or disputes when YEZZ’s products or marketing strategies might seem similar to ideas submitted to YEZZ. If, despite our request you still submit your ideas, then regardless of what your letter says, the following terms shall apply to your submissions.</p>
    <br/>

  </div>
  <div class="col-md-2"></div>
</div>


<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-8 col-sm-12 col-xs-12">
  <h3>Terms of Idea Submission</h3>
    <p>You agree that: (1) your submissions and their contents will automatically become the property of YEZZ, without any compensation to you; (2) YEZZ may use or redistribute the submissions and their contents for any purpose and in any way; (3) there is no obligation for YEZZ to review the submission; and (4) there is no obligation to keep any submissions confidential..</p>
    <br/>
    
  </div>
  <div class="col-md-2"></div>
</div>

<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-8 col-sm-12 col-xs-12">
  <h3>Product Feedback</h3>
    <p>YEZZ does, however, welcome your feedback regarding many areas of YEZZ’s existing business. If you want to send us your feedback, we simply request that you send it to us using the form found at yezz.world/contact. Please provide only specific feedback on YEZZ’s existing products or marketing strategies so that YEZZ can learn how to best satisfy your needs.</p>
    <br/>
  </div>
  <div class="col-md-2"></div>
</div>

<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-8 col-sm-12 col-xs-12">
  <h3>Feedback and Information</h3>
    <p>Any feedback you provide at this site shall be deemed to be non-confidential. YEZZ shall be free to use such information on an unrestricted basis.</p>
    <br/>
  </div>
  <div class="col-md-2"></div>
</div>




<script type="text/javascript">
 $(document).ready(function(){
  menuHandle('support');
});


</script>
@endsection