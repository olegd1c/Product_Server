<?

class OrderDetail
{
    public $count; //String
    public $id; //String
    public $price; //String
    public $sum; //String
}

class CartContainer
{
    public $orderDetails; //array(OrderDetail)
    public $totalSum; //String
	public $idCustomer; //String
	public $adress; //String

}

class Customer {
    public $login;//String
    public $password;//String
    public $oauth;//String
    public $oauth_key;//String
    public $adress;//String
    public $name;//String
    public $s_name;//String
    public $email;//String
    public $phone;//String
    public $id;//Integer
}

?>