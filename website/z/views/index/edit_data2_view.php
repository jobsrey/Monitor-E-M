<? require_once('include/top.php'); ?> 
<script language=javascript>
function parent_form_reset(id,formname)
{ 
opener.form_reset_reg(id,formname); 
self.close();
} 
</script> 
<div class="container"> 
  <div id="contMenu">
    <div style="clear:both;padding-top:15px;"></div>
    <div id="dspdata">

      		<table border="0" cellspacing="0" cellpadding="0">
             <tr>
              <td bgcolor="#999999">
              
                <table border="0" cellpadding="6" cellspacing="1" >
    				<form id="form1" name="form1" method="post" action="/<?=$ci_ctrl?>/qedit">
					<input name="TABLE" type="hidden" id="TABLE" value="<?=$TABLE;?>" />  
					<input name="ci_func" type="hidden" id="ci_func" value="<?=$ci_func;?>" />
                	<tr bgcolor="#CCCCCC">
                  		<td colspan="2"><strong><?=$tablemod." ".$tablelbl?></strong> <input name="id" type="hidden" id="id" value="<?=$id;?>" size="1" /></td> 
               		  </tr> 
        		<?
				if($TABLE=='md_location'){ // foreach($country_idxx as $key => $val) echo "<br>$key => $val";
				?>
            	<tr valign="top" bgcolor="#FFFFFF">
                  <td>Negara</td>
                  <td nowrap="nowrap"><div id="listloc0" class="float_l" style="width:100%;"><?=$coun_idx;?></div></td> 
                </tr> 
                <tr valign="top" bgcolor="#FFFFFF">
                  <td>Provinsi</td>
                  <td nowrap="nowrap"><div id="listloc1" class="float_l" style="width:100%;"><?=$prov_idx;?></div></td> 
                </tr> 
                <tr valign="top" bgcolor="#FFFFFF">
                  <td>Kota/Kabupaten</td>
                  <td nowrap="nowrap"><div id="listloc2" class="float_l" style="width:100%;"><?=$city_idx;?></div></td> 
                </tr> 
                <tr valign="top" bgcolor="#FFFFFF">
                  <td>Kecamatan</td>
                  <td nowrap="nowrap"><div id="listloc3" class="float_l" style="width:100%;"><?=$area_idx;?></div></td> 
                </tr> 
                <tr valign="top" bgcolor="#FFFFFF">
                  <td>Kelurahan</td>
                  <td  nowrap="nowrap"><div id="listloc4" class="float_l" style="width:100%;"><?=$venu_idx;?></div></td>
                 </tr> 
                 
				<? } else echo $editFormTable; 
				
					//--- add from form-registrasi
				?>	<input name="addFromReg" type="hidden" id="addFromReg" value="1" />
				
				
                
                <tr align="right" valign="top" bgcolor="#cccccc">
                  <td colspan="2">
                  <? /*
				  parent_form_reset('<?=$id;?>','<?=$ci_func;?>' ) 
				   */ ?>
                  <input type="submit" name="button" id="button" value="Submit" /><? if($is_done){ ?> &nbsp; - &nbsp; <a onclick="parent_form_reset('<?=$id;?>','<?=$ci_func;?>' )" href="#">Close -> Exit</a><? } ?></td>
                  </tr>
    		</form>
	    				
			<form id="formdel" name="formdel" method="post" action="/<?=$ci_ctrl?>/qedit" >  
				<input name="TABLE" type="hidden" id="TABLE" value="<?=$TABLE;?>" /> 
				<input name="ci_func" type="hidden" id="ci_func" value="<?=$ci_func;?>" />
				<input name="id" type="hidden" id="id" value="<?=$id;?>" size="1" /> 
				<input name="bdel" type="hidden" id="bdel" value="DELETE" class="bgRed white" onClick="gosubmit('formdel')"/>
                <tr align="left" valign="top" bgcolor="#660000">
				  <td colspan="2">
                  
                  </td>
                  </tr>
    		</form>
                </table>
                  
               </td>
              </tr>
            </table> 
 
    </div>
   </div>
</div>
<script> 
//if(window.name='edit_location'){
	//window.onunload = refreshParent;
    //function refreshParent() {
    	//window.opener.location.reload();
    //}
//</script>
<? require_once('include/bottom.php'); ?>