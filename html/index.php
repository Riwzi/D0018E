<!DOCTYPE html>
<html>
<head>
<title>e-buy</title>
<script src='js/main.js'></script>
</head>

<body>
<table>
<tr>
    <th>Product</th>
    <th>Price</th>
    <th></th>
</tr>
<?php
function displayProduct($row){
    echo    "<tr>
                <td>" . $row["name"] . "</td>
                <td>" . $row["price"] . "</td>
                <td><input type='button' value='Buy!'
                    onclick='purchase(" . $row["product_id"] . ")'>
                </td>
            </tr>";
}

$servername = "localhost";
$username = "nilfit-3";
$password = "nilfit-3";

// Create connection
$conn = mysqli_connect($servername, $username, $password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



$sql = "USE nilfit3db;";
$conn->query($sql);
$sql = "SELECT product_id, name, price FROM products";
$result = $conn->query($sql);
if ( $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        displayProduct($row);
    }
} else {
    echo "No products found";
}



$conn->close();
?>
</table>

</body>
</html> 
