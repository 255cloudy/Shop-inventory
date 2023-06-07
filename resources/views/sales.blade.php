@extends("layout.base")
@section("main-content")
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Search Product</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline collapsed">
                        <thead>
                        <tr>
                            <th>product</th>
                            <th>price</th>
                            <th>qty</th>
                            <th>actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    {{ $product->name }}
                                </td>
                                <td>
                                    {{ $product->price->sale_price}}
                                </td>
                                <td>
                                    {{$product->stock->qty}}
                                </td>
                                <td>
                                    <button type="button" id="update-button" data-toggle="modal" data-target="#product-update-modal" onclick="insertEntry(objectLookup({{ $product->id }}))" class="btn btn-block btn-primary btn-sm">add</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header" id="entries-header">
                    <h4 id="entry-number">Entries</h4>
                    <h4 id="entry-total">Total:</h4>
                    <button type="button" onclick="submitEntries()" id="submit-entries" class="btn btn-primary">Submit</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example2" class="table table-bordered table-striped dataTable dtr-inline collapsed">
                        <thead>
                        <tr>
                            <th>product</th>
                            <th>qty</th>
                            <th>price(ksh)</th>
                            <th>total(ksh)</th>
                        </tr>
                        </thead>
                        <tbody id="table_body">
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
    <form action="" method="POST" id="entry-submit-form">
        @csrf
        <input type="text" name="data" id="data-input">
    </form>
@endsection

@section('extra-css')
    <link rel="stylesheet" href="{{ asset("jquery-editable/css/jquery-editable.css") }}">
    <style>
        #entries-header {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        #entry-submit-form {
            display:none
        }
    </style>
@endsection()

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
    <script src={{ asset("jquery-editable/js/jquery-editable-poshytip.js") }}></script>
    <script>
        let prices = @json($prices);
        let products = @json($products);
        function  objectLookup(id){
            for(product of products){
                if(parseInt(product.id) === parseInt(id)){
                    return product
                }
            }
        }
        {{--let stock = {{!! $stock->toJson() !!}};--}}
        let table1 = $("#example1").DataTable({
            "responsive": true, "lengthChange": true, "pageLength":5, "autoWidth": false,"ordering":false,
            "buttons": ["excel", "pdf", "print", "colvis"]
        });
        table1.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        let table2 = $("#example2").DataTable({
            "responsive": true, "lengthChange": true, "pageLength":20, "autoWidth": false,"ordering":false,
            "buttons": ["excel", "pdf", "print", "colvis"],
            "editable": true
        });
        table2.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        console.log(table2);
        $("#hamburger-menu").trigger("click");
        $("#full-screen").trigger("click");
        let entry_number = 0;
        let numberOfEntries =1;
        let qtyIndex = 1;
        let priceIndex = 2;
        function recalculateTotal(newValue, rowId, colIndex){
            let data = table2.row(rowId).data();
            console.log(rowId);
            data[colIndex] = newValue;
            let total = data[qtyIndex] * data[priceIndex];
            table2.row(rowId).data([
                data[0], data[qtyIndex], data[priceIndex], total
            ]).draw();
            // console.log(table2.row(rowId-1).data());
            updateTotal();
        }
        function entryExists(product){
            let exists = false;
            $.each(allEntries, function(){
                // console.log("product id: "+product.id.toString() + " entry id: "+ this.product);
                if (this.product===product.id) {
                    exists = true;
                }
            })
            return exists;
        }
        let allEntries = [];
        function insertEntry(product){
            if(entryExists(product)){
                alert("Entry :"+ product.name+" already exists adjust qty")
            }else {

                // push all the entries
                let price = getPrice(product);
                console.log(price);
                let total = price*1
                let data = [product.name,1, price, total];
                // console.log( table2.row(0).data());
                table2.row(1);
                let node = table2.row.add(data).node();
                $(node).attr("data-row-number", entry_number);
                $(node).attr("data-product-id", product.id);
                table2.draw();
                let children = $("tr[data-row-number]").each(
                    function () {
                        let rowNo = $(this).attr("data-row-number");
                        let children = $(this).children();
                        $(children[qtyIndex]).editable({
                            type: 'number',
                            mode: 'inline',
                            onblur: 'submit',
                            success: function(response, newValue){recalculateTotal(newValue,rowNo, qtyIndex)}
                        });
                        $(children[priceIndex]).editable({
                            type: 'number',
                            mode: 'inline',
                            onblur: 'submit',
                            success: function(response, newValue){recalculateTotal(newValue, rowNo, priceIndex)}
                        })
                    }
                );
                updateEntries(entry_number);
                console.log(product.id);
                allEntries.push({
                    "product": product.id,
                    "qty": 1,
                    "price": getPrice(product)
                });
                entry_number++;
                numberOfEntries++;
                updateTotal()
            }
        }
        function getPrice(product){
            console.log(prices);
           for(price of prices){
               console.log(price);
               if(parseInt(price.product_id) === parseInt(product.id)){
                   return price.sale_price
               }
           }
        }

        function updateTotal (){
            let colTotal = table2.column(3).data().reduce(
                function (a, b){return a+b}
            );
            const Kes = new Intl.NumberFormat('en-US', {style: 'currency', currency: "KES"});
            colTotal = Kes.format(colTotal);
            $("#entry-total").text("Total: ".concat(colTotal));
        }
        function updateEntries(entry_number){
            let count = entry_number+1;
            $("#entry-number").text("Entries: ".concat(count.toString()));
        }
        function submitEntries(){
            // console.log(allEntries);
            let rowData = table2.rows().data()
            console.log(rowData);
            for(let i=0; i<rowData.length; i++){
                allEntries[i].qty = table2.row(i).data()[qtyIndex];
                allEntries[i].price = table2.row(i).data()[priceIndex];
            }
            let orderNumber = window.location.pathname.split("/")[3];
            $("#entry-submit-form").attr("action", "/sales");
            $("#data-input").attr("value", JSON.stringify(allEntries));
           console.log( $("#data-input").attr("value"));
            $("#entry-submit-form").trigger("submit");
        }
    </script>

@endsection
