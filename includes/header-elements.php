<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta chatset="utf-8" />
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<style type="text/css">

body{
    margin: 0px;
    padding: 0;
	font-family:"Helvetica Neue", Helvetica,Arial,sans-serif;
	max-height: 999999px;
	background-color:#FFF;
 }
a{
    text-decoration: none;
}
ul{
    padding:0;
    margin:0;
		padding-top: 78px;
}
h3.pagetitle{
    font-size: 18px;
    text-align: center;
    margin-top: 0;
    padding: 6px 0;
    max-height: 999999px;
    margin-bottom: 5px;
    z-index: 88;
    position: fixed;
    background-color: #eee;
    top: 0;
    left: 0;
    width: 100%;
    box-shadow: 0 0 12px rgba(58,58,58,0.8);
}
span#newordersnum{
    display:inline-block;
    position:relative;
    padding:8px;
    background-color:#c00;
    color:#fff;
    border-radius:100%;
    font-size:12px;
    width:18px;
    line-height:18px;
    top:-5px;
}
li.order{
    list-style: none;
    padding: 3px;
    font-size: 14px;
    background-color: #edeccf;
    color: #333;
    border-width: 3px;
    border-color: #a99959;
    margin-bottom: 20px;
    max-height: 999999px;
    position: relative;
    border-top-style: solid;
}
.order div{
	position:relative;
}
span.ordertime{
    display: block;
    font-size: 17px;
    color: #333;
    padding: 3px 6px 2px 0;
    margin: 5px auto 5px 5px;
    width: 78px;
    text-align: left;
}
.neworderdialogue-innercontainer span.ordertime{
    position: absolute;
    top: 3px;
}
span.orderby, span.totalword, span.paidbyword, span.bedeliveredatwords{
    display:inline-block;
    margin:5px 3px;
    color:#333;
    font-size:20px;
}
span.username, span.usertel, span.total, span.paidby, span.delivermethod, span.deliverytimeasked, span.bedeliveredat, button.completeOrderBtn{
    display: inline-block;
    background-color: #fdfcef;
    padding: 3px 6px;
    color: #000;
    font-size: 14px;
    margin: 1px;
    line-height: 20px;
    margin-right: 3px;
    margin-bottom: 3px;
}
span.deliverytimeasked{
	display:none;
}
span.username{
    font-weight:bold;
}
div.ordercontent{
    padding:20px;
    background-color:#fffee7;
    margin:6px;
    font-size:14px;
    display:none;
}
span.orange{
	background-color:#F90;
}
span.green{
	background-color:#3C3;
}
button.detailbtn{
	background-color: #3fdc39;
	color: #000;
	font-size: 14px;
	padding: 2px 6px;
	border-width: 1px;
	top: 0;
	right: 3px;
	border-radius: 6px;
}


/*-------*/
div.neworderdialogue-grandcontainer{
	position:fixed;
	width:100%;
	height:100%;
	top:0;
	left:0;
	background-color:rgba(0,0,0,0.9);
	overflow:auto;
	z-index:89;
}
div.neworderdialogue-innercontainer{
	position:relative;
	width:86%;
	margin:20px auto 0 auto;
	background-color:#FFF;
	padding:8px;
}
h4.neworderdialoguetitle{
	  text-align: center;
    font-size: 18px;
    margin: 0;
}
div.newordercontent{
	font-size:14px;
	padding-top:12px;
}
p.replywords{
	position: relative;
	display: inline-block;
	font-size: 12px;
	padding: 5px 8px;
	margin: 3px 0 0px 0;
	background-color: #FFC;
}
div.replytext{
	background-color:#FFC;
	font-size:14px;
	padding:5px;
	border-style:dashed;
	border-width:2px;
	border-color:#CCC;
	border-radius:6px;
}
p.choosingfield{
	display:inline-block;
	white-space:nowrap;
	margin:0;
}
.choosingfield select{
	background-color:#bdfcff;
}
button#replybtn{
	margin-top:12px;
	padding:6px 15px;
	font-size:14px;
	background-color:#0090F0;
	color:#FFF;
}
button#cancelbtn{
	padding:4px 9px;
	font-size:14px;
	background-color:#FC9;
	color:#C00;
	margin-top:8px;
}
span.newordersnum_0{
	display:none !important;
}

p.moreorder-indication{
	position:absolute;
	display:inline-block;
	background-color:#FFF;
	font-size:12px;
	padding:0;
	top:0;
	right:12px;
	display:none;
}
span.stillordernum{
	display:inline-block;
	background-color:#C30;
	color:#FFF;
	line-height:12px;
	height:12px;
	padding:3px 8px;
	border-radius:12px;
}
p.moreorder-indication.show{
	display:block;
}

span.navi-btns-container{
	display:inline-block;
	width:100%;
	padding:3px;
	line-height:20px;
}
button#showTodo, button#showDone, a.optionbtn{
	background-color: #FC6;
	margin: 0 5px;
	border-width: 1px;
	border-style: solid;
	border-color: #960;
	padding: 5px 23px;
	border-radius: 6px;
}
button.completeOrderBtn{
	background-color:#F90;
	padding: 2px 6px;
  border-radius: 8px;
}
a.optionbtn{
	background-color:#C63;
}



div.replycontainer{
	display:none;
}
p.replybtncontainer{
	margin-bottom:0;
}
button.r-window-btn{
	background-color:#39F;
	color:#FFF;
	font-size:16px;
	padding:3px 18px;
	margin:0;
}
button.crrinactivenbtn{
	border-style:none !important;
	border-color:#FFF !important;
	border-width:0 !important;
	background-color:#D7D899;
	color:#878787;
}



li.order_complete_YES{
	background-color:#CC0;
	display:none;
}
#m i.fa{
    display:inline-block;
    position:absolute;
    top:6px;
    right:35px;
    font-size:10px;
    color:#333; 
    /* #1fa67a */
}
#roundcounter{
    position: absolute;
    display: inline-block;
    top: 6px;
    right: 0px;
    font-size: 10px;
    color: #333;
    text-align: left;
    width: 30px;
}
.navi-btns-container a{
	color:#333;
	color: #333;
	font-size: 16px;
	font-weight: normal;
}
span.bedeliveredat{
	display:none;
}
.fa-phone-square{
    color:#1a9640;
}



/* v2.0 */
button.replytimebtn{
	display:block;
	width:25%;
	float:left;
	padding:12px 0;
	margin-bottom:5px;
}
button.replytimebtn.fullwidthbtn{
	width:50%;
	padding:8px 0;
}
div.replybtncontainer{
	background-color: #FFF;
	padding: 10px 0;
	position: fixed;
	left: 0;
	bottom: 15px;
	width: 100%;
}
div.replycontainer-inner{
	position:relative;
	padding:0 12px;
}
#updateindication{
	display:none;
	position:absolute; 
	width:100%; 
	height:100%; 
	top:0; 
	left:0; 
	background-color:rgba(255,255,255,0.85);
}

button.asrequesttimebtn{
	background-color:#9C9;
}
button.cancelsendingbtn{
	background-color:#e66;
}
p.buttonscontainer{
	position:absolute;
	top:-3px;
	right:3px;
	text-align:right;
	margin:0;
}
</style>
<script src="jquery-3.2.1.min.js"></script>