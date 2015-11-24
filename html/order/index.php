<!DOCTYPE HTML>
<html>
<head>
<title>e-buy</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<style>
.error {color: #FF0000;}
</style>
</head>

<body>

<h1>Complete your order</h1>
<p><span class="error">* required field.</span></p>
<form id="order_form" method="post" action="validate.php">
    Name: <input type="text" name="order_name" pattern="/^[a-zA-Z]*$/" required>
    <span class="error">*</span>
    <br><br>
    E-mail: <input type="email" name="order_email" required>
    <span class="error">*</span> 
    <br><br>    
    Address: <input type="text" name="order_addr" required>
    <span class="error">*</span>
    <br><br>
    Credit card number: <input type="text" name="order_credit" pattern="\s*(\d\s*){16}" required>
    <span class="error">*</span> 
    <br><br>  
    <input type="submit" id="submit" value="Submit">
    <br><br>
    <!-- ADD FORMS FOR FIRST/LAST NAME, PNUMBER -->
</form>


</body>
</html>
