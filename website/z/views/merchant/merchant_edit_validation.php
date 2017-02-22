<? require_once('include/top.php'); ?>
<link rel="stylesheet" href="/asset/css/jquery-ui-1.9.2.css" />    
<script type="text/javascript" language="javascript" src="/asset/js/jquery-ui-1.9.2.js"></script> 
<script> $(function() { $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' }); }); </script>
<script> $(function() { $( "#datepicker3" ).datepicker({ dateFormat: 'yy-mm-dd' }); }); </script>  
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
.bt_formreg11 {border:1px solid #ddd; font-size:15px; padding:4px 6px;}
.bt_formreg11 {background-color:#ddd; border-radius: 5px; font:normal 9px arial; cursor:pointer;}
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
            
           <form action="<?=base_url()?>merchant_manage/qedit_usrval" method="post" enctype="multipart/form-data" id="form"  onsubmit="return validateFormUser('form')" >
      <table width="100%" border="0" cellpadding="8" cellspacing="1" bgcolor="#FFFFFF">
           
           
        <tr bgcolor="#CCCCCC">
          <td colspan="4" nowrap="nowrap" bgcolor="#CCCCCC">
          	<input name="ID" type="hidden" value="<?=$row['ID'];?>" />
          	<strong>MERCHANT TFC</strong> : <span class="red">VALIDATION</span></td>
        </tr>
        <tr  bgcolor="#FFB3B3">
          <td  nowrap="nowrap" bgcolor="#FFB3B3">TFC Branch</td>
          <td  bgcolor="#FFB3B3"><?
		  	$disableGroup = ' disabled="disabled" ';
			if( $this->session->userdata('ID')==1 ) 	 $disableGroup = '';
			if( $this->session->userdata('ID')==2 ) 	 $disableGroup = ''; 
			if( $this->session->userdata('AccessType')=='admin' && $this->session->userdata('GroupID')==1) $disableGroup = '';
			//--- khusus user validator
			if($this->session->userdata('Username')=='tfcvalidator') $disableGroup = ' disabled="disabled" ';
			 
			
			
			//foreach($rowgrp as $rowgrp) foreach($rowgrp as $key => $value) echo "<br>$key => $value"; 
			//echo $row['GroupID']; exit;
			
			if( empty($row['GroupID']) && empty($row['ID']) && $this->session->userdata('ID')!=1 && $this->session->userdata('ID')!=2 ){
			
				$row['GroupID'] = $this->session->userdata('GroupID');
			}
		  	?>
              <select name="GroupID" id="GroupID" <?=$disableGroup;?> onchange="get_branch_data( $('select#GroupID').val() )" >
                <option value="-1"></option>
                <? foreach($rowgrp as $rowgrp){  ?>
                <option value="<?=$rowgrp['id'];?>" <? if($row['GroupID']==$rowgrp['id']){ echo 'selected="selected"'; $GroupName=$rowgrp['group']; $GroupDesc=$rowgrp['description']; }?> >
                <?=$rowgrp['group']; ?>
                </option>
                <? } ?>
            </select> </td>
          <td bgcolor="#FFB3B3">Accepted Cards </td>
          <td bgcolor="#FFB3B3"><?
			$tbl = "md_tfc_card";
			$slc_key = "TFCMerchantAcceptCardID";
			$rowData = $this->allmodel->getTableWhere($tbl);
		  	?>
            <select name="<?=$slc_key;?>2" id="<?=$slc_key;?>2" <?=$disableGroup;?> >
              <option value="-1"></option>
              <? foreach($rowData as $rowRes){  ?>
              <option value="<?=$rowRes['id'];?>" <? if($row[$slc_key]==$rowRes['id']) echo 'selected="selected"';?> >
              <?=$rowRes['name']; ?>
              </option>
              <? } ?>
            </select></td>
        </tr>
        <tr>
          <td bgcolor="#C6E7FF">Merchant ID <span class="red"></span></td>
          <td bgcolor="#C6E7FF">
          <?  
		  	if(empty($row['TFCMerchantID'])){  
				//--- generater number  000 000 0000
				//$grpID = $this->session->userdata('GroupID');  
		  		$grpID = $row['GroupID']; 
				
				$grp = $grpID; 
				if(strlen(trim($grp))==0) $grp = "000".$grp;
				if(strlen(trim($grp))==1) $grp = "00".$grp;
				if(strlen(trim($grp))==2) $grp = "0".$grp; 
				//echo $grp; 
				//--- get last number
				$tmpNumber = 80000000 + $grp*10000 + 1;  
				$lastNumber = 0; 
				
				for($i=$tmpNumber;$i<=($tmpNumber+10000);$i++){ 
					//echo $i."<br>";
					$qNum = "Select 1 From merchant_table Where GroupID = '".$grpID."' And TFCMerchantID = '".substr($i,1,strlen($i))."' Limit 1";
					$qChkNum = $this->db->query($qNum);
					if(!$qChkNum->num_rows()){ 
					 	$newNumber = substr($i,1,strlen($i)); 
					 	break;  
					}
				} 
				
				/*
				$qNum = "Select TFCMerchantID From merchant_table Where GroupID = '".$grpID."' Order By TFCMerchantID Desc Limit 1";
				$qDataNum = $this->db->query($qNum); 
				if($qDataNum->num_rows()){  
					$rowNum = $qDataNum->result_array();
					$lastNumber = $rowNum[0]['TFCMerchantID']; 
				} 
				//if(empty($lastNumber)) $lastNumber = 0; 
				$newNumber = $tmpNumber + substr($lastNumber,3,strlen($tmpNumber))+1;
				$newNumber = substr($newNumber,1,strlen($newNumber));
				//echo $newNumber ; //1 000 0001  
				*/
			} 
			else $newNumber = $row['TFCMerchantID'];  
			
			//echo $newNumber; exit;
			
			if( $row['TFCMerchantValidDateBegin']=="0000-00-00" || empty($row['TFCMerchantValidDateBegin']) ) 
				 $curTFCMerchantValidDateBegin = date("Y-m-d");
			else $curTFCMerchantValidDateBegin = $row['TFCMerchantValidDateBegin'];
			
			
			if( $row['TFCMerchantValidDateEnd']=="0000-00-00" || empty($row['TFCMerchantValidDateEnd']) ) 
				 $curTFCMerchantValidDateEnd = date('Y-m-d', strtotime('+1 year', strtotime(date("Y-m-d"))) );
			else $curTFCMerchantValidDateEnd = $row['TFCMerchantValidDateEnd'];
		  ?> 
          <input name="TFCMerchantID" type="text" id="TFCMerchantID"  value="<?=$newNumber;?>" size="10" maxlength="7" <? if(empty($row['ID'])) echo ' disabled="disabled" '; ?> autocomplete="off" />           </td>
          <td width="120" nowrap="nowrap" bgcolor="#FFFFCC">Merchant Valid Date <span class="red"></span><br /></td>
          <td bgcolor="#FFFFCC"><table border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td><input name="TFCMerchantValidDateBegin" type="text" id="datepicker2" value="<?=$curTFCMerchantValidDateBegin;?>" size="7" maxlength="12" /></td>
              <td>&nbsp;thru&nbsp;</td>
              <td><input name="TFCMerchantValidDateEnd"   type="text" id="datepicker3" value="<?=$curTFCMerchantValidDateEnd;?>" size="7" maxlength="12" /></td>
            </tr>

          </table></td>
        </tr>
        <tr  bgcolor="#efefef">
          <td bgcolor="#C6E7FF">Merchant Name</td>
          <td bgcolor="#C6E7FF"><span class="size16 bold"><?=$row['TFCMerchantName'];?></span></td>
          <td nowrap="nowrap" bgcolor="#FFFFCC">Merchant Status</td>
          <td bgcolor="#FFFFCC"><span class="red size16"><?=$row['TFCMerchantStatus'];?> </span>   =&gt;
            <select name="TFCMerchantStatus" id="TFCMerchantStatus" <?//=$disableGroup;?> >
           	  <? if(empty($row['ID'])){ ?>
              <option value="REGISTER" selected="selected" >REGISTER</option>
              <? }else{ ?>  
              <option value="VALID" 	<? if($row['TFCMerchantStatus']=="VALID") 	 echo 'selected="selected"';?> >VALID</option>
              <option value="EXPIRED" 	<? if($row['TFCMerchantStatus']=="EXPIRED")  echo 'selected="selected"';?> >EXPIRED</option>
              <option value="REGISTER" 	<? if($row['TFCMerchantStatus']=="REGISTER") echo 'selected="selected"';?> >REGISTER</option>
              <? } ?>
            </select></td>
        </tr> 
        <tr valign="top" bgcolor="#efefef">
          <td valign="middle" nowrap="nowrap" bgcolor="#efefef">AE-Officer-Name</td>
          <td valign="middle" nowrap="nowrap" bgcolor="#efefef"><?=$row['TFCMerchantAE'];?></td>
          <td valign="middle" nowrap="nowrap" bgcolor="#efefef">Register Date</td>
          <td valign="middle" nowrap="nowrap" bgcolor="#efefef"><? echo $row['TFCMerchantRegisterDate'];?></td>
        </tr>
      </table> 
	  <table width="100%" border="0" cellpadding="8" cellspacing="0" bgcolor="#999">
      	<tr align="right" >
        	<td></td>
            <td >&nbsp;<input type="submit" name="Submit" value="Submit" style="cursor:pointer" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
      </table>            
      </form> 
           
           
            
           
            
           
            
           
           
           
           
           
           
           
       
       	   
          
       
      
	   
 
       
       
      </td>
         </tr>
           
            
            
            
            
       </table>
			
			<br /><br />
			
			
   	 	</div>  
 
	</div> 
</div> 
<? require_once('include/bottom.php'); ?>
 