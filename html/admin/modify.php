<?php
require '../dbconnect.php';
$conn = dbconnect();

$product_id = $_POST["product_id"];
$product_name = $_REQUEST["product_name"];
$product_price = $_REQUEST["product_price"];
$product_desc = $_REQUEST["product_desc"];
$product_stock = $_REQUEST["product_stock"];


$stmt = $conn->prepare("UPDATE shopdb.Products
        SET product_name=?, product_price=?, product_desc=?, product_stock=?
        WHERE product_id=?;");
$stmt->bind_param("sisii", $product_name, $product_price, $product_desc, $product_stock, $product_id);
if ($stmt->execute() == TRUE) {
    echo "The product was successfully modified";
} else {
    echo "Failed to execute command: " . $sql . "\nError message:". $conn->error;
}
$stmt->close();
$conn->close();
?>
