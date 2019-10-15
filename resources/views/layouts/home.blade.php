<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="IE=11">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Maybank</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
        type="text/css">
    <link href="{{asset('global_assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
    <link href="/custom/style.css" rel="stylesheet" type="text/css">
    @yield('styles')
    <style>
        .img-responsive {
            max-width: 100%;
            margin-top: -80px;
            height: 120px;
        }

        #swal2-content {
            font-size: 25px
        }

        btn-home {
            border: 2 solid black !important;
        }
    </style>
    <!-- /global stylesheets -->

</head>

<body class="" style="background-color: #FFC400;">

    <!-- Page container -->
    <div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main content -->
            <div class="content-wrapper">


                <!-- Content area -->
                <div class="content justify-content-center align-items-center">

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


    <!-- Core JS files -->
    <script src="{{asset('custom/jquery.min.js')}}"></script>
    <script src="{{asset('global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
    <script type="text/javascript" src="/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script src="{{asset('custom/selectivizr-min.js')}}"></script>
    <script type="text/javascript" src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="{{asset('custom/promise.js')}}"></script>
    @yield('scripts')

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        $('.select').select2({
            minimumResultsForSearch: -1
        });
    </script>

    @stack('scriptcode')
</body>

</html>