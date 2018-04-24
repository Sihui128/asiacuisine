<?php
include_once('includes/header.php');
?>



<!DOCTYPE html>
<html>

<head>
<title>AsiaCuisine - My orders</title>
<?php
include_once('includes/header-elements.php');
?>
</head>

	<body>
  
<?php
include_once('includes/menu.php');
?>
  
<h3 class="pagetitle">
<span id="newordersnum" class="newordersnum_<?php echo $num; ?>"><?php echo $num; ?></span> 
  <span class="navi-btns-container"><button id="showTodo" onClick="showTodo()"><?php echo _tr('处理中'); ?></button><button id="showDone" class="crrinactivenbtn" onClick="showDone()"><?php echo _tr('已完成'); ?></button> | <a href="options.php?restaurant_id=<?php echo $restaurant_id;?>&language=<?php echo $crr_lang; ?>"><i class="fa fa-phone-square" aria-hidden="true"></i> <?php echo _tr('帮助'); ?></a></span>
</h3>

  <ul class="theorderlistcontainer">
  
<?php
$sql='SELECT * FROM orders WHERE restaurant_id = '.$restaurant_id.' AND DATE(`order_created_at`) = CURDATE() AND 	order_accepted <> "NO" ORDER BY id ASC';


foreach($conn->query($sql) as $row){
	$crr_order_id=$row['id'];

	$order_accepted=$row['order_accepted'];
	if(empty($order_accepted)){
		$order_accepted='TODO';
	}
	$order_confirmedtime=$row['order_confirmedtime'];
	if(empty($order_confirmedtime)){
		$order_confirmedtime='';
  }
	$order_complete = $row['order_complete'];
?>
<li class="order accepted_<?php echo $order_accepted; ?> order_complete_<?php echo $order_complete; ?>" id="order_<?php echo $crr_order_id; ?>">

<div class="orderbriefing">
<span class="ordertime">
<?php 
	$d = new DateTime($row['order_created_at']);
	echo $d->format('H:i:s'); // 2011-01-01T15:03:01.012345
?>
</span><span class="username"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $row['user_name']; ?>
</span><span class="usertel"><i class="fa fa-mobile" aria-hidden="true"></i> <?php echo $row['user_number']; ?>
</span><span class="total"><i class="fa fa-eur" aria-hidden="true"></i> <?php echo $row['order_totalprice']; ?> (paid by <?php echo $row['order_paymentmethod']; ?>)
</span><span class="delivermethod"><?php echo $row['order_delivermethod']; ?>
</span><span class="deliverytimeasked"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $row['order_delivertime']; ?>
</span>
<p class="buttonscontainer">
<button class="detailbtn" onClick="showOrderDetail('order_<?php echo $crr_order_id; ?>')"><i class="fa fa-eye"></i> <?php echo _tr('订单详情'); ?></button>

<?php
if($row['order_complete']=="NO"){
?>
<button id="completeOrderBtn_<?php echo $crr_order_id; ?>" class="completeOrderBtn" onClick="completeOrder(<?php echo $crr_order_id; ?>)"><i class="fa fa-check-square-o" aria-hidden="true"></i> <?php echo _tr('订单已完成'); ?></button>
<?php
}
?>

</p>

</div>

<div class="ordercontent">
<?php
$ordercontent_raw=$row['order_content_dishes_only'];
$ordercontent=str_replace($breaksigns, "<br>", $ordercontent_raw);
$ordercontent=str_replace('\n', " ", $ordercontent);

$crr_usernote=$row['extr_info'];
$crr_user_name=$row['user_name'];
$crr_user_number=$row['user_number'];
$crr_user_address=$row['user_address'];
$crr_order_delivertime=$row['order_delivertime'];


if(empty($crr_usernote)){
	$crr_usernote='none';
}

$ordercontent.='<p style="margin:3px; font-size:12px;"><strong>User note:</strong> '.$crr_usernote.'</p>';
$userinfo='<p style="margin:3px; font-size:12px;"><strong>client info:</strong><br /> '.$crr_user_name.'<br />'.$crr_user_address.'<br />'.$crr_user_number.'</p>';
echo $ordercontent.$userinfo;

?>
</div>
</li>
<?php
}
?>
<li class="bottomplaceholder" style="height:58px;"></li>
</ul>
  
  
<?php
$sql_last_new='SELECT * FROM orders WHERE  restaurant_id = '.$restaurant_id.' AND order_accepted IS NULL AND DATE(`order_created_at`) = CURDATE() ORDER BY order_created_at ASC LIMIT 1';
$stmt_ln=$conn->query($sql_last_new);
$newfound=$stmt_ln->rowCount();
if($newfound){
	foreach($stmt_ln as $rn){
		$newordercontent_raw=$rn['order_content'];
		$neworder_content_dishes_only=$rn['order_content_dishes_only'];
		$neworder_content_chinese=$rn['order_content_chinese'];
		
		$neworder_order_created_at=$rn['order_created_at'];
		$neworder_order_totalprice=$rn['order_totalprice'];
		$neworder_order_delivermethod=$rn['order_delivermethod'];
		$neworder_order_delivertime=$rn['order_delivertime'];	
		
		$neworder_user_name=$rn['user_name'];	
		$neworder_user_number=$rn['user_number'];	
		$neworder_user_address=$rn['user_address'];	
		
		$neworder_order_usernote=$rn['extr_info'];
		if(empty($neworder_order_usernote)){
			$neworder_order_usernote='-';
		}
		
		$neworder_order_paymentmethod=$rn['order_paymentmethod'];
		
		
		$orderid=$rn['id'];
		
		
		if($neworder_order_paymentmethod=='Cash' || $neworder_order_paymentmethod=="cash" || $neworder_order_paymentmethod == "En espèces" || $neworder_order_paymentmethod == "en espèces"){
			$neworder_order_paymentmethod_chinese='现金付款';
		}else{
			$neworder_order_paymentmethod_chinese='!!!注意: 客人已划卡付款';
		}
		
		if(strpos($neworder_order_delivermethod, 'ezorgen')!== false || strpos($neworder_order_delivermethod, 'ome delivery')!== false || strpos($neworder_order_delivermethod, 'omicile')!== false){
			$neworder_order_delivermethod_chinese='送餐';
		}else{
			$neworder_order_delivermethod_chinese='自取';
		}
		
		
	}
?>
<div class="neworderdialogue-grandcontainer">
<div class="neworderdialogue-innercontainer">
<h4 class="neworderdialoguetitle"><i class="fa fa-bell" aria-hidden="true"></i> <?php echo _tr('新订单'); ?></h4>
<div class="newordercontent">
  <div class="orderbriefing">
  <span class="ordertime">
  <?php 
	//echo $rn['order_created_at']; 
	$dn = new DateTime($rn['order_created_at']);
	echo $dn->format('H:i:s'); // 
	echo ' | '.date('H');
	?>
  </span>
  <span class="username"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $rn['user_name']; ?>
  </span><span class="usertel"><i class="fa fa-mobile" aria-hidden="true"></i> <?php echo $rn['user_number']; ?>
  </span><span class="total"><i class="fa fa-eur" aria-hidden="true"></i> <?php echo $rn['order_totalprice']; ?> (paid by <?php echo $rn['order_paymentmethod']; ?>)
  </span><span class="delivermethod"><?php echo $rn['order_delivermethod']; ?>
  </span><span class="deliverytimeasked"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $rn['order_delivertime']; ?></span>
  </div>
  
  <div class="newordercontent">
  <?php
  $ordercontent_raw=$rn['order_content_dishes_only'];
  $ordercontent=str_replace($breaksigns, "<br>", $ordercontent_raw);
  $ordercontent=str_replace('\n', " ", $ordercontent);
	$ordercontent.='<p style="margin:3px; font-size:12px;"><strong>User note:</strong> '.$neworder_order_usernote.'</p>';
  echo $ordercontent;
  ?>
  </div>
  <p class="deliverytimeindicationbox">
  <?php
	$userchosen_d_time=$row['order_delivertime'];
	$userchosen_d_time_adding='';
	
	if(strpos($userchosen_d_time, ':') !== false){
		$sugg_time=explode(':',$userchosen_d_time);
		$sugg_hour=$sugg_time[0];
		$sugg_min=$sugg_time[1];
	}else{	
		$crr_h=(int)date('H');
	  $crr_m=(int)date('i');
			
		if($crr_m>=30){
			$sugg_hour=$crr_h+1;
			$sugg_min=$crr_m-30;
		}else{
			$sugg_hour=$crr_h;
			$sugg_min=$crr_m+30;
		}
		
		
		
		if($sugg_min<6){
			$sugg_min="00";
		}else if($sugg_min>=6 && $sugg_min<=18){
			$sugg_min="15";
		}else if($sugg_min>18 && $sugg_min<=33){
			$sugg_min="30";
		}else if($sugg_min>33 && $sugg_min<=48){
			$sugg_min="45";
		}else if($sugg_min>48){
			$sugg_min="00";
			$sugg_hour+=1;
		}
		$userchosen_d_time_adding=' ( ~'.$sugg_hour.':'.$sugg_min.')';
	}
	?>
  
  </p>
  <div style="position:relative; height:220px;">--</div>
</div>




<div class="replybtncontainer">
<div class="replycontainer-inner">
<p style="clear:both; padding:0 0 9px 0; margin:0; font-size:16px;">
<?php echo '<span class="titlewords" style="font-size:12px;">'._tr('客人要求时间').'</span>: '.$userchosen_d_time.$userchosen_d_time_adding.'.'; ?>
</p>

<button class="replytimebtn fullwidthbtn asrequesttimebtn" onclick="sendReply(<?php echo $orderid; ?>, 0)"><?php echo _tr('接单'); ?></button>
<button class="replytimebtn fullwidthbtn cancelsendingbtn" onclick="rejectOrder(<?php echo $orderid; ?>)"><?php echo _tr('不接单'); ?></button>
<button class="replytimebtn" onclick="sendReply(<?php echo $orderid; ?>, 15)">+15</button>
<button class="replytimebtn" onclick="sendReply(<?php echo $orderid; ?>, 30)">+30</button>
<button class="replytimebtn" onclick="sendReply(<?php echo $orderid; ?>, 45)">+45</button>
<button class="replytimebtn" onclick="sendReply(<?php echo $orderid; ?>, 60)">+60</button>

<br style="clear:both;" />

<div id="updateindication" style="position:absolute; width:100%; height:100%; top:0; left:0; background-color:rgba(255,255,255,0.85)">
<p style="padding-top:50px; text-align:center;"><img src="includes/loading_blue.gif" style="width:28px; height:auto;" /></p>
</div>

</div><!-- END replycontainer-inner -->
</div><!-- END replybtncontainer -->
<p class="moreorder-indication"><?php echo _tr('还有'); ?><span class="stillordernum"></span><?php echo _tr('单'); ?></p>
</div><!-- end neworderdialogue-innercontainer -->
</div><!-- end neworderdialogue-grandcontainer -->



<script type="text/javascript">
function printTheTicket_in_format(){
	var a = "<?php echo ($restaurantname).'\n'.($current_address_street_number).'\n'.($current_address_zip_region).'\n'.($current_restaurant_phonenumber).'\n'.$current_restaurant_websitedomain.'\n\nOrder date:\n'.($neworder_order_created_at).'\n\nClient info:\n'.($neworder_user_name).'\n'.($neworder_user_address).'\n'.($neworder_user_number).'\n\n\n'; ?>";
	var b="<?php echo '*************************\nPayment:'.($neworder_order_paymentmethod).'\n---------\n'.($neworder_order_delivermethod).'\n---------\n'.($neworder_order_delivertime).'\n*************************\n\n\n'; ?>";
	
	var c="<?php echo ($neworder_content_dishes_only).'\n-------------------------\ntotal: '.($neworder_order_totalprice).' euro\n\nNotification(Melding):\n'.($neworder_order_usernote).'\n';?>";
	
	javascript:lee.funAndroid(a, b, c, 'English');
	
<?php
if($printCode==2){
?>
    javascript:lee.funAndroid(a, b, c, 'English');
<?php
}else if($printCode==3 && !empty($neworder_content_chinese)){
?>

    var a_chinese = "<?php echo '预订时间:\n'.($neworder_order_created_at).'\n\n客人信息:\n'.($neworder_user_name).'\n'.($neworder_user_address).'\n'.($neworder_user_number).'\n\n客人备注:\n'.($neworder_order_usernote).'\n\n'; ?>";
	var b_chinese ="<?php echo '*************************\n付款:'.($neworder_order_paymentmethod).'\n---------\n'.($neworder_order_delivermethod).'\n---------\n\n*************************\n\n\n'; ?>";
	var c_chinese ="<?php echo ($neworder_content_chinese).'\n--------------------\n总价格: '.($neworder_order_totalprice).' \n\n\n';?>";;
    javascript:lee.funAndroid(a_chinese, b_chinese, c_chinese, 'Chinese');
		
<?php
}
?>

	return false;
}

function printConfirmedtime(d){
	var a = "*************************\n";
	var b = "<?php echo _tr($neworder_order_delivermethod_chinese); ?>\n<?php echo _tr($neworder_order_paymentmethod_chinese); ?>\n<?php echo _tr('预计送餐时间'); ?>: "+d+"\n";
	var c= "*************************\n\n\n\n";
	
	javascript:lee.funAndroid(a, b, c, 'ConfirmDeliveryTime');
}

function sendReply(orderid, delayminutes){
	
	clearTimeout(t);
	
	$('#updateindication').fadeIn('fast');
	
	var orderID=orderid;	

	var d_time_hour=parseInt("<?php echo $sugg_hour; ?>");
	var d_time_minute=parseInt("<?php echo $sugg_min; ?>")+parseInt(delayminutes);
	
	if(d_time_minute>=60){
		d_time_hour+=1;
		d_time_minute=d_time_minute-60;
	}
	
	var str_d_time_hour=d_time_hour.toString();
	var str_d_time_minute=d_time_minute.toString();
	
	if(str_d_time_hour.length==1){
		str_d_time_hour='0'+str_d_time_hour;
	}
	if(str_d_time_minute.length==1){
		str_d_time_minute='0'+str_d_time_minute;
	}
	
	
	$('button#replybtn, button#cancelbtn').attr('disabled','disabled');
	$('button#replybtn').html('<i class="fa fa-hourglass-end" aria-hidden="true"></i> <?php echo _tr('保存中'); ?>...');
	
	tt=setTimeout('SendingmessageFailed()',8000);
	
	printConfirmedtime(str_d_time_hour+':'+str_d_time_minute);
	
	$.post( 
	  "sendconfirmation.php",
		{ order_id: orderID, hour: str_d_time_hour, minute: str_d_time_minute},
	  function( data ) {
			
			clearTimeout(tt);
			
			if($.trim(data)=="SUCCESS"){
				
				$('button#replybtn').html('<i class="fa fa-check-circle" aria-hidden="true"></i> <?php echo _tr('已发送'); ?>');
				$('button#replybtn').css('background-color','#093');
				setTimeout('refreshthepage()', 1000);				
			}else{
				alert('<?php echo _tr('客人手机号码错误，无法发送短信'); ?>');				
				refreshthepage();				
			}
		}
	);	
}
function rejectOrder(orderid){
	
	var r=confirm('确定拒绝这张单吗？');
	
	if(r){
		
		clearTimeout(t);
			
		$('#updateindication').fadeIn('fast');
		
		var orderID=orderid;
		
		$('button#replybtn, button#cancelbtn').attr('disabled','disabled');
		$('button#cancelbtn').html('<i class="fa fa-hourglass-end" aria-hidden="true"></i> <?php echo _tr('正在取消订单'); ?>...');
		
		tt=setTimeout('SendingmessageFailed()',8000);
		
		$.post( 
			"rejectorder.php",
			{order_id: orderID},
			function( data ) {
				clearTimeout(tt);
				if($.trim(data)=="SUCCESS"){
					$('button#cancelbtn').html('<i class="fa fa-ban" aria-hidden="true"></i> <?php echo _tr('已取消'); ?>!');
					$('button#cancelbtn').css('background-color','#093');					
					setTimeout('refreshthepage()', 1000);				
				}else{
					alert('<?php echo _tr('客人手机号码错误，无法发送短信'); ?>');					
				}
			}
	);
	}
}

//

$(document).ready(function(e) {
  playSound('oppo.mp3');//有新单的时候声音信息一定要播放一次 
	printTheTicket_in_format();
});

function SendingmessageFailed(){
	alert("<?php echo _tr('客人手机号码错误，无法发送短信'); ?>");
	refreshthepage();
}

</script>
<?php
}//if($newfound){
?>
    
