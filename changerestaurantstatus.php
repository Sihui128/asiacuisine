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
    position:relative;
}
.titlehelp{
    margin-top:25px;
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
    padding-top:20px;
}
img.support-icon{
    height:26px;
    position:relative;
    top:5px;
    left:-3px;
}
p.contactinfo{
    margin:0 0 6px 0;
    font-size:16px;
    font-weight:normal;
    text-align:center;
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
div.onlineorderbuttoncontainer{
    position:relative;
    text-align:center;
    padding:85px 0 35px 0;
    border-bottom-style:solid;
    border-width:1px;
    border-color:#999;
}
a.onlineorderbtn{
    position:relative;
    display:inline-block;
    padding:17px 20px;
    background-color:#FC6;
    border-radius:6px;
    font-size:18px;
    color:#000;
}
div#integratingframecontainer{
    border-style:solid;
	border-width:5px;
	border-color:#999;
	height:380px;
	margin-top:80px;
}
iframe#integratingframe{
	border-style:none;
	width:100%;
	height:100%;
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
      <a href="changerestaurantstatus.php?restaurant_id=<?php echo $restaurant_id;?>&language=<?php echo $crr_lang; ?>"><i class="fa fa-phone-square" aria-hidden="true"></i> <?php echo _('营业状态设定'); ?></a>
      
      <a href="orderhistory.php?restaurant_id=<?php echo $restaurant_id;?>&language=<?php echo $crr_lang; ?>"><i class="fa fa-phone-square" aria-hidden="true"></i> <?php echo _('订单记录'); ?></a>
      </span>
</h3>
<div id="integratingframecontainer">
    <iframe id="integratingframe" src="<?php echo $current_restaurant_url; ?>/wp-admin/edit.php?post_type=woc_hour&amp;page=woc_menu_settings&amp;origin=asiacuisineownerlogin">
</iframe>
</div>





<script type="text/javascript">

</script>

  	

<?php
include('includes/footer.php');
?>
</body>
	
</html>