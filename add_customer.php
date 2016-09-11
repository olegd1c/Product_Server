<?php

/*
 * Following code will create a new product row
 * All product details are read from HTTP Post Request
 */

//http://api.devapp.in.ua/php/add_customer.php?param={"login":"oleg_1c@ukr.net","password":"123"}

// array for JSON response
$response = array();
$response["success"] = 0;
$response["message"] = "";

// import func
require_once __DIR__ . '/db_func.php';

require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

$inputJSON = file_get_contents('php://input');

//test
//$inputJSON = $_GET['param'];

///////////////////////////
$inputCustomer = new Customer();
$inputCustomer = convert_param($inputJSON,$inputCustomer);

$resp = getCustomer($inputCustomer,true);

////////////////////////////////
//echo json_encode($resp);

if ($resp["success"] == 0) {
	$response = addCustomer($inputCustomer);
}
else{
	$response["success"] = 0;
	$response["message"] = "'error add customer. login occupied by another user'";
}

echo json_encode($response);

?>