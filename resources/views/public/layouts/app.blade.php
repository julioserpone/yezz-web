<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
    @include('public.layouts.partials.htmlheader')
@show

	<body>

	    @include('public.layouts.partials.mainheader')
	    
	    @yield('main-content')

	    @include('public.layouts.partials.footer')

	    @section('scripts')
	       @include('public.layouts.partials.scripts')
	    @show

	</body>
</html>
