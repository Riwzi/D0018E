$(document).ready(function(){
    $("#submit").attr("onclick", "addProductSubmit();");
});

function addProductSubmit(){
    $("#responseText").load("add.php",
        {
            product_name: $("#product_name").val(),
            product_price: $("#product_price").val()
        }
        //todo callback that displays the new product
    );
}

function modifyProductSubmit(){
    $("#responseText").load("modify.php",
        {
            product_id: $("#product_id").val(),
            product_name: $("#product_name").val(),
            product_price: $("#product_price").val()
        }
        //todo callback that displays the modified product
    );
    $("#form_title").text("Add product");
    $("#product_id").val("");
    $("#product_name").val("");
    $("#product_price").val("");
    $("#submit").attr("onclick", "addProductSubmit();");
}

function removeProduct(product_id){
    $("#responseText").load("remove.php",
        {product_id: product_id},
        function(){
            $("#p" + product_id).remove();
        }
    );
}

function modifyProduct(product_id){
    $("#form_title").text("Modify product " + product_id);
    $("#product_id").val(product_id);
    $("#product_name").val("Enter name here"); //todo use the name of the product instead
    $("#product_price").val("Enter price here");
    $("#submit").attr("onclick", "modifyProductSubmit();");
}
