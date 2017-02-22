<? require_once('include/top.php'); ?>

<div class="container">
  <div class="lblpage" align="right">
    <div class="float_l tahoma size18">
      <?=$pageLABEL;?>
    </div>
    <div class="float_r arial12 grey9"> </div>
  </div>
  <div class="linelbl"></div>
  <div id="contMenu">
    <div style="clear:both"></div>
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
				if($TABLE=='md_terminal_location'){ // foreach($country_idxx as $key => $val) echo "<br>$key => $val";
				?>
            	<tr valign="top" bgcolor="#FFFFFF">
                  <td>Country</td>
                  <td nowrap="nowrap"><div id="listloc0" class="float_l" style="width:100%;"><?=$coun_idx;?></div></td> 
                </tr> 
                <tr valign="top" bgcolor="#FFFFFF">
                  <td>province</td>
                  <td nowrap="nowrap"><div id="listloc1" class="float_l" style="width:100%;"><?=$prov_idx;?></div></td> 
                </tr> 
                <tr valign="top" bgcolor="#FFFFFF">
                  <td>city</td>
                  <td nowrap="nowrap"><div id="listloc2" class="float_l" style="width:100%;"><?=$city_idx;?></div></td> 
                </tr> 
                <tr valign="top" bgcolor="#FFFFFF">
                  <td>area</td>
                  <td nowrap="nowrap"><div id="listloc3" class="float_l" style="width:100%;"><?=$area_idx;?></div></td> 
                </tr> 
                <tr valign="top" bgcolor="#FFFFFF">
                  <td>venue</td>
                  <td  nowrap="nowrap"><div id="listloc4" class="float_l" style="width:100%;"><?=$venu_idx;?></div></td>
                 </tr> 
                 
				<? } else echo $editFormTable; ?>
                
                <tr align="right" valign="top" bgcolor="#cccccc">
                  <td colspan="2">
					  <? if(empty($status_id)&&!empty($id)){ ?>
					  <input type="submit" name="button" id="button" value="ACTIVATE" />
					  <? } elseif($TABLE!='md_terminal_location'){ ?>
					  <input type="submit" name="button" id="button" value="Submit" />
					  <? } ?>
                     
				  </td>
                  </tr>
    		</form>
	    				
			<form id="formdel" name="formdel" method="post" action="/<?=$ci_ctrl?>/qedit" >  
				<input name="TABLE" type="hidden" id="TABLE" value="<?=$TABLE;?>" /> 
				<input name="ci_func" type="hidden" id="ci_func" value="<?=$ci_func;?>" />
				<input name="id" type="hidden" id="id" value="<?=$id;?>" size="1" /> 
				<input name="bdel" type="hidden" id="bdel" value="DELETE" class="bgRed white" onClick="gosubmit('formdel')"/>
                <tr align="left" valign="top" bgcolor="#660000">
				  <td colspan="2">
				    <div align="left" style="display:inline-block; float:left;">
						<? if($status_id==1 && $group!='Lunari'){ ?>
                   		<input type="button" name="button" id="button" value="DELETE" class="bgRed white" onClick="gosubmit('formdel')"/>
				   		<? } ?>
                  	</div>
                   	<div align="right" style="display:inline-block; float:right;"> 
				      	<? if(isset($done)) { ?>
					  	<input type="button" name="button" id="button" value="CLOSE" onclick="window.close()" />
                      	<? } ?>
                     </div>
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
	window.onunload = refreshParent;
    function refreshParent() {
    	window.opener.location.reload();
    }
//</script>
<? require_once('include/bottom.php'); ?>