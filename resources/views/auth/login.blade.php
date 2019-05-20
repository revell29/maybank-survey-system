@extends('layouts.app')

@section('content')
<div class="container-login100">
        <div class="wrap-login100">
            <form class="login100-form validate-form" id="form-login">
                <span class="login100-form-title p-b-43">
                    Login
                </span>
                <label id="username" style="color:red;"></label>
                <label id="notif-not-found" style="color:red;"></label>
                <div class="form-group" data-validate = "Valid email is required: ex@abc.xyz">
                    <input class="form-control" type="text" name="username">
                </div>
                <label id="password" style="color:red;"></label>
                <div class="form-group" data-validate="Password is required">
                    <input class="form-control" type="password" name="password">
                </div>

                <div class="flex-sb-m w-full p-t-3 p-b-32">
                    <div class="contact100-form-checkbox">
                        <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                        <label class="label-checkbox100" for="ckb1">
                            Remember me
                        </label>
                    </div>
                </div>
                <div class="container-login100-form-btn">
                    <button type="button" class="btn-block btn btn-warning" id="login">
                        Login
                    </button>
                </div>
            </form>
            <div class="login100-more">
                <img src="/assets/logo/logo.png" class="img-responsive" style="height: 200px; margin-top:25%;">
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('#login').on('click',function(){
            $.ajax({
                url: '{{route('login')}}',
                data: $('#form-login').serialize(),
                dataType: 'JSON',
                method: 'POST',
                beforeSend: function(response){
                    $('#login').html('please wait..').prop('disabled',true);
                    $
                },
                success: function(response,xhr){
                    window.location.href = response.redirect;
                    console.log(response);
                },error: function(response){
                    $('#login').html('login').prop('disabled',false);
                    var errors = response.responseJSON.errors;
                    var not_found = response.responseJSON.message;
                    $('#notif-not-found').html(not_found);
                    $('#username').html(errors.username[0]);
                    $('#password').html(errors.password[0]);
                    notification(not_found,'danger');
                }             
            })
        })
    })
</script>
@endpush