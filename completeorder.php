<?php
/**
 * Add the field to order emails
 **/
if(!isset($_POST['order_id'])){
	exit('ERROR');
}
$orderid=$_POST['order_id'];

require_once('connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");


$sql_update='UPDATE orders SET 	order_complete = "YES" WHERE id = '.$orderid;
$stmt=$conn->query($sql_update);
$updated=$stmt->rowCount();

if($updated){
	echo 'SUCCESS';
}
?>