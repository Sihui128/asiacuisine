<?php
require_once('connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");


if(isset($_POST['content']) && isset($_POST['restaurant_id']) && isset($_POST['ordercontent']) && isset($_POST['order_paymentmethod']) && isset($_POST['order_totalprice']) && isset($_POST['order_delivermethod']) && isset($_POST['user_name']) && isset($_POST['user_email']) && isset($_POST['user_number']) && isset($_POST['user_address']) && isset($_POST['order_delivertime']) && isset($_POST['user_note'])){
	$content=$_POST['content'];
	$ordercontent=$_POST['ordercontent'];
	$restaurant_id=$_POST['restaurant_id'];
	$order_paymentmethod=$_POST['order_paymentmethod'];
	$order_totalprice=$_POST['order_totalprice'];
	$order_delivermethod=$_POST['order_delivermethod'];
	$user_name=$_POST['user_name'];
	$user_email=$_POST['user_email'];
	$user_number=$_POST['user_number'];
	$user_address=$_POST['user_address'];
	$order_delivertime=$_POST['order_delivertime'];
	$user_note=$_POST['user_note'];
	
	
	
	$ordercontent=str_replace('â¬', '€', $ordercontent);
	$ordercontent=str_replace('&#8211;', '-', $ordercontent);
	$ordercontent=str_replace('&euro;', '€', $ordercontent);
	$ordercontent=str_replace('"', '\"', $ordercontent);
	
	$frenchcharactersappears=array('Ã¢','Ã¤','Ã¨','Ã©','Ãª','Ã«','Ã®','Ã¯','Ã´','Å','Ã¹','Ã»','Ã¼','Ã¿','Ã§','Ã');
	$frenchcharacters=array('â','ä','è','é','ê','ë','î','ï','ô','œ','ù','û','ü','ÿ','ç','à');
	$ordercontent=str_replace($frenchcharactersappears, $frenchcharacters, $ordercontent);
	
	
	$ordercontent_items=explode('\n\n',$ordercontent);
	
	$ordercontent_refined='';
	
	foreach($ordercontent_items as $item){
		if(!empty($ordercontent_refined)){
			$ordercontent_refined.='\n\n';
		}
		
		$line_length=0;
		$item_words=explode(' ', $item);
		
		foreach($item_words as $word){
			
			$crr_word_length=strlen($word);
			
			
			if($crr_word_length>=21){//包含4个字符显示数量，能容纳最多25个字符
				$ordercontent_refined.='\n    '.$word.'\n    ';
				$line_length=4;
			}else{
				
				if(($crr_word_length+$line_length)<=24){//包含一个空格,4个数量显示占位，能容纳最多25个字符
				  if($line_length==0){
						$ordercontent_refined.= $word;
						$line_length += $crr_word_length;
					}else{
						$ordercontent_refined.= ' '.$word;
						$line_length += $crr_word_length+1;
					}					
				}else{
				  $ordercontent_refined.= '\n    '.$word;
					$line_length=$crr_word_length+4;
				}
			}
		}
		
	}
	
	
	$order_content_chinese=NULL;
	if(isset($_POST['ordercontentchinese'])){
		$order_content_chinese=$_POST['ordercontentchinese'];
	}
	if(empty($order_content_chinese)){
		$order_content_chinese=NULL;
	}
	
	$sql='INSERT INTO orders (restaurant_id, order_content, order_content_dishes_only, order_content_chinese, order_paymentmethod, order_totalprice, order_delivermethod, user_name, user_email, user_number, user_address, order_delivertime, extr_info) VALUES (:restaurant_id, :order_content, :order_content_dishes_only, :order_content_chinese, :order_paymentmethod, :order_totalprice, :order_delivermethod, :user_name, :user_email, :user_number, :user_address, :order_delivertime, :extr_info)';
	$stmt=$conn->prepare($sql);	
	
	$stmt->bindParam(':restaurant_id', $restaurant_id, PDO::PARAM_INT);	
	$stmt->bindParam(':order_content', $content, PDO::PARAM_STR);
	$stmt->bindParam(':order_content_dishes_only', $ordercontent_refined, PDO::PARAM_STR);
	$stmt->bindParam(':order_content_chinese', $order_content_chinese, PDO::PARAM_STR);
	$stmt->bindParam(':order_paymentmethod', $order_paymentmethod, PDO::PARAM_STR);	
	$stmt->bindParam(':order_totalprice', $order_totalprice, PDO::PARAM_STR);	
	$stmt->bindParam(':order_delivermethod', $order_delivermethod, PDO::PARAM_STR);	
	$stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);	
	$stmt->bindParam(':user_email', $user_email, PDO::PARAM_STR);	
	$stmt->bindParam(':user_number', $user_number, PDO::PARAM_STR);	
	$stmt->bindParam(':user_address', $user_address, PDO::PARAM_STR);	
	$stmt->bindParam(':order_delivertime', $order_delivertime, PDO::PARAM_STR);	
	$stmt->bindParam(':extr_info', $user_note, PDO::PARAM_STR);	
		
	$stmt->execute();
	$OK=$stmt->rowCount();
	
	if($OK){
		echo 'SUCCESS';
	}else{
		$errors = $stmt->errorInfo();
		echo 'FAILED: '.$errors[2];
	}
	
}else{
	echo 'POSTING PROBLEM';
}