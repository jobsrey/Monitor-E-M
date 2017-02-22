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
.style4 {color: #FFFFFF}
.style5 {
	color: #990000;
	font-weight: bold;
}
.style7 {color: #660000}
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
    <td width="100%" valign="top">
      <h2>USER MANAGEMENT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;        
        <input type="button" name="Submit2" value="ADD USER" onclick="window.location.assign('user_add.php')" />
</h2>      
      <hr size="1"> 
      
       <table width="100%" border="0" cellpadding="1" cellspacing="10">
         <tr>
           <td bgcolor="#666666"><table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF">
        <tr bgcolor="#666666">
          <td><span class="style4">No.</span></td>
          <td><span class="style4">User</span></td>
          <td><span class="style4">Name</span></td>
          <td><span class="style4">Email</span></td>
          <td><span class="style4">Mobile</span></td>
          <td><span class="style4">Level</span></td>
          <td><span class="style4">Edit</span></td>
          <td bgcolor="#666666"><span class="style4">Status</span></td>
          <td width="100%" nowrap="nowrap" bgcolor="#666666"><span class="style4">Last Login </span></td>
        </tr>
        <tr bgcolor="#CCCC66">
          <td>1.</td>
          <td bgcolor="#CCCC66"><span class="style5">USer1</span></td>
          <td>Riawan</td>
          <td>riandul@oncom.com</td>
          <td>081111111111</td>
          <td>Admin</td>
          <td><input type="submit" name="Submit" value="EDIT" onclick="window.location.assign('user_edit.php')"/></td>
          <td>OWNER</td>
          <td>Jumat, 8 Agustus 2014 : 01.00 AM </td>
        </tr>
        <tr bgcolor="#cccccc">
          <td>2.</td>
          <td>USer2</td>
          <td>Namamu</td>
          <td>riandul2@oncom.com</td>
          <td>081111111112</td>
          <td>User</td>
          <td><input type="submit" name="Submit3" value="EDIT" onclick="window.location.assign('user_edit.php')"/></td>
          <td nowrap="nowrap" bgcolor="#cccccc">INSERT MD </td>
          <td>Jumat, 8 Agustus 2014 </td>
        </tr>
        <tr bgcolor="#eeeeee">
          <td>3.</td>
          <td>USer3</td>
          <td>Matamu</td>
          <td>riandu3l@oncom.com</td>
          <td>081111111113</td>
          <td>Supervisor</td>
          <td><input type="submit" name="Submit4" value="EDIT" onclick="window.location.assign('user_edit.php')"/></td>
          <td>TERMINAL</td>
          <td>Jumat, 9 Agustus 2014 </td>
        </tr>
      </table></td>
         </tr>
       </table></td>
  </tr>
</table>
 
</body>
</html>