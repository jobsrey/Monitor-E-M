<? require_once('include/top.php'); ?>


<div class="container">

	<div class="lblpage" align="right">
		<div class="float_l tahoma size18"><?=$pageLABEL;?>ss</div> 
	</div> 
	
    <div class="linelbl"></div> 
  	<div id="contMenu"> 
   		<div style="clear:both"></div> 
    	<div id="dspdata"> 
      		 
			<table width="100%" border="0" cellpadding="1" cellspacing="0"> 
			<form id="form" action="<?=base_url()?>user_manage/qedit" method="post"  onsubmit="return validateFormUser('form')" >
                            
         <tr>
           <td bgcolor="#999999"><table width="100%" border="0" cellpadding="8" cellspacing="0" bgcolor="#FFFFFF">
        <tr bgcolor="#CCCCCC">
          <td colspan="4" nowrap bgcolor="#CCCCCC"><input name="ID" type="hidden" value="<?=$row['ID'];?>"><input name="StatusID" type="hidden" value="<?=$row['StatusID'];?>"><strong>User Profile</strong><? if($edit=='add') echo ' - <span class="red">New User Created</span>';?></td>
          <td colspan="3" align="right">ID : <?=$row['ID'];?> &nbsp;</td>
          </tr>
        <tr valign="top" bgcolor="#FFB3B3">
          <td nowrap>Access &nbsp;&nbsp;&nbsp;</td>
          <td width="5">:</td>
          <td><select name="AccessType">
            <option value="admin" <? if($row['AccessType']=="admin") echo "selected";?>>Admin -> Full Access</option>
            <option value="user" <? if($row['AccessType']=="user") echo "selected";?>>User -> Limited Access</option>
          </select> 
&nbsp;            <span class="red"> </span></td>
          <td>&nbsp;</td>
          <td>Group</td>
          <td width="5">:</td>
          <td width="100%"><select name="GroupID" id="GroupID">
            <option value="0" <? if($row['GroupID']=="0") echo "selected";?>>none</option>
            <option value="1" <? if($row['GroupID']=="1") echo "selected";?>>Lunari</option>
                              </select></td>
        </tr>
        <tr valign="top" bgcolor="#FFFFFF">
          <td>Username</td>
          <td width="5">:</td>
          <td>            <input name="Username" type="text" value="<?=$row['Username'];?>" /><span class="red"> * </span></td>
          <td>&nbsp;</td>
          <td width="120" nowrap>Phone 1 &nbsp;&nbsp;</td>
          <td width="5">:</td>
          <td width="100%">
            <input name="Phone" type="text" value="<?=$row['Phone'];?>" /><span class="red"> * </span>
          </td>
        </tr>
        <tr valign="top" bgcolor="#efefef">
          <td nowrap>Password</td>
          <td width="5">:</td>
          <td>
		  	<? if( empty($row['ID']) || $row['StatusID']==2 ){ ?>
			<input name="Password" type="text" id="Password" /><span class="red"> * </span><br>
            Retype password:<br>
            <input name="Password2" type="password" id="Password22" /> <span class="red"> * </span>
            <? }else{ ?>
			<input name="chgPassword" type="button" id="chgPassword" value="Change Password"  onclick="popupwindow('/user_manage/chgpwd/<?=$row['StatusID']?>', 'User Change Password', 320, 240)" >
			<? } ?>			</td>
          <td>&nbsp;</td>
          <td>Phone 2 </td>
          <td width="5">:</td>
          <td><input name="Phone2" type="text" value="<?=$row['Phone2'];?>" /></td>
        </tr>
        <tr valign="top" bgcolor="#FFFFFF">
          <td> Name</td>
          <td width="5">:</td>
          <td>            <input name="FullName" type="text" value="<?=$row['FullName'];?>" size="35" /><span class="red"> * </span></td>
          <td>&nbsp;</td>
          <td>Phone 3 </td>
          <td width="5">:</td>
          <td><input name="Phone3" type="text" value="<?=$row['Phone3'];?>" /></td>
        </tr>
        <tr valign="top" bgcolor="#efefef">
          <td>Address</td>
          <td width="5">:</td>
          <td>            <textarea name="Address" cols="27" rows="2"><?=$row['Address'];?></textarea>
           </td>
          <td>&nbsp;</td>
          <td>Email</td>
          <td width="5">:</td>
          <td><input name="Email" type="text" value="<?=$row['Email'];?>" size="35" /><span class="red"> * <br>
              <br>
              </span></td>
        </tr>
        <tr valign="top" bgcolor="#efefef">
          <td colspan="7"><span class="red">*) must be filled out before submitting the form</span></td>
          </tr>
      </table> 
	  
	  
      <table width="100%" border="0" cellpadding="8" cellspacing="0" bgcolor="#FFFFFF">
        <tr bgcolor="#CCCCCC">
          <td colspan="2"><strong> User Privileges </strong></td>
        </tr>
        <tr bgcolor="#5A91B1">
          <td>Menu</td>
          <td> &nbsp;Access </td>
        </tr> 
		<?=$mainMenuTbl;?> 
      </table>
	  
	  
	  
	  
	  
	  
                        <br>
            <table width="100%" border="0" cellpadding="8" cellspacing="0" bgcolor="#FFFFFF">
        <tr align="right" bgcolor="#FFFFFF">
          <td height="55" align="left" valign="top" bgcolor="#FFFFFF" class="red tahoma10">*Edit Previlegs changeable by user with access &quot;Admin&quot; only.</td>
          <td >
		  <? if($row['StatusID']==2){ ?><select name="StatusIDChg" id="StatusIDChg">
            <option value="1">REACTIVATE USER</option>
            <option value="2" selected>KEEP DELETED</option>
          </select>            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<? } ?>
  <input type="submit" name="Submit" value="Submit" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
      </table>            </td>
         </tr>
            </form>
       </table>
			
			
			
			
   	 	</div>  
 
	</div> 
</div> 
<? require_once('include/bottom.php'); ?>
 