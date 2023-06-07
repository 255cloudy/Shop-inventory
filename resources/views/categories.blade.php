@extends('layout.base')
@section('main-content')
    <!-- update  Modal -->
    <div class="modal fade" id="product-update-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="update_modal_title">Update Category </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="product-update-form" method="POST" >
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" value="{{ old("name") }}"  name="name" class="form-control @error('name') is-invalid @enderror" id="product-name" placeholder="name">
                                @error('name')
                                <span id="exampleInputEmail1-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" value="{{ old("description") }}" name="description" class="form-control @error("description") is-invalid @enderror " id="product-description" placeholder="description">
                                @error('description')
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
    {{--    create modal--}}
    <div class="modal fade" id="product-create-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="update_modal_title">Create</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="product-create-form" method="POST" action="/category">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" value="{{ old("name") }}"  name="name" class="form-control @error('name') is-invalid @enderror" id="product-name" placeholder="name">
                                @error('name')
                                <span id="exampleInputEmail1-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" value="{{ old("description") }}" name="description" class="form-control @error("description") is-invalid @enderror " id="product-description" placeholder="description">
                                @error('description')
                                <span id="exampleInputEmail1-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{--    end create modal--}}
    {{--    delete object modal--}}
    <div class="modal fade" id="product-delete-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="delete-text"> Are you sure you want to delete:  </p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="confirm-delete" class="btn btn-danger">Confirm</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    {{--    end delete modal--}}
    <a class="btn btn-app" id="add-btn" data-toggle="modal" data-target="#product-create-modal">
        <i class="fas fa-plus"></i> add
    </a>
    {{--    end of add--}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All categories</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline collapsed">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>name</th>
                            <th>description</th>
                            <th>updated </th>
                            <th>actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>
                                    {{ $category->id }}
                                </td>
                                <td>
                                    {{ $category->name }}
                                </td>
                                <td>
                                    {{$category->description}}
                                </td>
                                <td>
                                    @php
                                        $date = new Carbon($category->updated_at);
                                        echo $date->tz("EAT")->toDayDateTimeString()
                                    @endphp
                                </td>
                                <td>
                                    <button type="button" data-toggle="modal" data-target="#product-update-modal" onclick="updateProduct(objectLookup({{$category->id}}))" class="btn btn-block btn-primary btn-sm">Update</button>
                                    <button type="button" data-toggle="modal" data-target="#product-delete-modal" onclick="deleteProduct(objectLookup({{$category->id}}))" class="btn btn-block btn-danger btn-xs">Delete</button>
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
@section('extra-js')
    <script>
        const updateProductUrl = "update";
        const deleteProductUrl = "delete";
        let categories =  @json($categories);
        function  objectLookup(id){
            for(category of categories){
                if(parseInt(category.id) === parseInt(id)){
                    return category
                }
            }
        }
        function updateProduct(product){
            const form = $("#product-update-form");
            const newUrl = updateProductUrl.concat("/", product.id);
            form.attr("action", newUrl);
            $("#product-name")[0].value = product.name;
            $("#product-description")[0].value = product.description;
        }

        function deleteProduct(product){
            $("p#delete-text").text("Are you sure you want to delete: ". concat(product.name));
            $("#confirm-delete").on("click", function () {
                window.location.assign( "delete/".concat(product.id));
            })
        }
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": true, "pageLength":5, "autoWidth": false,"ordering": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
        $(function() {
            if($(".is-invalid").length>0){
                $("#add-btn").click();
            }
        })

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
