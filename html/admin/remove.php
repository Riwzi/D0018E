<?php
require '../dbconnect.php';
$conn = dbconnect();

$product_id = $_REQUEST["product_id"];

$stmt = $conn->prepare("DELETE FROM shopdb.Products WHERE product_id=?;");
$stmt->bind_param("i", $product_id);
if ( $stmt->execute() == TRUE) {
    echo "Product removed";
} else {
    echo "Error: " . $conn->error;
}
$stmt->close();
$conn->close();
?>
