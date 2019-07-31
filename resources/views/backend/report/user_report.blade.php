@extends('layouts.master')

@section('title', 'Report Customer Service - Home')

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
<script type="text/javascript" src="/custom/numeral.min.js"></script>
<script type="text/javascript" src="/custom/sum().js"></script>
<script type="text/javascript" src="/custom/datatables.js"></script>
<script type="text/javascript" src="/custom/daterange/daterangepicker.js"></script>
@endsection

@section('content')

<!-- Page header -->
<div class="page-header page-header-light">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Report</span> - Customer
                Service
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>

        <div class="header-elements d-none">
            {{-- <a href="{{route('Report::export')}}" class="btn btn-labeled btn-labeled-left bg-success">Export <b><i
                    class="icon-file-spreadsheet"></i></b></a> --}}
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                <a href="#" class="breadcrumb-item">Report</a>
                <span class="breadcrumb-item active">Customer Service</span>
            </div>

            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<!-- /page header -->

<!-- Main content -->
<div class="content">
    <div class="card">
        <table class="table table-hover table-bordered table-sm datatable-select-checkbox" id="report-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NPK</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Branch</th>
                    <th>Tidak Puas</th>
                    <th>Biasa</th>
                    <th>Puas</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th colspan="5" style="text-align: left">Total</th>
                    <th></th>
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
    var table = $('#report-table').DataTable({
        order: [1, 'desc'],
        dom: '<"datatable-header"fl><"datatable-scroll datatable-scroll-wrap"t><"datatable-footer"ip>',
        ajax: {
            url: '{{route('ReportUser::list')}}',
            data: function (d) {
                d.datefrom = $('input[name=datefrom]').val();
            },
            method: 'GET'
        },
        columns: [
            { data: 'id', name: 'id',searchable:true},
            { data: 'nik', name: 'nik',searchable:true },
            { data: 'name', name: 'name',searchable:true },
            { data: 'role', name: 'role',searchable:true },
            { data: 'branch.branch_name', name: 'branch_name',searchable:true },
            { data: 'tidak_puas', name: 'tidak_puas',searchable:false},
            { data: 'biasa', name: 'biasa',searchable:false },
            { data: 'puas', name: 'puas',searchable:false },
            { data: 'total', name: 'total',searchable:false },
        ],
          drawCallback: function () {
            var api = this.api();
            $( api.column(5).footer() ).html(
                    numeral(api.column( 5, { page:'current' } ).data().sum()).format('0,0')
            );
            $( api.column(6).footer() ).html(
                    numeral(api.column( 6, { page:'current' } ).data().sum()).format('0,0')
            );
            $( api.column(7).footer() ).html(
                    numeral(api.column( 7, { page:'current' } ).data().sum()).format('0,0')
            );
            $( api.column(8).footer() ).html(
                    numeral(api.column( 8, { page:'current' } ).data().sum()).format('0,0')
            );
        }
    })
    $(".dataTables_filter").find('label').hide();
    $(".dataTables_filter").append("<div class='row' id='join'><form action='{{route('ReportUser::exportIndex')}}'>"+
                    "<input type='text' name='datefrom' value='' placeholder='From' id='date-from' class='date-range' style='max-width:220px;'>"+
                    "&nbsp;&nbsp;"+
                    "<label><input type='text' class='' id='myInputTextField' placeholder='Type here..' aria-controls='report-table'></label>"+
                    "&nbsp;&nbsp;"+
                    "<button type='button' class='btn btn-primary' id='search'>Search</button>"+
                    "&nbsp;&nbsp;"+
                    @permission('export_excel')
                    "<button type='submit' class='btn btn-success'>Excel <b><i class='icon-file-spreadsheet'></i></b></button>"+
                    @endpermission
                    "&nbsp;&nbsp;"+
                    @permission('export_pdf')
                    "<button type='submit' class='btn btn-danger' name='pdf'>PDF <b><i class='icon-file-pdf'></i></b></button>"+
                    @endpermission
                    "</div>"+
                    "</form>");

    $('#date-from').daterangepicker({
        opens: 'right',
        autoUpdateInput: false,
        locale: {
            format: 'DD MMM YYYY H:mm'
        }
    }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });

    $('input[name="datefrom"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD MMM YYYY') + ' - ' + picker.endDate.format('DD MMM YYYY'));
    });

    $('input[name="datefrom"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    $('#search').on('click', function(e) {
        table.draw();
        e.preventDefault();
    });

    $('#myInputTextField').keyup(function(){
      table.search($(this).val()).draw() ;
    })
</script>
@endpush
@section('globaldatatables')
@include('global.datatables-report')
@endsection