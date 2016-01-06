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
    $stmt->close();
    
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
        
?>    
<form id='rate_form'>
    <input type="hidden" name="rating" id="rating" value="">
    <input type="hidden" name="product_id" value="<?php echo $product_id;?>">
    <input type="button" value="+" onclick="rateProduct(1)">
    <input type="button" value="-" onclick="rateProduct(0)">
</form>
<b>Comments:</b><br>
<?php
    //The reply_number variable determines how much indentation/padding the comment will have
    function displayComment($comment_text, $comment_fname, $comment_lname, $reply_number, $comment_id){
        $output = $comment_text." -".$comment_fname." ".$comment_lname;
        echo str_repeat("&nbsp", 4*$reply_number).$output;
        echo "<input type='button' value='Reply' onclick='replyToComment($comment_id)'><br>";
    }
    
    //gets all replies to the comment with it parent_id and gets the replies to those replies
    function getReply($conn, $parent_id, $reply_number){
        $sql = "SELECT comment_text, customer_id, comment_id
            FROM shopdb.ProductComments WHERE comment_parent_id=$parent_id;";
        $result = $conn->query($sql);
        //Loops until there are no more comments with the same parent
        while ($row = $result->fetch_assoc()){
            $customer_id = $row["customer_id"];
            $comment_text = $row["comment_text"];
            $comment_id = $row["comment_id"];
            //retrieve the name of the commenter
            $sql = "SELECT customer_fname, customer_lname FROM shopdb.Customers
                WHERE customer_id=$customer_id;";
            $result2 = $conn->query($sql);
            $row = $result2->fetch_assoc();
            $comment_fname = $row["customer_fname"];
            $comment_lname = $row["customer_lname"];
            //display the comment
            displayComment($comment_text, $comment_fname, $comment_lname, $reply_number, $comment_id);
            //retrieve any replies to this comment
            getReply($conn, $comment_id, $reply_number+1);
        }
    }
    
    //This function gets the comments with null parents
    function getRootComments($conn, $product_id, $reply_number){
        $stmt = $conn->prepare("SELECT comment_text, customer_id, comment_id 
            FROM shopdb.ProductComments 
            WHERE product_id=? AND comment_parent_id IS NULL;");
        $stmt->bind_param("i",$product_id);
        $stmt->execute();
        $stmt->bind_result($comment_text, $customer_id, $comment_id);
        $stmt->store_result();
        //Loops until there are no more comments with the same parent
        while ($stmt->fetch()){
            //retrieve the name of the commenter
            $stmt2 = $conn->prepare("SELECT customer_fname, customer_lname FROM shopdb.Customers
                WHERE customer_id=?;");
            $stmt2->bind_param("i",$customer_id);
            $stmt2->execute();
            $stmt2->bind_result($comment_fname, $comment_lname);
            $stmt2->fetch();
            $stmt2->close();
            //display the comment
            displayComment($comment_text, $comment_fname, $comment_lname, $reply_number, $comment_id);
            //retrieve any replies to this comment
            getReply($conn, $comment_id, $reply_number+1);
        }
        $stmt->free_result();
        $stmt->close();
    }
    $conn->autocommit(false);
    $conn->begin_transaction();
    getRootComments($conn, $product_id, null, 0);
    $conn->commit();
    $conn->close();
}
?>

<!-- Should submitting a comment be above or below the other comments? --> 
<br><b id='comment_form_title'>Submit a comment:</b><br>
<form id='comment_form'>
    <textarea style="resize:none" name="comment" cols="64" rows="4" maxlength="256" required></textarea>
    <input type="hidden" name="product_id" value="<?php echo $product_id;?>">
    <input type="button" value="Comment" onclick="commentSubmit()">
</form>
</body>
</html>
