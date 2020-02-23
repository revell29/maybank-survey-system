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
            <h4><span class="font-weight-semibold">Master Data</span> - {{isset($data) ? 'Edit Role' : 'Add Role'}}</h4>
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
                <a href="{{route('role.index')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                <a href="#" class="breadcrumb-item">Master Data</a>
                <span class="breadcrumb-item active">{{isset($data) ? 'Edit Role' : 'Add Role'}}</span>
            </div>

            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<!-- /page header -->

<!-- Main content -->
<div class="content">
    <form id="form-role">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">{{isset($data) ? 'Edit Role' : 'Add Role'}}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Role Name</label>
                            <input type="text" class="form-control notif" name="name"
                                value="{{isset($data) ? $data->name : null}}" readonly>
                            <label class="validation-invalid-label notif" id="name"></label>
                        </div>
                        <div class="form-group">
                            <label>Role Description</label>
                            {!! Form::textarea('description', isset($data) ? $data->description : null, ['class' =>
                            'form-control m-input', 'placeholder' => 'Enter Description','readonly']) !!}
                            <label class="validation-invalid-label notif" id="description"></label>
                        </div>
                        <div class="form-group">
                            <label>Privileges</label>
                            <label class="validation-invalid-label notif" id="permission-notif"></label>
                            <div class="row">
                                <div class="col-md-3">
                                    @foreach($permission as $p)
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <div class="">
                                                <span class="">
                                                    {!! Form::checkbox('permissions[]', $p->id, isset($data) ?
                                                    $data->hasPermission($p->name) : '',['class' =>
                                                    'form-check-input-styled','readonly'])
                                                    !!}
                                                </span>
                                            </div>
                                            {{$p->display_name}}
                                        </label>
                                    </div>
                                    @break($loop->iteration == 4)
                                    @endforeach
                                </div>
                                <div class="col-md-3">
                                    @foreach($permission as $p)
                                    @continue($p->id < 5) <div class="form-check">
                                        <label class="form-check-label">
                                            <div class="">
                                                <span class="">
                                                    {!! Form::checkbox('permissions[]', $p->id, isset($data) ?
                                                    $data->hasPermission($p->name) : '',['class' =>
                                                    'form-check-input-styled','readonly'])
                                                    !!}
                                                </span>
                                            </div>
                                            {{$p->display_name}}
                                        </label>
                                </div>
                                @break($loop->iteration == 8)
                                @endforeach
                            </div>
                            <div class="col-md-3">
                                @foreach($permission as $p)
                                @continue($p->id < 9) <div class="form-check">
                                    <label class="form-check-label">
                                        <div class="">
                                            <span class="">
                                                {!! Form::checkbox('permissions[]', $p->id, isset($data) ?
                                                $data->hasPermission($p->name) : '',['class' =>
                                                'form-check-input-styled','readonly'])
                                                !!}
                                            </span>
                                        </div>
                                        {{$p->display_name}}
                                    </label>
                            </div>
                            @break($loop->iteration == 12)
                            @endforeach
                        </div>
                        <div class="col-md-3">
                            @foreach($permission as $p)
                            @continue($p->id < 13) <div class="form-check">
                                <label class="form-check-label">
                                    <div class="">
                                        <span class="">
                                            {!! Form::checkbox('permissions[]', $p->id, isset($data) ?
                                            $data->hasPermission($p->name) : '',['class' =>
                                            'form-check-input-styled','readonly'])
                                            !!}
                                        </span>
                                    </div>
                                    {{$p->display_name}}
                                </label>
                        </div>
                        @break($loop->iteration == 16)
                        @endforeach
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            @foreach($permission as $p)
                            @continue($p->id < 17) <div class="form-check">
                                <label class="form-check-label">
                                    <div class="">
                                        <span class="">
                                            {!! Form::checkbox('permissions[]', $p->id, isset($data) ?
                                            $data->hasPermission($p->name) : '',['class' =>
                                            'form-check-input-styled','readonly'])
                                            !!}
                                        </span>
                                    </div>
                                    {{$p->display_name}}
                                </label>
                        </div>
                        @break($loop->iteration == 20)
                        @endforeach
                    </div>
                    <div class="col-md-3">
                        @foreach($permission as $p)
                        @continue($p->id < 21) <div class="form-check">
                            <label class="form-check-label">
                                <div class="">
                                    <span class="">
                                        {!! Form::checkbox('permissions[]', $p->id, isset($data) ?
                                        $data->hasPermission($p->name) : '',['class' =>
                                        'form-check-input-styled','readonly'])
                                        !!}
                                    </span>
                                </div>
                                {{$p->display_name}}
                            </label>
                    </div>
                    @break($loop->iteration == 24)
                    @endforeach
                </div>
            </div>
        </div>
</div>
</div>
</div>
<div class="card-footer">
    <div class="text-right">
        @permission('create_role')
        <button type="button" id="save" class="btn btn-md btn-primary pull-right">Submit</button>
        @endpermission
        <a href="{{route('role.index')}}" class="btn btn-md btn-danger">Back</a>
    </div>
</div>
</div>
</div>
</form>
</div>
<!-- /main content -->

@endsection

@push('scriptcode')
<script type="text/javascript">
    $('#save').on('click', function () {
        var btn = $(this);
        $.ajax({
            url: '{{ isset($data) ? route('role.update',$data->id) : route('role.store')}}',
            data: $('#form-role').serialize(),
            dataType: 'json',
            type: '{{ isset($data) ? 'PATCH' : 'POST'}}',
            beforeSend: function (xhr, $form) {
                btn.html('Please wait').prop('disabled', true);
                $('.form-group').removeClass('has-danger');
            },
            success: function (response, xhr, status, $form) {
                swal({
                    title: "Success!",
                    text: response.message,
                    type: "success",
                    buttonsStyling: false,
                    confirmButtonClass: 'btn btn-primary btn-lg',
                }).then(function () {
                    // Redirect the user
                    window.location.href = "/master/role";
                });
            },
            error: function (response, status) {
                if (response.status == 500) {
                    btn.html('Submit').prop('disabled', false);
                    swal("Error", response.message, 'error');
                }
                if (response.status == 422) {
                    btn.html('Submit').prop('disabled', false);
                    var error = response.responseJSON.errors;
                    if (error.name) $('#name').html(error.name[0]);
                    if (error.display_name) $('#display_name').html(error.display_name[0]);
                    if (error.permission) $('#permission-notif').html(error.permission[0]);
                }
            }
        });
        return false;
    });
    $('.form-check-input-styled').uniform();
</script>
@endpush