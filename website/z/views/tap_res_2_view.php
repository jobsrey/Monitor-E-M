<?
 
$arr_response = explode("<br>",$response);

$arrRes = array(); $resProd = 0; $curProductID = 0; $prod_num = 0;
foreach($arr_response as $key => $value){
	if(!$resProd)
	if(!empty($value))
	if(preg_match('/ => /i',$value))
	{
		//echo "<br>$key => $value";
		$arr = explode(" => ",$value);
		$arrRes[trim($arr[0])] = $arr[1]; 
	}
	
 
}
/*
foreach($arrRes as $key => $value){ 
		echo "<br>$key => $value";
 

}	

transaction_id = 021-160508-210649
card_number = 7610000001
member_credit = 1
merchant_id = 0210004
merchant_product = 19
trx_result = SUCCESS. Thank You for using Tribun Family Card. 
exit;
*/

?><html>
<head>
<title>Sim Transaction</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
.frame {
	width:527px;
	height:300px;
}
.left {
	float:left;
	padding-left:40px;
	width:200px;
	padding-top:15px;
	font: normal 12px arial;
	color:#333333
}
.right {
	float:right;
	margin-right:30px;
	padding-top:70px;
	width:230px;
	font: normal 12px arial;
	color:#666666
}
.form {
	font: normal 11px arial;
	width:180px;
	color:#333333;
	border:1px solid #666666;
}
.lupa a {
	color:#333333;
	text-decoration:underline;
	font:normal 11px arial;
}
.lupa a:hover {
	text-decoration:none;
}
.red {
	color:#F00;
	font-weight: bold;
}
.style5 {
	color: #F00;
	font-weight: bold;
	font-size: 12px;
}
.style7 {
	font-size: 11px;
	font-family: Arial, Helvetica, sans-serif;
}
.style9 {
	font-size: 12px
}
</style>
<script type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
</head>
<body style="font:normal 13px tahoma" bgcolor="#bbbbbb" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="100%" cellpadding="20" cellspacing="0" border="0">
  <tr>
    <td align="center" valign="top"><table width="100%" cellpadding="0" cellspacing="0" style="max-width:300px;">
        <tr>
          <td align="center" bgcolor="#FFFFFF"><img src="/asset/images/logo.png" width="180" height="43" hspace="5" vspace="10"></td>
        </tr>
        <tr>
          <td align="center" bgcolor="#003366"><div style="padding:20px">
              <form name="form1" method="post" action="/query_tap/val">
                <table border="0" cellpadding="5" cellspacing="0"  style="color:#cccccc">
                  <tr>
                    <td align="center">
                    
					 <div style='color:#eeeeee'>Transaction ID :</div> 
					 <div style='color:#ffffff'><strong><?=$arrRes['transaction_id'];?></strong></div>  
                    
                    </td>
                  </tr>
                  <tr>
                    <td align="center"><div style="margin-bottom:0;">--------------------------------------</div></td>
                  </tr> 
                  <tr>
                    <td align="center"> <?=$arrRes['trx_result'];?> </td>
                  </tr>
                  
                 
                  <tr>
                    <td align="left" style="font-size:15px">&nbsp; 
                    </td>
                  </tr>
                  
                  <tr>
                    <td align="center">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center"><input type="button" name="button" id="button" value="&lt;- Start-Over :: Cancel" onClick="window.location.assign('/tap')"></td>
                  </tr>
                </table>
              </form>
            </div>
            </td>
        </tr>
      </table></td>
  </tr>
</table>
</td>
</body>
</html>
