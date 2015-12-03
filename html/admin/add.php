<?php
require '../dbconnect.php';
$conn = dbconnect();

$product_name = $_REQUEST["product_name"];
$product_price = $_REQUEST["product_price"];
$product_desc = $_REQUEST["product_desc"];
$product_stock = $_REQUEST["product_stock"];

$stmt = $conn->prepare("INSERT INTO shopdb.Products (product_name, product_price, 
                                     product_desc, product_stock)
        VALUES (?, ?, ?, ?);");
$stmt->bind_param("sisi", $product_name, $product_price, $product_desc, $product_stock);

if ( $stmt->execute() == TRUE) {
    echo "The product was successfully added";
} else {
    echo "Insertion failed: " . $conn->error;
}
$stmt->close();
$conn->close();
?>
