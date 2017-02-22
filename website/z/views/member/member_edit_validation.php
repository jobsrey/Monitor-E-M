<? require_once('include/top.php'); ?>

<link rel="stylesheet" href="/asset/css/jquery-ui-1.9.2.css" />    
<script type="text/javascript" language="javascript" src="/asset/js/jquery-ui-1.9.2.js"></script> 
<script> $(function() { $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' }); }); </script>
<script> $(function() { $( "#datepicker3" ).datepicker({ dateFormat: 'yy-mm-dd' }); }); </script>
<script> $(function() { $( "#datepicker4" ).datepicker({ dateFormat: 'yy-mm-dd' }); }); </script>
<script> $(document).ready(function(){ $("#but-filter").click(function(){ $("#form-filter").toggle(); });});</script>
<script> $(document).ready(function(){ $("#but-desc").click(function(){ $("#form-desc").toggle(); });});</script>
<style type="text/css">
.lblpage{padding-top:20px;} 
.tdline thead td{ border-top:0px solid #aaa;}
.tdline tbody td{ border-bottom:0px solid #aaa;}
.ibDtPict input#datepicker,.ibDtPict input#datepicker2, .ibDtPict select{font:normal 13px arial;}
.ibDtPict input#datepicker,.ibDtPict input#datepicker2 {height:18px;width:65px;}
.ibDtPict select{height:20px;}

.bt_formreg, input, select, textarea{ border:1px solid #ddd; font-size:15px; padding:4px 6px;}

button{font:normal 15px Arial;padding:4px 6px; cursor:pointer;} 
 

.bt_formreg{ background-color:#ddd; border-radius: 5px; font:normal 9px arial; cursor:pointer;}
.bt_formreg:active, button:active {
    position: relative;
    top: 1px;
}
.bt_formreg1 {border:1px solid #ddd; font-size:15px; padding:4px 6px;}
.bt_formreg1 {background-color:#ddd; border-radius: 5px; font:normal 9px arial; cursor:pointer;}
</style>


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
           <form id="form" action="<?=base_url()?>member_manage/qedit_usrval" method="post"  onsubmit="return validateFormUser('form')" >
      <table width="100%" border="0" cellpadding="8" cellspacing="1" bgcolor="#FFFFFF">
           
           
        <tr bgcolor="#CCCCCC">
          <td colspan="2" nowrap bgcolor="#CCCCCC"><input name="ID" type="hidden" value="<?=$row['ID'];?>">
            <strong>MEMBER   TFC</strong> : <span class="red">VALIDATION<? //if($edit=='add') echo ' - New User Created';?></span></td>
          <td colspan="2" bgcolor="#CCCCCC">ID :
            <?=$row['ID'];?>
            <? /*
          <select name="AccessType" <? if($this->session->userdata('ID')!=1 && $this->session->userdata('ID')!=2 && !$isAdmin) echo "disabled";?> >
            <option value="admin" <? if($row['AccessType']=="admin") echo "selected";?>>Admin -> Full Access</option> 
            <option value="user" <? if($row['AccessType']=="user") echo "selected";?>>User -> Limited Access</option>
          </select>
          */ ?></td>
          </tr>
        <tr  bgcolor="#FFB3B3">
          <td  nowrap bgcolor="#FFB3B3">TFC Branch</td>
          <td  bgcolor="#FFB3B3">
            <?
		  	$disableGroup = ' disabled="disabled" ';
			if( $this->session->userdata('ID')==1 ) 	 $disableGroup = '';
			if( $this->session->userdata('ID')==2 ) 	 $disableGroup = ''; 
			if( $this->session->userdata('AccessType')=='admin' && $this->session->userdata('GroupID')==1) $disableGroup = '';
						
			if( empty($row['GroupID']) && empty($row['ID']) && $this->session->userdata('ID')!=1 && $this->session->userdata('ID')!=2 ){
			
				$row['GroupID'] = $this->session->userdata('GroupID');
			}
			//--- khusus user validator
			if($this->session->userdata('Username')=='tfcvalidator') $disableGroup = ' disabled="disabled" ';
			
			
			//if($row['GroupID']==13) $disableGroup = ' disabled="disabled" ';
			
			
			//foreach($rowgrp as $rowgrp) foreach($rowgrp as $key => $value) echo "<br>$key => $value"; 
			//echo $row['GroupID']; exit;
		  	
		 
			
			?>
            	<select name="GroupID" id="GroupID" <?=$disableGroup;?> onchange="get_branch_data( $('select#GroupID').val() )" >
                <option value="-1"></option>
                <? foreach($rowgrp as $rowgrp){  ?>
                <option value="<?=$rowgrp['id'];?>" <? if(trim($row['GroupID'])==trim($rowgrp['id'])){ echo 'selected="selected"'; $GroupName=$rowgrp['group']; $GroupDesc=$rowgrp['description']; }?> ><?=$rowgrp['group']; ?></option>
                <? } ?>
			</select></td>
          <td width="120" bgcolor="#FFB3B3">Card Type </td>
          <td  bgcolor="#FFB3B3"><?
			$tbl = "md_member_type";
			$slc_key = "TFCMemberTypeID";
			$rowData = $this->allmodel->getTableWhere($tbl);
		  ?><select name="<?=$slc_key;?>" id="<?=$slc_key;?>2" <?=$disableGroup;?>> 
              <? foreach($rowData as $rowRes){  ?>
              <option value="<?=$rowRes['id'];?>" <? if($row[$slc_key]==$rowRes['id']) echo 'selected="selected"';?> >
              <?=$rowRes['name']; ?>
              </option>
              <? } ?>
            </select></td>
          </tr>
        <tr  bgcolor="#efefef">
          <td  nowrap bgcolor="#FFFFCC">Name on Card</td>
          <td bgcolor="#FFFFCC" ><span class="size20"><?=$row['FullName'];?></span></td>
          <td nowrap="nowrap" bordercolor="#F0F0F0" bgcolor="#FFFFCC">Card Valid Date <span class="red"></span> </td>
          <td bordercolor="#F0F0F0" bgcolor="#FFFFCC">
          <?
		  	if( $row['TFCValidDateBegin']=="0000-00-00" || empty($row['TFCValidDateBegin']) ) 
				 $curTFCValidDateBegin = date("Y-m-d");
			else $curTFCValidDateBegin = $row['TFCValidDateBegin'];
			
			
			if( $row['TFCValidDateEnd']=="0000-00-00" || empty($row['TFCValidDateEnd']) ) 
				 $curTFCValidDateEnd = date('Y-m-d', strtotime('+1 year', strtotime(date("Y-m-d"))) );
			else $curTFCValidDateEnd = $row['TFCValidDateEnd'];
		  
		  ?>
          
          <input <?  if(empty($row['ID'])) echo ' disabled="disabled" ';  ?>name="TFCValidDateBegin" type="text" id="datepicker2" value="<?=$curTFCValidDateBegin;?>" size="7" maxlength="10" />
            thru 
          <input <?  if(empty($row['ID'])) echo ' disabled="disabled" ';  ?> name="TFCValidDateEnd" type="text" id="datepicker3" value="<?=$curTFCValidDateEnd;?>" size="7" maxlength="10" /></td>
        </tr>
        <tr  bgcolor="#efefef">
          <td  nowrap bgcolor="#FFFFCC">Card Number <span class="red"></span></td>
          <td bgcolor="#FFFFCC" > 
          <? 
		  	
			if(empty($row['TFCNumber'])){  
				//--- generater number  000 000 0000    10000001
				//$grpID = $this->session->userdata('GroupID');  
		  		$grpID = $row['GroupID']; 
				
				$grp = $grpID; 
				if(strlen(trim($grp))==0) $grp = "000".$grp;
				if(strlen(trim($grp))==1) $grp = "00".$grp;
				if(strlen(trim($grp))==2) $grp = "0".$grp; 
				//echo $grp; 
				//--- get last number
				$tmpNumber = 80000000000 + $grp*10000000 + 1;  
				$lastNumber = 0;
 
				for($i=$tmpNumber;$i<=($tmpNumber+1000000);$i++){ 
					//echo $i."<br>";
					$qNum = "Select 1 From member_table Where GroupID = '".$grpID."' And TFCNumber = '".substr($i,1,strlen($i))."' Limit 1";
					$qChkNum = $this->db->query($qNum);
					if(!$qChkNum->num_rows()){ 
					 	$newNumber = substr($i,1,strlen($i)); 
					 	break;  
					}
				} 
		  
 
				/* old method
				$qNum = "Select TFCNumber From member_table Where GroupID = '".$grpID."' Order By TFCNumber Desc Limit 1";
				$qDataNum = $this->db->query($qNum); 
				if($qDataNum->num_rows()){  
					$rowNum = $qDataNum->result_array();
					$lastNumber = $rowNum[0]['TFCNumber']; 
				} 
				//if(empty($lastNumber)) $lastNumber = 0; 
				$newNumber = $tmpNumber + substr($lastNumber,3,strlen($tmpNumber))+1;
				$newNumber = substr($newNumber,1,strlen($newNumber));
				//echo $newNumber ; //1 000 0001 
				*/
				
			} 
			else $newNumber = $row['TFCNumber']; 
			
			//echo $newNumber; exit;
		  ?> 
            <input name="TFCNumber" type="text" value="<?=$newNumber;?>" size="10" maxlength="10"  <? if(empty($row['ID'])) echo ' disabled="disabled" '; ?> autocomplete="off" />          </td>
          <td nowrap="nowrap" bordercolor="#F0F0F0" bgcolor="#FFFFCC">Member Status <span class="red"></span></td>
          <td bordercolor="#F0F0F0" bgcolor="#FFFFCC"><span class="red size16"><?=$row['TFCStatus'];?></span>  &nbsp;=&gt;&nbsp; 
          <select name="TFCStatus" id="TFCStatus" > 
			  <option value="" 	<? echo 'selected="selected"';?> ></option> 
			  <option value="REGISTER" 	<? if($row['TFCStatus']=="REGISTER") echo 'selected="selected"';?> >REGISTER</option>
              <option value="PAID" 		<? if($row['TFCStatus']=="PAID") 	 echo 'selected="selected"';?> >PAID</option>  
              <option value="PRINTCARD" <? if($row['TFCStatus']=="PRINTCARD")echo 'selected="selected"';?> >PRINTCARD</option> 
              <? if(!empty($row['TFCSerialNumber'])){ ?> 
              <option value="VALID" <? if($row['TFCStatus']=="VALID")echo 'selected="selected"';?> >VALID</option> 
              <? } ?>
			  
            </select></td>
        </tr>
        <tr  bgcolor="#FFFFFF">
          <td nowrap="nowrap" bgcolor="#FFFFCC">Card Serial Number <span class="red">*</span></td>
          <td bgcolor="#FFFFCC"><input name="TFCSerialNumber" type="text" value="<?=$row['TFCSerialNumber'];?>" size="8" maxlength="8" <?  if(empty($row['ID'])) echo ' disabled="disabled" ';  ?> autocomplete="off" /></td>
          <td nowrap="nowrap" bgcolor="#FFFFCC">No. Polisi Mobil</td>
          <td nowrap="nowrap" bgcolor="#FFFFCC"><input readonly="readonly" name="TFCNoPolisi" type="text" value="<?=$row['TFCNoPolisi'];?>" size="9" autocomplete="off" /></td>
        </tr>
        <?  /*
        <tr >
          <td valign="middle" bgcolor="#999999">PIN / Password</td>
          <td colspan="3" bgcolor="#999999">123456 
            <input name="chgPassword" type="button" id="chgPassword" value="Change Password"  onclick="popupwindow('/member_manage/chgpwd/<?=$row['StatusID']?>/<?=$row['ID']?>', 'Member Change Password', 320, 280)" style="cursor:pointer" /></td>
          </tr>
         */ ?>   
        <tr  bgcolor="#efefef">
          <td bgcolor="#FFFFCC">&nbsp;</td>
          <td bgcolor="#FFFFCC"></td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
        </tr>
        <tr  bgcolor="#efefef">
          <td colspan="4" bgcolor="#CCCCCC">&nbsp;<span class="red">* Card Serial Number generate on CARD-PRINT Processing</span></td>
          </tr> 
      </table> 
 

	 
           
            <table width="100%" border="0" cellpadding="8" cellspacing="0" bgcolor="#999">
        <tr align="right" >
          <td height=" " align="left"  class="red tahoma10">&nbsp;
          
		  </td>
          <td >
 
		   &nbsp; 
  			          <input type="submit" name="Submit" value="Submit" style="cursor:pointer" /></td></tr>
      </table>            
       </form> 
       
       	    
          
            
      
	   
 
       
       
      </td>
         </tr>
           
            
            
            
            
       </table>
			
			
			</div>  
 
	</div> 
</div> 
<? require_once('include/bottom.php'); ?>
 