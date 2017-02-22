<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>Edit Location</title>
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
<? if($isPOST==1){ 

//echo $addid;
?>
<script language=javascript>

function parent_url(url)
{ 
//alert(url); 
opener.location.href = url;
self.close();
}
</script>
			<table width="100%"  height="100%" border="0" cellpadding="8" cellspacing="1"> 
              <tr bgcolor="#5A91B1"> 
                  <td height="185" align="center" nowrap bgcolor="#eeeeee"> 
				  <? if($editid=="error_add"){ ?>
				    <span class="red size18">Error : Empty Location.<br>Type new location please...</span><br><br>
                    <span class=""><a onclick="window.close()" href="#">Close -> Try Again</a></span>	 
				  <? }elseif($editid=="del_done"){ ?>
				    <span class="red size18"><?=$strPop?> Location done...</span><br><br>
                    <span class=""><a onclick="parent_url('/master_data/edit_data/<?=$parent_id;?>/terminal_location')" href="#">Close -> Exit</a></span>	
				  <? }elseif($editid=="ren_done"){ ?>
				    <span class="red size18"><?=$strPop?> Location done...</span><br><br>
                    <span class=""><a onclick="parent_url('/master_data/edit_data/<?=$id;?>/terminal_location')" href="#">Close -> Exit</a></span>	 
                 <? }else{ ?>
				    <span class="red size18"><?=$strPop?> Location done...</span><br><br>
                    <span class=""><a onclick="parent_url('/master_data/edit_data/<?=$editid;?>/terminal_location')" href="#"><u>CLOSE</u></a></span>
				  <? } ?> 
                  <p>&nbsp;</p>
				  </td> 
                </tr> 
              </table>
<? } else { ?>
      <table width="100%" height="185" border="0" cellpadding="1" cellspacing="0" >  
        <form id="form" action="<?=base_url()?>master_data/locat_edit/" method="post" > 
          <tr> 
            <td bgcolor="#dddddd"><table width="100%" border="0" cellpadding="8" cellspacing="1"> 
                <tr bgcolor="#5A91B1"> 
                  <td align="center" nowrap><span class="style4"><?=$strPop?> Location</span></td> 
                </tr> 
                <tr valign="top" bgcolor="#FFFFFF"> 
                  <td align="center"><span class="red">Parent : 
                  <strong><?=$parent_name?></strong>
                  <input name="parent_id" type="hidden" id="parent_id" value="<?=$parent_id?>" />
                  </span></td> 
                </tr> 
                <tr valign="top" bgcolor="#efefef"> 
                  <td align="center" nowrap><span class="red">
				  <? if($strPop=="Add"){ ?>
				  Enter new location of <br />
                  <strong><?=$strloc?></strong> :<br />
                    <input name="add_location" id="add_location" type="text" />
                  </span>
				  <? } ?>
				  <? if($strPop=="Delete"){ ?>
				  Delete location name : <br />
                  <strong><?=$loc_name?></strong><br /> Are you sure?
                    <input name="del_location" id="_location" type="hidden" value="<?=$del_id?>" />
                  </span> 
				  <? } ?>
				  <? if($strPop=="Rename"){ ?>
				  Rename "<strong><?=$loc_name?></strong>" to :<br /><br /> 
				    <input name="ren_id" id="ren_id" type="hidden" value="<?=$ren_id?>" />
                    <input name="ren_location" id="ren_location" type="text" value="<?=$loc_name?>" />
                  </span>
				  <? } ?>
				  </td> 
                </tr> 
                <tr valign="top" bgcolor="#FFFFFF"> 
                  <td align="center"> 
                    <input type="button" name="button" value="Cancel" onclick="window.close()" /> &nbsp; &nbsp;
                    <input type="submit" name="Submit" value="<?=$strPop ?>" />
                  </td> 
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
