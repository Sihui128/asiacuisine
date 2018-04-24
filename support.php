<?php
include_once('includes/header.php');
?>



<!DOCTYPE html>
<html>

<head>
<title>AsiaCuisine - Help</title>
<?php
include_once('includes/header-elements.php');
?>
<style>
div.supportcontent{
    padding:15px;
    margin:0;
}
.titlehelp{
    margin-top:75px;
    text-align:center;
    margin-bottom:0;
}
#wechatqr{
    width:128px;
}
span.wechatcaption{
    display:inline-block;
    padding-top:5px;
    font-size:12px;
}
.supportcontent p{
    margin-top:0;
}
p.wechatqrcontainer{
    text-align:center;
    margin-top:35px;
}
img.support-icon{
    height:26px;
    position:relative;
    top:5px;
    left:-3px;
}
p.contactinfo{
    margin:0 0 6px 0;
    font-size:20px;
    font-weight:bold;
}
span.wechaticoncontainer{
    display:inline-block;
    width:18px;
    height:22px;
    position:relative;
    overflow:visible;
    top:2px;
    left:-4px;
}
img.wechaticon{
    width:auto;
    height:22px;
}
button#showTodo{
    border:none;
}
button#showTodo, button#showDone{
    display:none;
}
button#showgoback{
    background-color: #FC6;
    margin: 0 5px;
    border-width: 1px;
    border-style: solid;
    border-color: #FC6;
    padding: 5px 23px;
    border-radius: 6px;
}

</style>
</head>

	<body>
  
<?php
include_once('includes/menu.php');
?>

<h3 class="pagetitle">
<span id="newordersnum" class="newordersnum_<?php echo $num; ?>"><?php echo $num; ?></span>

  <span class="navi-btns-container">
      
      
      <button id="showTodo" onClick="showTodo()"><?php echo _('处理中'); ?></button><button id="showDone" class="crrinactivenbtn" onClick="showDone()"><?php echo _('已完成'); ?></button> 
      
      
      <button id="showgoback" onClick="showTodo()">
         🔙 <?php echo _('返回订单页面'); ?>
      </button> 
      
      
      | <a href="support.php?restaurant_id=<?php echo $restaurant_id;?>&language=<?php echo $crr_lang; ?>"><i class="fa fa-phone-square" aria-hidden="true"></i> <?php echo _('帮助'); ?></a></span>
</h3>
<?php
if(isset($_GET['language']) && $_GET['language']=='en'){
?>
<h3 class="titlehelp"><img class="support-icon" src="support-asiacuisine.ico" />Problem？Contact us now</h3>
<div class="supportcontent">
    <p>If you need any help, for example changing the information on the website or experiencing any technical problem, please do not hesitate to contact us:</p>
    <p class="contactinfo"><i class="fa fa-phone-square" aria-hidden="true"></i> Phone: 0485123391</p>
    <p class="contactinfo"><span class='wechaticoncontainer'><img class="wechaticon" height="30" src="asiacuisine-support-wechat.png" /></span> Wechat: AsiaCuisine</p>
    <p class="wechatqrcontainer"><img id="wechatqr" src="qrcode-wechat-asiacuisine.png" /><br /><span class="wechatcaption">Scan QR code to Wechat</span></span></p>
</div>
<?php
}else{
?>
<h3 class="titlehelp"><img class="support-icon" src="support-asiacuisine.ico" />有问题？立刻联系我们</h3>
<div class="supportcontent">
    <p>如果您有任何问题需要我们的帮助，或需要更改时间或网站上的信息，请随时联系我们:</p>
    <p class="contactinfo"><i class="fa fa-phone-square" aria-hidden="true"></i> 电话: 0485123391</p>
    <p class="contactinfo"><span class='wechaticoncontainer'><img class="wechaticon" height="30" src="asiacuisine-support-wechat.png" /></span> 微信: AsiaCuisine</p>
    <p class="wechatqrcontainer"><img id="wechatqr" src="qrcode-wechat-asiacuisine.png" /><br /><span class="wechatcaption">扫二维码加微信</span></span></p>
</div>
<?php
}
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




function refreshthepage(){
	//location.reload();
	javascript:lee.resetBrowser();
}

function showTodo(){
	//$('input#thelist').val('TODO');
	//$('form#thelistform').submit();
	refreshthepage();
}
function showDone(){
	refreshthepage();
}

</script>

  	

<?php
include('includes/footer.php');
?>
</body>
	
</html>