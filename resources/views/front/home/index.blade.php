@extends('layouts.home')
@section('content')
<div class="row">
    <div class="col-md-12">
            <div class="text-left">
                <h1>{{$data->branch->branch_name}}</h1>
            </div>
             <div class="text-right">
                <img src="/assets/logo/logo.png" class="img-responsive">
            </div>
    </div>
</div>
<div class="title-survei thanks" id="thanks" style="display: none;">
    <h1>Thank You!</h1>
</div>
<div class="main" id="main">
    <div class="title-survei">
        <h1>Good day!</h1>
        <label>Please kindly rate our service</label>
    </div>
    <form id="form-survei">
        <div class="row text-center">
            <div class="col-md-12 col-sm-6 col-xs-12">
                <label class="padding" for="buruk">
                    <input type="radio" name="level_1" id="buruk" value="1" class="emoticon" data-emot="buruk">
                    <img src="/assets/logo/sad.png" class="image-emot img-fluid">
                </label>
                <label class="padding" for="sedang">
                    <input type="radio" name="level_2" value="1" id="sedang" class="emoticon" data-emot="sedang">
                    <img src="/assets/logo/confused.png" class="image-emot img-fluid">
                </label>
                <label class="padding" for="happy">
                    <input type="radio" name="level_3" id="happy" value="1" class="emoticon" data-emot="baik">
                    <img src="/assets/logo/happy.png" class="image-emot img-fluid">
                </label>
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
            </div>
        </div>
    </form>
    <div class="title-survei">
        <label class="footer-title">we value your feedback</label>
    </div>
</div>
<div class="footer">
    <div class="text-right">
        <button class="btn-logout" id="logout"></button>
    </div>
</div>
@endsection
@push('scriptcode')
<script type="text/javascript">
        $(function(){
            $('.emoticon').on('click',function(){
                $.ajax({
                    url: '{{route('home.store')}}',
                    data: $('#form-survei').serialize(),
                    dataType: 'JSON',
                    method: 'POST',
                    success: function(response){
                        $('.emoticon').prop('checked',false);
                        $('.main').hide();
                        $('#thanks').fadeIn(2000).show().delay(5000).queue(function(){
                            window.location.reload();
                        });
                    },error: function(){

                    }
                })
            })
            $('#logout').click(function(){
                swal({
                    title: 'Do you want to logout?',
                    text: "",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, logout',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    }).then(function(result) {
                    if (result.value) {
                        $.ajax({
                            url: '{{url("/client/logout")}}',
                            type: 'GET',
                            success: function(response) {
                                window.location.href = response.redirect
                            },
                            error: function() {
                            
                            }
                        })
                    }
                })        
            })
        })
</script>
@endpush