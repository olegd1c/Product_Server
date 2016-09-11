<?php
//$json = $_GET['id'];

//$json = '{"name": "vasya", "pas" : "pas45" }';
//echo "name: ".$obj->{'name'}; ; //vasya

/*
$a = array(1, 2, 3, 17);

foreach ($a as $v) {
    echo "Текущее значение переменной \$a: $v.\n";
}
*/

/*
  $json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';

   var_dump(json_decode($json));
   var_dump(json_decode($json, true));
*/

//http://jsonutils.com/ - json to class


require_once __DIR__ . '/db_func.php';

$json = '{"orderDetails":[{"count":1,"id":2,"price":300,"sum":300},{"count":1,"id":1,"price":200,"sum":200}],"totalSum":500}';


//$data = json_decode($json, true);
//$class = new CartContainer();
//foreach ($data as $key => $value) $class->{$key} = $value;

$class = convert_param($json,new CartContainer());

echo "totalSum: ".$class->{'totalSum'}; ; //vasya

echo "class: orderDetails ".$class->{'orderDetails'}; ; //vasya

$arr = $class->{'orderDetails'};

foreach ($arr as $key => $valueArr) {
	foreach ($valueArr as $keyA => $value) {
    	echo " key: $keyA; val: $value<br />\n";
	}
}

//var_dump(json_decode($json, true));
$obj = json_decode($json,true);

//for ($obj[0] as $v) {
	//echo $v;
//}

echo date("H:m:s");

$date_str = '2012-05-05 00:00:00';
$date = new DateTime($date_str);
echo $date->Format('Y-m-d');


//echo '<br/>';
//echo now();
/*
echo " orderDetails_arr: ".$obj;

echo " val2: ".$obj[0]["id"]." <br />\n";

foreach ($obj as $key => $value) {
    echo " key: $key; val: $value<br />\n";
}

foreach ($obj as $value) {
	echo " val: ".$value." <br />\n";
}


echo " orderDetails1: ".$obj[0]['id'];

//$myArray = json_decode($data, true);
//echo $myArray[0]['id'];

foreach ($arr as $value) {
	echo "Value: ".$value ."<br />\n";
}
*/

//echo "orderDetails: ".$arr;
//echo "orderDetails: ".$obj->{'orderDetails'[0]}; //vasya

//http://devapp.in.ua/php/get_json.php?id={%22name%22:%22vasya1%22,%22pas%22:%22pas45%22}
?>