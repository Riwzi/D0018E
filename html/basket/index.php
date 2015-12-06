<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>e-buy</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src='basket.js'></script>
</head>

<body>
<?php
include '../menu.php';
?>
<table>
<tr>
    <th>Product</th>
    <th>Price</th>
    <th>Count</th>
</tr>
<?php
function displayProduct($row, $count){
    // each tr tag (row) has an id of p followed by the product id
    // example: product_id 333 will have a row with id='p333'
    echo    "<tr id='p" . $row["product_id"] . "'>
                <td>" . $row["product_name"] . "</td>
                <td>" . $row["product_price"] . "</td>
                <td>" . $count . "</td>
                <td><input type='button' value='Remove'
                    onclick='basket_remove(" . $row["product_id"] . ")'>
                </td>
            </tr>";
}
require '../dbconnect.php';
$conn = dbconnect();
$conn->autocommit(false);
$conn->begin_transaction();
foreach($_SESSION['basket'] as $product_id => $count){
    $sql = 
    "SELECT *
    FROM shopdb.Products
    WHERE product_id=" .$product_id.";";
    $result = $conn->query($sql);
    //this should only be true if the product id is not in the database
    if ( $result->num_rows === 0) {
        die('unable to find product with id ' . $product_id . ' in the database');
    }
    $row = $result->fetch_assoc();
    displayProduct($row, $count);
}
$conn->commit();
//close database connection
$conn->close();
?>
</table>
<p id="responseText"></p>

<a href='/order/'><button>Place order</button></a>
</body>
</html> 
