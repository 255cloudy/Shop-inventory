@extends('layout.base')
@section('main-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" id="card-header">
                    <h3>The Purchase Price For the Following Items Has Changed</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline collapsed">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>From</th>
                            <th>To </th>
                            <th> Change </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($changes as $change)
                            <tr>
                                <td>
                                    {{ $change->product->name}}
                                </td>
                                <td>
                                    {{ $change->from}}
                                </td>
                                <td>
                                    {{$change->to}}
                                </td>
                                <td> {{  $change->to - $change->from }}</td>
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

        let table = $("#example1").DataTable({
            "responsive": true, "lengthChange": true, "pageLength":5, "autoWidth": false,"ordering": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });
        table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#confirm-viewed').on("click", function (){
            let url = "/order/all";
            window.location.assign(url);
        })
    </script>
@endsection
