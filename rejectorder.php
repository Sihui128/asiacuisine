<?php
/**
 * Add the field to order emails
 **/
if(!isset($_POST['order_id'])){
	exit('ERROR');
}
$orderid=$_POST['order_id'];

require_once ('twilio-php-master/Twilio/autoload.php'); // Loads the library 
use Twilio\Rest\Client; 

require_once('connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");


$sql='SELECT * FROM orders WHERE id = '.$orderid;
foreach($conn->query($sql) as $row){
	$total=$row['order_totalprice'];
	$user_phone=$row['user_number'];
	$restaurant_id=$row['restaurant_id'];
	$order_paymentmethod=strtolower($row['order_paymentmethod']);
}


$sql_r='SELECT * FROM restaurants WHERE id = '.$restaurant_id;
foreach($conn->query($sql_r) as $rr){
	$restaurantname=$rr['restaurant_name'];
	$twilio_account_sid=$rr['twilio_account_sid'];
	$twilio_auth_token=$rr['twilio_auth_token'];
	$twilio_from_number=$rr['twilio_from_number'];
	$main_language=$rr['main_language'];
}


if($order_paymentmethod!='cash' && $order_paymentmethod!='en espèces'){
  mail("refund@asiacuisine.be", $orderid, 'refund! please check! Restaurant: '.$restaurantname.' | orderID: '.$orderid.' | amount: '.$total);
}

$sql_update='UPDATE orders SET order_accepted = "NO" WHERE id = '.$orderid;
$stmt=$conn->query($sql_update);
$updated=$stmt->rowCount();

if($updated){
	if(!isset($_GET['inhouse'])){
	
		$smsbody=$restaurantname.': Het spijt ons, maar we kunnen uw bestelling niet voorbereiden vanwege het gebrek aan materiaal. ';
	
		if($order_paymentmethod=='cash' || $order_paymentmethod=='en espèces'){
			$smsbody.='';
		}else{
			$smsbody.='U wordt binnenkort terugbetaald.';
		}
		
		$smsbody.=' Onze excuses';
		
		
		if($main_language=='FR'){
			$smsbody=$restaurantname.': Nous sommes desoles, mais nous ne pouvons pas préparer votre commande en raison du manque de materiel. ';
		
			if($order_paymentmethod=='cash' || $order_paymentmethod=='en espèces'){
				$smsbody.='';
			}else{
				$smsbody.='Vous serez rembourse bientot.';
			}
			
			$smsbody.=' toutes nos excuses.';
		}
		
		
		$client = new Client($twilio_account_sid, $twilio_auth_token); 
		//$smsbody='Cuisine Speciale: You have received a coupon of 5 euro, the coupon code is '.$coupon_code.'. Use it on www.cuisineasia.be/china';
		
		$client->messages->create($user_phone, array( 
					'From' => $twilio_from_number, 
					'Body' => $smsbody,      
		));
		
		echo 'SUCCESS';
	}else{
		echo 'SUCCESS';
	}
}
exit();
?>
