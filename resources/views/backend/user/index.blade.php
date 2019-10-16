@extends('layouts.master')

@section('title', 'Dashboard - Home')

@section('scripts')
<script type="text/javascript" src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="/global_assets/js/plugins/tables/datatables/extensions/select.min.js"></script>
<script type="text/javascript" src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
<script type="text/javascript" src="/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
<script type="text/javascript" src="/custom/datatables.js"></script>
<script type="text/javascript" src="/js/global/datatables.js"></script>
@endsection

@section('content')

<!-- Page header -->
<div class="page-header page-header-light">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Master Data</span> - User</h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>

        <div class="header-elements d-none">
            @permission('create_user')
            <a href="{{route('user.create')}}" class="btn btn-labeled btn-labeled-left bg-primary">Add User <b><i
                        class="icon-add"></i></b></a>
            @endpermission
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{route('user.index')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                <a href="#" class="breadcrumb-item">Master Data</a>
                <span class="breadcrumb-item active">User</span>
            </div>

            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<!-- /page header -->

<!-- Main content -->
<div class="content">
    <div class="card">
        <table class="table table-hover table-bordered table-xxs datatable-select-checkbox" id="data-table"
            data-url="{{route('user.index')}}">
            <thead>
                <tr>
                    <th><input type="checkbox" class="styled" id="select-all"></th>
                    <th>ID</th>
                    <th>UserID</th>
                    <th>Username</th>
                    <th>Role</th>
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
        searching: true,
        processing: true,
        serverSide: true,
        stateSave: true,
        ajax: '{{route('User::list')}}',
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
            { data: 'id', name: 'id', width: '30px', class: "text-center" },
            { data: 'user_id', name: 'user_id' },
            { data: 'username', name: 'username', searchable: true},
            { data: 'roles_name', name: 'roles_name' },
        ]
    })

    table.on('select',function(){
        table.rows('#1').deselect();
    })

</script>
@endpush