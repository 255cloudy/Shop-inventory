
@extends('layout.base')
@section('main-content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Filter Data Aggregates</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="/report/sales" id="filter-form" method="POST">
                            @csrf
                          <div class="row">
                              <div class="col-lg-3">
                                  <div class="form-group">
                                      <label for="day">Day</label>
                                      <select name="day" id="day" class="custom-select">
                                          <option value="any">Any</option>
                                          @for($i = 0; $i < 7; $i++)
                                              <option value="{{ $i }}"> {{ $days[$i] }}</option>
                                          @endfor
                                      </select>
                                  </div>
                              </div>
                              <div class="col-lg-3">
                                  <div class="form-group">
                                      <label for="month">month</label>
                                      <select name="month" id="month" class="custom-select">
                                          <option value="any">Any</option>
                                          @for($i = 0; $i < 12; $i++)
                                              <option value="{{ $i}}"> {{ $months[$i] }}</option>
                                          @endfor
                                      </select>
                                  </div>
                              </div>
                              <div class="col-lg-3">
                                  <div class="form-group">
                                      <label for="year">Year</label>
                                      <select name="year" id="year" class="custom-select">
                                          <option value="{{ Carbon::now()->year }}">{{ Carbon::now()->year }}</option>
                                          <option value="any">Any</option>
                                          @for($i = 1;$i < 10; $i++)
                                              <option value="{{ Carbon::now()->year-$i }}"> {{ Carbon::now()->year-$i }}</option>
                                          @endfor
                                      </select>
                                  </div>
                              </div>
                              <div class="col-lg-3">
                                 <div class="form-group">
                                     <button id="filter-btn" type="submit" class="btn btn-lg btn-primary">Filter</button>
                                 </div>
                              </div>
                          </div>
                        </form>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Filter by specific date</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="/report/sales/date" id="filter-form-date" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Date:</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" name="date" class="form-control datetimepicker-input" data-target="#reservationdate">
                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                    <h3>Sales</h3>
                    @if($isQueried === "aggregate")
                        <span>Day: {{ $query["day"]}}</span>
                        <span>Month: {{ $query["month"]}}</span>
                        <span>Year: {{ $query["year"]}}</span>
                    @endif
                    @if($isQueried === "date")
                        <span>Date: {{ $query}}</span>
                    @endif

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline collapsed">
                        <thead>
                        <tr>

                            <th>Name</th>
                            <th>Total sales</th>
                            <th>Pcs sold </th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($product_data as $product)
                            @if($product->pcs > 0)
                            <tr>
                                <td>
                                    {{ $product->product }}
                                </td>
                                <td>
                                    {{ $product->total }}
                                </td>
                                <td>
                                    {{$product->pcs}}
                                </td>
                            </tr>
                            @endif
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
                    $('#reservationdate').datetimepicker({
                        format: "Y-M-D"
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
