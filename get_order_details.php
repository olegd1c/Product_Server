<?php

/*
 * Following code will get single product details
 * A product is identified by product id (pid)
 */

// array for JSON response
$response = array();

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

$where = "";

if (isset($_GET["idOrder"])) {

	$idOrder = $_GET['idOrder'];
	$query = "SELECT id, order_id, prod_id, price, qty, sum, lineNumber FROM `ordersDetails` WHERE order_id =".$idOrder;


	//$response["messageError"] = "query: ". $query;
	//echo json_encode($response);

	$result = mysql_query($query);
	//echo json_encode($response);

	if (!empty($result)) {

		$response["ordersDetails"] = array();
		while($row = mysql_fetch_array($result))
		{
			$order = array();
			$order["id"] = $row["id"];

			//$date = new DateTime($row["date"]);
			//$order["date"] = "'".$date->Format('d-m-Y')."'";
			//$order["date"] = "'".$row["date"]."'";

			$order["order_id"] = $row["order_id"];

			$order["prod_id"] = $row["prod_id"];


			$order["price"] = $row["price"];

			$order["qty"] = $row["qty"];
			$order["sum"] = $row["sum"];
			$order["lineNumber"] = $row["lineNumber"];

			array_push($response["ordersDetails"], $order);
		 }

		// check for empty result
		$response["success"] = 1;
		 echo json_encode($response);
		}
	else {
		// no product found
		$response["success"] = 0;

		// echo no users JSON
		echo json_encode($response);
	}
}
else {
		// no product idOrder
		$response["success"] = 0;
		$response["messageError"] = "'No product idOrder.'". $query;

		// echo no users JSON
		echo json_encode($response);
}

?>