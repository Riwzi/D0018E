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
    $comment = $_REQUEST["comment"];
    if(array_key_exists("response_to", $_REQUEST)){
        $parent_id = $_REQUEST["response_to"];
    } else {
        $parent_id = NULL;
    }
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
    // insert the comment into the database
    $stmt = $conn->prepare("INSERT INTO shopdb.ProductComments
        (customer_id, product_id, comment_parent_id, comment_text)
        VALUES (?,?,?,?);");
    $stmt->bind_param("iiis", $customer_id, $product_id, $parent_id, $comment);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    /**/
}
?>
