<?php
session_start();
?>

<!DOCTYPE HTML>
<html>
<head>
<title>e-buy</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>

<body>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $order_fname = $_REQUEST["order_fname"];
    $order_lname = $_REQUEST["order_lname"];
    $order_email = $_REQUEST["order_email"];
    $order_address = $_REQUEST["order_address"];
    $order_credit = $_REQUEST["order_credit"];

    if (!empty($order_fname)) {
        $order_fname = cleanInput($order_fname);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$order_fname)) {
           die("Error, could not place order");
        }
    }
    
    if (!empty($order_lname)) {
        $order_lname = cleanInput($order_lname);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$order_lname)) {
          die("Error, could not place order");
        }
    }
    
    
    if (!empty($order_email)) {
        $order_email = cleanInput($order_email);
        
        if (!filter_var($order_email, FILTER_VALIDATE_EMAIL)){
            die("Error, could not place order");
        }
    }
    
    if (!empty($order_address)) {
        $order_address = cleanInput($order_address);
    }

    if (empty($order_credit)) {
        $order_credit = cleanInput($order_credit);
        //removes all whitespaces from the string
        $order_credit = preg_replace('/\s+/', '', $order_credit);
        if (!preg_match("\d{16}", $order_credit)){
            die("Error, could not place order");
        }
    }
    
    //TODO remove the die() functions from below?
    require '../dbconnect.php';
    $conn = dbconnect();
    $conn->autocommit(false);
    $conn->begin_transaction();
    
    //Check if the customer already exists in the database
    $stmt = $conn->prepare("SELECT customer_id FROM shopdb.Customers WHERE customer_email=?;");
    $stmt->bind_param("s", $order_email);
    $stmt->execute();
    $stmt->store_result();
    //True if customer does not exist in the database
    if ($stmt->num_rows === 0){
        $stmt->close();
        //insert the customer into the database
        $stmt = $conn->prepare("INSERT INTO shopdb.Customers (customer_email, customer_fname, 
                                                customer_lname, customer_creditcard) 
                                                VALUES(?,?,?,?);");

        $stmt->bind_param("ssss", $order_email, $order_fname, $order_lname, $order_credit);
        $stmt->execute();
        if($stmt == FALSE){
            die("Error 1, query was " . $sql . "    mysql error:  " . $conn->error);
        }
        $stmt->close();
        
        //get the newly generated customer id
        $sql = "SELECT MAX(customer_id) FROM shopdb.Customers;";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $customer_id = $row["MAX(customer_id)"];
             
    }
    //Customer exists
    else{
        echo "customer exists";
        $customer_id;
        $stmt->bind_result($customer_id);
        $stmt->fetch();
        $stmt->close();
    }
    
    //insert the order
    $stmt = $conn->prepare("INSERT INTO shopdb.Orders (customer_id, order_address)
                            VALUES (?,?);");
    $stmt->bind_param("is", $customer_id, $order_address);
    if($stmt == FALSE){
        echo "insert order fail";
    }
    $stmt->execute();
    $stmt->close();
    
    //retrieve the newly generated order id
    $stmt = $conn->prepare("SELECT MAX(order_id) FROM shopdb.Orders WHERE customer_id = $customer_id;");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
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
        $stmt->execute();
    }
    $stmt->close();
    $conn->commit();
    
    //empty the basket after committing
    unset($_SESSION['basket']);
    
    $conn->close();
    
    //REDIRECT TO "THANK YOU" PAGE
    header("Location: accepted.php");
    die();
}


function cleanInput($input){
   $output = trim($input);
   $output = stripslashes($input);
   $output = htmlspecialchars($input);
   return $output;
}

?>

</body>
</html>

