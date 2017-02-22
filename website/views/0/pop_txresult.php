<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title><?=$pageTITLE;?></title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #000000;
}
a, a:visited {color: #000000; text-decoration:none}
.style3 {color: #666666}
.style4 {font-weight: bold}
-->
</style></head>
<body>
<hr size="1" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
  <tr>
    <td><table width="100%" border="0" cellpadding="4" cellspacing="1">
  <tr bgcolor="#CCCCCC">
    <td colspan="2" nowrap="nowrap"><strong>Transaction Result :  </strong></td>
    </tr>
  <tr bgcolor="#FFFFFF">
    <td nowrap="NOWRAP"> Date Time </td>
    <td width="100%" align="left" nowrap="NOWRAP" bgcolor="#FFFFFF"><?=$dt;?></td>
  </tr>
  <tr bgcolor="#FFFFCC">
    <td nowrap="NOWRAP">Transaction id </td>
    <td align="left" nowrap="NOWRAP"><span class="style4">
      <?=$trxid;?>
    </span></td>
  </tr>
  <tr bgcolor="#efefef">
    <td nowrap="NOWRAP">Card Select </td>
    <td align="left" nowrap="NOWRAP"><?=$card;?></td>
  </tr>
  <tr bgcolor="#efefef">
    <td nowrap="NOWRAP">Payment Method </td>
    <td align="left" nowrap="NOWRAP"><span class="style4">
      <?=$payment;?>
    </span></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td nowrap="NOWRAP" bgcolor="#CCCCCC">Payment Status  </td>
    <td align="left" nowrap="NOWRAP"><span class="style4">
      <?=$payment_status;?>
    </span> </td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td nowrap="NOWRAP"> Card Delivery Status</td>
    <td align="left" nowrap="NOWRAP"><span class="style4">
      <?=$delivery_status;?>
    </span></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td nowrap="NOWRAP"> Response Status</td>
    <td align="left" nowrap="NOWRAP"><strong><?=$error;?></strong> &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<span class="style3">( 1=OK | 0=Error ) :: Send Message Response 
status to Client Socket</span></td>
  </tr>
</table></td>
  </tr>
</table>

<hr size="1" />
<div align="right"><br />
    <a href="#" onclick="window.close()">Close Window
    </a>
</div>
</body>
</html>