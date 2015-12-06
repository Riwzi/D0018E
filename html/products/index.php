<!DOCTYPE HTML>
<html>
<head>
<title>e-buy</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>

<body>
<?php
include "../menu.php";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $product_id = $_REQUEST["id"];
    require '../dbconnect.php';
    $conn = dbconnect();
    
    //retrieve the data about the product
    $stmt = $conn->prepare("SELECT product_name, product_price, product_desc, product_stock FROM shopdb.Products WHERE product_id=?;");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->store_result();
    
    //True if the product doesn't exist
    if ($stmt->num_rows == 0){
        $conn->close();
        die("<br>This product is not available.");
    }
    $stmt->bind_result($product_name, $product_price, $product_desc, $product_stock);
    $stmt->fetch();
    
    echo "<br><b>Product name:</b><br> ".$product_name."<br>
        <b>Product price:</b><br> ".$product_price."<br>
        <b>Currently in stock:</b><br> ".$product_stock."<br>
        <b>Description:</b><br> ".$product_desc."<br>";
        
    $stmt->close();
    $conn->close();
}
?>
</body>
</html>
