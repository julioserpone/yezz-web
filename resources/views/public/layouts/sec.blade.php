
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

@section('htmlheader')
@include('public.layouts.partials.htmlheader')
@show

<!--
BODY TAG OPTIONS:
=================
-->
	<body>

		@include('public.layouts.partials.secheader')

		@yield('main-content')

		@include('public.layouts.partials.footer')

		@section('scripts')
			@include('public.layouts.partials.scripts')
		@show
	</body>
</html>
