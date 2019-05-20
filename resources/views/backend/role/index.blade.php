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
                    <h4><span class="font-weight-semibold">Master Data</span> - Role</h4>
                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>

                <div class="header-elements d-none">
                    @permission('create_role')
                    <a href="{{route('role.create')}}" class="btn btn-labeled btn-labeled-left bg-primary">Add Role <b><i class="icon-add"></i></b></a>
                    @endpermission
                </div>
            </div>

            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                <div class="d-flex">
                    <div class="breadcrumb">
                        <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                        <a href="#" class="breadcrumb-item">Master Data</a>
                        <span class="breadcrumb-item active">Role</span>
                    </div>
                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>
            </div>
        </div>
	<!-- /page header -->

    <!-- Main content -->
    <div class="content">
        <div class="card">
            <table class="table table-hover table-bordered table-xxs datatable-select-checkbox" id="data-table" data-url="{{route('role.index')}}">
                <thead>
                <tr>
                    <th><input type="checkbox" class="styled" id="select-all"></th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
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
        order: [1, 'desc'],
        ajax: '{{route("Role::data")}}',
        columnDefs: [{
            targets: 0,
            createdCell: function(td, cellData) {
                if (cellData != 1) {
                    $(td).addClass('select-checkbox')
                }
            }
        }],
        columns: [
            { data: 'id', name: 'id', width: '50px', orderable: false, render: function() { return ''} },
            { data: 'id', name: 'id',class: 'text-center', width: '30px'},
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
        ]
    })

    table.on('select',function(){
        table.rows('#1').deselect();
    })
</script>
@endpush
@section('globaldatatables')
    @include('global.datatables-role')
@endsection