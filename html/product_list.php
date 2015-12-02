<?php
// Displays the requested page of the product list. Page 1 is the first page.
// $displayfn should be a function that outputs the data from
// one row of the table.
function displayProductList($page, $displayfn){
    require 'dbconnect.php';
    $conn = dbconnect();
    $conn->autocommit(false);
    $conn->begin_transaction();

    if ($page < 1){
        die("Product list page numbers can't be less than 1");
    } elseif ($page = 1){ //use the frontpage view
        $sql = "SELECT * FROM shopdb.FrontPageProducts";
        $result = $conn->query($sql);
        if ( $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $displayfn($row);
            }
        } else {
            echo "No products found";
        }
    } else {
        $sql = "SELECT product_id, product_name, product_price
                FROM shopdb.Products
                LIMIT " . ($page - 1) . ", 20;";
        $result = $conn->query($sql);
        if ( $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $displayfn($row);
            }
        } else {
            echo "No products found";
        }
    }
    $conn->commit();
    $conn->close();
}
?>
