<a href='/'><button>Home</button></a>
<a href='/basket/'><button>Basket</button></a>
<?php
//only show login button if the customer isn't already logged in
if (!array_key_exists('customer_login', $_SESSION)){
    echo "<a href='/login/'><button>Login</button></a>";
} // show a logout button otherwise
else{
    echo "<a href='/login/logout.php'><button>Logout</button></a>";
}
?>
<br>
