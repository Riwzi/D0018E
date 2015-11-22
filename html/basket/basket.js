function basket_remove(product_id){
    $("#responseText").load("/basket/remove.php",
        {product_id: product_id},
        function(){
            $("#p" + product_id).remove();
        }
    );
}
