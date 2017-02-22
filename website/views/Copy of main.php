<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title><?=$pageTITLE;?></title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
a, a:visited {color: #000000; text-decoration:none}
.style1 {color: #006666}
.style2 {color: #FF6600}
.style3 {
	font-size: 10px;
	font-weight: bold;
}
-->
</style></head>
<body>
<table width="100%" border="0" cellpadding="1" cellspacing="1" bordercolor="#CCCCCC">
  <tr>
    <td rowspan="2" valign="bottom"><img src="/images/logo.png" width="180" height="43" /></td>
    <td rowspan="2" nowrap="NOWRAP"><br /><br />
    - Web Administrator</td>
    <td width="100%" rowspan="2" valign="bottom" nowrap="nowrap"><br /></td>
    <td height="24" valign="bottom" nowrap="nowrap"><div align="right">
      <p align="left">User Login : <strong><span class="style2">USer1</span><br />
        </strong></p>
    </div></td>
    <td rowspan="2" valign="bottom" nowrap="nowrap"><div align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div></td>
    <td rowspan="2" valign="bottom" nowrap="nowrap"><div align="right" class="style3">LOGOUT</div></td>
    <td rowspan="2" valign="bottom" nowrap="nowrap">&nbsp;</td>
  </tr>
  <tr>
    <td valign="bottom" nowrap="NOWRAP"><span class="style1">Last Login Date: 12-31-0000 </span></td>
  </tr>
</table>
<hr size="3">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" bgcolor="#FFFFFF"><br />&nbsp;&nbsp;MAIN MENU<br /><br /><? $this->load->view('main_leftmenu'); ?></td>
    <td width="100%">&nbsp;</td>
  </tr>
</table>
 
</body>
</html>