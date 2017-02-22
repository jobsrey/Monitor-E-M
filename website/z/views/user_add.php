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
    <td width="100%" valign="top">
      <h2>ADD USER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h2>      
      <hr size="1"> 
      
       <table border="0" cellpadding="1" cellspacing="10">
         <tr>
           <td bgcolor="#CCCCCC"><table border="0" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF">
        <tr bgcolor="#CCCCCC">
          <td colspan="3"><em><strong>User Profile </strong></em></td>
          </tr>
        <tr bgcolor="#efefef">
          <td>ID </td>
          <td width="5">:</td>
          <td>10293</td>
          </tr>
        <tr bgcolor="#efefef">
          <td>Username</td>
          <td width="5">:</td>
          <td> <input name="textfield" type="text" value="User1" /> </td>
          </tr>
        <tr bgcolor="#efefef">
          <td>Password</td>
          <td width="5">:</td>
          <td><input name="textfield2" type="text" /></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td>Status</td>
          <td>:</td>
          <td>OWNER</td>
        </tr>
        <tr bgcolor="#dddddd">
          <td>Name</td>
          <td width="5">:</td>
          <td><input name="textfield22" type="text" size="40" /></td>
        </tr>
        <tr bgcolor="#dddddd">
          <td>Address</td>
          <td width="5">:</td>
          <td><input name="textfield242" type="text" size="40" /></td>
        </tr>
        <tr bgcolor="#dddddd">
          <td>Area</td>
          <td width="5">:</td>
          <td><select name="select">
            <option>Jakarta</option>
          </select></td>
        </tr>
        <tr bgcolor="#efefef">
          <td>Phone</td>
          <td width="5">:</td>
          <td><input name="textfield25" type="text" /></td>
        </tr>
        <tr bgcolor="#efefef">
          <td>Email</td>
          <td width="5">:</td>
          <td><input name="textfield26" type="text" /></td>
        </tr>
        <tr bgcolor="#CCCCCC">
          <td colspan="3"><em><strong> Privileges Menu </strong></em></td>
        </tr>
        <tr bgcolor="#FFFFCC">
          <td colspan="2"><a href="users.php">User Management</a> &nbsp;&nbsp;            </td>
          <td><input type="checkbox" name="checkbox" value="checkbox" />
Admin
  <input type="checkbox" name="checkbox2" value="checkbox" />
Guest
<input type="checkbox" name="checkbox22" value="checkbox" />
Hidden </td>
        </tr>
        <tr bgcolor="#efefef">
          <td colspan="2">Master Data             </td>
          <td><input type="checkbox" name="checkbox3" value="checkbox" />
Admin
  <input type="checkbox" name="checkbox23" value="checkbox" />
Guest
<input type="checkbox" name="checkbox222" value="checkbox" />
Hidden </td>
        </tr>
        <tr bgcolor="#FFFFCC">
          <td colspan="2" nowrap="nowrap">Dealer / Reseller / Terminal             </td>
          <td><input type="checkbox" name="checkbox4" value="checkbox" />
Admin
  <input type="checkbox" name="checkbox24" value="checkbox" />
Guest
<input type="checkbox" name="checkbox223" value="checkbox" />
Hidden </td>
        </tr>
        <tr bgcolor="#efefef">
          <td colspan="2"><span class="xl63">Product Data </span>
            </td>
          <td><input type="checkbox" name="checkbox5" value="checkbox" />
Admin
  <input type="checkbox" name="checkbox25" value="checkbox" />
Guest
<input type="checkbox" name="checkbox224" value="checkbox" />
Hidden </td>
        </tr>
        <tr bgcolor="#FFFFCC">
          <td colspan="2">Deposit History             </td>
          <td><input type="checkbox" name="checkbox6" value="checkbox" />
Admin
  <input type="checkbox" name="checkbox26" value="checkbox" />
Guest
<input type="checkbox" name="checkbox225" value="checkbox" />
Hidden </td>
        </tr>
        <tr bgcolor="#efefef">
          <td colspan="2"><a href="#">Trace Log Viewer</a>
            </td>
          <td><input type="checkbox" name="checkbox7" value="checkbox" />
Admin
  <input type="checkbox" name="checkbox27" value="checkbox" />
Guest
<input type="checkbox" name="checkbox226" value="checkbox" />
Hidden </td>
        </tr>
        <tr bgcolor="#FFFFCC">
          <td colspan="2">Monitoring             </td>
          <td><input type="checkbox" name="checkbox8" value="checkbox" />
Admin
  <input type="checkbox" name="checkbox28" value="checkbox" />
Guest
<input type="checkbox" name="checkbox227" value="checkbox" />
Hidden </td>
        </tr>
        <tr bgcolor="#efefef">
          <td colspan="2"><a href="#">Replenishment</a>
            </td>
          <td><input type="checkbox" name="checkbox9" value="checkbox" />
Admin
  <input type="checkbox" name="checkbox29" value="checkbox" />
Guest
<input type="checkbox" name="checkbox228" value="checkbox" />
Hidden </td>
        </tr>
        <tr bgcolor="#FFFFCC">
          <td colspan="2">Reporting              </td>
          <td><input type="checkbox" name="checkbox10" value="checkbox" />
Admin
  <input type="checkbox" name="checkbox210" value="checkbox" />
Guest
<input type="checkbox" name="checkbox229" value="checkbox" />
Hidden </td>
        </tr>
        <tr bgcolor="#CCCCCC">
          <td colspan="3"><em><strong>Status</strong></em></td>
        </tr>
        <tr bgcolor="#FFFFCC">
          <td colspan="2"><a href="users.php">Owner</a> </td>
          <td>
            <input name="status" type="radio" value="1" checked="checked" />
            <select name="select2">
            </select>
          </td>
        </tr>
        <tr bgcolor="#efefef">
          <td colspan="2">Insert MD </td>
          <td><input name="status" type="radio" value="2" />
              <select name="select3">
            </select></td>
        </tr>
        <tr bgcolor="#FFFFCC">
          <td colspan="2" nowrap="nowrap">Insert SD </td>
          <td><input name="status" type="radio" value="3" />
              <select name="select4">
            </select></td>
        </tr>
        <tr bgcolor="#efefef">
          <td colspan="2"><span class="xl63">Terminal</span> </td>
          <td><input name="status" type="radio" value="4" />
              <select name="select5">
            </select></td>
        </tr>
        <tr bgcolor="#CCCCCC">
          <td colspan="3"><em><strong> </strong></em></td>
        </tr>
        <tr align="center" bgcolor="#FFFFFF">
          <td height="55" colspan="3">&nbsp;            <input type="submit" name="Submit" value="SAVE" />
            &nbsp;</td>
        </tr>
      </table></td>
         </tr>
       </table>    </td>
  </tr>
</table>
 
</body>
</html>