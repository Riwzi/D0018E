<?php
require '../dbconnect.php';
$conn = dbconnect();
$conn->autocommit(false);
$conn->begin_transaction();

$product_id = $_REQUEST["product_id"];

$sql = "DELETE FROM shopdb.Products WHERE product_id='$product_id'" ;
if ( $conn->query($sql)) {
    echo "Product removed";
} else {
    echo "Error: " . $conn->error;
}
$conn->commit();
$conn->close();
?>
