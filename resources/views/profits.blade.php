@extends('layout.base')
@section('main-content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Filter Report by Date</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="/report/profit" id="filter-form-date" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>From:</label>
                                        <div class="input-group date" id="reservationdatefrom" data-target-input="nearest">
                                            <input type="text" value="{{ $from }}" name="from" class="form-control datetimepicker-input
                                            @error("from")
                                                is-invalid
                                            @enderror
                                            " data-target="#reservationdatefrom">
                                            <div class="input-group-append" data-target="#reservationdatefrom" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                            @error('from')
                                            <span id="exampleInputEmail1-error" class="error invalid-feedback">{{ $errors->first('from') }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>To:</label>
                                        <div class="input-group date" id="reservationdateto" data-target-input="nearest">
                                            <input type="text" value="{{ $to }}" name="to" class="form-control datetimepicker-input
                                            @error('to')
                                                is-invalid
                                            @enderror" data-target="#reservationdateto">
                                            <div class="input-group-append" data-target="#reservationdateto" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                            @error('to')
                                            <span id="exampleInputEmail1-error" class="error invalid-feedback">{{ $errors->first('to') }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                @error('dates')
                                    <span id="exampleInputEmail1-error" class="error invalid-feedback">{{ $errors->first("dates") }}</span>
                                @enderror
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <button id="filter-btn-date" type="submit" class="btn btn-lg btn-primary">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" id="card-header">
                    <h3>Profit/loss Report</h3>
                    <h4> Sales: {{ $sales_total }} </h4>
                    <h4>Expenses: {{ $expenses }}</h4>
                    <h4>Profit {{ $profit_total }}</h4>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline collapsed">
                        <thead>
                        <tr>

                            <th>Name</th>
                            <th>Pcs Sold</th>
                            <th>Profit </th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($product_data as $product)
                            <tr>
                                <td>
                                    {{ $product["product"] }}
                                </td>
                                <td>
                                    {{ $product["pcs"] }}
                                </td>
                                <td>
                                    {{$product["profit"]}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
    <!-- /.row -->
@endsection
@section("extra-js")
    <script src={{ asset("js/plugins/datatables/jquery.dataTables.min.js") }}></script>
    <script src={{ asset("js/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") }}></script>
    <script src={{ asset("js/plugins/datatables-responsive/js/dataTables.responsive.min.js") }}></script>
    <script src={{ asset("js/plugins/datatables-responsive/js/responsive.bootstrap4.min.js") }}></script>
    <script src={{ asset("js/plugins/datatables-buttons/js/dataTables.buttons.min.js") }}></script>
    <script src={{ asset("js/plugins/datatables-buttons/js/buttons.bootstrap4.min.js") }}></script>
    <script src={{ asset("js/plugins/jszip/jszip.min.js") }}></script>
    <script src={{ asset("js/plugins/pdfmake/pdfmake.min.js") }}></script>
    <script src={{ asset("js/plugins/pdfmake/vfs_fonts.js") }}></script>
    <script src={{ asset("js/plugins/datatables-buttons/js/buttons.html5.min.js") }}></script>
    <script src={{ asset("js/plugins/datatables-buttons/js/buttons.print.min.js") }}></script>
    <script src={{ asset("js/plugins/datatables-buttons/js/buttons.colVis.min.js") }}></script>
    <!-- date-range-picker -->
    {{--            <script src={{ asset("js/plugins/daterangepicker/daterangepicker.js") }}></script>--}}
    <script src={{ asset("js/plugins/moment/moment.min.js")}}></script>
    <script src= {{ asset("js/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js")}}></script>
    <script>
        //Date picker
        let form =   $("#filter-form");
        let formDate =   $("#filter-form-date");
        form.attr('action', "/report/sales");
        $(function () {
            $('#reservationdatefrom').datetimepicker({
                format: 'Y-M-D'
            });
            $('#reservationdateto').datetimepicker({
                format: 'Y-M-D'
            });
            $("#example1").DataTable({
                "responsive": true, "lengthChange": true, "pageLength":5, "autoWidth": false,"ordering": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
@section("extra-css")
    <style>
        #card-header {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    </style>
    <link rel="stylesheet" href={{ asset("js/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css")}}>
    <link rel="stylesheet" href={{ asset("js/plugins/daterangepicker/daterangepicker.css") }}>
@endsection
