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
    <form id="form1" name="form1" method="post" action="/<?=$ci_ctrl?>/qedit">
      	<input name="TABLE" type="hidden" id="TABLE" value="<?=$TABLE;?>" /> 
      	<input name="ci_func" type="hidden" id="ci_func" value="<?=$ci_func;?>" /> 

      		<table border="0" cellspacing="0" cellpadding="0">
             <tr>
              <td bgcolor="#CCCCCC">
              
                <table border="0" cellpadding="6" cellspacing="1" >
                <tr bgcolor="#CCCCCC">
                  <td><strong><?=$tablemod." ".$tablelbl?></strong></td>
                  <td align="right"> id :&nbsp; <input name="id" type="text" id="id" value="<?=$id;?>" size="1" /></td>
                </tr> 
				
        		<? if($TABLE=='vending_terminal'){ ?>
            	<tr valign="top" bgcolor="#FFFFFF">
                  <td>ip</td>
                  <td><input name="ip" type="text" id="ip" autocomplete="off" value="<?=$ip?>" /></td>
                </tr>
                  <tr valign="top" bgcolor="#efefef">
                  <td>vmid</td>
                  <td><input name="vmid" type="text" id="vmid" autocomplete="off" value="<?=$vmid?>" /></td>
                </tr>
                  <tr valign="top" bgcolor="#FFFFFF">
                  <td>name</td>
                  <td><input name="name" type="text" id="name" autocomplete="off" value="<?=$name?>" size="35" /></td>
                </tr>
                  <tr valign="top" bgcolor="#efefef">
                  <td>alamat</td>
                  <td><textarea name="alamat" cols="27" rows="2" id="alamat"><?=$alamat?></textarea></td>
                </tr>
                  <tr valign="top" bgcolor="#FFFFFF">
                  <td>location</td>
                  <td> 
                  	<select name="location_id" id="location_id">
                 	 <? foreach($location_idx as $key => $arr){ //echo "<br>$key => $arr"; ?>
                    	<option value="<?=$arr['id'];?>" <? if($location_id==$arr['id']) echo 'selected="selected"' ?> ><?=$arr['name'];?></option>
                     <? } ?>
                    </select>
                    </td>
                </tr>
                  <tr valign="top" bgcolor="#efefef">
                  <td>area</td>
                  <td>
                  	<select name="area_id" id="area_id">
                 	 <? foreach($area_idx as $key => $arr){ ?>
                    	<option value="<?=$arr['id'];?>" <? if($area_id==$arr['id']) echo 'selected="selected"' ?> ><?=$arr['name'];?></option>
                     <? } ?> 
                    </select></td>
                </tr>
                  <tr valign="top" bgcolor="#FFFFFF">
                  <td>owner</td>
                  <td> 
                  	<select name="owner_id" id="owner_id">
                 	 <? foreach($owner_idx as $key => $arr){ ?>
                    	<option value="<?=$arr['id'];?>" <? if($owner_id==$arr['id']) echo 'selected="selected"' ?> ><?=$arr['name'];?></option>
                     <? } ?>  
                    </select></td>
                </tr>
                <? }else{  
                 
 					//-- get table keys
					$arr_fields      = $this->allmodel->getTableKeys($TABLE); 
					$arr_fields_type = $this->allmodel->getTableKeysType($TABLE); 
					//foreach( $arr_fields_type as $k => $varKey) echo "<br>$k ===> $varKey"; exit;
 
					$col1 = "#ffffff";
					$col2 = "#f6f6f6";
					$x=0;
					foreach( $arr_fields as $k => $varKey){  //echo "<br>$key ===> $value"; 
						$n = fmod($x,2); 
						if($n) $clr = $col1; else $clr = $col2;
						
						$value = $$varKey;
						
						if(!$this->funcdbindex->hiddenfields($varKey)){ 
						
							echo '<tr valign="top" bgcolor="'.$clr.'">';
							echo '  <td>'.$varKey.'</td>';
							
							$inputsize = 'width:120px';
							if	  ($arr_fields_type[$k]=="varchar(255)") $inputsize = 'width:220px';
							elseif($arr_fields_type[$k]=="varchar(120)") $inputsize = 'width:160px'; 
							
							if($arr_fields_type[$k]=="text")
							echo '  <td><textarea rows="2" name="'.$varKey.'" id="'.$varKey.'" style="width:220px">'.$value.'</textarea></td>';
							else
							echo '  <td><input type="text" style="'.$inputsize.'" name="'.$varKey.'" id="'.$varKey.'" value="'.$value.'" /></td>';
	 
							echo '</tr>';
	 
							$x++;
							
						}	 
					} 
					
				}
				?>
                
                <tr valign="top" bgcolor="#cccccc">
                  <td><? if($status_id==1){ ?><input type="submit" name="bdel" id="bdel" value="DELETE" class="bgRed white"/><? } ?></td>
                  <td><? if($status_id==0&&!empty($id)){ ?><input type="submit" name="button" id="button" value="ACTIVATE" /><? }else{ ?><input type="submit" name="button" id="button" value="Submit" /><? } ?></td>
                </tr>
                </table>
                
                </td>
              </tr>
            </table> 
            
  
      
      		 
             
        
        
        
        
    </form>
 
    </div>
   </div>
</div>
<? require_once('include/bottom.php'); ?>
