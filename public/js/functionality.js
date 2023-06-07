const updateProductUrl = "update";
const deleteProductUrl = "delete";
const createProductUrl = ""
function updateProduct(product){

    const form = $("#product-update-form");
    const newUrl = updateProductUrl.concat("/", product.id);
    form.attr("action", newUrl);
    $("#product-name")[0].value = product.name;
    $("#product-description")[0].value = product.description;
}

function createProduct(product){

}
function deleteProduct(product){

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
