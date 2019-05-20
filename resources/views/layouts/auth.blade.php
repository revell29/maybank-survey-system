<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Maybank</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{asset('global_assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
	{{-- <link href="/assets/css/sweetalert2.min.css" rel="stylesheet" type="text/css"> --}}
    @yield('styles')
    <style>
            .img-responsive {
                max-width: 100%;
                margin-top: 0px;
                height: 200px;
            }
            .logo {
                height: auto;
                color: black !important;
                padding-right: 20px;
                display: block;
                margin-top: -40px;
            }
        </style>
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{asset('global_assets/js/main/jquery.min.js')}}"></script>
	<script src="{{asset('global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/ui/nicescroll.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/notifications/pnotify.min.js')}}"></script>
	{{-- <script src="{{asset('global_assets/js/plugins/notifications/sweetalert2.min.js')}}"></script> --}}
	<script src="{{asset('global_assets/js/plugins/loaders/blockui.min.js')}}"></script>
	<!-- /core JS files -->
    <script type="text/javascript" src="/custom/datatables.js"></script>

    <!-- Theme JS files -->
    @yield('scripts')
	<script src="{{asset('assets/js/app.js')}}"></script>
    <!-- /theme JS files -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
    </script>

</head>

<body class="" style="background-color: #FFC400;">

    <!-- Page container -->
    <div class="page-container">
    
        <!-- Page content -->
        <div class="page-content">
    
            <!-- Main content -->
            <div class="content-wrapper">
                
                <div class="text-right logo">
                    <img src="/assets/logo/logo.png" class="img-responsive">
                </div>
                <!-- Content area -->
                <div class="content d-md-flex d-sm-flex d-lg-flex d-flex-xl justify-content-center align-items-center">
    
                    @yield('content')
    
                    <!-- Footer -->
                    {{-- <div class="footer text-muted text-center">
                        &copy; {!! date('Y') !!}. <a href="#">Management System</a><a href="#" target="_blank"></a>
                    </div> --}}
                    <!-- /footer -->
    
                </div>
                <!-- /content area -->
    
            </div>
            <!-- /main content -->
    
        </div>
        <!-- /page content -->
    
    </div>
    <!-- /page container -->
    
	@stack('scriptcode')
</body>
</html>
