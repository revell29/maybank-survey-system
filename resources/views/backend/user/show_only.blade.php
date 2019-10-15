@extends('layouts.master')

@section('title', 'Dashboard - Home')

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
                    <h4><span class="font-weight-semibold">Master Data</span> - {{isset($data) ? 'Edit User' : 'Add User'}}</h4>
                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>

                <div class="header-elements d-none">
                    {{-- <a href="{{route('user.create')}}" class="btn btn-labeled btn-labeled-left bg-primary">Add User <b><i class="icon-add"></i></b></a> --}}
                </div>
            </div>

            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                <div class="d-flex">
                    <div class="breadcrumb">
                        <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                        <a href="#" class="breadcrumb-item">Master Data</a>
                        <span class="breadcrumb-item active">{{isset($data) ? 'Edit User' : 'Add User'}}</span>
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
                        <h5 class="card-title">{{isset($data) ? 'Edit User' : 'Add User'}}</h5>
                    </div>
                    <div class="card-body">
                        <form method="" class="" id="form-user">
                            <div class="form-group">
                                <label>User ID</label>
                                <input type="text" class="form-control notif" name="user_id" value="{{isset($data) ? $data->user_id : $prefix}}" readonly>
                            </div>
            
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" value="{{ is_null(old('username')) ? (isset($data) ? $data->username : null) : old('username') }}" readonly>
                                <label class="validation-invalid-label notif" id="last_name"></label>
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                {!! Form::select('role_id',$role,isset($data) ? $data->roles : null,['class' => 'form-control select-nosearch','readonly'])!!}
                                <label class="validation-invalid-label notif" id="last_name"></label>
                            </div>

                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="text-right">
                            @permission('edit_user')
                            <button type="button" id="save" class="btn btn-md btn-primary pull-right">Submit</button>
                            @endpermission
                            <a href="{{route('user.index')}}" class="btn btn-md btn-danger">Back</a>
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
      $('#save').on('click', function () {

        $.ajax({
          url: '{{isset($data) ? route('user.update',$data->id) : route('user.store')}}',
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
                window.location.href = "/master/user";
            });
          },
          error: function (response,status) {
            if(response.status == 500){
                swal("Error",response.message,'error');
            }
            if(response.status == 422){
                var error = response.responseJSON.errors;
                if (error.first_name) $('#first_name').html(error.first_name[0]);
                if (error.last_name) $('#last_name').html(error.last_name[0]);
                if (error.email) $('#email').html(error.email[0]);
                if (error.username) $('#username').html(error.username[0]);
                if (error.password) $('#password').html(error.password[0]);
                if (error.password_confirmation) $('#password_confirmation').html(error.password_confirmation[0]);
            }
          }
        });
        return false;
      });
    });
</script>
@endpush