<?php
/*  If the client is not logged in, redirects to the login page
    Note that the session must be started before including this.
*/
if (!array_key_exists('customer_login', $_SESSION)){
    //redirect to index of this folder
    header("Location: /login");
    die();
}

