<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
<title>e-buy</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src='products.js'></script>
</head>

<body>
<?php
include "../menu.php";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $product_id = $_REQUEST["id"];
    require '../dbconnect.php';
    $conn = dbconnect();
    
    //retrieve the data about the product
    $stmt = $conn->prepare("SELECT product_name, product_price, product_desc, product_stock 
        FROM shopdb.Products WHERE product_id=?;");
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
    
    $conn->autocommit(false);
    $conn->begin_transaction();
    //return the amount of positive ratings
    $stmt = $conn->prepare("SELECT count(grade_positive) 
        FROM shopdb.ProductGrades 
        WHERE product_id=? and grade_positive=TRUE;");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($positive);
    $stmt->fetch();
    
    //returns the amount of negative ratings
    $stmt = $conn->prepare("SELECT count(grade_positive) 
        FROM shopdb.ProductGrades 
        WHERE product_id=? and grade_positive=FALSE;");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($negative);
    $stmt->fetch();
    
    $conn->commit();
    
    echo "<br><b>Product name:</b>
        <br> ".$product_name."<br>
        <b>Product price:</b>
        <br> ".$product_price."<br>
        <b>Currently in stock:</b>
        <br> ".$product_stock."<br>
        <b>Description:</b>
        <br> ".$product_desc."<br>
        <b>Product rating:</b>
        <br>Positive: ". $positive ." Negative: ". $negative."";
    
    //TODO add functionality to the buttons    
    if (array_key_exists('customer_login', $_SESSION)){
        echo "<button>+</button> <button>-</button>";
    }
    //TODO show comments    
    //query all root comments, for each of those, recursively query all comments with that comment as parent
        
    $stmt->close();
    $conn->close();
}
?>

<!-- Should submitting a comment be above or below the other comments? --> 
<br><b>Submit a comment:</b><br>
<form id='comment_form'>
    <textarea style="resize:none" name="comment" cols="64" rows="4" maxlength="256"></textarea>
    <input type="hidden" name="product_id" value="<?php echo $product_id;?>">
    <input type="button" value="Comment" onclick="commentSubmit()">
</form>
<p id="responseText"></p>
</body>
</html>
