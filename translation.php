<?php
function _tr($thestring){
	$crr_lang='zh';
	if(isset($_GET['language'])){
		$crr_lang=$_GET['language'];
	}
	if($crr_lang=='en'){
		switch ($thestring) {
				case "处理中":
						$thestring = 'To-Do';
						break;
				case "已完成":
						$thestring = 'Done';
						break;
				case "设置":
						$thestring = 'Options';
						break;
				case "订单已完成":
						$thestring = 'Order Completed';
						break;
				case "订单详情":
						$thestring = 'View Detail';
						break;
				case "新订单":
						$thestring = 'New Order';
						break;
				case "发确认短信":
						$thestring = 'Send Confirmation SMS';
						break;
				case "回复内容":
						$thestring = 'SMS content';
						break;
				case "发送短信":
						$thestring = 'Send the SMS';
						break;
				case "忽略短信发送，关闭窗口":
						$thestring = 'Skip Sending, Close Window';
						break;
				case "保存中":
						$thestring = 'Saving';
						break;
				
				case "已发送":
						$thestring = 'Sent';
						break;
				case "正在取消":
						$thestring = 'Canceling';
						break;
				case "已取消":
						$thestring = 'Canceled';
						break;
						
				case "帮助":
						$thestring = 'Help';
						break;
				case "设定":
						$thestring = 'Options';
						break;
				case "返回订单页面":
						$thestring = 'Back to order list';
						break;
				case "不接单":
						$thestring = 'Reject order';
						break;
				
		}
	}else if($crr_lang=='nl'){
		
	}else if($crr_lang=='fr'){
		
	}
	
	return $thestring;
}
?>