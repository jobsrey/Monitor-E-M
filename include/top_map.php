<!DOCTYPE html>
<html >
<head>
<title><?=$pageTITLE;?></title> 
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">  
<meta name="description" content="the self services kiosk to buy prepaid card e-money and cash top-up machine">
<link rel="icon" type="image/x-icon" href="/asset/images/favicon.ico"/> 
<link rel="stylesheet" type="text/css" media="screen" href="/asset/css/main.css" /> 
<script type="text/javascript" language="javascript" src="/asset/js/jquery.js"></script>   
<script type="text/javascript" language="javascript" src="/asset/js/allscript.js"></script>
<!--[if lt IE 10] -->
<script> 
toggleItem = function(){
    var el = document.getElementsByTagName('blink')[0];
    if (el.style.display === 'block') {
        el.style.display = 'none';
    } else {
        el.style.display = 'block';
    }
}
setInterval(toggleItem, 1000);
</script>
<!--[endif]--> 
<style>
.blink {
  -webkit-animation: blink 1s steps(5, start) infinite;
  -moz-animation:    blink 1s steps(5, start) infinite;
  -o-animation:      blink 1s steps(5, start) infinite; 
  animation:         blink 1s steps(5, start) infinite;
}

@-webkit-keyframes blink {
  to { visibility: hidden; }
}
@-moz-keyframes blink {
  to { visibility: hidden; }
}
@-o-keyframes blink {
  to { visibility: hidden; }
}
@keyframes blink {
  to { visibility: hidden; }
}
</style> 
 





</head>
<body onload="initialize()">

<? 
//$is_pop=1;
if(!$is_pop) {
require_once('include/h.php'); ?> 
<div class="linetop"></div>
<? } ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
<? if(!$is_pop){ ?>
    <td align="left" valign="top" bgcolor="#FFFFFF">
		<div class="lblmainmenu"><a href="/" style="color:red"><? /* MAIN MENU */?></a></div>
    	<?=$navMenu?>
		<div class="lblmainmenu"><a href="/login/logout" style="color:red"><? /* LOGOUT */?></a></div>
	</td>
<? } ?>
    <td width="100%" valign="top" nowrap="nowrap">
		