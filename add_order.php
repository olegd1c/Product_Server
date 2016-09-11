<?php

/*
 * Following code will create a new product row
 * All product details are read from HTTP Post Request
 */

// array for JSON response
$response = array();
$response["success"] = 0;
$response["message"] = "";

try
    {

// import func
require_once __DIR__ . '/db_func.php';

require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

$inputJSON = file_get_contents('php://input');
$cartContainer = new CartContainer();
$cartConteiner = convert_param($inputJSON,$cartContainer);

mysql_query("START TRANSACTION");

$idCustomer = $cartContainer->{'idCustomer'};
$total_price = $cartContainer->{'totalSum'};
$adress = $cartContainer->{'adress'};

$query_order = "INSERT INTO orders (date,customer_id,sum,status,adress) VALUES(now(),'$idCustomer','$total_price','1','$adress')";

//$response["message"] = $response["message"] . ' '. $query_order;

$flagOrder = mysql_query($query_order);
$order_id = mysql_insert_id();
//$order_id = '56565';
	$query_text = "INSERT INTO ordersDetails (order_id,prod_id,price,qty,sum,lineNumber) VALUE";
    $query_value = "";
    $lineNumber = 1;

    foreach ($cartContainer->{'orderDetails'} as $key => $item):
		if (!$query_value == "")
        {
            $query_value = $query_value . ", ";
        }

		$query_value = $query_value.'('
			.$order_id.','
			.$item['id'].','
			.$item['price'].','
			.$item['count'].','
			.$item['sum'].','
			.$lineNumber
			.')';
		/*
		foreach ($item as $keyRow => $val):

			//$query_value = $query_value.' key: '.$keyRA.' item: '.$val;
		endforeach;
		*/
		$lineNumber = $lineNumber+1;
    endforeach;

$query_text = $query_text.' '.$query_value;
$flagOrderDetail = mysql_query($query_text);

try
    {
        if ($flagOrder and $flagOrderDetail)
        {
            mysql_query("COMMIT");
			//send_email($email);
			//return true;
			$response["success"] = 1;
			$response["message"] = "OK";
			echo json_encode($response);
        } else
        {
            mysql_query("ROLLBACK");
			//echo ('ошибка записи заказа');
			//return false;
			$response["success"] = 0;
			$response["message"] = "order_id: ".$order_id.", flagOrderDetail: ".$flagOrderDetail.", flagOrder: ".$flagOrder.", query_order: ".$query_order.", query_text: ".$query_text.". error write order";
			echo json_encode($response);
        }
    }
    catch (exception $ex)
    {
		//echo ($ex);
		//return false;

		$response["success"] = 0;
		$response["message"] = $ex;
		echo json_encode($response);
    }


 }
    catch (exception $ex)
    {
		//echo ($ex);
		//return false;

		$response["success"] = 0;
		$response["message"] = $ex;
		echo json_encode($response);
}

//$response["message"] = $response["message"] . ' '. $query_text;

//$response["message"] = $cartContainer->{'orderDetails'};
//$response["message"] = $cartContainer->{'totalSum'}.' '.$cartContainer->{'orderDetails'};
//$response["success"] = 1;
//$response["message"] = "totalSum: ".$cartConteiner->{'totalSum'};

//echo json_encode($response);

/////////////////////////
/*
$total_price = $_SESSION['total_price'];
    $idCustomer = $customer['id'];
    //echo('START TRANSACTION');

	mysql_query("START TRANSACTION");

	//$query_order = "INSERT INTO orders (date,customer_id,sum,status) VALUES('$date','$idCustomer','$total_price','1')";

	$query_order = "INSERT INTO orders (date,customer_id,sum,status) VALUES(now(),'$idCustomer','$total_price','1')";
    //echo('$query_order: '.$query_order);
    $flagOrder = mysql_query($query_order);
    $order_id = mysql_insert_id();

    //echo('$order_id: '.$order_id);

    $query_text = "INSERT INTO ordersDetails (order_id,prod_id,price,qty,sum,lineNumber) VALUE";
    $query_value = "";
    $lineNumber = 1;
    foreach ($_SESSION['cart'] as $id => $qty):

        $product = get_product($id);
        $product_t = $product['title'];
        $product_id = $product['id'];
        $product_price = $product['price'];

        //echo('цикл товары');

        //$query = mysql_query("INSERT INTO orders (date,time,name,s_name,post_index,email,qty,product,prod_id,price)
        //VALUE('$date','$time','$name','$s_name','$post_index','$email','$qty','$product_t','$product_id
        //','$product_price' )");

        if (!$query_value == "")
        {
            $query_value = $query_value . ", ";
        }

        $query_value = $query_value . "('$order_id','$product_id','$product_price','$qty','$product_price*$qty','$lineNumber')";
        $lineNumber = $lineNumber + 1;
        //,'','.$product['title'].'','.$product['id'].','.$product['price'].',
    endforeach;

    //echo('queryDet: '.$query_text.$query_value.')');
    $flagOrderDetail = mysql_query($query_text . $query_value);

    //echo(' $flagOrderDetail: '.$flagOrderDetail);
    //echo(' $flagOrder: '.$flagOrder);

    try
    {
        if ($flagOrder and $flagOrderDetail)
        {
            mysql_query("COMMIT");
            send_email($email);
            return true;
        } else
        {
            mysql_query("ROLLBACK");
            echo ('ошибка записи заказа');
            return false;
        }
    }
    catch (exception $ex)
    {
        echo ($ex);
        return false;
    }
*/

/*

	echo "totalSum: ".$obj->{'totalSum'}; ; //vasya

	echo "class: orderDetails ".$class->{'orderDetails'}; ; //vasya

	$arr = $class->{'orderDetails'};

	foreach ($arr as $key => $valueArr) {
		foreach ($valueArr as $keyA => $value) {
			echo " key: $keyA; val: $value<br />\n";
		}
	}
*/

?>