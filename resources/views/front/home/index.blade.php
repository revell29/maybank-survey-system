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
        <label>Please kindly rate our service</label><br>
    </div>
    <form id="form-survei" class="form-horizotal">
        <div class="row">
            <div class="col-md-12 text-center" style="margin-left:0px;">
                <button type="button" class="btn btn-lg rounded-round btn-warning btn-home" style="background-color: #263238; height: 60px; margin-top:15px; margin-bottom: 15px;" data-toggle="modal"
                    data-target="#exampleModal" id="btn-cus">Choose
                    the
                    Customer Service /
                    Teller</button>
            </div>
            <input type="hidden" name="teller_id" id="teller-id">
            <div class="col-md-12 col-sm-6 col-xs-12 text-center">
                <label class="padding" for="buruk">
                    <input type="radio" name="level_1" id="buruk" value="1" class="emoticon" data-emot="buruk">
                    <img src="/assets/logo/sad.png" class="image-emot img-fluid img-buruk">
                </label>
                <label class="padding" for="sedang">
                    <input type="radio" name="level_2" value="1" id="sedang" class="emoticon" data-emot="sedang">
                    <img src="/assets/logo/confused.png" class="image-emot img-fluid img-sedang">
                </label>
                <label class="padding" for="happy">
                    <input type="radio" name="level_3" id="happy" value="1" class="emoticon" data-emot="baik">
                    <img src="/assets/logo/happy.png" class="image-emot img-fluid img-baik">
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Choose
                        the
                        Customer Service /
                        Teller</h5>
                <button type="button" class="btn" style="background-color:#FFC400;" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 500px; overflow:auto;">
                <table class="table table-md" id="cs-teller">
                    @foreach ($options['user'] as $key=> $d)
                    <tr id="{{$key}}" style="cursor: pointer; text-align:center;">
                        <td><strong style="font-size: 15px;">{{$d}}</strong></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scriptcode')
<script type="text/javascript">
    $(function(){
            $('#cs-teller').on('click','tr',function(){
                console.log($(this).attr('id'))
                $('#teller-id').val($(this).attr('id'));
                $('#btn-cus').html('Customer Service : '+$(this).text())
                $('#exampleModal').modal('toggle')
            })
            $('.emoticon').on('click',function(e){
                var button = $(this).data('emot');
                e.preventDefault();
                $.ajax({
                    url: '{{route('home.store')}}',
                    data: $('#form-survei').serialize(),
                    dataType: 'JSON',
                    method: 'POST',
                    timer: 3000,
                    beforeSend: function() {
                        $('.img-'+button).css("transform", "scale(1.3)");
                    },
                    success: function(response){
                        $('.emoticon').prop('checked',false);
                        $('.main').hide();
                        $('#thanks').fadeIn(2000).show().delay(5000).queue(function(){
                            window.location.reload();
                        });
                    },error: function(response,statu){
                        if(response.status == 422){
                            $('.emoticon').prop('checked',false);
                            console.log($(this).data('emot'))
                            $('.img-'+button).css("transform", "scale(1)");
                            var error = response.responseJSON.errors;
                            swal({
                                text: error.teller_id[0],
                                type: 'warning',
                                showCancelButton: false,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
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