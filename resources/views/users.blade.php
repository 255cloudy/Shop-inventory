@extends('layout.base')
@section('main-content')
    @extends('layout.base')
    @section('main-content')
        <!-- update  Modal -->
        <div class="modal fade" id="product-update-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="update_modal_title">Update User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="product-update-form" method="POST" >
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="price">Username</label>
                                    <input type="text" value="{{ old("username") }}"  name="username" class="form-control @error("username") is-invalid invalid-update @enderror" id="username" >
                                    @error("username")
                                    <span id="exampleInputEmail1-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password"  name="password" class="form-control @error("password") is-invalid invalid-update @enderror" id="password" >
                                    @error("password")
                                    <span id="exampleInputEmail1-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
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
                        <h3>Price</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline collapsed">
                            <thead>
                            <tr>
                                <th>name</th>
                                <th>Super User</th>
                                <th>Updated</th>
{{--                                <th>actions</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        {{ $user->name}}
                                    </td>
                                    <td>
                                        {{ $user->su}}
                                    </td>
                                    <td>
                                        @php
                                            $date = new Carbon($user->updated_at);
                                            echo $date->tz("EAT")->toDayDateTimeString()
                                        @endphp
                                    </td>
{{--                                    <td>--}}
{{--                                        <button type="button" id="update-button" data-toggle="modal" data-target="#product-update-modal" onclick="updateProduct(objectLookup({{ $price->id }}),{{$price->product->id}})" class="btn btn-block btn-primary btn-sm">Update</button>--}}
{{--                                        --}}{{--                                    <button type="button" data-toggle="modal" data-target="#product-delete-modal" onclick="deleteProduct({{Js::from($order)}})" class="btn btn-block btn-danger btn-xs">Delete</button>--}}
{{--                                    </td>--}}
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
            let prices = @json($prices);
            function  objectLookup(id){
                for(price of prices){
                    if(parseInt(price.id) === parseInt(id)){
                        return price
                    }
                }
            }
            $(function() {
                if($(".invalid-update").length>0){
                    $("#product-update-modal").modal().show();
                }
            })

            function updateProduct(product, id){
                let url = "/price/update/"+product.id;
                $("#product-update-form").attr("action", url);
                console.log(product.sale_price);
                let title = "Update price for: " + getProductName(id);
                $("#update_modal_title").text(title);
                $("#price").attr("value", product.sale_price);
            }
            let table = $("#example1").DataTable({
                "responsive": true, "lengthChange": true, "pageLength":5, "autoWidth": false,"ordering": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            });
            table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        </script>
    @endsection
@endsection
