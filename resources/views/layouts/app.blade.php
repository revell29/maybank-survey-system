<!DOCTYPE html>
<html lang="en">
<head>
	<title>Maybank</title>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!--===============================================================================================-->	
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/custom/login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/custom/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/custom/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/custom/login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="/custom/login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/custom/login/vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="/custom/login/css/util.css">
	<link rel="stylesheet" type="text/css" href="/custom/login/css/main.css">
<!--===============================================================================================-->
</head>
<body style="background-color: #666666;">
	
	<div class="limiter">
		@yield('content')
	</div>
	
	

	
	
<!--===============================================================================================-->
	<script src="{{asset('global_assets/js/main/jquery.min.js')}}"></script>
	<script src="{{asset('global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/ui/nicescroll.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/notifications/pnotify.min.js')}}"></script>
	<script src="/custom/login/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="/custom/datatables.js"></script>
    <script src="/custom/login/js/main.js"></script>
    
    <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
        </script>

    @stack('scripts')
</body>
</html>