<html>
<head>
<title>e-buy</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src='new_account.js'></script>
<style>
.error {color: #FF0000;}
</style>
</head>

<body>
<h1>Create account</h1>
<p><span class="error">* required field.</span></p>
<form id="account_form" method="post" action="create_account.php">
    First name: <input type="text" name="fname" pattern="^[a-zA-Z]*$" required>
    <span class="error">*</span>
    <br><br>
    Last name: <input type="text" name="lname" pattern="^[a-zA-Z]*$" required>
    <span class="error">*</span>
    <br><br>
    E-mail: <input type="email" name="email" required>
    <span class="error">*</span> 
    <br><br>
    Password:
    <input type='password' id='password' name='password' required>
    <span class="error">*</span>
    <br><br>
    Password (again):
    <input type='password' id='password2' name='password2' required>
    <span class="error">Passwords must match</span>
    <br><br>
    Address: <input type="text" name="address" required>
    <span class="error">*</span>
    <br><br>
    Credit card number: <input type="text" name="credit" pattern="\s*(\d\s*){16}" required>
    <span class="error">*</span> 
    <br><br>
    <input type="submit" id="submit" value="Submit">
    <br><br>
</form>

</body>
