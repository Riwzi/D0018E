<?php
session_start();

require "../login/require_login.php";

$order_email = $_SESSION["customer_login"];

require '../dbconnect.php';
$conn = dbconnect();
$conn->autocommit(false);
$conn->begin_transaction();

$stmt = $conn->prepare("SELECT customer_id, customer_address FROM shopdb.Customers
                        WHERE customer_email=?;");
$stmt->bind_param("s", $order_email);
$stmt->execute();
$stmt->bind_result($customer_id, $order_address);
$stmt->fetch();
$stmt->close();
// customer id and order delivery address are now set


//insert the order
$stmt = $conn->prepare("INSERT INTO shopdb.Orders (customer_id, order_address)
                        VALUES (?,?);");
$stmt->bind_param("is", $customer_id, $order_address);
if (!$stmt->execute()){
    $conn->close();
    orderFailed();
}
$stmt->close();

//retrieve the newly generated order id
$stmt = $conn->prepare("SELECT MAX(order_id) FROM shopdb.Orders WHERE customer_id=?;");
$stmt->bind_param("i", $customer_id);
if (!$stmt->execute()){
    $conn->close();
    orderFailed();
}
$order_id = 0;
$stmt->bind_result($order_id);
$stmt->fetch();
$stmt->close();

//Insert the shopping baskets
$stmt = $conn->prepare("INSERT INTO shopdb.ShoppingBasket
                        (product_count, order_id, product_id)
                        VALUES(?, ?, ?);");
foreach($_SESSION['basket'] as $product_id => $count){
    $stmt->bind_param("iii", $count, $order_id, $product_id);
    if (!$stmt->execute()){
        $conn->close();
        orderFailed();
    }
    $stmt2 = $conn->prepare("UPDATE shopdb.Products SET product_stock=product_stock-? WHERE product_id=?");
    $stmt2->bind_param("ii", $count, $product_id);
    $stmt2->execute();
    $stmt2->close();
}
$stmt->close();
$conn->commit();
//empty the basket after committing
unset($_SESSION['basket']);
$conn->close();

//REDIRECT TO "THANK YOU" PAGE
header("Location: accepted.php");
die();


//Rollbacks the transaction and redirects to "try again" page
function orderFailed(){
    header("Location: failed.php");
    die();
}

