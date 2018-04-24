<!DOCTYPE html>
<html>

<head>
<title>AsiaCuisine - My orders</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

	<body>

<h3 class="pagetitle">
<input type="text" id="printcontent" name="printcontent" style="width:300px;" /><br /><br /><br /><br />
<button class="detailbtn" onClick="printTheTicket_in_format()"><i class="fa fa-eye"></i> 打印</button>
</h3>

  
  
  

<script type="text/javascript">

function printTheTicket_in_format(){
    
	var a = $('input#printcontent').val();
	javascript:lee.funAndroid(a);
 
	return false;
	
	//alert(a);
}
/**/



$(document).ready(function(e) {
 // printTheTicket_in_format();
});
</script>
 
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

	

</script>

  	

</body>
	
</html>