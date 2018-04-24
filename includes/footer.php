<p style="font-size:10px; color:#999; position:fixed; bottom:25px; left:0; z-index:888; background-color:#FFC; display:none;"><span id="crrt"></span></p>
   
<?php
$sql_restaurant='SELECT * FROM restaurants WHERE id = '.$restaurant_id;
foreach($conn->query($sql_restaurant) as $rowr){
	$name_restaurant=$rowr['restaurant_name'];
}
?>
<p id="m" style="font-size:12px; color:#333; position:fixed; bottom:0; left:0; z-index:98; background-color:#FFC; text-align:center; margin:0; padding:3px; width:100%;" id="monitor"><?php echo $name_restaurant; ?><span id="roundcounter"></span><i class="fa fa-refresh" aria-hidden="true"></i></p>