<?php
include "include/mysql.php";
session_start();
if (isset($_REQUEST['_SESSION'])) die("Get lost Muppet!");

// Script Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

/*  
Global variables and functions are stored here. 
*/
$cartCount = 0;
if(isset($_SESSION['cart_array']) AND is_array(@$_SESSION['cart_array'])){
    foreach($_SESSION['cart_array'] AS $each_item){
        $cartCount = $cartCount + $each_item['quantity'];
    }
}
?>