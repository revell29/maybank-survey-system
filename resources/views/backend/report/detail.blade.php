@extends('layouts.master')

@section('title', 'Dashboard - Home')

@section('styles')
<link rel="stylesheet" type="text/css" href="/custom/daterange/daterangepicker.css">
@endsection

@section('scripts')
    <script type="text/javascript" src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="/global_assets/js/plugins/tables/datatables/extensions/select.min.js"></script>
    <script type="text/javascript" src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
    <script type="text/javascript" src="/global_assets/js/plugins/ui/moment/moment.min.js"></script>
    <script type="text/javascript" src="/custom/daterange/daterangepicker.js"></script>
    <script type="text/javascript" src="/custom/numeral.min.js"></script>
    <script type="text/javascript" src="/custom/sum().js"></script>
    <script type="text/javascript" src="/custom/datatables.js"></script>
@endsection

@section('content')

   <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Report</span> - Survey</h4>
                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>

                <div class="header-elements d-none">
                    {{-- <a href="{{route('user_branch.create')}}" class="btn btn-labeled btn-labeled-left bg-primary">Add User <b><i class="icon-add"></i></b></a> --}}
                </div>
            </div>

            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                <div class="d-flex">
                    <div class="breadcrumb">
                        <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                        <a href="#" class="breadcrumb-item">Report</a>
                        <span class="breadcrumb-item active">Survey</span>
                    </div>

                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>
            </div>
        </div>
	<!-- /page header -->

    <!-- Main content -->
    <div class="content">
        <div class="card">
            <table class="table table-hover table-bordered table-md datatable-select-checkbox" id="report-table">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Tidak Puas</th>
                    <th>Biasa</th>
                    <th>Puas</th>
                </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="2" style="text-align: left">Total</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </tfoot>
            </table>
        </div>
    </div>
    <!-- /main content -->

@endsection
@push('scriptcode')
<script type="text/javascript">
var id = "{!! isset($data) ? $data->branch_id : null !!}";
var date = $('#date-from').val();
var table = $('#report-table').DataTable({
        order: [1, 'desc'],
        bFilter: false,
        searching: true,
        ajax: {
            url: '{{route('ReportDetail::list')}}',
            data: function (d) {
                d.datefrom = $('input[name=datefrom]').val();
                d.dateto = $('input[name=dateto]').val();
                d.branch_id = id
            },
            method: 'POST'
        },
        columns: [
            { data: 'date', name: 'date' },
            { data: 'time', name: 'time' },
            { data: 'level_1', name: 'level_1' },
            { data: 'level_2', name: 'level_2' },
            { data: 'level_3', name: 'level_3' },
        ],
        drawCallback: function () {
            var api = this.api();
            $( api.column(2).footer() ).html(
                    numeral(api.column( 2, { page:'current' } ).data().sum()).format('0,0')
            );
            $( api.column(3).footer() ).html(
                    numeral(api.column( 3, { page:'current' } ).data().sum()).format('0,0')
            );
            $( api.column(4).footer() ).html(
                    numeral(api.column( 4, { page:'current' } ).data().sum()).format('0,0')
            );
        }
    })

    $(".dataTables_filter").find('label').hide();
    $(".dataTables_filter").prepend("<div class='row>'"+
                    "<div class='col-md-12'>"+
                    "<form class='' action='{{  route('Report::export')}}'>"+
                    "<input type='hidden' name='branch_id' value='"+id+"'>"+
                    "<label>From</label>"+
                    "&nbsp;&nbsp;"+
                    "<input type='text' name='datefrom' value='' placeholder='From' id='date-from' class='date-range'>"+
                    "&nbsp;&nbsp;"+
                    "<label>To</label>"+
                    "&nbsp;&nbsp;"+
                    "<button type='button' class='btn btn-primary search'>Search</button>"+
                    "&nbsp;&nbsp;"+
                    @permission('export_excel')
                    "<button type='submit' class='btn btn-success'>Export Excel <b><i class='icon-file-spreadsheet'></i></b></button>"+
                    "&nbsp;&nbsp;"+
                    @endpermission
                    @permission('export_pdf')
                    "<button type='submit' name='pdf' class='btn btn-danger'>Export PDF <b><i class='icon-file-pdf'></i></b></button>"+
                    @endpermission
                    "</form>"+
                    "</div>"+
                    "</div>");
                    
    $('.search').on('click', function(e) {
        table.draw();
        e.preventDefault();
    });

    $('#date-from').daterangepicker({
        opens: 'right',
        locale: {
            format: 'DD MMM YYYY'
        }
    }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });

</script>
@endpush
@section('globaldatatables')
    @include('global.datatables-report-detail')
@endsection