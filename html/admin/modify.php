<?php
require '../dbconnect.php';
$conn = dbconnect();
$product_id = $_POST["product_id"];
$product_name = $_REQUEST["product_name"];
$product_price = $_REQUEST["product_price"];
$product_desc = $_REQUEST["product_desc"];
$product_stock = $_REQUEST["product_stock"];

$sql = "UPDATE shopdb.Products
        SET product_name='$product_name', product_price=$product_price,
        product_desc='$product_desc', product_stock=$product_stock
        WHERE product_id=$product_id";

if ( $conn->query($sql) === TRUE) {
    echo "The product was successfully modified";
} else {
    echo "Failed to execute command: " . $sql . "\nError message:". $conn->error;
}
$conn->close();
?>
