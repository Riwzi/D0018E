<?php
session_start();
if ($_SESSION['staff_login']){
    alert('hey, you are already logged in! we should redirect you...');
    // TODO do this properly
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
    <input type='text' id='username'><br>
    Password:<br>
    <input type='password' id='password'><br>
    <input type='button' value='Login' onclick="login()">
</form>
<p id="responseText"></p>
</body>
</html>
