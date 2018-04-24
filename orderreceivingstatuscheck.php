<?php
$crr_h=(int)date('H');

if($crr_h>=23 || $crr_h<=11){
	exit($crr_h);
}



require_once('connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");

//SUBDATE(NOW(), INTERVAL 5 MINUTE)
$sql='SELECT * FROM orders WHERE order_accepted IS NULL AND order_created_at < SUBDATE(NOW(), INTERVAL 5 MINUTE) AND DATE(`order_created_at`) = CURDATE()';

$stmt=$conn->query($sql);
$num=$stmt->rowCount();

//echo 'Num: '.$num.'<br>';

$missingorderids='';
$missingordercontent='';

if($num){
	
	$missingordercontent.='以下餐馆没有及时接单，请和餐馆沟通 :'."\n\r";
	
	foreach($conn->query($sql) as $row){
		$crr_order_id=$row['id'];
		$crr_restaurant_id=$row['restaurant_id'];
		$crr_order_order_created_at=$row['order_created_at'];
		$missingorderids.=' '.$crr_order_id.' ';
		
		
		$sqlr='SELECT * FROM restaurants WHERE id = '.$crr_restaurant_id;
		foreach($conn->query($sqlr) as $rr){
			$restaurant_name=$rr['restaurant_name'];
			$restaurant_phonenumber=$rr['phonenumber'];
		}
		$missingordercontent.='餐馆名: '.$restaurant_name.' / 餐馆电话: '.$restaurant_phonenumber.' / 单id: '.$crr_order_id."\r\n\n";
	}
}

echo '---'.$missingordercontent;

if(!empty($missingordercontent)){
	$to      = 'asiacuisineorderalert@gmail.com';
	$subject = '!!! order '.$missingorderids.' is not accepted';
	$message = $missingordercontent;
	$headers = 'From: webmaster@asiacuisine.be' . "\r\n" .
			'Reply-To: info@@asiacuisine.be' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
	$headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/html; charset=UTF-8\r\n";   
	
	mail($to, $subject, $message, $headers);
}
