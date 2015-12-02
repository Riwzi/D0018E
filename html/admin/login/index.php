<?php
session_start();
//check if client is already logged in
if (array_key_exists('staff_login', $_SESSION)){
    // redirect
    header("Location: ../");
    die();
}
?>
<html>
<head>
<title>e-buy</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src='login.js'></script>
</head>

<body>
<form id='login_form'>
    Username:<br>
    <input type='text' name='username'><br>
    Password:<br>
    <input type='password' name='password'><br>
    <input type='button' value='Login' onclick="login()">
</form>
<p id="responseText"></p>
</body>
</html>
