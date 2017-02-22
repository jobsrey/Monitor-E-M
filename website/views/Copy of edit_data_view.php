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
                
                <? if($TABLE=='authorize_dealer'){ ?>
				
				
                  <tr valign="top" bgcolor="#FFFFFF">
                  <td>dealer</td>
                  <td><input name="dealer" type="text" id="dealer" autocomplete="off" value="<?=$dealer?>" size="35" /></td>
                </tr>
                  <tr valign="top" bgcolor="#efefef">
                  <td>name</td>
                  <td><input name="name" type="text" id="name" autocomplete="off" value="<?=$name?>" /></td>
                </tr>
                  <tr valign="top" bgcolor="#FFFFFF">
                  <td>email</td>
                  <td><input name="email" type="text" id="email" autocomplete="off" value="<?=$email?>" /></td>
                </tr>
                  <tr valign="top" bgcolor="#efefef">
                  <td>address</td>
                  <td><textarea name="address" cols="27" rows="2" id="address"><?=$address?>
                  </textarea></td>
                </tr>
                  <tr valign="top" bgcolor="#FFFFFF">
                  <td>phone_1</td>
                  <td><input name="phone_1" type="text" id="phone_1" autocomplete="off" value="<?=$phone_1?>" /></td>
                </tr>
                  <tr valign="top" bgcolor="#FFFFFF">
                  <td>phone_2</td>
                  <td><input name="phone_2" type="text" id="phone_2" autocomplete="off" value="<?=$phone_2?>" /></td>
                </tr>
                  <tr valign="top" bgcolor="#FFFFFF">
                  <td>phone_3</td>
                  <td><input name="phone_3" type="text" id="phone_3" autocomplete="off" value="<?=$phone_3?>" /></td>
                </tr>
                  <tr valign="top" bgcolor="#FFFFFF">
                  <td>phone_4</td>
                  <td><input name="phone_4" type="text" id="phone_4" autocomplete="off" value="<?=$phone_4?>" /></td>
                </tr>
                
                  	<? } ?>
					
					
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
        
        
                  	<? } ?>
                
                
                  <tr valign="top" bgcolor="#cccccc">
                  <td><input type="submit" name="bdel" id="bdel" value="DELETE" class="bgRed white"/></td>
                  <td><input type="submit" name="button" id="button" value="Submit" /></td>
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
