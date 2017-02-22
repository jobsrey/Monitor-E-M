<html>
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
.style9 {font-size: 12px}
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
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div align="center" style="font:normal 13px tahoma">
  <table width="527" height="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" valign="middle"><table border="1" cellpadding="0" cellspacing="0" bordercolor="#eeeeee" bgcolor="#efefef">
        <tr>
          <td bgcolor="#FFFFFF">
          <img src="/asset/images/logo.png" width="180" height="43" hspace="20" vspace="10"></td>
          </tr>
        <tr>
          <td align="center"><div style="padding:20px;"><p>            TRX #1 =&gt; htmlpost<br>
            <br>
            <span class="style5">Read-Card Data:</span><br>
            </p>
            <?
			
				$card_number  	= "0210000003";
				$card_serialnum = "000001";
				$merchant_id	= "0210004";
				$transaction_id = "021-".date("ymd")."-".date("His"); 
			
			
			
			?>
            <form name="form1" method="post" action="/query/val">
              <label>card_number <br>
              <input name="card_number" type="text" id="card_number" value="<?=$card_number?>">
                </label>
              <p>
                <label>card_serialnum
                <br>
                <input name="card_serialnum" type="text" id="card_serialnum" value="<?=$card_serialnum?>">
                </label>
              </p>
              <p>
                <label>merchant_id <br>
                <input name="merchant_id" type="text" id="merchant_id" value="<?=$merchant_id?>">
                </label>
              </p>
              <p>
                <label>transaction_id <br>
                <input name="transaction_id" type="text" id="transaction_id" value="<?=$transaction_id?>">
                </label>
                <br>
                <span class="style7">transaction_id format :<br>
                <strong>XXX</strong>-<strong>000000</strong>-<strong>111111</strong><br>
                <strong>XXX</strong>: 3 digit awal dari id merchant <br>
                =&gt; 3 digit kode telpon area.(021 ato 274).<br>
                <strong>000000</strong> : date(Ymd)<br>
                <strong>111111</strong> : date(His)</span><br>
              </p>
              <p>
                <input type="submit" name="button" id="button" value="Submit">
              </p>
            </form></div>
            <hr>
            <span class="style9">test data sample:<br>
            card_number<br>
            card_serialnum<br>
            <br>
            member valid:<br>
0210000003<br>
990C177D<br>
<br>
3610000001<br>
490D177D<br>
<br>
member expired:<br>
0210000001<br>
790D177D<br>
<br>
card wrong serial:<br>
0210000003<br>
000002<br>
<br>
merchan_id:<br>
0210004<br>
3610001<br>
<br>
merchant expired:<br>
0210003</span></td>
        </tr>
        
      </table>
      </td>
    </tr>
  </table>
  </td>
</div>
</body>
</html>