<script type="text/javascript">


var lastSoundPlaySeconde = new Date().getTime() / 1000;
var roundCounting=0;
var t=0;


$(document).ready(function(){
	t=setTimeout(checkorder, 500);
	//启动android端定时检测，是否webview仍然活跃
	javascript:lee.startResetTimer(180);
});
	
function checkorder(){
	
	clearTimeout(t);
	if(roundCounting<100){
	    roundCounting++;
	}else{
	    roundCounting=1;
	}
	
	//让指示图标显示动画，以判断javascript是否还活跃
	$('#roundcounter').html(roundCounting);
	$("#m i.fa").finish().delay(2000).fadeOut(300).delay(500).fadeIn(200).delay(2000).fadeOut(300).delay(500).fadeIn(200).delay(2000).fadeOut(300).delay(500).fadeIn(200).delay(2000).fadeOut(300).delay(500).fadeIn(200).delay(2000).fadeOut(300).delay(500).fadeIn(200);
	
	//和android段沟通，确定webview仍然活跃
	javascript:lee.checkBrowserActive();
	
	var crr_seconds = new Date().getTime() / 1000; 
	
	var crr_new_order_NUM=parseInt($('span#newordersnum').text());
	
	
	var d = new Date();
  var crrhour = d.getHours();
	
	if(crr_new_order_NUM>1){
		//$('p.moreorder-indication').html('still '+(crr_new_order_NUM-1)+' orders');//show there are more orders than 1
		$('span.stillordernum').html(crr_new_order_NUM-1);
	  $('p.moreorder-indication').addClass('show');
	}
	/*
	if(crrhour>22 || crrhour<11){//不在工作时间不需要检查服务器以节约流量
		$('#roundcounter').html(roundCounting+'ˆ'+crrhour);
		t=setTimeout(checkorder, 15000);
		return;
	}
	*/
	$.post( 
	  "checkorder.php",
		{restaurant_id: "<?php echo $restaurant_id; ?>"},
	  function( data ) {
			var returned_order_NUM=parseInt(data);
		
			
			if(returned_order_NUM!=0){
				if((crr_seconds-lastSoundPlaySeconde)>60){//如果有新订单，且超过几分钟点没接收，则每隔该时间段声音提醒一次
				  playSound('bar.mp3');
					lastSoundPlaySeconde=crr_seconds;
				}
			}else{
				lastSoundPlaySeconde=crr_seconds;
			}
			
			if(returned_order_NUM!=crr_new_order_NUM){
				
				lastSoundPlaySeconde=crr_seconds;				
				
				$('span#newordersnum').html(returned_order_NUM);
				if(returned_order_NUM>0){
				  $('span#newordersnum').removeAttr('class');
				}
				
				if(crr_new_order_NUM>0){		//如果已经有订单，不刷新。播放提醒
				  playSound('oppo.mp3');//有新单的时候声音信息一定要播放一次	
					t=setTimeout(checkorder, 15000);
					$('p.moreorder-indication').html('still '+(returned_order_NUM-1)+' orders');
					$('p.moreorder-indication').addClass('show');
				}else{ // 如果还没有订单，直接刷新浏览器。播放声音并且打印订单
					clearTimeout(t);
				  refreshthepage();
				}
				
				
			}else{
				t=setTimeout(checkorder, 15000);
			}
		}
	);
	if(roundCounting>=240){
		refreshthepage();
	}	
}

	
function showOrderDetail(orderid){
	$('div.ordercontent').not('#'+orderid+' div.ordercontent').slideUp();
	$('#'+orderid+' div.ordercontent').slideDown();
	console.log(orderid);
}



