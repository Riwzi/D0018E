<!DOCTYPE html>
<html>
<head>
<title>e-buy</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src='js/main.js'></script>
<script src='admin.js'></script>
</head>

<body>
<h1 id='form_title'>Add product</h1>
<form id='product_form' action='index.php' method='post'>
    Product name:<br>
    <input type='text' id='product_name' name='product_name'><br>
    Price:<br>
    <input type='number' id='product_price' name='product_price'><br>
    Description (max 255 characters):<br>
    <textarea rows='4' cols='52' id='product_desc' name='product_desc'></textarea><br>
    Stock:<br>
    <input type='number' id='product_stock' name='product_price'><br>
    <input type='hidden' id='product_id' name='product_id' value=''>
    <input type='button' id='submit' value='Submit'>
</form>

<p id="responseText"></p>

<table>
<tr>
    <th>Product</th>
    <th>Price</th>
    <th></th>
</tr>
<?php
function displayProduct($row){
    $product_id = $row["product_id"];
    // each tr tag (row) has an id of p followed by the product id
    // example: product_id 333 will have a row with id='p333'
    echo    "<tr id='p$product_id'>
                <td>" . $row["product_name"] . "</td>
                <td>" . $row["product_price"] . "</td>
                <td><input type='button' value='Modify'
                    onclick='modifyProduct($product_id)'>
                </td>
                <td><input type='button' value='Remove'
                    onclick='removeProduct($product_id)'>
                </td>
            </tr>";
}

require '../product_list.php';
displayProductList(1, 'displayProduct');
?>
</table>
</body>
</html> 
