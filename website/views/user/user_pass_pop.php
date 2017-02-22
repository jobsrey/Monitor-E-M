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
        <form id="form" action="<?=base_url()?>user_management/chgpwd/" method="post"  onsubmit="return validateFormPass('form')" > 
          <tr> 
            <td bgcolor="#dddddd"><table width="100%" border="0" cellpadding="8" cellspacing="1"> 
                <tr bgcolor="#5A91B1"> 
                  <td align="center" nowrap><span class="style4">Change  Password 
                    <input name="ID" type="hidden" id="ID" value="<?=$ID;?>" />
                    <input name="StatusID" type="hidden" id="StatusID" value="<?=$StatusID;?>" />
                  </span></td> 
                </tr> 
                <tr valign="top" bgcolor="#FFFFFF"> 
                  <td align="center"><span class="red">Enter CURRENT password : <br />
                      <input name="Password" type="text" id="Password" />
                  </span></td> 
                </tr> 
                <tr valign="top" bgcolor="#efefef"> 
                  <td align="center" nowrap><span class="red">Enter NEW password :<br />
                      <input name="PasswordNew1" type="password" id="PasswordNew1" />
                  </span></td> 
                </tr> 
                <tr valign="top" bgcolor="#FFFFFF"> 
                  <td align="center"><span class="red">Retype NEW password :<br />
                      <input name="PasswordNew2" type="password" id="PasswordNew2" />
                  </span></td> 
                </tr> 
                <tr valign="top" bgcolor="#efefef"> 
                  <td align="center"><span class="red">
                    <input type="submit" name="Submit" value="Submit" />
                  </span></td> 
                </tr> 
                <tr valign="top" bgcolor="#CCCCCC"> 
                  <td>&nbsp;</td> 
                </tr> 
              </table></td> 
          </tr> 
        </form> 
  </table>  
		<? } ?>
</div> 
</body>
</html>