function completeOrder(orderid){
	var orderID=orderid;
	
	$('button#completeOrderBtn_'+orderid).attr('disabled','disabled');
	$('button#completeOrderBtn_'+orderid).html('<i class="fa fa-hourglass-end" aria-hidden="true"></i> <?php echo _tr('保存中'); ?>...');
	
	$.post( 
	  "completeorder.php",
		{order_id: orderID},
	  function( data ) {
		  //$( ".result" ).html( data );
			if($.trim(data)=="SUCCESS"){
				$('button#completeOrderBtn_'+orderid).html('<i class="fa fa-check-square-o" aria-hidden="true"></i> <?php echo _tr('订单已完成'); ?>!');
				$('button#completeOrderBtn_'+orderid).css('background-color','#093');
				setTimeout('refreshthepage()', 300);				
			}else{
				alert('Unknown error: '+data);
				refreshthepage();
			}
		}
	);	
}

function refreshthepage(){
	//location.reload();
	javascript:lee.resetBrowser();
}

function playSound(a){
	   
	//var a = "SN";
	javascript:lee.playSoundNoti(a);   
	return false;
}


function stopT(){
  javascript:lee.checkBrowserActive();
	clearTimeout(t);
}


function showTodo(){
	refreshthepage();
}
function showDone(){
	console.log('showdone');
	$('li.order_complete_NO').slideUp();
	$('li.order_complete_YES').slideDown();
	$('button#showDone').removeClass('crrinactivenbtn');
	$('button#showTodo').addClass('crrinactivenbtn');
}


function openReplyWindow(){
	/*
	$('div.replycontainer').slideDown();
	$('button.r-window-btn').fadeOut();
	*/
}
</script>

  	

<?php
include('includes/footer.php');
?>
</body>
	
</html>