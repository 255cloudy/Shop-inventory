@extends('layout.base')
@section('main-content')
    <!-- update  Modal -->
    <div class="modal fade" id="product-update-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="update_modal_title">Update stock </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="product-update-form" method="POST" >
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="asset-qty">qty</label>
                                <input type="number" value="{{ old("qty") }}" name="qty" class="form-control @error("qty", "update") invalid-update is-invalid @enderror " id="qty" placeholder=1>
                                @error('qty', "update")
                                <span id="exampleInputEmail1-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            @csrf
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{--    add a new element--}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" id="card-header">
                    <h3>Stock</h3>
                    <h3 id="stock-total">Valued at: </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline collapsed">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Buy Price </th>
                            <th> Value </th>
                            <th>Updated</th>
                            <th>actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($stocks as $stock)
                            <tr>
                                <td>
                                    {{ $stock->product->name}}
                                </td>
                                <td>
                                    {{ $stock->qty}}
                                </td>
                                <td>
                                    {{$stock->retail_price}}
                                </td>
                                <td>
                                    {{ number_format($stock->retail_price * $stock->qty) }}
                                </td>
                                <td>  @php
                                        $date = new Carbon($stock->updated_at);
                                        echo $date->tz("EAT")->toDayDateTimeString()
                                    @endphp
                                </td>
                                <td>
                                    <button type="button" id="update-button" data-toggle="modal" data-target="#product-update-modal" onclick="updateProduct(objectLookup({{ $stock->id }}), {{$stock->product->id}})" class="btn btn-block btn-primary btn-sm">Update</button>
                                    {{--                                    <button type="button" data-toggle="modal" data-target="#product-delete-modal" onclick="deleteProduct({{Js::from($order)}})" class="btn btn-block btn-danger btn-xs">Delete</button>--}}
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
        let products = @json($products);
        function getProductName(id){
            for (let product of products) {
                if(product.id === id){
                    return product.name;
                }
            }
        }
        let stocks = @json($stocks);
        function  objectLookup(id){
            for(stock of stocks){
                if(parseInt(stock.id) === parseInt(id)){
                    return stock
                }
            }
        }
        $(function() {
            if($(".invalid-update").length>0){
                $("#product-update-modal").modal().show();
            }
        })

        function updateProduct(product, id){
            let url = "/stock/update/"+product.id;
            $("#product-update-form").attr("action", url);
            let title = "Update Stock For: " + getProductName(id);
            $("#update_modal_title").text(title);
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

        $("#stock-total").text("Valued At: " + colTotal);
    </script>
@endsection
