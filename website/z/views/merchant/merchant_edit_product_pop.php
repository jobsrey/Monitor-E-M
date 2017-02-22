<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>User Management>Users</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" media="screen" href="/asset/css/main.css" />
<script type="text/javascript" language="javascript" src="/asset/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="/asset/js/allscript.js"></script>
<style type="text/css">
<!--
.style4 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
</head>
<body> 
<div style="padding:0;">   
<? if($isPOST==1){ ?>

<table width="100%"  height="100%" border="0" cellpadding="8" cellspacing="1"> 
                <tr bgcolor="#5A91B1"> 
                  <td height="280" align="center" nowrap bgcolor="#eeeeee">
				  <? if(empty($err)){ ?>
				  <span class="red size18">Password changed,<br>Logout and re-login please...</span><br><br>
                  <span class=""><a onclick="window.close()" href="#">EXIT</a></span>
				  <? }else{ ?>
				  <span class="red size18"><?=$err;?></span><br><br>
                  <span class=""><a onclick="window.close()" href="#">Please Try Again</a></span>
				  <? } ?>
                  <p>&nbsp;</p>
				  </td> 
                </tr> 
              </table>
<? } else { ?>
      <table width="100%" height="260" border="0" cellpadding="1" cellspacing="0" >  
        <form id="form" action="<?=base_url()?>user_manage/chgpwd/" method="post"  onsubmit="return validateFormPass('form')" > 
          <tr> 
            <td bgcolor="#dddddd"><table width="100%" border="0" cellpadding="8" cellspacing="1"> 
                <tr bgcolor="#5A91B1"> 
                  <td colspan="2" align="center" nowrap><span class="style4">Add PRODUCT/SERVICES 
                      <input name="ID" type="hidden" id="ID" value="<?=$ID;?>" />
                  </span></td> 
                </tr> 
                <tr valign="top" bgcolor="#FFFFFF"> 
                  <td valign="top"> Name</td> 
                  <td>                    <input name="product_name" type="text" id="product_name" />                  </td>
                </tr> 
                <tr valign="top" bgcolor="#efefef"> 
                  <td valign="top" nowrap><span class="red">Value </span></td> 
                  <td nowrap><input name="product_value" type="text" id="product_value" size="4" /></td>
                </tr>
                <tr valign="top" bgcolor="#FFFFFF">
                  <td valign="top"> Term</td>
                  <td><input name="product_term" type="text" id="Password3" />                  </td>
                </tr> 
                <tr valign="top" bgcolor="#efefef"> 
                  <td colspan="2" align="center"><span class="red">
                    <input type="submit" name="Submit" value="Submit" />
                  </span></td> 
                </tr> 
                <tr valign="top" bgcolor="#CCCCCC"> 
                  <td colspan="2">&nbsp;</td> 
                </tr> 
            </table></td> 
          </tr> 
        </form> 
  </table>  
		<? } ?>
</div> 
</body>
</html>
