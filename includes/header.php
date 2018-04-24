<?php
if(isset($_GET['restaurant_id'])){
	$restaurant_id=$_GET['restaurant_id'];
}else{
	exit('NO PERMISSION TO ACCESS THIS PAGE');
}

require_once('connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");


$breaksigns=array('\n\n\n','\n\n');



$crr_lang='zh';
if(isset($_GET['language'])){
    $crr_lang=$_GET['language'];
}


$sql_r='SELECT * FROM restaurants WHERE id = '.$restaurant_id;
foreach($conn->query($sql_r) as $rr){
	$restaurantname=$rr['restaurant_name'];
	$current_open_status=$rr['current_open_status'];
	
	$current_address_street_number=$rr['address_street_number'];
	$current_address_zip_region = $rr['address_zip_region'];
	
	$current_restaurant_url=$rr['domain_name'];
	$current_restaurant_phonenumber=$rr['phonenumber'];
	
	$printCode=$rr['print_code'];
	
}



$urlbeginwith   = array("https://", "http://");
$current_restaurant_websitedomain=str_replace($urlbeginwith, '', $current_restaurant_url);


###############################
#                             #
#        Translation          #
#                             #
###############################
include_once('translation.php');
###############################
#                             #
#        Translation          #
#                             #
###############################

?>