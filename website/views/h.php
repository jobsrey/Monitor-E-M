 <table width="100%" border="0" cellpadding="1" cellspacing="1" bordercolor="#CCCCCC">
  <tr>
    <td rowspan="2" valign="bottom"><img src="/images/logo.png" width="180" height="43" /></td>
    <td rowspan="2" nowrap="NOWRAP" class="grey6"><br /><br />
    &nbsp;Web Administrator</td>
    <td width="100%" rowspan="2" valign="bottom" nowrap="nowrap"><br /></td>
    <td height="24" align="left" valign="bottom" nowrap="nowrap">      <div align="left">Sign In as <strong><span class="style2">
        <?=$this->session->userdata('Username')?>
        </span><br />
    </strong></div></td><td rowspan="2" valign="bottom" nowrap="nowrap"><div align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div></td>
    <td valign="bottom" nowrap="nowrap"><div align="right" class="style3"><a href="/login/logout">LOGOUT</a></div></td>
    <td rowspan="2" valign="bottom" nowrap="nowrap">&nbsp;</td>
  </tr>
  <tr>
    <td valign="bottom" nowrap="NOWRAP"><span class="style1"><?=$this->session->userdata('SigninLog')?></span></td>
    <td valign="bottom" nowrap="nowrap">&nbsp;</td>
  </tr>
</table>