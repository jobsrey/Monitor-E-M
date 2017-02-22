 <table width="100%" border="0" cellpadding="1" cellspacing="1" bordercolor="#CCCCCC">
  <tr>
    <td width="180" rowspan="2" valign="bottom"><img src="/asset/images/logo.png" width="180" height="43" /></td>
    <td rowspan="2" align="left" nowrap="nowrap" class="grey6"><br /><br />
    &nbsp;Web Administrator</td>
    <td width="100%" rowspan="2"></td>
    <td colspan="2" align="left" valign="bottom" nowrap="nowrap" class="style1">
		<div align="left" >LogIn as 
		<span class="style2 bold" style="border-right:1px dotted #000000"><?=$this->session->userdata('FullName')?> &nbsp; </span> &nbsp;&nbsp; Access : </span> 
		<span class="style2 bold" style="border-right:1px dotted #000000"> <? if($this->session->userdata('AccessType')=='admin') echo 'Administrator'; else echo 'Limited'; ?> &nbsp; </span> &nbsp;&nbsp; IP : <?=$_SERVER['REMOTE_ADDR'];?></span>
    </div></td>
  </tr>
  <tr>
    <td align="left" valign="bottom" nowrap="NOWRAP"><span class="style1"><?=$this->session->userdata('SigninLog')?></span></td>
    <td align="right" valign="bottom" nowrap="nowrap"><a style="padding:2px 10px 0 50px; display:inline-block;font:normal 9px arial;" href="/login/logout">LOGOUT</a></td>
  </tr> 
</table>