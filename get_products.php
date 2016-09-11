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

// check for post data


    // get a product from products table
    //$result = mysql_query("SELECT *FROM trackers WHERE name = $name");

	//mysql_query("SET NAMES 'utf8'");
	//mysql_query("SET CHARACTER SET 'utf8'");
	//mysql_query("SET SESSION collation_connection = 'utf8_general_ci'");
	//mysql_query('SET NAMES utf8 COLLATE utf8_general_ci');

//CONVERT(name USING cp1251 ) AS name

$query = "SELECT `id`, `title`, `discription`, `price`, `image`, `categoryId`, `notsale`, `article` FROM products";
$where = "";

if (isset($_GET["id"])) {
	$name = $_GET['id'];
	$where = " where id = ".$_GET['id'];
}

if (isset($_GET["id_ar"])) {
	$name = $_GET['id_ar'];
	$where = " where id in ( ".$_GET['id_ar'].")";
}

if (isset($_GET["last"])) {
	$where = " WHERE id
		IN (
			SELECT MAX( id ) AS id
			FROM trackers ".$where."
			GROUP BY name
			)";
}

$query = $query.$where;
$limit = "";

if (isset($_GET["limit_record"])) {
	$start = 0;
	if (isset($_GET["limit_start"])) {
		$start = $_GET['limit_start'];
	}
		
	$record = $_GET['limit_record'];
	$limit = " LIMIT $start,$record";
}

$query = $query.$limit;

$result = mysql_query($query);

if (!empty($result)) {
	// check for empty result
	$response["success"] = 1;

    $response["products"] = array();
	while($row = mysql_fetch_array($result))
	{
    	$product = array();
        $product["id"] = $row["id"];
		$product["title"] = "'".$row["title"]."'";
        $product["discription"] = "'".$row["discription"]."'";
        $product["price"] = $row["price"];
		$product["image"] = $row["image"];

		array_push($response["products"], $product);
     }

     echo json_encode($response);
    }
else {
	// no product found
    $response["success"] = 0;
    $response["messageError"] = "'No product found' ";

    // echo no users JSON
    echo json_encode($response);
}
?>