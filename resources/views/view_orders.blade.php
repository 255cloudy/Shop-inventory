@extends('layout.base')
@section('main-content')
    <!-- /.modal -->
    {{--    end delete modal--}}
    <!-- update  Modal -->
    <div class="modal fade" id="product-update-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="update_modal_title">Update entry </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="product-update-form" method="POST" >
                        @csrf
                        <input type="text" name="id" value="{{ old("id") }}"  style="display: none" id="entry-id">
                        <div class="card-body">
                            <div class="form-group" data-select2-id="29">
                                <label for="product">Product</label>
                                <select id="product" name="product_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}" data-select2-id="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                @error('product', "update")
                                <span id="exampleInputEmail1-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" value="{{ old("price") }}"  name="price" class="form-control @error('price', "update") is-invalid invalid-update @enderror" id="price" placeholder="name">
                                @error('price', "update")
                                <span id="exampleInputEmail1-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
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


{{--    <a class="btn btn-app" id="add-btn">--}}
{{--        <i class="fas fa-plus"></i> Add Entry--}}
{{--    </a>--}}
    {{--    end of add--}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" id="orders-header">
                    <h3>Entries for order: #{{ $order->id }}</h3>
                    <h3 id="order-total">Totaling</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline collapsed">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>product</th>
                            <th>qty</th>
                            <th>price(ksh)</th>
                            <th>total(ksh)</th>
                            <th>updated </th>
                            <th>actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($entries as $entry)
                            <tr>
                                <td>
                                    {{ $entry->id }}
                                </td>
                                <td>
                                    {{ $entry->product->name }}
                                </td>
                                <td>
                                    {{$entry->qty}}
                                </td>
                                <td>
                                    {{ number_format($entry->retail_price)}}
                                </td>
                                <td>
                                    {{number_format($entry->retail_price * $entry->qty)}}
                                </td>
                                <td>
                                    @php
                                        $date = new Carbon($entry->updated_at);
                                        echo $date->tz("EAT")->toDayDateTimeString()
                                    @endphp
                                </td>
                                <td>
                                    <button type="button" id="update-button" data-toggle="modal" data-target="#product-update-modal" onclick="updateProduct(objectLookup({{ $entry->id }}))" class="btn btn-block btn-primary btn-sm">Update</button>
                                    <button type="button" data-toggle="modal" data-target="#product-delete-modal" onclick="deleteProduct(objectLookup({{ $entry->id }}, {{ $order->id}}))" class="btn btn-block btn-danger btn-xs">Delete</button>
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
@section('extra-css')
    <style>
        #orders-header {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    </style>
@endsection()
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
        let entries = @json($entries);
        function  objectLookup(id){
            for(entry of entries){
                if(parseInt(entry.id) === parseInt(id)){
                    return entry
                }
            }
        }
        const updateProductUrl = "update";
        const deleteProductUrl = "delete";
        const url = window.location.host.concat("/order", )
        function updateProduct(entry){
            const url = "/order/".concat("update/", entry.id);
            $("#product-update-form").attr("action", url);
            console.log("updating");
            let products = {{Js::from($products)}};
            $.each(products, function ($index, $element){

            });
            $("#product").children().each(function(index, element){
                if(element.value == entry.product_id){
                    element.selected="selected";
                }
            })
            $("#qty").attr("value", entry.qty);
            $("#price").attr("value", entry.retail_price);
            $("#entry-id").attr("value", entry.id);

        }

        function deleteProduct(product, order){
            let baseUrl  = "/order/delete/"+order+"/";
            window.location.assign(baseUrl.concat(product.id));
        }
        if($(".invalid-update").length>0){
            $("#product-update-modal").modal().show();
        };
        let table = $("#example1").DataTable({
            "responsive": true, "lengthChange": true, "pageLength":5, "autoWidth": false,"ordering": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });
        table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        let colTotal =0;
        for(let i=0; i<table.column(4).data().length; i++){
            colTotal +=  Number(table.column(4).data()[i].replace(",", ""));
        }
        let currency = new Intl.NumberFormat('en-US', {style: 'currency', currency: "KES"})
        colTotal = currency.format(colTotal);
        $("#order-total").text("TOTAL: " + colTotal);
    </script>
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
@endsection
