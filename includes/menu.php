<?php 
$sql='SELECT COUNT(*) AS num FROM orders WHERE restaurant_id = '.$restaurant_id.' AND order_accepted IS NULL AND DATE(`order_created_at`) = CURDATE()';
$stmt=$conn->query($sql);
$found=$stmt->rowCount();
if($found){
	foreach($stmt as $row){
		$num=$row['num'];
	}
}else{
	$num=0;
}
?>

