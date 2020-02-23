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
                @permission('access_cs')
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