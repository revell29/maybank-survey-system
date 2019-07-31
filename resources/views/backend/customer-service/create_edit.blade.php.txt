@extends('layouts.master')

@section('title', 'Customer Service - Home')

@section('scripts')
<script type="text/javascript" src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="/global_assets/js/plugins/tables/datatables/extensions/select.min.js"></script>
<script type="text/javascript" src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
<script type="text/javascript" src="/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
@endsection

@section('content')

<!-- Page header -->
<div class="page-header page-header-light">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Master Data</span> -
                {{isset($data) ? 'Edit Customer Service' : 'Add Customer Service'}}</h4>
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
                <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                <a href="#" class="breadcrumb-item">Master Data</a>
                <span
                    class="breadcrumb-item active">{{isset($data) ? 'Edit Customer Service' : 'Add Customer Service'}}</span>
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
                    <h5 class="card-title">{{isset($data) ? 'Edit User Branch' : 'Add Customer Service'}}</h5>
                </div>
                <div class="card-body">
                    <form method="" class="" id="form-user">
                        <div class="form-group">
                            <label>NIK</label>
                            <input type="text" class="form-control notif" name="nik"
                                value="{{isset($data) ? $data->nik : null}}">
                            <label class="validation-invalid-label notif" id="nik"></label>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name"
                                value="{{ is_null(old('name')) ? (isset($data) ? $data->name : null) : old('name') }}">
                            <label class="validation-invalid-label notif" id="name"></label>
                        </div>
                        <div class="form-group">
                            <label>Branch</label>
                            {!! Form::select('branch_id',$options['branches'],isset($data) ? $data->branch_id :
                            null,['class' => 'select form-control','placeholder' => 'Select a branch']) !!}
                            <label class="validation-invalid-label notif" id="branch"></label>
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            {!! Form::select('role',$options['role'],isset($data) ? $data->role : null,['class' =>
                            'select form-control','placeholder' => 'Select a role']) !!}
                            <label class="validation-invalid-label notif" id="role"></label>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="text-right">
                        @permission(['create_user_branch','update_user_branch'])
                        <button type="button" id="save" class="btn btn-md btn-primary pull-right">Submit</button>
                        @endpermission
                        <a href="{{route('customer_service.index')}}" class="btn btn-md btn-danger">Back</a>
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

      $('#save').on('click', function () {

        $.ajax({
          url: '{{isset($data) ? route('customer_service.update',$data->id) : route('customer_service.store')}}',
          data: $('#form-user').serialize(),
          dataType: 'json',
          type: '{{ isset($data) ? 'PATCH' : 'POST'}}',
          beforeSend: function (xhr, $form) {
            $('.form-group').removeClass('has-danger');
            $('#save').prop('disabled',true).html('please wait.');
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
                window.location.href = "/master/customer_service";
            });
          },
          error: function (response,status) {
            if(response.status == 500){
                swal("Error",response.message,'error');
                $('#save').prop('disabled',false).html('submit');
            }
            if(response.status == 422){
                var error = response.responseJSON.errors;
                if (error.branch_id) $('#branch').html(error.branch_id[0]);
                if (error.role) $('#role').html(error.role[0]);
                if (error.name) $('#name').html(error.name[0]);
                if (error.nik) $('#nik').html(error.nik[0]);
                $('#save').prop('disabled',false).html('submit');
            }
          }
        });
        return false;
      });
    });
</script>
@endpush