
<script src="{{ asset('theme/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('theme/global/plugins/jquery-migrate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('theme/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>

<!-- Core plugins BEGIN (required only for current page) -->
<script src="{{ asset('theme/global/plugins/fancybox/source/jquery.fancybox.pack.js') }}" type="text/javascript"></script><!-- pop up -->
<script src="{{ asset('theme/global/plugins/jquery.easing.js') }}"></script>
<script src="{{ asset('theme/global/plugins/jquery.parallax.js') }}"></script>
<script src="{{ asset('theme/global/plugins/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('theme/frontend/onepage/scripts/jquery.nav.js') }}"></script>
<script src="{{ asset('js/yezz-menu.js') }}"></script>

<!-- Core plugins END (required only for current page) -->
<link rel="stylesheet" type="text/css" href="{{ asset('theme/global/plugins/bootstrap-select/bootstrap-select.min.css') }}"/>
<script type="text/javascript" src="{{ asset('theme/global/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('theme/global/plugins/select2/select2.min.js') }}"></script>

<script src="{{ asset('theme/admin/pages/scripts/components-dropdowns.js') }}"></script>

<script type="text/javascript" src="{{ asset('theme/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"></script>
<script src="{{ asset('theme/admin/layout/scripts/demo.js') }}" type="text/javascript"></script>


<link rel="stylesheet" type="text/css" href="{{ asset('theme/global/plugins/select2/select2.css') }}"/>

<!-- Global js BEGIN -->
<script src="{{ asset('theme/frontend/onepage/scripts/layout.js') }}" type="text/javascript"></script>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js" type="text/javascript" ></script>

<script src="{{ asset('/theme/yezz-slider/js/owl.carousel.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/theme/yezz-slider/js/slider.js') }}" type="text/javascript"></script>
<script src="{{ asset('/theme/yezz-slider/js/product-carousel.js') }}" type="text/javascript"></script>
<script src="{{ asset('/theme/yezz-slider/js/testimonial.js') }}" type="text/javascript" ></script>


@if(isset($front_requires['multiselect']))
<!-- Multiselect -->
<script src="{{ asset('plugins/jquery-bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}" type="text/javascript"></script>
@endif

<script>
	$(document).ready(function() {
	Layout.init();
	});

	/*Google Analytics*/
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-26734490-1', 'auto');
	ga('send', 'pageview');

</script>
<!-- Start Live Chat Code -->
<script type="text/javascript" src="{{ asset('/live_chat/templates/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/live_chat/templates/js/main.min.js') }}"></script>
<script type="text/javascript">$(function(){$("<link>").attr({href: "{{ asset('/live_chat/templates/css/live_chat.css') }}", rel: "stylesheet"}).appendTo("head");$("body").append($("<div>").load("/live_chat/live_chat.php",function(){live_chat("/live_chat/");}));});</script>
<!-- End Live Chat Code -->