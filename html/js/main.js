function basket_add(product_id){
    $("#responseText").load("../basket/add.php",
        {product_id: product_id}
    );
}

function product_search(search_string){
    //
}
