<?php

/*
$json = '{"orderDetails":[{"count":"1","id":"2","price":"300","sum":"300"},,..,,{"count":"1","id":"1","price":"200","sum":"200"}],"totalSum":"500"}';
*/
// import func
require_once __DIR__ . '/db_models.php';


function convert_param($json,$class)
{

	$data = json_decode($json, true);

	foreach ($data as $key => $value) {
		$class->{$key} = $value;
	}
	return $class;
}

function convert_row_array($array,$row,$class)
{
	foreach ($class as $key => $value) {
		$array[$key] = $row[$key];
	}

	return $array;
}

function getCustomer($inputCustomer,$usePassword){
	$login = $inputCustomer->{'login'};
	$password = $inputCustomer->{'password'};
	$oauth = $inputCustomer->{'oauth'};
	$oauth_key = $inputCustomer->{'oauth_key'};

	$query = "SELECT id,login,password,oauth,oauth_key,address as adress,name,s_name,email,phone FROM customers";

	//echo $query;

	//////////////////////
	$where = "";

	//!is_null
	if ($login != NULL and $password != NULL) {
		$where = " WHERE login = '".$login."' ";
		if($usePassword == true) {
			$where = $where." AND password = '".$password."'";
		}
	}

	if ($oauth != NULL AND $oauth_key != NULL) {
		if ($where == "") {
			$where = " where ";
		}
		else {
			$where = $where." or ";
		}
		$where = $where."(oauth = '".$oauth."' AND oauth_key = '".$oauth_key."')" ;
	}

	$query = $query.$where;

	//echo $query.'<br\>';

	//////////////////////
	$result = mysql_query($query);

	if (!empty($result)) {
		// check for empty result
		$row = mysql_fetch_array($result);
		if ($row["id"] != NULL) {
			//echo $row;

			$response["success"] = 1;

			$customer = array();

			$customer = convert_row_array($customer,$row,$inputCustomer);
			/*

			$customer["id"] = $row["id"];
			$customer["login"] = $row["login"];
			$customer["password"] = $row["password"];
			$customer["oauth"] = "'".$row["oauth"]."'";
			$customer["oauth_key"] = $row["oauth_key"];
			$customer["adress"] = "'".$row["address"]."'";
			$customer["name"] = "'".$row["name"]."'";
			$customer["s_name"] = "'".$row["s_name"]."'";
			$customer["email"] = "'".$row["email"]."'";
			$customer["phone"] = "'".$row["phone"]."'";
			*/
			$response["customer"] = $customer;

			//echo $response;
			//echo json_encode($response);
		}
		else {
			// no product found
			$response["success"] = 0;
			$response["message"] = "'customer no found'";

		}
		}
	else {
		// no product found
		$response["success"] = 0;
		$response["message"] = "'customer no found'";

		//echo $response;
		// echo no users JSON
		//echo json_encode($response);
	}

	return $response;
}

function addCustomer($inputCustomer){
	$login = $inputCustomer->{'login'};
	$password = $inputCustomer->{'password'};
	$oauth = $inputCustomer->{'oauth'};
	$oauth_key = $inputCustomer->{'oauth_key'};
	$adress = $inputCustomer->{'adress'};
	$name = $inputCustomer->{'name'};
	$email = $inputCustomer->{'email'};
	$phone = $inputCustomer->{'phone'};

	$query = "INSERT INTO customers (login,password,oauth,oauth_key,address,name,s_name,email,phone) VALUES('$login','$password','$oauth','$oauth_key','$adress','$name','$s_name','$email','$phone')";

	//echo $query;

	//////////////////////
	try {
		$result = mysql_query($query);

		if ($result) {
			// check for empty result

			$resCustomer = getCustomer($inputCustomer,true);

			//$row = mysql_fetch_array($result);

			$response["success"] = 1;

			//$customer = array();
			//$customer = convert_row_array($customer,$row,$inputCustomer);

			$response["customer"] = $resCustomer["customer"];

			//$response["message"] = json_encode($row);
			//echo json_encode($response);

			}
		else {
			// no product found
			$response["success"] = 0;
			$response["message"] = "'error add customer. rezult: '".$result;

			// echo no users JSON
			//echo json_encode($response);
		}
	}
	catch (exception $ex)
    {
		//echo ($ex);
		//return false;

		$response["success"] = 0;
		$response["message"] = $ex;
    }

	return $response;
}

function updateCustomer($inputCustomer){
	$id = $inputCustomer->{'id'};
	$login = $inputCustomer->{'login'};
	$password = $inputCustomer->{'password'};
	$oauth = $inputCustomer->{'oauth'};
	$oauth_key = $inputCustomer->{'oauth_key'};
	$adress = $inputCustomer->{'adress'};
	$name = $inputCustomer->{'name'};
	$s_name = $inputCustomer->{'s_name'};
	$email = $inputCustomer->{'email'};
	$phone = $inputCustomer->{'phone'};

	$query = "UPDATE customers SET login = '$login',password = '$password',oauth = '$oauth', oauth_key = '$oauth_key',
		address = '$adress',name = '$name',s_name = '$s_name',email = '$email', phone = '$phone'
	WHERE id = '$id'";

	//echo $query;

	//////////////////////
	try {
		$result = mysql_query($query);

		if (!empty($result)) {
			// check for empty result

			$resCustomer = getCustomer($inputCustomer,true);
			$response["success"] = 1;

			$response["customer"] = $resCustomer["customer"];
			$response["message"] = "query: ".$query;

			}
		else {
			// no product found
			$response["success"] = 0;
			$response["message"] = "'error update customer'";

			// echo no users JSON
			//echo json_encode($response);
		}
	}
	catch (exception $ex)
    {
		//echo ($ex);
		//return false;

		$response["success"] = 0;
		$response["message"] = $ex;
    }

	return $response;
}
?>