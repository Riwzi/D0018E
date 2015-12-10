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
    if (!preg_match("/^[a-zA-Z ]*$/",$fname) || empty($fname)) {
       die("Error, could not create account: fname");
    }
    $lname = cleanInput($lname);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$lname) || empty($lname)) {
      die("Error, could not create account: lname");
    }
    $email = cleanInput($email);
    if (!preg_match("/[a-zA-Z0-9#!$%&'*+=?^_`{}~\-\/]+@[a-zA-Z0-9.-]+/", $email) || empty($email)){
        die("Error, could not create account: email=" . $email);
    }
    $address = cleanInput($address);
    if (empty($address)) {
        die("Error, could not create account: address");
    }
    $credit = cleanInput($credit);
    //removes all whitespaces from the string
    $credit = preg_replace('/\s+/', '', $credit);
    if (!preg_match("/\d{16}/", $credit) || empty($credit)) {
        die("Error, could not create account: credit=$credit");
    }
    
    
    require '../../dbconnect.php';
    $conn = dbconnect();
    $conn->autocommit(false);
    $conn->begin_transaction();

    $stmt = $conn->prepare("SELECT count(customer_email) FROM shopdb.LoginCustomer
        WHERE customer_email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $matches = -1;
    $stmt->bind_result($matches);
    $stmt->fetch();
    $stmt->close();
    if($matches != 0){
        die("Error when creating account: e-mail address is already in use.");
    }
    //Check if the customer already exists in the database
    $stmt = $conn->prepare("SELECT customer_id FROM shopdb.Customers WHERE customer_email=?;");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    //True if customer does not exist in the database
    if ($stmt->num_rows === 0){
        $stmt->close();
        //insert the customer into the database
        $stmt = $conn->prepare("INSERT INTO shopdb.Customers (customer_email, customer_fname, 
                                                customer_lname, customer_creditcard, customer_address) 
                                                VALUES(?,?,?,?,?);");

        $stmt->bind_param("sssis", $email, $fname, $lname, $credit, $address);
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
    //Customer exists, but does not have an account yet
    else{
        $stmt->close();
        $stmt = $conn->prepare("UPDATE shopdb.Customers
                                SET customer_fname=?, customer_lname=?,
                                customer_creditcard=?, customer_address=?
                                WHERE customer_email=?;");
        $stmt->bind_param("ssiss", $fname, $lname, $credit, $address, $email);
        $stmt->execute();
        $stmt->close();
    }
    //add the login entry
    $stmt = $conn->prepare("INSERT INTO shopdb.LoginCustomer
                            (customer_email, user_password_sha2_512)
                            VALUES(?,sha2(?,512));");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $conn->commit();
    $conn->close();
    // Redirect to login
    header("Location: ../");
/**/
}
