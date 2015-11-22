<?php
session_start();
/*
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
*/

if (!array_key_exists('product_id', $_REQUEST)){
    die('no product id in the request');
}

//ensure the basket array has been initialized
if (!array_key_exists('basket', $_SESSION)){
    die();
}

//receive product id via POST and remove from shopping basket
$product_id = $_REQUEST['product_id'];
//only if it is actually in the basket
if (array_key_exists($product_id, $_SESSION['basket'])){
    unset($_SESSION['basket'][$product_id]);
    echo 'Product removed from shopping basket';
}
