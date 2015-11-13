<?php
require '../dbconnect.php';
$conn = dbconnect();

$product_name = $_REQUEST["product_name"];
$product_price = $_REQUEST["product_price"];


$sql = "INSERT INTO shopdb.products (name, price)
        VALUES ('$product_name', $product_price);";

if ( $conn->query($sql) === TRUE) {
    echo "The product was successfully added";
} else {
    echo "Insertion failed: " . $conn->error;
}
$conn->close();
?>
