<?php
session_start();
?>
<!DOCTYPE HTML>
<html>

<head>
<title>e-buy</title>
<style>
.error {color: #FF0000;}
</style>
<?php include "../menu.php";?>
</head>

<body>

<h1>Complete your order</h1>
<p><span class="error">* required field.</span></p>
<form id="order_form" method="post" action="place.php">
    First name: <input type="text" name="order_fname" pattern="^[a-zA-Z]*$" required>
    <span class="error">*</span>
    <br><br>
    Last name: <input type="text" name="order_lname" pattern="^[a-zA-Z]*$" required>
    <span class="error">*</span>
    <br><br>
    E-mail: <input type="email" name="order_email" pattern="[a-zA-Z0-9#!$%&'*+=?^_`{}~\-\/]+@[a-zA-Z0-9.-]+" required>
    <span class="error">*</span> 
    <br><br>    
    Address: <input type="text" name="order_address" required>
    <span class="error">*</span>
    <br><br>
    Credit card number: <input type="text" name="order_credit" pattern="\s*(\d\s*){16}" required>
    <span class="error">*</span> 
    <br><br>  
    <input type="submit" id="submit" value="Submit">
    <br><br>
</form>


</body>
</html>
