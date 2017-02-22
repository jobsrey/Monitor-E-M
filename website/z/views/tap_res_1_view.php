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
		$arrRes[$arr[0]] = $arr[1]; 
	}
	
	if($value=="PRODUCT MERCHANT:") $resProd=1; 
	
	if($resProd)
	if(!empty($value))
	if(preg_match('/ => /i',$value)){
		
		$arr = explode(" => ",$value);
		//$arrRes[$arr[0]] = $arr[1];  
		//echo "<br>".$arr[0]." => ".$arr[1]; 
		if($arr[0]=="item_id"){
			$prod_num++;
			 //$curProductID = $arr[1];
			 $arrRes['product_id'][$prod_num][$arr[0]] = $arr[1];
	 	}else{
			$arrRes['product_id'][$prod_num][$arr[0]] = $arr[1];
			//echo "<br> $curProductID - ".$arr[0]." => ".$arr[1]; 
		} 
	} 
}
/*
foreach($arrRes as $key => $value){
	if(!is_array($value)){
		echo "<br>$key => $value";
	}else{
		foreach($value  as $key2 => $value2)
		foreach($value2  as $key3 => $value3)
		echo "<br> $key => $key2 => $key3 => $value3"; 
	}

}	

curDate => 2016-05-08 18:27:31
card_number => 7610000001
merchant_id => 0210004
transaction_id => 021-160508-182731
MemberID => 556
FullName => Anwar Helmi
TFCNumber => 7610000001
TFCSerialNumber => E985EEBE
TFCStatus => VALID
TFCNoPolisi => BM 1871 QB
TFCValidDateBegin => 2016-04-26
TFCValidDateEnd => 2017-04-26
member_exist => 1
member_expired => 0
MerchantID => 7
TFCMerchantID => 0210004
TFCMerchantName => TesBenzi Auto Care
TFCMerchantStatus => VALID
TFCMerchantValidDateBegin => 2016-03-25
TFCMerchantValidDateEnd => 2017-03-25
TFCMerchantLogo => http://localhost/upload/autocare4.jpg
merchant_exist => 1
merchant_expired => 0
product_id => 1 => item_id => 17
product_id => 1 => item_merchant_id => 7
product_id => 1 => item_merchant_category => 1
product_id => 1 => item_merchant_type => 1
product_id => 1 => item_product_name => Car Wash
product_id => 1 => item_product_value => 1
product_id => 1 => item_product_periode => dy
product_id => 1 => item_product_credit => 20000
product_id => 1 => item_product_term => No Polisi Sesuai
product_id => 1 => item_trx_value_max => 1
product_id => 1 => item_trx_value_used => 0
product_id => 1 => item_trx_last_date =>
product_id => 1 => item_trx_allowed => OK
product_id => 1 => item_trx_value_credit => 1
product_id => 1 => item_trx_value_now => 1
product_id => 1 => item_trx_message => You are using 1 of 1 credit for this item / day
product_id => 1 => item_trx_url => http://localhost/query/trx/transaction_id=021-160508-182731---card_number=7610000001---card_serialnumber=E985EEBE---member_credit=1---merchant_id=0210004---merchant_product=17

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
                    <? if(isset($arrRes['VALIDATE_RESULT'])){
							if($arrRes['VALIDATE_RESULT']=="TRANSACTION DENIED"){
								echo $arrRes['VALIDATE_TEXT'];
								//echo "<br>".$arrRes['VALIDATE_RESULT'];
							}
						}else{		
							echo "Card-ID : <span style='color:#ffffff'>". $arrRes['card_number']."</span>";
							echo "<br>Name : <span style='color:#ffffff'>".$arrRes['FullName']."</span>";
							$subY = substr($arrRes['TFCValidDateEnd'],0,4);
							$subM = substr($arrRes['TFCValidDateEnd'],5,2);
							echo "<br><br><strong style=\"color:orange\">VALID</strong> thru : <span style='color:#ffffff'>$subM/$subY </span>";
                        }
					?>                      </td>
                  </tr>
                  <tr>
                    <td align="center"><div style="margin-bottom:0;">--------------------------------------</div></td>
                  </tr>
                  <tr>
                    <td align="center"><? if(trim($arrRes['TFCMerchantLogo'])) { ?><img src="<?=$arrRes['TFCMerchantLogo'];?>" width="200" style="margin-bottom:8px;"><? } ?>
                      <? if(isset($arrRes['MERCHANT_VALIDATE_RESULT'])){
							if($arrRes['MERCHANT_VALIDATE_RESULT']=="TRANSACTION DENIED"){
								//echo $arrRes['MERCHANT_VA$arrRes['TFCMerchantID']LIDATE_TEXT'];
								echo "SORRY, Merchant-ID: <strong>".$arrRes['TFCMerchantID']."</strong>";
								echo "<br><span style='color:#ffffff'><strong>".$arrRes['TFCMerchantName']."</strong></span>";
								echo "<br>Status : <span style='color:#ffffff'><strong>".$arrRes['TFCMerchantStatus']."</strong></span>";
								if($arrRes['TFCMerchantStatus']=="EXPIRED")
								echo "<br>Valid Date :<br>".substr($arrRes['TFCMerchantValidDateBegin'],0,7)." thru ".substr($arrRes['TFCMerchantValidDateEnd'],0,7);
								echo "<br><span style='color:orange'>TRANSACTION DECLINE</span>";
							}
						}else{		
							//echo "Merchant-ID : <span style='color:#ffffff'>". $arrRes['TFCMerchantID']."</span>";
							echo "<br><span style='color:#ffffff'><strong>".$arrRes['TFCMerchantName']."</strong></span>";
							echo "<br><span style='color:#ffffff'>". $arrRes['TFCMerchantAddress']."</span>";
							$subY = substr($arrRes['TFCMerchantValidDateEnd'],0,4);
							$subM = substr($arrRes['TFCMerchantValidDateEnd'],5,2);
							echo "<br><br><strong style=\"color:orange\">VALID</strong> thru : <span style='color:#ffffff'>$subM/$subY </span>";
                        }
					?>                    </td>
                  </tr>
                  
                  <tr>
                    <td align="center"><div style="margin:10px 0 8px;font-size:12px;"> >>> Available products/services <<< </div></td>
                  </tr>
                  
                 
                  <tr>
                    <td align="left" style="font-size:15px">
                    <? 
					$n=1;
					foreach($arrRes['product_id'] as $key => $row){ 
						if($row['item_product_periode']=="dy") $period_str = "day";
						if($row['item_product_periode']=="wk") $period_str = "week";
						if($row['item_product_periode']=="mo") $period_str = "month";
						if($row['item_product_periode']=="2mo") $period_str = "2 month";
						if($row['item_product_periode']=="3mo") $period_str = "3 month";
						if($row['item_product_periode']=="4mo") $period_str = "4 month";
						if($row['item_product_periode']=="6mo") $period_str = "6 month";
						if($row['item_product_periode']=="yr") $period_str = "year";
					?>
                   	  <div style="margin-bottom:0;font:normal 20px arial;"><?=$n;?>. <?=$row['item_product_name'];?></div>
                    	<div style="padding:0 0 0 25px;">Valid : <?=$row['item_product_value'];?> per <?=$period_str;?></div>
                    	<div style="padding:0 0 0 25px;">Term : <?=$row['item_product_term'];?></div>
                    	<div style="padding:0 0 0 25px;">Available Credit : <?=$row['item_trx_value_credit'];?> (per <?=$period_str;?>)</div>
                        
                        <? 
						//$row['item_trx_allowed']="OK";
						if($row['item_trx_allowed']!="OK"){ ?>
                    	
                        <div style="padding:0 0 0 25px;">Last Used : <?=$row['item_trx_last_date'];?></div>
                   	  	<div style="padding:0 0 0 25px; color:#FF6600">Current credit is EMPTY. Please try next <?=$period_str;?> for available credit </div>
                    	<div style="padding:0 0 0 25px;">-----------------------------------------</div> 
						<? }else{ 
								$getthisitem = $row['item_trx_url']; 
						?>
                   	  	<div style="padding:8px 0 0 25px;"> <input name="button<?=$n?>" type="button" style="height:50px; font-size:20px;"  onClick="window.location.assign('<?=$getthisitem;?>')" value="GET THIS !"></div>
                        <div style="padding:5px 0 0 20px;font:normal 13px arial;color:#00CCFF"><em>*<?=$row['item_trx_message'];?></em></div> 
                        <div style="padding:0 0 0 25px;">-----------------------------------------</div>  
                        
                    	<? } ?>
                        
                    
                    <? $n++;
					 } ?>                    </td>
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
