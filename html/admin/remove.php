<?php
$servername = "localhost";
$username = "nilfit-3";
$password = "nilfit-3";

// Create connection
$conn = mysqli_connect($servername, $username, $password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$product_id = $_REQUEST["product_id"];

$sql = "USE nilfit3db;";
$conn->query($sql);
$sql = "DELETE FROM products WHERE product_id='$product_id'" ;
if ( $conn->query($sql)) {
    echo "Product removed";
} else {
    echo "Error: " . $conn->error;
}



$conn->close();
?>
