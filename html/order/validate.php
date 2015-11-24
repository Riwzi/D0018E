<?php

//echo "text";

function validateErr(){
    echo "Error, could not place order";
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_name = $_REQUEST["order_name"];
    $order_email = $_REQUEST["order_email"];
    $order_credit = $_REQUEST["order_credit"];
    $order_addr = $_REQUEST["order_addr"];

    if (!empty($order_name)) {
        $order_name = cleanInput($order_name);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$order_name)) {
           validateErr();
        }
    }

    if (!empty($order_email])) {
        $order_email = cleanInput($order_email);
        if (!filter_var($order_email, FILTER_VALIDATE_EMAIL)){
            validateErr();
        }

    }

    if (!empty($order_addr)) {
        $order_addr = cleanInput($order_addr);
    }

    if (empty($order_credit)) {
        $order_credit = cleanInput($order_credit);
        //removes all whitespaces from the string
        $order_credit = preg_replace('/\s+/', '', $order_credit);
        if (!preg_match("\d{16}", $order_credit)){
            validateErr();
        }
    }

    //todo database interaction and send to next page
    require '../dbconnect.php';
    $conn = dbconnect();
    
    //if customer exists in database, add order to him/her, else make new customer?
    //how do i know if its a new customer or not? do i know the customer id?
    
    $conn->close();
}


function cleanInput($input){
   $output = trim($input);
   $output = stripslashes($input);
   $output = htmlspecialchars($input);
   return $output;
}

?>
