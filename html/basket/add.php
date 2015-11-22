<?php
session_start();
/*
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
*/

if (!array_key_exists('product_id', $_REQUEST)){
    die('no product id in the add request');
}

//ensure the basket array has been initialized
if (!array_key_exists('basket', $_SESSION)){
    $_SESSION['basket'] = array();
}

//receive product id via POST and add to shopping basket
$product_id = $_REQUEST['product_id'];
if (!array_key_exists($product_id, $_SESSION['basket'])){
    //this product is not already in the basket
    $_SESSION['basket'][$product_id] = 1;
} else{
    //product is in the basket, add 1
    $_SESSION['basket'][$product_id] = $_SESSION['basket'][$product_id] + 1;
}
echo 'Product added to shopping basket';
