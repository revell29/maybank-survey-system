<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Maybank</title>

	<!-- Global stylesheets -->
	{{-- <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css"> --}}
	<link href="{{asset('global_assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
	{{-- <link href="/assets/css/sweetalert2.min.css" rel="stylesheet" type="text/css"> --}}
	@yield('styles')
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{asset('global_assets/js/main/jquery.min.js')}}"></script>
	<script src="{{asset('global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/ui/nicescroll.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/notifications/pnotify.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/notifications/pnotify.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/loaders/blockui.min.js')}}"></script>
	<!-- /core JS files -->

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

<body class="navbar-top">

	<!-- Main navbar -->
	<div class="navbar navbar-expand-md navbar-dark fixed-top" style="background-color: #FFC400;">
		<div class="navbar-brand">
			<a href="" class="d-inline-block">
				{{-- <img src="../../../../global_assets/images/logo_light.png" alt=""> --}}
				<label style="color:white; font-size:20px; line-height:2px; padding:4px;">Maybank</label>
			</a>
		</div>

		<div class="d-md-none">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
				<i class="icon-tree5"></i>
			</button>
			<button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
				<i class="icon-paragraph-justify3"></i>
			</button>
		</div>

		<div class="collapse navbar-collapse" id="navbar-mobile">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
						<i class="icon-paragraph-justify3"></i>
					</a>
				</li>
			</ul>

			<ul class="navbar-nav ml-auto">

				<li class="nav-item dropdown dropdown-user">
					<a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle"
						data-toggle="dropdown">
						<span>{{Auth::user()->username}}</span>
					</a>

					<div class="dropdown-menu dropdown-menu-right">
						<a href="{{url('/logout')}}" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<div class="sidebar sidebar-dark sidebar-main sidebar-fixed sidebar-expand-md" style="background-color: ">

			<!-- Sidebar mobile toggler -->
			<div class="sidebar-mobile-toggler text-center">
				<a href="#" class="sidebar-mobile-main-toggle">
					<i class="icon-arrow-left8"></i>
				</a>
				Maybank
				<a href="#" class="sidebar-mobile-expand">
					<i class="icon-screen-full"></i>
					<i class="icon-screen-normal"></i>
				</a>
			</div>
			<!-- /sidebar mobile toggler -->


			<!-- Sidebar content -->
			<div class="sidebar-content">

				<!-- Main navigation -->
				<div class="card card-sidebar-mobile">
					<ul class="nav nav-sidebar" data-nav-type="accordion">

						<!-- Main -->
						{{-- <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li> --}}
						<li class="nav-item">
							<a href="{{ url('/dashboard') }}" class="nav-link">
								<i class="icon-home4"></i>
								<span>Dashboard</span>
							</a>
						</li>
						@permission('access_user')
						<li class="nav-item">
							<a href="{{ route('user.index') }}" class="nav-link">
								<i class="icon-user"></i>
								<span>User Management</span>
							</a>
						</li>
						@endpermission
						@permission('access_role')
						<li class="nav-item">
							<a href="{{ route('role.index') }}" class="nav-link">
								<i class="icon-key"></i>
								<span>User Role Management</span>
							</a>
						</li>
						@endpermission
						@permission('access_user_branch')
						<li class="nav-item">
							<a href="{{route('user_branch.index')}}" class="nav-link">
								<i class="icon-users"></i>
								<span>Branch User Management</span>
							</a>
						</li>
						@endpermission
						@permission('access_user_branch')
						<li class="nav-item">
							<a href="{{route('customer_service.index')}}" class="nav-link">
								<i class="icon-users"></i>
								<span>Customer Service</span>
							</a>
						</li>
						@endpermission
						@permission('access_branch')
						<li class="nav-item">
							<a href="{{route('branch.index')}}" class="nav-link">
								<i class="icon-store"></i>
								<span>Branch Management</span>
							</a>
						</li>
						@endpermission
						@permission('access_report')
						<li class="nav-item nav-item-submenu">
							<a href="#" class="nav-link"><i class="icon-books"></i> <span>Report</span></a>
							<ul class="nav nav-group-sub" data-submenu-title="Layouts">
								<li class="nav-item"><a href="{{route('report.index')}}" class="nav-link">Branch
										Report</a></li>
								<li class="nav-item"><a href="{{route('report_user.index')}}" class="nav-link">Customer
										Service Report</a></li>
							</ul>
						</li>
						<!-- /main -->
						@endpermission
						@permission('access_log')
						<li class="nav-item">
							<a href="{{route('log.index')}}" class="nav-link">
								<i class="icon-list3"></i>
								<span>Log</span>
							</a>
						</li>
						<!-- /main -->
						@endpermission
					</ul>
				</div>
				<!-- /main navigation -->

			</div>
			<!-- /sidebar content -->

		</div>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">
			@yield('content')
		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->
	@stack('scriptcode')
	@section('globaldatatables')
	@include('global.datatables')
	@show
</body>

</html>