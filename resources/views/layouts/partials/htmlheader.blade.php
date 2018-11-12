<head>
    <meta charset="UTF-8">
    <html lang="en">
    <title> YezzWorld - @yield('htmlheader_title', 'Your title here') </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Laravel User Token-->
    <meta name="csrf-token" content="{{ Session::token() }}"> 
    
    <!-- Bootstrap 3.3.4 -->
    <link href="{{ asset('/css/bootstrapCosmo.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- jquery UI -->
    <link href="{{ asset('/yezz-bower/jquery-ui/themes/base/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/yezz-bower/jquery-ui/themes/base/spinner.css') }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="{{ asset('/yezz-bower/components-font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Ionicons  -->
    <link href="{{ asset('/yezz-bower/ionicons/css/ionicons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset('/css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link href="{{ asset('/css/skins/skin-black.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/typeahead.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/yezz.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/yezz-bower/datatables.net-dt/css/jquery.dataTables.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/yezz-bower/datatables.net-buttons-dt/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Select2 for inputs type Select -->
    <link href = "{{ asset('/css/select2.min.css') }}" rel = "stylesheet" >
    <!-- iCheck -->
    <link href="{{ asset('/plugins/iCheck/square/blue.css') }}" rel="stylesheet" type="text/css" />
    <!-- Pace -->
    <link href="{{ asset('/plugins/pace-master/themes/blue/pace-theme-minimal.css') }}" rel="stylesheet" type="text/css" />
    <!-- Sweet Alert -->
    <!--<link href="{{ asset('/yezz-bower/sweetalert/src/sweetalert.css') }}" rel="stylesheet" type="text/css" />-->
    <link href="{{ asset('/yezz-bower/bootstrap-formhelpers/dist/css/bootstrap-formhelpers.css') }}" rel="stylesheet" type="text/css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
