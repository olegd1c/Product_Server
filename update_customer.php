<?php

// array for JSON response
$response = array();
$response["success"] = 0;
$response["message"] = "";

// import func
require_once __DIR__ . '/db_func.php';

require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

//$inputJSON = $_GET['param'];
$inputJSON = file_get_contents('php://input');
//echo $inputJSON;

$inputCustomer = new Customer();
$inputCustomer = convert_param($inputJSON,$inputCustomer);

$response = updateCustomer($inputCustomer,true);

// echo no users JSON
echo json_encode($response);


?>