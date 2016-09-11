<?
//$response ='rrr ';
//$response ='pp1 '.isset($_POST['pp1']);
//$response ='pp1: '.$_POST['pp1'];

//{"orderDetails":[{"count":1,"id":2,"price":300,"sum":300},{"count":1,"id":1,"price":200,"sum":200}],"totalSum":500}

// array for JSON response
$response = array();
$response["success"] = 0;
$response["message"] = "";
//var_dump(http_post_request_body());
//var_dump(headers_list());
//var_dump(header());

//$getBody = headers_list();
//$getBody = headers_sent();
//$getBody = $_REQUEST;
//$getBody = http_get_request_headers();

$inputJSON = file_get_contents('php://input');
$getBody = $inputJSON;
//$input= json_decode( $inputJSON, TRUE ); //convert JSON into array

$response["message"] = $getBody;
echo json_encode($response);


if(isset($_POST['param'])){
	$json = $_POST['param'];

	$obj = json_decode($json);
	//$response["message"] ='param_json: '.$obj->{'totalSum'};
	//$response["message"] ='param_json: '.$json;
	//$obj = json_decode($json);

	//echo "totalSum: ".$obj->{'totalSum'}; ; //vasya

	//$response["message"] ='param_json: '.$obj ['orderDetails'];
	$message = "totalSum: ".$obj->{'totalSum'};

	$message = $message.' '.$obj->{'orderDetails'};

	$response["message"] = $message;
	$response["success"] = 1;
}
else {
	$response["message"] = "'param not found'";
}


$mes = "param ";
foreach ($_POST as $key => $value) {
    //do something
	//echo $key . ' has the value of ' . $value;
	//echo json_encode($key);
	$mes = $mes.' '.$key . ' has the value of ' . $value;
	
}


$response["message"] = $mes; 

foreach (getallheaders() as $name => $value) {
	//$response = $response . " ". $name. ": " .$value;
}

echo json_encode($response);
//echo $param;

//echo "body: ".isset($_POST['body']);

//$json = $_POST['body'];


//$json = '{"name": "vasya", "pas" : "pas45" }';

//$obj = json_decode($json);

//echo "id: ".$obj->{'id'}; ; //vasya

?>