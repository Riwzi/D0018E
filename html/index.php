<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>e-buy</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src='js/main.js'></script>
</head>

<body>
<?php
include './menu.php';
?>
<table>
<tr>
    <th>Product</th>
    <th>Price</th>
    <th></th>
</tr>
<?php
function displayProduct($row){
    echo    "<tr>
                <td>" . $row["product_name"] . "</td>
                <td>" . $row["product_price"] . "</td>
                <td><input type='button' value='Add'
                    onclick='basket_add(" . $row["product_id"] . ")'>
                </td>
            </tr>";
}

require 'product_list.php';
displayProductList(1, 'displayProduct');
?>
</table>
<p id="responseText"></p>
</body>
</html> 
