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
  <span class="navi-btns-container"><button id="showTodo" onClick="showTodo()"><?php echo _('处理中'); ?></button><button id="showDone" class="crrinactivenbtn" onClick="showDone()"><?php echo _('已完成'); ?></button> | <a href="options.php?restaurant_id=<?php echo $restaurant_id;?>&language=<?php echo $crr_lang; ?>"><i class="fa fa-cog" aria-hidden="true"></i> <?php echo _('设定'); ?></a></span>
</h3>

  <ul class="theorderlistcontainer">
  
<?php
$sql='SELECT * FROM orders WHERE restaurant_id = '.$restaurant_id.' AND DATE(`order_created_at`) = CURDATE()  ORDER BY id ASC';


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
<li class="order accepted_<?php echo $order_accepted; ?> order_complete_<?php echo $order_complete; ?>" id="order_<? echo $crr_order_id; ?>">

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
<p style="position:relative; margin:0; text-align:right;">
<?php if(empty($row['order_accepted'])){ ?>
<span class="bedeliveredat orange"><i class="fa fa-bell" aria-hidden="true"></i> <?php echo $order_confirmedtime; ?></span>
<?php
}else{
?>
<span class="bedeliveredat green"><i class="fa fa-check-circle-o" aria-hidden="true"></i> <?php echo $order_confirmedtime; ?></span>
<?php
}

if($row['order_complete']=="NO"){
?>
<button id="completeOrderBtn_<? echo $crr_order_id; ?>" class="completeOrderBtn" onClick="completeOrder(<? echo $crr_order_id; ?>)"><i class="fa fa-check-square-o" aria-hidden="true"></i> <?php echo _('订单已完成'); ?></button>
<?php
}
?>

</p>
<button class="detailbtn" onClick="showOrderDetail('order_<? echo $crr_order_id; ?>')"><i class="fa fa-eye"></i> <?php echo _('订单详情'); ?></button>
</div>

<div class="ordercontent">
<?php
$ordercontent_raw=$row['order_content_dishes_only'];
$ordercontent=str_replace($breaksigns, "<br>", $ordercontent_raw);

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
$sql_last_new='SELECT * FROM orders WHERE  restaurant_id = '.$restaurant_id.' AND order_accepted IS NULL ORDER BY order_created_at ASC LIMIT 1';
$stmt_ln=$conn->query($sql_last_new);
$newfound=$stmt_ln->rowCount();
if($newfound){
	foreach($stmt_ln as $rn){
		$newordercontent_raw=$rn['order_content'];
		$neworder_content_dishes_only=$rn['order_content_dishes_only'];
		
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
	}
?>
<div class="neworderdialogue-grandcontainer">
<div class="neworderdialogue-innercontainer">
<h4 class="neworderdialoguetitle"><i class="fa fa-bell" aria-hidden="true"></i> <?php echo _('新订单'); ?></h4>
<div class="newordercontent">
  <div class="orderbriefing">
  <span class="ordertime">
  <?php 
	//echo $rn['order_created_at']; 
	$dn = new DateTime($rn['order_created_at']);
	echo $dn->format('H:i:s'); // 
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
	
	
	
	$ordercontent.='<p style="margin:3px; font-size:12px;"><strong>User note:</strong> '.$neworder_order_usernote.'</p>';
  echo $ordercontent;
  ?>
  </div>
</div>
<p class="replybtncontainer"><button onClick="openReplyWindow()" class="r-window-btn"><?php echo _('发确认短信'); ?></button></p>
<div class="replycontainer">
<p class="replywords"><?php echo _('回复内容'); ?></p>


<div class="replytext">
<?php echo $restaurantname; ?>: Thanks for the order (in total <?php echo $rn['order_totalprice']; ?> euro) 
We are processing this order 

<?php
if($row['order_delivermethod']=='afhalen' || $row['order_delivermethod']=='self pick up'){
?>
and it will be ready around  
<?php
}else{
?>
and the estimate deliver time is around   
<?php
}
$userchosen_d_time=$row['order_delivertime'];
if(strpos($userchosen_d_time, ':') !== false){
	$sugg_time=explode(':',$userchosen_d_time);
	$sugg_hour=$sugg_time[0];
	$sugg_min=$sugg_time[1];
}else{
	$crr_h=date('H');
	$crr_m=date('i');
	
	if($crr_m>=30){
		$sugg_hour=$crr_h+1;
		$sugg_min=00;
	}else{
		$sugg_hour=$crr_h;
		$sugg_min=30;
	}
}
?>
<p class="choosingfield">
<select name="d_time_hour" id="d_time_hour">
<option value="12"<?php if($sugg_hour=='12') echo ' selected="selected"'; ?>>12</option>
<option value="13"<?php if($sugg_hour=='13') echo ' selected="selected"'; ?>>13</option>
<option value="14"<?php if($sugg_hour=='14') echo ' selected="selected"'; ?>>14</option>
<option value="15"<?php if($sugg_hour=='15') echo ' selected="selected"'; ?>>15</option>
<option value="16"<?php if($sugg_hour=='16') echo ' selected="selected"'; ?>>16</option>
<option value="17"<?php if($sugg_hour=='17') echo ' selected="selected"'; ?>>17</option>
<option value="18"<?php if($sugg_hour=='18') echo ' selected="selected"'; ?>>18</option>
<option value="19"<?php if($sugg_hour=='19') echo ' selected="selected"'; ?>>19</option>
<option value="20"<?php if($sugg_hour=='20') echo ' selected="selected"'; ?>>20</option>
<option value="21"<?php if($sugg_hour=='21') echo ' selected="selected"'; ?>>21</option>
<option value="22"<?php if($sugg_hour=='22') echo ' selected="selected"'; ?>>22</option>
<option value="23"<?php if($sugg_hour=='23') echo ' selected="selected"'; ?>>23</option>
</select>
:
<select name="d_time_minute" id="d_time_minute">
<option value="00"<?php if($sugg_min=='00') echo ' selected="selected"'; ?>>00</option>
<option value="15"<?php if($sugg_min=='15') echo ' selected="selected"'; ?>>15</option>
<option value="30"<?php if($sugg_min=='30') echo ' selected="selected"'; ?>>30</option>
<option value="45"<?php if($sugg_min=='45') echo ' selected="selected"'; ?>>45</option>
</select>
</p>
</div>
<button id="replybtn" onClick="sendReply(<?php echo $orderid; ?>)"><i class="fa fa-paper-plane" aria-hidden="true"></i> <?php echo _('发送短信'); ?> </button>
</div><!-- end replycontainer -->
<button id="cancelbtn" onClick="cancelOrder(<?php echo $orderid; ?>)"><i class="fa fa-step-forward" aria-hidden="true"></i> <?php echo _('忽略短信发送，关闭窗口'); ?> </button>
</div><!-- end neworderdialogue-innercontainer -->
<p class="moreorder-indication"></p>
</div><!-- end neworderdialogue-grandcontainer -->



<script type="text/javascript">

function printTheTicket_in_format(){
	var a = "<?php echo '\n'.$neworder_order_created_at.'\n-----\n';?>";
	var b='<?php echo $neworder_content_dishes_only;?>';
	var c='<?php echo '\n-----\ntotal: '.$neworder_order_totalprice.' euro\n--\n- '.$neworder_order_delivermethod.'\n- '.$neworder_order_delivertime.'\n\n\n***********\nClient info:\n'.$neworder_user_name.'\n'.$neworder_user_address.'\n'.$neworder_user_number.'\n\nNotification(Melding):\n'.$neworder_order_usernote.'\n\n\n***********\nPayment Method:\n'.$neworder_order_paymentmethod.'\n.\n.\n----------\n----------\n----------\n----------\n';?>';
	javascript:lee.funAndroid(a, b, c);
	playSound('oppo.mp3');//有新单的时候声音信息一定要播放一次   
	return false;
}
/**/



$(document).ready(function(e) {
  printTheTicket_in_format();
});
</script>
<?php
}
?>
<audio id="notificationsound" src="notificationsound.mp3" preload="auto"></audio>
<a style="display:none;">点击调用android原生方法打印</a>
    
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
	
	if(crr_new_order_NUM>1){
		$('p.moreorder-indication').html('still '+(crr_new_order_NUM-1)+' orders');//show there are more orders than 1
	  $('p.moreorder-indication').addClass('show');
	}
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
				$('span#crrt').html('sound is 475 : '+returned_order_NUM+' | '+crr_new_order_NUM);
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

