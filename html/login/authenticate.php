<?php
session_start();
/* respond with a 200 status code on success and
403 status code on failure */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //set the header to be 403 by default
    header('HTTP/1.1 403 Forbidden');

    $username = $_REQUEST["username"];
    $password = $_REQUEST["password"];
    require '../dbconnect.php';
    $conn = dbconnect();
    $stmt = $conn->prepare("SELECT count(customer_email) FROM shopdb.LoginStaff
        WHERE customer_email=? AND user_password_sha2_512=sha2(?, 512);");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $matches = -1;
    $stmt->bind_result($matches);
    $stmt->fetch();
    if($matches===1){
        // keep track of this user's logged in state
        $_SESSION['customer_login'] = $username;
        // set the header to a success code
        header('HTTP/1.1 200 OK');
    }
    // no need for a response body, just send the header
}
?>
