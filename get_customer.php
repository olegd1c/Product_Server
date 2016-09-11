<?php

/*
 * Following code will create a new product row
 * All product details are read from HTTP Post Request
 */

//http://api.devapp.in.ua/php/get_customer.php?param={"login":"oleg_1c@ukr.net","password":"123"}
//http://api.devapp.in.ua/php/get_customer.php?param={"oauth":"google","oauth_key":"googlekey"}

// array for JSON response
$response = array();
$response["success"] = 0;
$response["message"] = "";

// import func
require_once __DIR__ . '/db_func.php';

require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

$inputJSON = $_GET['param'];

//echo $inputJSON;

$inputCustomer = new Customer();
$inputCustomer = convert_param($inputJSON,$inputCustomer);

$response = getCustomer($inputCustomer,true);

// echo no users JSON
echo json_encode($response);


?>