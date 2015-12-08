<?php

function cleanInput($input){
   $output = trim($input);
   $output = stripslashes($input);
   $output = htmlspecialchars($input);
   return $output;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $fname = $_REQUEST["fname"];
    $lname = $_REQUEST["lname"];
    $email = $_REQUEST["email"];
    $password = $_REQUEST["password"];
    $address = $_REQUEST["address"];
    $credit = $_REQUEST["credit"];

    // This input-cleaning section is needed to prevent users from
    // submitting invalid information. The form prevents normal users
    // from doing this, but it could be circumvented by sending a
    // POST request to this page.

    $fname = cleanInput($fname);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$order_fname) || empty($fname)) {
       die("Error, could not create account");
    }
    $lname = cleanInput($lname);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$order_lname) || empty($lname)) {
      die("Error, could not create account");
    }
    $email = cleanInput($email);
    if (!filter_var($order_email, FILTER_VALIDATE_EMAIL) || empty($email)){
        die("Error, could not create account");
    }
    $order_address = cleanInput($order_address);
    if (empty($address)) {
        die("Error, could not create account");
    }
    $order_credit = cleanInput($order_credit);
    //removes all whitespaces from the string
    $order_credit = preg_replace('/\s+/', '', $order_credit);
    if (!preg_match("\d{16}", $order_credit) || empty($order_credit)) {
            die("Error, could not create account");
    }
    
    
    require '../../dbconnect.php';
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

        $stmt->bind_param("ssss", $email, $fname, $lname, $credit);
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
    