function sendReply(orderid){
	var orderID=orderid;
	var d_time_hour=$('#d_time_hour').val();
	var d_time_minute=$('#d_time_minute').val();
	
	$('button#replybtn, button#cancelbtn').attr('disabled','disabled');
	$('button#replybtn').html('<i class="fa fa-hourglass-end" aria-hidden="true"></i> <?php echo _('保存中'); ?>...');
	
	$.post( 
	  "sendconfirmation.php",
		{ order_id: orderID, hour: d_time_hour, minute: d_time_minute},
	  function( data ) {
			if($.trim(data)=="SUCCESS"){
				$('button#replybtn').html('<i class="fa fa-check-circle" aria-hidden="true"></i> <?php echo _('已发送'); ?>');
				$('button#replybtn').css('background-color','#093');
				clearTimeout(t);
				setTimeout('refreshthepage()', 1000);				
			}else{
				alert('Invalid mobile number!');
				clearTimeout(t);
				refreshthepage();
			}
		}
	);	
}
function cancelOrder(orderid){
	var orderID=orderid;
	
	$('button#replybtn, button#cancelbtn').attr('disabled','disabled');
	$('button#cancelbtn').html('<i class="fa fa-hourglass-end" aria-hidden="true"></i> <?php echo _('正在取消'); ?>...');
	
	$.post( 
	  "cancelorder.php",
		{order_id: orderID},
	  function( data ) {
		  //$( ".result" ).html( data );
			if($.trim(data)=="SUCCESS"){
				$('button#cancelbtn').html('<i class="fa fa-ban" aria-hidden="true"></i> <?php echo _('已取消'); ?>!');
				$('button#cancelbtn').css('background-color','#093');
				clearTimeout(t);
				setTimeout('refreshthepage()', 1000);				
			}else{
				alert('Unknown error: '+data);
				clearTimeout(t);
				refreshthepage();
			}
		}
	);	
}

function completeOrder(orderid){
	var orderID=orderid;
	
	$('button#completeOrderBtn_'+orderid).attr('disabled','disabled');
	$('button#completeOrderBtn_'+orderid).html('<i class="fa fa-hourglass-end" aria-hidden="true"></i> <?php echo _('保存中'); ?>...');
	
	$.post( 
	  "completeorder.php",
		{order_id: orderID},
	  function( data ) {
		  //$( ".result" ).html( data );
			if($.trim(data)=="SUCCESS"){
				$('button#completeOrderBtn_'+orderid).html('<i class="fa fa-check-square-o" aria-hidden="true"></i> <?php echo _('订单已完成'); ?>!');
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
	$('div.replycontainer').slideDown();
	$('button.r-window-btn').fadeOut();
}
</script>

  	

<?php
include('includes/footer.php');
?>
</body>
	
</html>