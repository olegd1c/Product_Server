<?php

/*
 * Following code will create a new product row
 * All product details are read from HTTP Post Request
 */

//http://api.devapp.in.ua/php/get_add_customer.php?param={"login":"oleg_1c@ukr.net","password":"123"}

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

//echo json_encode($inputJSON);
//test
//$inputJSON = $_GET['param'];

///////////////////////////
$inputCustomer = new Customer();
$inputCustomer = convert_param($inputJSON,$inputCustomer);

$resp = getCustomer($inputCustomer,true);

//echo "1. ".$resp["success"]." \n ";

if ($resp["success"] == 1) {
	$response = $resp;
}
else{
	$resp = getCustomer($inputCustomer,false);
	//echo json_encode($resp);
	////////////////////////////////
	//echo "2. ".$resp["success"]." \n ";

	if ($resp["success"] == 0 )//and $resp["message"] == ""
	{
		$response = addCustomer($inputCustomer);
	}
	else{
		//$response = $resp;
		$response["success"] = 0;
		$response["message"] = "'error add customer. login take'";
	}
}
echo json_encode($response);

?>