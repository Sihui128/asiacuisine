<?php
/**
 * Add the field to order emails
 **/
if(!isset($_POST['order_id']) || !isset($_POST['hour']) || !isset($_POST['minute'])){
	exit('ERROR');
}
$orderid=$_POST['order_id'];
$order_confirmedtime=$_POST['hour'].':'.$_POST['minute'];

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
}


$sql_r='SELECT * FROM restaurants WHERE id = '.$restaurant_id;
foreach($conn->query($sql_r) as $rr){
	$restaurantname=$rr['restaurant_name'];
	$main_language=$rr['main_language'];
	$twilio_account_sid = $rr['twilio_account_sid'];
	$twilio_auth_token= $rr['twilio_auth_token'];
	$twilio_from_number = $rr['twilio_from_number'];
}


$sql_update='UPDATE orders SET order_accepted = "YES", order_confirmedtime = "'.$order_confirmedtime.'" WHERE id = '.$orderid;
$stmt=$conn->query($sql_update);
$updated=$stmt->rowCount();




if($updated){
	if(!isset($_GET['inhouse'])){
	$smsbody=$restaurantname.': Bedankt voor de bestelling. (in totaal '.$total.' euro) We zijn deze bestelling aan het verwerken. ';

	if($row['order_delivermethod']=='afhalen' || $row['order_delivermethod']=='self pick up' || $row['order_delivermethod']=='à emporter'){
		$smsbody.='en het zal klaar zijn rond ';
	}else{
		$smsbody.='en de geschatte levertijd is rond ';
	}
	
	$smsbody.=$order_confirmedtime;
	
	if($main_language=="fr" || $main_language=='FR'){
	
		$smsbody=$restaurantname.': Merci pour la commande. (un total de '.$total.' euros) Nous traitons cette commande. ';
		
		if($row['order_delivermethod']=='afhalen' || $row['order_delivermethod']=='self pick up' || $row['order_delivermethod']=='à emporter'){
			$smsbody.='et il sera pret vers ';
		}else{
			$smsbody.="et le delai de livraison estime est d'environ " ;
		}
		
		$smsbody.=$order_confirmedtime;
	
	
	}
	
	 
	$client = new Client($twilio_account_sid, $twilio_auth_token); 
	
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