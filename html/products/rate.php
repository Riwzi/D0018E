<?php
session_start();
/**/
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
/**/
require "../login/require_login.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // some input validation might be needed
    $user = $_SESSION["customer_login"];
    $product_id = $_REQUEST["product_id"];
    $grade_positive_new = $_REQUEST["rating"];
    // find the customer id of the commenter
    require "../dbconnect.php";
    $conn = dbconnect();
    $stmt = $conn->prepare("SELECT customer_id FROM shopdb.Customers WHERE customer_email=?");
    //var_dump($conn->error_list);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->bind_result($customer_id);
    $stmt->fetch();
    $stmt->close();
    
    //check if the user has already rated this product and changes his rating
    $stmt = $conn->prepare("SELECT count(grade_positive) 
        FROM shopdb.ProductGrades 
        WHERE customer_id=? AND product_id=?;");
    $stmt->bind_param("ii", $customer_id, $product_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    
    //if the user has not rated yet, insert his rating
    if ($count==0){
        $stmt = $conn->prepare("INSERT INTO shopdb.ProductGrades
            (grade_positive, customer_id, product_id)
            VALUES (?,?,?);");
        $stmt->bind_param("iii", $grade_positive_new, $customer_id, $product_id);
        $stmt->execute();
        $stmt->close();
    }
    else{
        //if the user has changed his rating, update with his new rating
        if ($row['grade_positive']!=$grade_positive_new){
            $stmt = $conn->prepare("UPDATE shopdb.ProductGrades
                SET grade_positive=? WHERE customer_id=? AND product_id=?;");
            $stmt->bind_param("iii", $grade_positive_new, $customer_id, $product_id);
            $stmt->execute();
            $stmt->close();
        }
    }
    $conn->close();
}
?>
