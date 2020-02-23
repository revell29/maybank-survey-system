@extends('layouts.auth')

@section('styles')
<style>
    .card {
        border: 0px;
        border-radius: 5px;
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection

@section('content')
<div style="margin-top:-20px;">
    <div class="row">
        <div class="col-md-6">
            <form action="" class="form-login" id="formLogin" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="guard" value="user_branch">
                <div class="card login-form">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i
                                class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>
                        </div>

                        <div class="form-group form-group-feedback form-group-feedback-left">
                            <input type="text" class="form-control" name="username" placeholder="Username">
                            <div class="form-control-feedback">
                                <i class="icon-user text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group form-group-feedback form-group-feedback-left">
                            <input type="password" class="form-control" name="password" placeholder="Password">
                            <div class="form-control-feedback">
                                <i class="icon-lock2 text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-dark btn-block" id="submit">Sign in <i
                                    class="icon-circle-right2 position-right"></i></button>
                        </div>

                        <div class="text-center">
                            {{-- <a href="{{ url('/password/reset') }}">Forgot password?</a> --}}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scriptcode')
<script type="text/javascript">
    $(document).ready(function(){
            $('#submit').on('click',function(){
                $.ajax({
                    url: '{{route('login.survei')}}',
                    method: 'POST',
                    data: $('#formLogin').serialize(),
                    dataType: 'JSON',
                    success: function(response){
                        window.location.href = response.redirect
                    },error: function(response){
                        if(response.status == 401){
                            notification('Error!',response.responseJSON.message, 'error','bg-danger border-danger');
                        }
                        if(response.status == 422){
                            notification('Error!','Please fill the input field.', 'error','bg-danger border-danger');
                        }
                        if(response.status == 500){
                            notification('Error!',response.responseJSON.message, 'error','bg-danger border-danger');
                        }
                    }
                })
            })
        });
</script>
@endpush