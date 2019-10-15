@extends('layouts.master')

@section('title', 'Dashboard - Home')

@section('scripts')
    <script type="text/javascript" src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="/global_assets/js/plugins/tables/datatables/extensions/select.min.js"></script>
    <script type="text/javascript" src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
    <script type="text/javascript" src="/custom/datatables.js"></script>
@endsection

@section('content')

   <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Activity Log</span></h4>
                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>

                <div class="header-elements d-none">
                    @permission('create_user')
                    {{-- <a href="{{route('user.create')}}" class="btn btn-labeled btn-labeled-left bg-primary">Add User <b><i class="icon-add"></i></b></a> --}}
                    @endpermission
                </div>
            </div>

            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                <div class="d-flex">
                    <div class="breadcrumb">
                        <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                        <a href="#" class="breadcrumb-item">Activity Log</a>
                    </div>

                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>
            </div>
        </div>
	<!-- /page header -->

    <!-- Main content -->
    <div class="content">
        <div class="card">
            <table class="table table-hover table-bordered table-xxs datatable-select-checkbox" id="data-table" data-url="{{route('user.index')}}">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>User</th>
                    <th>Subject</th>
                    <th>IP</th>
                    <th>method</th>
                    <th>Time</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- /main content -->

@endsection

@push('scriptcode')
<script type="text/javascript">
var table = $('#data-table').DataTable({
        order: [0, 'desc'],
        ajax: '{{route("log.data")}}',
        columns: [
            { data: 'id', name: 'id', width: '50px'},
            { data: 'user', name: 'user' },
            { data: 'subject', name: 'subject' },
            { data: 'ip', name: 'ip' },
            { data: 'method', name: 'method' },
            { data: 'created_at', name: 'created_at' },
        ]
    })
</script>
@endpush
@section('globaldatatables')
    @include('global.datatables-report')
@endsection