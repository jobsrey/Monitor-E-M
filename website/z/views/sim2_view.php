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
          <td align="center"><div style="padding:20px;">
            <p>            TRX #2 =&gt; serverResponse<br>
            <span class="style5">Get Data from server:</span><?
			 
			
			
			
			?>
            </p>
            <form name="form1" method="post" action="http://localhost/query/val">
              <table width="200" border="0" cellpadding="4" cellspacing="1" bgcolor="#CCCCCC">
                <tr>
                  <td bgcolor="#efefef">transaction_id </td>
                  <td bgcolor="#efefef"><?=$transaction_id;?></td>
                  </tr>
                <tr>
                  <td bgcolor="#ffffff">member_name</td>
                  <td bgcolor="#ffffff"><?=$member_name;?></td>
                  </tr>
                <tr>
                  <td bgcolor="#efefef">card_serialnum</td>
                  <td bgcolor="#efefef"><?=$card_serialnum;?></td>
                  </tr>
                <tr>
                  <td bgcolor="#ffffff">member_status</td>
                  <td bgcolor="#ffffff"><?=$member_status;?></td>
                </tr>
                <tr>
                  <td bgcolor="#CCCCCC">&nbsp;</td>
                  <td bgcolor="#CCCCCC">&nbsp;</td>
                </tr>
                <tr>
                  <td bgcolor="#efefef">merchant_id</td>
                  <td bgcolor="#efefef"><?=$merchant_id;?></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF">merchant_name</td>
                  <td bgcolor="#FFFFFF"><?=$merchant_name;?></td>
                </tr>
                <tr>
                  <td bgcolor="#efefef">meerchant_status</td>
                  <td bgcolor="#efefef"><?=$meerchant_status;?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
              <label></label>
              <p>
                <label><br>
                </label>
              </p>
              <p>
                <label><br>
                </label>
              </p>
              <p>
                <label><br>
                </label>
              </p>
              <p>
                <input type="submit" name="button" id="button" value="Submit">
              </p>
            </form></div></td>
        </tr>
        
      </table>
      </td>
    </tr>
  </table>
  </td>
</div>
</body>
</html>
