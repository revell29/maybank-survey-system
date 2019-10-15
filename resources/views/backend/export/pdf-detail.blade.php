<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
</head>

<body style="background-color: transparent;">
    <div class="">
        <div class="" style="text-align: center;">
            <img src="{{ asset('/assets/logo/logo.png')}}" style="height:200px; width:300px;" />
        </div>
        <br><br>
        <div class="col-md-6 text-left">
            <strong class="col-sm-2">Date</strong>:
            <label>{{ isset($date1) != null ? $date1 : date('d F Y')}}</label><br>
            <strong class="col-sm-2">Branch</strong>: <label>{{$branch->branch_name}}</label><br>
            <strong class="col-sm-2">Admin</strong>: <label>{{Auth::user()->username}}</label><br>
        </div>
        <hr>
        <table class="table table-sm table-bordered table-striped">
            <thead>
                <tr>
                    <td>Date</td>
                    <td>Time</td>
                    <td>Tidak Puas</td>
                    <td>Biasa</td>
                    <td>Puas</td>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $s)
                <tr>
                    <td>{{$s->created_at->format('d F Y')}}</td>
                    <td>{{$s->created_at->format('H:i')}}</td>
                    <td>{{$s->level_1}}</td>
                    <td>{{$s->level_2}}</td>
                    <td>{{$s->level_3}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>