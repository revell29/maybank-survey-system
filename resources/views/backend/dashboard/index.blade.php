@extends('layouts.master')

@section('title', 'Dashboard - Home')

@section('content')

   <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Dashboard</span></h4>
                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>

                <div class="header-elements d-none">
                    {{-- <a href="#" class="btn btn-labeled btn-labeled-right bg-primary">Button <b><i class="icon-menu7"></i></b></a> --}}
                </div>
            </div>

            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                {{-- <div class="d-flex">
                    <div class="breadcrumb">
                        <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                        <a href="#" class="breadcrumb-item">Link</a>
                        <span class="breadcrumb-item active">Current</span>
                    </div>

                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div> --}}

                {{-- <div class="header-elements d-none">
                    <div class="breadcrumb justify-content-center">
                        <a href="#" class="breadcrumb-elements-item">
                            Link
                        </a>

                        <div class="breadcrumb-elements-item dropdown p-0">
                            <a href="#" class="breadcrumb-elements-item dropdown-toggle" data-toggle="dropdown">
                                Dropdown
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="#" class="dropdown-item">Action</a>
                                <a href="#" class="dropdown-item">Another action</a>
                                <a href="#" class="dropdown-item">One more action</a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item">Separate action</a>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
	<!-- /page header -->

    <!-- Main content -->
    <div class="content">
        <div class="card">
            <div class="card-header header-elements-inline">
               
            </div>

            <div class="card-body">
                <center><h1>Welcome {{Auth::user()->name}}</h1></center>
            </div>
        </div>
    </div>
    <!-- /main content -->

@endsection

@push('scriptcode')
<script type="text/javascript">

</script>
@endpush


