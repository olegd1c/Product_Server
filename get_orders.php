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


$query = " SELECT Ord.id, Ord.date, Ord.customer_id as idCustomer, Ord.sum, Ord.number, Ord.adress as adress, Stat.name AS statusName , Stat.id AS status_id, Ord.comment
FROM  orders AS Ord
LEFT JOIN ordersStatus as Stat ON Ord.status = Stat.id
";

$where = "";

if (isset($_GET["id"])) {
	$name = $_GET['id'];
	$where = " where id = ".$_GET['id'];
}

if (isset($_GET["idCustomer"])) {
	$customer_id = $_GET['idCustomer'];
	if ($where == "") {
		$where = " where ";
	}
	else {
		$where = $where." and ";
	}
	$where = $where." Ord.customer_id = ".$customer_id;
}

$query = $query.$where;

//$response["messageError"] = "query: ". $query;
//echo json_encode($response);

$result = mysql_query($query);
//echo json_encode($response);

if (!empty($result)) {

    $response["orders"] = array();
	while($row = mysql_fetch_array($result))
	{
    	$order = array();
        $order["id"] = $row["id"];

		$date = new DateTime($row["date"]);
		$order["date"] = "'".$date->Format('d-m-Y')."'";
		//$order["date"] = "'".$row["date"]."'";

        $order["idCustomer"] = $row["idCustomer"];
        $order["sum"] = $row["sum"];
		//$order["number"] = $row["number"];
		$order["number"] = $row["id"];
		$order["adress"] = $row["adress"];
		$order["status"] = $row["statusName"];

		///////////////
	    $order["products"] = array();

    	$product = array();
        $product["id"] = $row[""];
		$product["title"] = $row["title"];
        $product["discription"] = $row["discription"];
        $product["price"] = $row["price"];
		$product["image"] = $row["image"];

		array_push($order["products"], $product);
		///////////////

		array_push($response["orders"], $order);
     }

	// check for empty result
	$response["success"] = 1;

     echo json_encode($response);
    }
else {
	// no product found
    $response["success"] = 0;
    $response["messageError"] = "'No product found.'". $query;

    // echo no users JSON
    echo json_encode($response);
}

?>