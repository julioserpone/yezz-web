<head>
	<meta charset="utf-8">
	<title>YEZZ Mobile :: @yield('htmlheader_title', 'Home')</title>

	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="{{trans('message.meta_og_description')}}">
	<meta name="keywords" content="{{trans('message.meta_keywords')}}">
	<meta name="Author" content="YEZZ Mobile">
	<meta name="language" content="es">
	<meta name="robots" content="index, follow">
	<meta property="og:title" content="{{trans('message.meta_og_title')}}">
	<meta property="og:type" content="website">
	<meta property="og:url" content="http://sayyezz.com">
	<meta property="og:image" content="">
	<meta property="og:description" content="{{trans('message.meta_og_description')}}">
	<link rel="canonical" href="http://sayyezz.com">
	<link rel="shortcut icon" href="{{ asset('yezz.ico') }}">

	<link href="{{ asset('theme/frontend/onepage/css/googlefonts.css') }}" rel="stylesheet" type="text/css">

	<link href="{{ asset('theme/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('theme/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
	<link href="{{ asset('theme/global/plugins/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet">
	<link href="{{ asset('theme/global/css/components.css') }}" rel="stylesheet">
	<link href="{{ asset('theme/frontend/onepage/css/style.css') }}" rel="stylesheet">
	<link href="{{ asset('theme/frontend/onepage/css/style-responsive.css') }}" rel="stylesheet">
	<link href="{{ asset('theme/frontend/onepage/css/themes/yezz.css') }}" rel="stylesheet" id="style-color">
	<link href="{{ asset('theme/frontend/onepage/css/custom.css') }}" rel="stylesheet">
	<link href="{{ asset('yezz-bower/sweetalert/dist/sweetalert.css') }}" rel="stylesheet">
	<link href="{{ asset('yezz-bower/bootstrap-formhelpers/dist/css/bootstrap-formhelpers.css') }}" rel="stylesheet">

	@if(isset($front_requires['multiselect']))
	<link href="{{ asset('/plugins/jquery-bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}" rel="stylesheet">
	@endif

	<script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
	<script src="{{ asset('/yezz-bower/jquery-ui/jquery-ui.js') }}"></script>
	<script src="{{ asset('/yezz-bower/jquery-ui/ui/widget.js') }}"></script>
	<script src="{{ asset('/yezz-bower/jquery-ui/ui/widgets/autocomplete.js') }}"></script>
	<script src="{{ asset('/yezz-bower/bootstrap-formhelpers/dist/js/bootstrap-formhelpers.js') }}"></script>
	<script src="{{ asset('/yezz-bower/bootstrap-formhelpers/js/bootstrap-formhelpers-countries.js') }}"></script>
	<script src="{{ asset('/yezz-bower/sweetalert/dist/sweetalert.min.js') }}"></script>

	<link href="{{ asset('theme/yezz-slider/css/owl.carousel.css') }}" rel="stylesheet">  
	<link href="{{ asset('theme/yezz-slider/css/owl.theme.css') }}" rel="stylesheet">

	<link href="{{ asset('/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('/yezz-bower/datatables.net-dt/css/jquery.dataTables.css') }}" rel="stylesheet" type="text/css" />
</head>