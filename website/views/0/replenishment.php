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
.style8 {font-size: 12px}
-->
</style></head>
<body>
<table width="100%" border="0" cellpadding="1" cellspacing="1" bordercolor="#CCCCCC">
  <tr>
    <td rowspan="2" valign="bottom"><img src="/asset/images/logo.png" width="180" height="43" /></td>
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
      <h2>REPLENISHMENT</h2>      
      <hr size="1"> 
      <table border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td nowrap="nowrap">&nbsp;Select Date :</td>
          <td><input name="textfield" type="text" value="22 Agustus 2014" /></td>
          <td width="11" nowrap="nowrap">&nbsp;</td>
          <td nowrap="nowrap">Select Logs :</td>
          <td><select name="select">
            <option>All</option>
            <option>TSG</option>
            <option>EA</option>
            <option>TX</option>
            <option>PrePaid</option>
          </select></td>
          <td width="11">&nbsp;</td>
          <td><input type="submit" name="Submit2" value="Submit" /></td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="1" cellspacing="10">
         <tr>
           <td bgcolor="#666666"><table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#FFFFFF">
        <tr bgcolor="#666666">
          <td><span class="style4">No.</span></td>
          <td nowrap="nowrap"><span class="style4">Date Time</span></td>
          <td><span class="style4">id</span></td>
          <td width="100%"><span class="style4">Log</span></td>
          <td><span class="style4">Type</span></td>
          <td><span class="style4">Source</span></td>
          <td bgcolor="#666666"><span class="style4">Status</span></td>
          <td nowrap="nowrap" bgcolor="#666666"><span class="style4">Check By </span></td>
          <td width="100%" nowrap="nowrap" bgcolor="#666666"><span class="style4">Check Date </span></td>
        </tr>
        <tr bgcolor="#eeeeee">
          <td><span class="style8">1.</span></td>
          <td nowrap="nowrap" bgcolor="#eeeeee"><span class="style8">12-01-2014 | 06.00 </span></td>
          <td class="style8">010010prn140811</td>
          <td nowrap="nowrap"><span class="style8"><a href="#">Error Printer</a> </span></td>
          <td><span class="style8">prn</span></td>
          <td nowrap="nowrap"><span class="style8">Mesin 1 </span></td>
          <td><span class="style8">Checked</span></td>
          <td><span class="style8">Agus</span></td>
          <td nowrap="nowrap" bgcolor="#eeeeee"><span class="style8">12-01-2014 | 06.00</span></td>
        </tr>
        <tr bgcolor="#cccccc">
          <td><span class="style8">2.</span></td>
          <td><span class="style8">12-01-2014 | 06.00 </span></td>
          <td class="style8">010010prn140811</td>
          <td><span class="style8"><a href="#">Cancel Transaction</a>... </span></td>
          <td><span class="style8">TX</span></td>
          <td><span class="style8">Mesin 2 </span></td>
          <td nowrap="nowrap" bgcolor="#cccccc"><span class="style8">View</span></td>
          <td><span class="style8">Riawan</span></td>
          <td><span class="style8">12-01-2014 | 06.00</span></td>
        </tr>
        <tr bgcolor="#eeeeee">
          <td><span class="style8">3.</span></td>
          <td><span class="style8">12-01-2014 | 06.00 </span></td>
          <td bgcolor="#eeeeee" class="style8">010010prn140811</td>
          <td><span class="style8"><a href="#">Card Slot Empty </a></span></td>
          <td><span class="style8">CRD</span></td>
          <td><span class="style8">Mesin 3 </span></td>
          <td><span class="style8">Checked</span></td>
          <td><span class="style8">Agus</span></td>
          <td><span class="style8">12-01-2014 | 06.00</span></td>
        </tr>
        <tr bgcolor="#cccccc">
          <td><span class="style8">2.</span></td>
          <td><span class="style8">12-01-2014 | 06.00 </span></td>
          <td class="style8">010010prn140811</td>
          <td><span class="style8"><a href="#">Cancel Transaction </a></span></td>
          <td><span class="style8">TX</span></td>
          <td><span class="style8">Mesin 2 </span></td>
          <td nowrap="nowrap" bgcolor="#cccccc"><span class="style8">View</span></td>
          <td><span class="style8">Riawan</span></td>
          <td><span class="style8">12-01-2014 | 06.00</span></td>
        </tr>
        <tr bgcolor="#eeeeee">
          <td><span class="style8">3.</span></td>
          <td><span class="style8">12-01-2014 | 06.00 </span></td>
          <td bgcolor="#eeeeee" class="style8">010010prn140811</td>
          <td><span class="style8"><a href="#">Replace Cash box Done </a> </span></td>
          <td><span class="style8">CBX</span></td>
          <td><span class="style8">Mesin 3 </span></td>
          <td><span class="style8">Checked</span></td>
          <td><span class="style8">Agus</span></td>
          <td><span class="style8">12-01-2014 | 06.00</span></td>
        </tr>
        <tr bgcolor="#eeeeee">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td bgcolor="#eeeeee">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
         </tr>
      </table>
      <p>&nbsp;&nbsp;Page : 1 of 2 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt; prev&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;next &gt; </p></td>
  </tr>
</table>
 
</body>
</html>