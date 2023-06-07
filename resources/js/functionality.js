
function updateProduct(product){
 let modal = $("#product-update-modal");
 let form = $("#product-update-form");
 form.attr("action", form.attr("action").concat("/", product.id));
 form.elements["name"].value = product.name;
 form.elements["description"].value = product.description;
}
function deleteProduct(product){

}
