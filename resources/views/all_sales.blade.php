@extends('layout.base')
@section('main-content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Filter by  date Range</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="filtered" id="filter-form-date" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4">
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
                                <div class="col-lg-4">
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
                                <div class="col-lg-4">
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
                    <h3>Sales  {{ $today }}</h3>
                    <h3 id="stock-total">Total</h3>
                </div>
                <!-- /.card-header -->
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline collapsed">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>updated </th>
                            @if(Auth::user()->su)
                                <th>actions</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sales as $sale);
                            <tr>
                                <td>
                                    {{ $sale->product->name }}
                                </td>
                                <td>
                                    {{$sale->qty}}
                                </td>
                                <td>
                                    {{$sale->sale_price}}
                                </td>
                                <td>
                                    {{$sale->total}}
                                </td>
                                <td>
                                    @php
                                        $date = new Carbon($sale->updated_at);
                                        echo $date->tz("EAT")->toDayDateTimeString()
                                    @endphp
                                </td>
                                @if(Auth::user()->su)
                                    <td>
                                        <button type="button"   onclick="deleteSale({{$sale->id}})" class="btn btn-block btn-danger btn-sm">reverse</button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
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
@section('extra-js')
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
    <script src={{ asset("js/plugins/moment/moment.min.js")}}></script>
    <script src= {{ asset("js/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js")}}></script>
    <script>
        $(function() {
            if($(".invalid-update").length>0){
                $("#product-update-modal").modal().show();
            }
                $('#reservationdatefrom').datetimepicker({
                    format: 'Y-M-D'
                });
                $('#reservationdateto').datetimepicker({
                    format: 'Y-M-D'
                });
        }
        );
        function deleteSale(url){
            let strurl =url.toString();
            let where = `/sales/reverse/${strurl}`;
            window.location.replace(where);
        }
        function updateProduct(product){
            let url = "/stock/update/"+product.id;
            $("#product-update-form").attr("action", url);
            $("#qty").attr("value", product.qty);
        }
        let table = $("#example1").DataTable({
            "responsive": true, "lengthChange": true, "pageLength":5, "autoWidth": false,"ordering": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });
        table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        let colTotal =0;
        for(let i=0; i<table.column(3).data().length; i++){
            console.log();
            colTotal +=  Number(table.column(3).data()[i].replace(",", ""));
        }
        let currency = new Intl.NumberFormat('en-US', {style: 'currency', currency: "KES"})
        colTotal = currency.format(colTotal);
        $("#stock-total").text("Total: " + colTotal);
    </script>
@endsection


