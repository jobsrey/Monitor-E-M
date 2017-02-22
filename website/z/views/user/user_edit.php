<? require_once('include/top.php'); ?>


<div class="container">

	<div class="lblpage" align="right">
		<div class="float_l tahoma size18"><?=$pageLABEL;?></div> 
	</div> 
	
    <div class="linelbl"></div> 
  	<div id="contMenu"> 
   		<div style="clear:both"></div> 
    	<div id="dspdata">  
      		<?//=$indexData?> 
			<table width="" border="0" cellpadding="1" cellspacing="0"> 
		                      
         <tr>
           <td bgcolor="#999999">	
           <form id="form" action="<?=base_url()?>user_manage/qedit_usr" method="post"  onsubmit="return validateFormUser('form')" >
      <table width="100%" border="0" cellpadding="8" cellspacing="0" bgcolor="#FFFFFF">
 
        <tr bgcolor="#CCCCCC">
          <td colspan="4" nowrap bgcolor="#CCCCCC"><input name="ID" type="hidden" value="<?=$row['ID'];?>"><input name="StatusID" type="hidden" value="<?=$row['StatusID'];?>"><strong>User Profile</strong><? if($edit=='add') echo ' - <span class="red">New User Created</span>';?></td>
          <td colspan="3" align="right">ID : <?=$row['ID'];?> &nbsp;</td>
          </tr>
        <tr valign="top" bgcolor="#FFB3B3">
          <td nowrap>Access &nbsp;&nbsp;&nbsp;</td>
          <td width="5">:</td>
          <td>
          <?
		  
		 	//if($row['AccessType']!="admin")
			//if($this->funcuser->chkFinanceAccess($row['ID'])) $row['AccessType'] = "finance" ;
		  	//echo $row['AccessType']
			
			$isAdmin = $isAdmin2 = 0;
			if($this->session->userdata('AccessType')=="super_user") $isAdmin = $isAdmin2 = 1; 
			if($this->session->userdata('AccessType')=="super_user"&&$row['AccessType']=="super_user1") $isAdmin2 = 0;
		  ?>
          
          <select name="AccessType" <? if($this->session->userdata('ID')!=1 && $this->session->userdata('ID')!=2 && !$isAdmin2) echo "disabled";?> > 
            <option value="super_user" <? if($row['AccessType']=="super_user") echo "selected";?>>Super User -> Add/Edit Users Access</option> 
            <option value="admin"  <? if($row['AccessType']=="admin") echo "selected";?>>Admin -> Add/edit/update Data Access</option>
            <option value="finance"  <? if($row['AccessType']=="finance") echo "selected";?>>Finance -> Member Payment Menu Access</option> 
          </select> &nbsp; <span class="red"> </span></td>
          <td>&nbsp;</td>
          <td>Group</td>
          <td width="5">:</td>
          <td width="100%"> 
          <?
		  	$disableGroup = ' disabled="disabled" ';
			if( $this->session->userdata('ID')==1 ) 	 $disableGroup = '';
			if( $this->session->userdata('ID')==2 ) 	 $disableGroup = ''; 
			if( $this->session->userdata('AccessType')=='admin' && $this->session->userdata('GroupID')==1) $disableGroup = '';
 			
			//$this->session->userdata('GroupID'); 
 
			if( empty($row['GroupID']) && empty($row['ID']) && $this->session->userdata('ID')!=1 && $this->session->userdata('ID')!=2 ){
			
				$row['GroupID'] = $this->session->userdata('GroupID');
			}
			
			//foreach($rowgrp as $key => $value) echo "<br>$key => $value";  exit;
			
		  ?>
          <select name="GroupID" id="GroupID" <?=$disableGroup;?> onchange="getvalue('chgGroupID',$('select#GroupID').val())"> 
            <option value="-1"></option>  
          <? foreach($rowgrp as $rowgrp){ ?> 
            <option value="<?=$rowgrp['id'];?>" <? if(trim($row['GroupID'])==trim($rowgrp['id'])) echo 'selected="selected"';?> ><?=$rowgrp['group'];?></option> 
         <? } ?>   
         </select></td>
        </tr>
        <tr valign="top" bgcolor="#FFFFFF">
          <td>Username</td>
          <td width="5">:</td>
          <td><input name="Username" type="text" value="<?=$row['Username'];?>" autocomplete="off" 
          <? if($this->session->userdata('ID')!=1 && $this->session->userdata('ID')!=2 && !$isAdmin) echo "disabled";?> /><span class="red"> * </span></td>
          <td>&nbsp;</td>
          <td width="120" nowrap>Phone&nbsp;</td>
          <td width="5">:</td>
          <td width="100%">
            <input name="Phone" type="text" value="<?=$row['Phone'];?>" autocomplete="off" /></td>
        </tr>
        <tr valign="top" bgcolor="#efefef">
          <td nowrap>Password</td>
          <td width="5">:</td>
          <td>
		  	<? if( empty($row['ID']) || $row['StatusID']==2 ){ ?>
			<input name="Password" type="text" id="Password" value=""  autocomplete="off"/>
			<span class="red"> * </span><br>
            Retype password:<br>
            <input name="Password2" type="password" id="Password2" value="" autocomplete="off" />
             <span class="red"> * </span>
            <? }else{ ?>
			<input name="chgPassword" type="button" id="chgPassword" value="Change Password"  onclick="popupwindow('/user_manage/chgpwd/<?=$row['StatusID']?>/<?=$row['ID']?>', 'User Change Password', 320, 280)" >
			<? } ?>			</td>
          <td>&nbsp;</td>
          <td>Email</td>
          <td width="5">:</td>
          <td nowrap="nowrap"><input name="Email" type="text" value="<?=$row['Email'];?>" size="35" autocomplete="off" /></td>
        </tr>
        <tr valign="top" bgcolor="#FFFFFF">
          <td> Name</td>
          <td width="5">:</td>
          <td nowrap="nowrap">            <input name="FullName" type="text" value="<?=$row['FullName'];?>" size="35" autocomplete="off" /><span class="red"> * </span></td>
          <td>&nbsp;</td>
          <td>Note / <br />
            Comment</td>
          <td width="5">:</td>
          <td><textarea name="Comment" cols="27" rows="2"><?=$row['Comment'];?></textarea></td>
        </tr>
        <tr bgcolor="#efefef"  align="left">
          <td colspan="7"><span class="red">*) must be filled out before submitting the form</span></td>
          </tr>
      </table> 
 
      <table width="100%" border="0" cellpadding="8" cellspacing="0" bgcolor="#999">
        <tr align="right" >
          <td height=" " align="left" valign="top" class="red tahoma10">
          
		  <? /**Edit Previlegs changeable by &quot;Admin/Super User &quot;. */ ?></td>
          <td >
 
		  <? if($row['StatusID']==2){ ?>User Status : 
		  <select name="StatusIDChg" id="StatusIDChg">
            <option value="1">REACTIVATE USER</option>
            <option value="2" selected>KEEP DELETED</option>
          </select>            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<? } ?>
  			<input type="submit" name="Submit" value="Submit" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
      </table>         
       </form> 
       
       	  <? 
		  //if($this->session->userdata('AccessType')=='user')  $disable = ' disabled="disabled" '; 
 
		  if(!empty($menuAccessUsr)){ ?> 
          
      <form id="form2" action="<?=base_url()?>user_manage/qedit_usr" method="post"  onsubmit="return validateFormAccess('form2')" >
      
	  	  <input type="hidden" name="ID" id="ID" value="<?=$row['ID'];?>"> 
          <input type="hidden" name="curGroupID" id="curGroupID" value="<?=$row['GroupID'];?>">
          <input type="hidden" name="chgGroupID" id="chgGroupID" value="<?=$row['GroupID'];?>">
<? 
 
 $show_privileges = 0;
 if($this->session->userdata('AccessType')=='super_user'&& $row['AccessType']!="super_user") $show_privileges = 1;
 if($this->session->userdata('ID')==1) $show_privileges = 1;
 if($this->session->userdata('ID')==2) $show_privileges = 1;

if($show_privileges){ 
// && ( $this->session->userdata('ID')==1||$this->session->userdata('ID')==2 )
?>
	  <table width="100%" border="0" cellpadding="8" cellspacing="0" bgcolor="#FFFFFF">
        <tr bgcolor="#CCCCCC">
          <td colspan="2" nowrap="nowrap"><strong> Edit User Privileges</strong> &nbsp; | &nbsp; Group : <strong><?=$row['group'];?> </strong>
            </td>
          </tr>
        <tr bgcolor="#5A91B1">
          <td>Menu</td>
          <td align="left"> &nbsp;Access &nbsp; | &nbsp;Template set-access =&gt;   
            <input type="button" name="all" id="all" value="All" onclick="checkedAll()" />
			- 
            <input type="button" name="admin" id="admin" value="Admin" onclick="checkedAdmin()" />
			- 
			<input type="button" name="finance" id="finance" value="Finance" onclick="checkedFinance()"/>
			- 
			<input type="button" name="none" id="none" value="None" onclick="checkedNone()"/>            </td>
        </tr> 
		<?=$menuAccessUsr;?>  
        <tr bgcolor="#999999">
          <td colspan="2" bgcolor="#CCCCCC"><span class="red">*Pilihan akses menu diatas dapat dirubah oleh <strong>super-user</strong> dan di set sesuai kebutuhan <strong>user</strong> masing-masing.<span> --- 
            <input type="submit" name="SubmitAccess" value="Update Privileges" />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr> 
      </table>             
<? } ?>               
       </form> 
      
	  <? } else echo '<br><div class="white pad5">=> To Edit <strong>User Privileges</strong>, Select "Group" than enter Submit.</div>'; ?></td>
         </tr>
           
            
            
            
            
       </table>
			
			
			
			
   	 	</div>  
 
	</div> 
</div> 
<? require_once('include/bottom.php'); ?>
 