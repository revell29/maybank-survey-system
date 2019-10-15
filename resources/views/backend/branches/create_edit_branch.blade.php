@extends('layouts.master')

@section('title', 'Dashboard - Home')

@section('scripts')
<script type="text/javascript" src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
<script type="text/javascript" src="/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
@endsection

@section('content')

<!-- Page header -->
<div class="page-header page-header-light">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Master Data</span> - {{isset($data) ? 'Edit Branch' : 'Add Branch'}}
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>

        <div class="header-elements d-none">
            {{-- <a href="{{route('user.create')}}" class="btn btn-labeled btn-labeled-left bg-primary">Add User <b><i
                    class="icon-add"></i></b></a> --}}
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{route('branch.index')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                <a href="#" class="breadcrumb-item">Master Data</a>
                <span class="breadcrumb-item active">{{isset($data) ? 'Edit Branch' : 'Add Branch'}}</span>
            </div>

            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<!-- /page header -->

<!-- Main content -->
<div class="content">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">{{isset($data) ? 'Edit Branch' : 'Add Branch'}}</h5>
                </div>
                <div class="card-body">
                    <form method="" class="" id="form-user">
                        <div class="form-group">
                            <label>Branch Code</label>
                            <input type="text" class="form-control notif" name="branch_id"
                                value="{{isset($data) ? $data->branch_id : null}}">
                            <label class="validation-invalid-label notif" id="branch_id"></label>
                        </div>
                        <div class="form-group">
                            <label>Branch Name</label>
                            <input type="text" class="form-control" name="branch_name"
                                value="{{ is_null(old('branch_name')) ? (isset($data) ? $data->branch_name : null) : old('branch_name') }}">
                            <label class="validation-invalid-label notif" id="branch_name"></label>
                        </div>
                        <div class="form-group">
                            <label>Branch Region</label>
                            <input type="text" class="form-control" name="branch_address"
                                value="{{ is_null(old('branch_address')) ? (isset($data) ? $data->branch_address : null) : old('branch_address') }}">
                            <label class="validation-invalid-label notif" id="branch_address"></label>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="text-right">
                        @permission('create_branch')
                        <button type="button" id="save" class="btn btn-md btn-primary pull-right">Submit</button>
                        @endpermission
                        <a href="{{route('branch.index')}}" class="btn btn-md btn-danger">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /main content -->

@endsection

@push('scriptcode')
<script type="text/javascript">
    $(document).ready(function () {
        $('.select').select2();

    $('.select-nosearch').select2({
        minimumResultsForSearch: Infinity
    });
    $('#save').on('click', function () {

    $.ajax({
        url: '{{isset($data) ? route('branch.update',$data->id) : route('branch.store')}}',
        data: $('#form-user').serialize(),
        dataType: 'json',
        type: '{{ isset($data) ? 'PATCH' : 'POST'}}',
        beforeSend: function (xhr, $form) {
        $('.form-group').removeClass('has-danger');
        },
        success: function (response, xhr, status, $form) {
        swal({
            title: "Success!",
            text: response.message,
            type: "success",
            buttonsStyling: false,
            confirmButtonClass: 'btn btn-primary btn-lg',
        }).then(function() {
            // Redirect the user
            window.location.href = "/master/branch";
        });
        },
        error: function (response,status) {
        if(response.status == 500){
            swal("Error",response.message,'error');
        }
        if(response.status == 422){
            var error = response.responseJSON.errors;
            if (error.branch_id) $('#branch_id').html(error.branch_id[0]);
            if (error.branch_name) $('#branch_name').html(error.branch_name[0]);
            if (error.branch_address) $('#branch_address').html(error.branch_address[0]);
        }
        }
    });
    return false;
    });
});
</script>
@endpush