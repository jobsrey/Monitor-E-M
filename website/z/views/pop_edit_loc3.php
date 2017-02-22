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

//echo $addID;
?>
<script language=javascript>

function parent_url(url)
{ 
//alert(url); 
opener.location.href = url;
self.close();
}

function parent_loc_reset(typeform,parentid,curmenu,editid)
{ 
//alert(typeform+'-----'+parentid+'-----'+curmenu); //member_1-----34-----1

if(editid=="member_1")
opener.loc_reset(typeform,parentid,curmenu,editid); 
if(editid=="member_2")
opener.loc_reset3(typeform,parentid,curmenu,editid); 

self.close();
}

//function loc_reset(typeform,chgform)
//{
// alert(typeform+"-----"+chgform);
//}

</script>
			<table width="100%"  height="100%" border="0" cellpadding="8" cellspacing="1"> 
              <tr bgcolor="#5A91B1"> 
                  <td height="185" align="center" nowrap bgcolor="#eeeeee"> 
				  <? 
				 // echo $type;
				  
				  
				  if($editID=="error_add"){ ?>
				    <span class="red size18">Error : Empty Location.<br>Type new location please...</span><br><br>
                    <span class=""><a onclick="window.close()" href="#">Close -> Try Again</a></span>	 
				  <? }elseif($editID=="del_done"){ ?>
				    <span class="red size18"><?=$strPop?> Location done...</span><br><br>
                    <span class=""><a onclick="parent_url('/master_data/edit_data/<?=$parent_id;?>/location')" href="#">Close -> Exit</a></span>	
				 
                  <? }elseif($editID=="ren_done"){ ?>
				    <span class="red size18"><?=$strPop?> Location done...</span><br><br>
                    <span class=""><a onclick="parent_url('/master_data/edit_data/<?=$id;?>/location')" href="#">Close -> Exit</a></span>	 
				 
                  <? }elseif($editID=="chgpar_done"){ ?>
				    <span class="red size18"><?=$strPop?> done...</span><br><br>
                    <span class=""><a onclick="parent_url('/master_data/edit_data/<?=$id;?>/location')" href="#">Close -> Exit</a></span>	 
                 
				 <? }elseif($editID=="member_1"||$editID=="member_2"||$editID=="merchant_1"||$editID=="merchant_2"){ ?>
				    <span class="red size18"><?=$strPop?> done...</span><br><br> 
                    <? /*parent_loc_reset('<?=$typeform;?>','<?=$parentid;?>','<?=$curmenu;?>','<?=$editID;?>') */ ?>
                    <span class=""><a onclick="parent_loc_reset('<?=$typeform;?>','<?=$parentid;?>','<?=$curmenu;?>','<?=$editID;?>')" href="#">Close -> Exit</a></span>	 
                 
				 <? }else{ 
				 
				 		//echo $typeForm; 
		//echo $chgform; 
				 
				 ?>
				    <span class="red size18"><?=$strPop?> Location done...</span><br>
				    <br>
                    <span class=""><a onclick="parent_url('/master_data/edit_data/<?=$editID;?>/location')" href="#"><u>Close -> Exit</u></a></span>
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
                  <td align="center"><span class="red"><? if($strPop=="Change Parent") echo "Current "; ?>Parent : 
                  <strong><?=$parent_name?></strong>
                  <input name="parent_id" type="hidden" id="parent_id" value="<?=$parent_id?>" />
                  <input name="curmenu" type="hidden" id="curmenu" value="<?=$iCurMenu;?>" />
                  </span></td> 
                </tr> 
                <tr valign="top" bgcolor="#efefef"> 
                  <td align="center" nowrap><span class="red">
				  <? if($strPop=="Add"){ ?>
				  Enter new location of <br />
                  <strong><?=$strloc?></strong> :<br />
                    <input name="add_location" id="add_location" type="text" />
                    <input name="selectname" id="selectname" type="hidden" value="<?=$selectname?>"/>
                    <input name="typeForm" id="typeForm" type="hidden" value="<?=$typeForm?>"/> 
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
				  <? if($strPop=="Change Parent"){ ?>
				  Update "<strong><?=$parent_name?></strong>" to :<br /><br /> 
				    <input name="chgpar_id" id="chgpar_id" type="hidden" value="<?=$chgpar_id?>" /> 
                  </span> 
                            
                   <select name="chgpar_location" id="chgpar_location">
                  
                    <?  
						//if($loc_cat = "area"
						foreach($locData as $k => $v)  
						if($locData[$k]['loc_cat']!="venue"){
							
							
							
							
							if($cur_cat=="kelurahan"&&$locData[$k]['loc_cat']=="kecamatan") 		$show=1;
							elseif($cur_cat=="kecamatan"&&$locData[$k]['loc_cat']=="kotakab")  		$show=1;
							elseif($cur_cat=="kotakab"&&$locData[$k]['loc_cat']=="provinsi")  	$show=1;
							elseif( $cur_cat=="provinsi" && $locData[$k]['loc_cat']=="negara") $show=1;
							else $show=0;    
							
							if($show){ echo "<br>".$cur_cat." --- ".$locData[$k]['loc_cat'];
							?>
                               <option value="<?=$locData[$k]['id'];?>"><?=$locData[$k]['loc_name'];?> &nbsp; - &nbsp; [<?=$locData[$k]['loc_cat'];?>]</option>
                 
                            <?	
							}
						} 
							
							?>
				          
                  </select>
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
