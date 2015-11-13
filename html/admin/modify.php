<?php
require '../dbconnect.php';
$conn = dbconnect();
$product_id = $_POST["product_id"];
$product_name = $_REQUEST["product_name"];
$product_price = $_REQUEST["product_price"];

$sql = "UPDATE shopdb.products
        SET name='$product_name',price=$product_price
        WHERE product_id=$product_id";

if ( $conn->query($sql) === TRUE) {
    echo "The product was successfully modified";
} else {
    echo "Failed: " . $conn->error;
}
$conn->close();
?>
