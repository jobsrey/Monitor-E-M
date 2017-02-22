<html>
<head>
<title>Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
.frame { width:527px; height:300px;  }
.left {float:left; padding-left:40px; width:200px; padding-top:15px; font: normal 12px arial; color:#333333}
.right {float:right; margin-right:30px; padding-top:70px; width:230px; font: normal 12px arial; color:#666666}
.form {font: normal 11px arial; width:180px; color:#333333; border:1px solid #666666;}
.lupa a{color:#333333; text-decoration:underline; font:normal 11px arial;}
.lupa a:hover {text-decoration:none;}
.red {
	color:#F00;
	font-weight: bold;
}
.style1 {
	color: #006666
}
.style3 {
	font-size: 14px
}
</style>
<script type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
  
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('/asset/images/login2.jpg')">
<div align="center">
<table width="527" height="100%" cellpadding="0" cellspacing="0">
<tr><td align="center" valign="middle">
	<div class="frame">
    	<div class="left" align="left">
        	<p class="style3"><strong>&nbsp;&nbsp;&nbsp;Welcome to<br>
        	  <img src="/asset/images/logo.png" width="180" height="43" vspace="10"><br>
        	  &nbsp;&nbsp;&nbsp;Web Administrator. </strong><br>
       	      <br>
       	      <em>&nbsp;&nbsp;<span class="style1">&nbsp;Use a valid username and &nbsp;&nbsp;&nbsp;password to gain access to<br>
&nbsp;&nbsp;       	      the administration console </span></em><span class="style1">.</span></p>
        	<p>&nbsp;</p>
        	<p>&nbsp; </p>
    	</div>
        <div class="right" align="left">
        	<span style="font:normal 25px arial;">
			<? if($login_type=="login_member"){ ?>Login MEMBER<? } ?>
			<? if($login_type=="login_merchant"){ ?>Login MERCHANT<? } ?>
            
            </span>
        
        	<? if(!empty($result)){ ?>
        	<span class="red" style="padding-left:45px;display:inline-block;"><?=$result?></span>
            <br>
            <br>
            <? }else{ ?>
            <br> 
			<br>
            <br>
            <br> 
            <? } ?>
		<form method="post" action="<?=base_url()?><?=index_page();?><?=$login_type;?>/signin">
  			<div><strong>Username</strong> / Email Address</div>
            <div><input name="username" type="text" class="form" style="font-size:16px" value="0123456789" autocomplete="off" >
            </div>
            <div style="padding-top:5px;"><strong>Password</strong></div> 
            <div><input name="password" type="password" class="form" style="font-size:16px" value="1" autocomplete="off" >
            </div> 
            <div style="padding-top:10px; float:left">
              <input name="image" type="image" id="Image1" onMouseOver="MM_swapImage('Image1','','/asset/images/login2.jpg',1)" onMouseOut="MM_swapImgRestore()" src="/asset/images/login1.jpg">
            </div>
            <? /* <div style="margin-left:5px; padding-top:12px; float:left;" class="lupa">[ <a href="#">forget password?</a> ]</div>  */ ?> 
      	</form>        
        </div> 
    </div> 
</td></tr>
</table>
</td>

</div>
</body>
</html>
