@extends('layout.base')
@section('main-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" id="card-header">
                    <h3>Sales</h3>
                    <h3 id="stock-total">Total</h3>
                </div>
                <!-- /.card-header -->
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline collapsed">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>updated </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sales as $sale);
                            <tr>
                                <td>
                                    {{ $sale->id }}
                                </td>
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
    <script>
        $(function() {
            if($(".invalid-update").length>0){
                $("#product-update-modal").modal().show();
            }
        })

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
            console.log(colTotal);
        }
        let currency = new Intl.NumberFormat('en-US', {style: 'currency', currency: "KES"})
        colTotal = currency.format(colTotal);
        $("#stock-total").text("Total: " + colTotal);
    </script>
@endsection
