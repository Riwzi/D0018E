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
                <td>" . $row["product_name"] . "</td>
                <td>" . $row["product_price"] . "</td>
                <td><input type='button' value='Buy!'
                    onclick='purchase(" . $row["product_id"] . ")'>
                </td>
            </tr>";
}

require 'product_list.php';
displayProductList(1, 'displayProduct');
?>
</table>

</body>
</html> 
