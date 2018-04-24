<?php


require_once ('twilio-php-master/Twilio/autoload.php'); // Loads the library 
use Twilio\Rest\Client;  

require_once('connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");



$sql_r='SELECT * FROM restaurants WHERE id = 5';
foreach($conn->query($sql_r) as $rr){
	$restaurantname=$rr['restaurant_name'];
	$main_language=$rr['main_language'];
	$twilio_account_sid = $rr['twilio_account_sid'];
	$twilio_auth_token= $rr['twilio_auth_token'];
	$twilio_from_number = $rr['twilio_from_number'];
}


$smsbody='this is a test';


 
$client = new Client($twilio_account_sid, $twilio_auth_token); 

$resp=$client->messages->create('032311463', array( 
			'From' => $twilio_from_number, 
			'Body' => $smsbody,      
));

print_r($resp);
?>