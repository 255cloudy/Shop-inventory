@extends('layout.base')
@section('main-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" id="card-header">
                    <h3>The Purchase Price For the Following Items Has Changed</h3>
                    <button class="btn btn-primary" onclick="submitData()" id="confirm-changes"> Confirm </button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline collapsed">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>product_id</th>
                            <th>From</th>
                            <th>To </th>
                            <th> Change </th>
                            <th>current selling price</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($changes as $change)
                            <tr id="{{ $change->product->id }}">
                                <td>
                                    {{ $change->product->name}}
                                </td>
                                <td>
                                    {{ $change->product->id}}
                                </td>
                                <td>
                                    {{ $change->from}}
                                </td>
                                <td>
                                    {{$change->to}}
                                </td>
                                <td> {{  $change->to - $change->from }}</td>
                                <td class="editable" data-id="{{$change->product->id}}" >{{ $change->product->price->sale_price }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button id="confirm-viewed" class="btn btn-lg btn-success">
                        Proceed
                    </button>
                </div>
            </div>
        </div>
        <form style="display: none" action="" method="post" id="changes-form">
           @csrf
            <input type="text" name="entries" id="entries-data">
        </form>
    </div>
@endsection
@section("extra-css")
    <link rel="stylesheet" href="{{ asset("jquery-editable/css/jquery-editable.css") }}">
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
    <script src={{ asset("jquery-editable/js/jquery-editable-poshytip.js") }}></script>
    <script>
        let updates = [];
        let table = $("#example1").DataTable({
            "responsive": true, "lengthChange": true, "pageLength":50, "autoWidth": false,"ordering": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "editable": true,
            "columnDefs": {
                "target": 1,
                "visible": false,
                "searchable": false
            }
        });
        // make the cells editable
        $(".editable").each(
            function (){
                $(this).editable({
                    type: 'number',
                    mode: 'inline',
                    onblur: 'submit',
                    success: function (response, newvalue){
                        const spIndex = 5;
                        const id = $(this).parent().attr("id");
                        console.log(id);
                        table.row('#'+id).data()[spIndex] = newvalue;
                    }
                })
            }
        )
        function submitData(){
            const idIndex = 1;
            const spIndex = 5;
            $(table.rows().data()).each(
                function (index){
                    updates.push(
                        {
                            product: this[idIndex],
                            sp: this[spIndex]
                        }
                    );
                }
            )
            let updates_string = JSON.stringify(updates);
            $("#entries-data").attr("value", updates_string);
            $("#changes-form").trigger("submit");
        }
        table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#confirm-viewed').on("click", function (){
            let url = "/order/all";
            window.location.assign(url);
        })
    </script>
@endsection
