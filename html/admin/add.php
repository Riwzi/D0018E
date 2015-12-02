<?php
require '../dbconnect.php';
$conn = dbconnect();
$conn->autocommit(false);
$conn->begin_transaction();

$product_name = $_REQUEST["product_name"];
$product_price = $_REQUEST["product_price"];
$product_desc = $_REQUEST["product_desc"];
$product_stock = $_REQUEST["product_stock"];


$sql = "INSERT INTO shopdb.Products (product_name, product_price, 
                                     product_desc, product_stock)
        VALUES ('$product_name', $product_price, '$product_desc', $product_stock);";

if ( $conn->query($sql) === TRUE) {
    echo "The product was successfully added";
} else {
    echo "Insertion failed: " . $conn->error;
}
$conn->commit();
$conn->close();
?>
