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
    

    require '../dbconnect.php';
    $conn = dbconnect();
    
    //Check if the customer already exists in the database
    $sql = "SELECT * FROM shopdb.Customers WHERE customer_email='$order_email';";
    $result = $conn->query($sql);
    //True if customer does not exist in the database
    if ($result->num_rows === 0){
        $sql = "INSERT INTO shopdb.Customers (customer_email, customer_fname, 
                                              customer_lname, customer_creditcard) 
                VALUES('$order_email', '$order_fname', '$order_lname', '$order_credit');";
        $result = $conn->query($sql);
        if($result == FALSE){
            die("Error 1, query was " . $sql . "    mysql error:  " . $conn->error);
        }
        $sql = "SELECT MAX(customer_id) FROM shopdb.Customers;";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $customer_id = $row["MAX(customer_id)"];
    }
    //Customer exists
    else{
        $row = $result->fetch_assoc();
        $customer_id = $row["customer_id"];
    }
    
    //insert the order
    $sql = "INSERT INTO shopdb.Orders (customer_id, order_address)
            VALUES ($customer_id, '$order_address');";
    $result = $conn->query($sql);
    if($result == FALSE){
        die("Error 2, could not place order");
    }
    
    //retrieve the newly generated order id
    $sql = "SELECT MAX(order_id) FROM shopdb.Orders WHERE customer_id = $customer_id;";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $order_id = $row["MAX(order_id)"];

    if($result == FALSE){
        die("Error 3, could not place order");
    }
    
    
    //Insert the shopping baskets
    foreach($_SESSION['basket'] as $product_id => $count){
        $sql = "INSERT INTO shopdb.ShoppingBasket
            (product_count, order_id, product_id)
            VALUES ($count, $order_id, $product_id);";
        if($conn->query($sql) == FALSE){
            die("Error 4, could not place order");
        }
    }
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

