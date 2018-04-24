<?php
if(!isset($_POST['restaurant_id'])){
    exit('error: no restaurant ID');
}

$restaurant_id=$_POST['restaurant_id'];

require_once('connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");


$sql='SELECT COUNT(*) AS num FROM orders WHERE  restaurant_id = '.$restaurant_id.' AND order_accepted IS NULL AND DATE(`order_created_at`) = CURDATE()';
$stmt=$conn->query($sql);
$found=$stmt->rowCount();
if($found){
	foreach($stmt as $row){
		$num=$row['num'];
	}
}else{
	$num=0;
}
echo $num;