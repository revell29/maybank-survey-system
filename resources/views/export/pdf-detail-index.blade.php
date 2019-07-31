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
            <strong class="col-sm-2">Admin</strong>: <label>{{Auth::user()->username}}</label><br>
        </div>
        <hr>
        <table class="table table-sm table-bordered table-striped">
            <thead>
                <tr>
                    <td>Branch Code</td>
                    <td>Branch Name</td>
                    <td>Tidak Puas</td>
                    <td>Biasa</td>
                    <td>Puas</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>
                @php
                $total_all = 0;
                $total_1 = 0;
                $total_2 = 0;
                $total_3 = 0;
                @endphp
                @foreach($data as $s)
                @php
                $l1 = $s->survey_branch == NULL ? null : $s->survey_branch[0]->lv1;
                $l2 = $s->survey_branch == NULL ? null : $s->survey_branch[0]->lv2;
                $l3 = $s->survey_branch == NULL ? null : $s->survey_branch[0]->lv3;
                $total = $l1+$l2+$l3;

                $total_1 += $s->survey_branch->sum('lv1');
                $total_2 += $s->survey_branch->sum('lv2');
                $total_3 += $s->survey_branch->sum('lv3');
                $total_all += $total;
                @endphp
                <tr>
                    <td>{{$s->branch_id}}</td>
                    <td>{{$s->branch_name}}</td>
                    <td>{{$l1}}</td>
                    <td>{{$l2}}</td>
                    <td>{{$l3}}</td>
                    <td>{{$total}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan='2'>Total</td>
                    <td>{{$total_1 ? $total_1 : null}}</td>
                    <td>{{$total_2 ? $total_2 : null}}</td>
                    <td>{{$total_3 ? $total_3 : null}}</td>
                    <td>{{$total_all}}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>