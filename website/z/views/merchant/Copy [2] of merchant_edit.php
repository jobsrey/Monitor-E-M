<? require_once('include/top.php'); ?>
<link rel="stylesheet" href="/asset/css/jquery-ui-1.9.2.css" />    
<script type="text/javascript" language="javascript" src="/asset/js/jquery-ui-1.9.2.js"></script>
<script> $(function() { $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' }); }); </script>
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
           
           <? if($ID==0){ ?>
           <form action="<?=base_url()?>merchant_manage/qedit_usr" method="post" enctype="multipart/form-data" id="form"  onsubmit="return validateFormUser('form')" >
      <table width="100%" border="0" cellpadding="8" cellspacing="1" bgcolor="#FFFFFF">
           
           
        <tr bgcolor="#CCCCCC">
          <td colspan="4" nowrap="nowrap" bgcolor="#CCCCCC">
          	<input name="ID" type="hidden" value="<?=$row['ID'];?>" />
          	<strong>MERCHANT TFC</strong> : <span class="red">REGISTER</span></td>
        </tr>
        <tr  bgcolor="#FFB3B3">
          <td  nowrap="nowrap" bgcolor="#FFB3B3">TFC Branch</td>
          <td  bgcolor="#FFB3B3"><?
		  	$disableGroup = ' disabled="disabled" ';
			if( $this->session->userdata('ID')==1 ) 	 $disableGroup = '';
			if( $this->session->userdata('ID')==2 ) 	 $disableGroup = ''; 
			if( $this->session->userdata('AccessType')=='admin' && $this->session->userdata('GroupID')==1) $disableGroup = '';
			 
			
			
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
          <td colspan="2" rowspan="2" bgcolor="#FFB3B3"><div id="branch_data"><div class="size20 bold"><?=$GroupName;?></div><div style="padding:3px 0;"><?=nl2br($GroupDesc);?></div></div></td>
          </tr>
        <tr  bgcolor="#FFB3B3">
          <td  nowrap="nowrap" bgcolor="#FFB3B3">PIC-Officer-Name</td>
          <td  bgcolor="#FFB3B3"><input name="TFCMerchantAE" type="text" id="TFCMerchantAE" value="<?=$row['TFCMerchantAE'];?>" size="16" autocomplete="off" /></td>
        </tr>
        <tr>
          <td bgcolor="#C6E7FF">Merchant ID <span class="red">*</span></td>
          <td bgcolor="#C6E7FF"><input <? echo ' disabled="disabled" '; ?> name="TFCMerchantID" type="text" id="TFCMerchantID" value="<?=$row['TFCMerchantID'];?>" size="10" autocomplete="off" /></td>
          <td width="120" nowrap="nowrap" bgcolor="#efefef">Register Date<br /></td>
          <td bgcolor="#efefef"> 
          <input id="TFCMerchantRegisterDate" name="TFCMerchantRegisterDate" type=" " size="7" maxlength="18"  value="<? if(empty($row['TFCMerchantRegisterDate']))echo date("Y-m-d");else echo $row['TFCMerchantRegisterDate'];?>" readonly="readonly">          
            *yyyy-mm-dd</td>
        </tr>
        <tr  bgcolor="#efefef">
          <td bgcolor="#C6E7FF">Merchant Name </td>
          <td bgcolor="#C6E7FF"><input name="TFCMerchantName" type="text" id="TFCMerchantName" value="<?=$row['TFCMerchantName'];?>" size="35" autocomplete="off" /></td>
          <td nowrap="nowrap" bgcolor="#ffffff"> Valid Date <span class="red">*</span></td>
          <td bgcolor="#ffffff"><table border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td><input <? echo ' disabled="disabled" '; ?> name="TFCMerchantValidDateBegin" type="text" id="TFCMerchantValidDateBegin" value="<?=$row['TFCMerchantValidDateBegin'];?>" size="7" maxlength="12" /></td>
              <td>&nbsp;thru&nbsp;</td>
              <td><input <? echo ' disabled="disabled" '; ?> name="TFCMerchantValidDateEnd" type="text" id="TFCMerchantValidDateEnd" value="<?=$row['TFCMerchantValidDateEnd'];?>" size="7" maxlength="12" /></td>
            </tr>

          </table>            </td>
        </tr>
        
        <tr bgcolor="#FFFFFF">
          <td valign="middle" nowrap="nowrap" bgcolor="#efefef">Category </td>
          <td valign="top" bgcolor="#efefef"><?
			$tbl = "md_merchant_category";
			$slc_key = "TFCMerchantCategoryID";
			$rowData = $this->allmodel->getTableWhere($tbl);
		  	?>
            <select name="<?=$slc_key;?>" id="<?=$slc_key;?>" <?//=$disableGroup;?> >
              <option value="-1"></option>
              <? foreach($rowData as $rowRes){  ?>
              <option value="<?=$rowRes['id'];?>" <? if($row[$slc_key]==$rowRes['id']) echo 'selected="selected"';?> >
              <?=$rowRes['name']; ?>
              </option>
              <? } ?>
            </select></td>
          <td valign="middle" bgcolor="#FFFFCC">Merchant Status <span class="red">*</span></td>
          <td bgcolor="#FFFFCC"><span class="red size16"><?=$row['TFCMerchantStatus'];?> </span>   =&gt;
            <select name="TFCMerchantStatus" id="TFCMerchantStatus" <?//=$disableGroup;?> >
           	  <? if(empty($row['ID'])){ ?>
              <option value="REGISTER" selected="selected" >REGISTER</option>
              <? }else{ ?>  
              <option value="REGISTER" 	<? if($row['TFCMerchantStatus']=="REGISTER") echo 'selected="selected"';?> >REGISTER</option>
              <option value="PAID" 		<? if($row['TFCMerchantStatus']=="PAID") 	 echo 'selected="selected"';?> >PAID</option> 
              <option value="VALID" 	<? if($row['TFCMerchantStatus']=="VALID") 	 echo 'selected="selected"';?> >VALID</option>
              <option value="EXPIRED" 	<? if($row['TFCMerchantStatus']=="EXPIRED")  echo 'selected="selected"';?> >EXPIRED</option>
              <? } ?>
            </select>            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td valign="middle" nowrap="nowrap" bgcolor="#ffffff">Value-Type</td>
          <td valign="top" bgcolor="#ffffff"><?
			$tbl = "md_merchant_type";
			$slc_key = "TFCMerchantTypeID";
			$rowData = $this->allmodel->getTableWhere($tbl);
		  	?>
            <select name="<?=$slc_key;?>" id="<?=$slc_key;?>" <?//=$disableGroup;?> >
              <option value="-1"></option>
              <? foreach($rowData as $rowRes){  ?>
              <option value="<?=$rowRes['id'];?>" <? if($row[$slc_key]==$rowRes['id']) echo 'selected="selected"';?> >
                <?=$rowRes['name'];?>
                </option>
              <? } ?>
            </select></td>
          <td bgcolor="#ffffff">Accepted Cards</td>
          <td bgcolor="#ffffff"><?
			$tbl = "md_tfc_card";
			$slc_key = "TFCMerchantAcceptCardID";
			$rowData = $this->allmodel->getTableWhere($tbl);
		  	?>
            <select name="<?=$slc_key;?>" id="<?=$slc_key;?>" <?//=$disableGroup;?> >
              <option value="-1"></option>
              <? foreach($rowData as $rowRes){  ?>
              <option value="<?=$rowRes['id'];?>" <? if($row[$slc_key]==$rowRes['id']) echo 'selected="selected"';?> >
              <?=$rowRes['name']; ?>
              </option>
              <? } ?>
            </select></td>
        </tr>
        <tr valign="top" bgcolor="#efefef">
          <td colspan="4" valign="middle" nowrap="nowrap" bgcolor="#efefef"><span class="red"><em>*) setting this on menu merchant validation</em></span></td>
          </tr>
      </table> 
	  <table width="100%" border="0" cellpadding="8" cellspacing="0" bgcolor="#999">
      	<tr align="right" >
        	<td></td>
            <td >&nbsp;<input type="submit" name="Submit" value="Submit" style="cursor:pointer" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
      </table>            
      </form> 
           
           
           <? } else { //-- else if ID==0 ?>
           
           <form action="<?=base_url()?>merchant_manage/qedit_usr" method="post" enctype="multipart/form-data" id="form"  onsubmit="return validateFormUser('form')" >
      <table width="100%" border="0" cellpadding="8" cellspacing="1" bgcolor="#FFFFFF">
           
           
        <tr bgcolor="#CCCCCC">
          <td colspan="2" nowrap="nowrap" bgcolor="#CCCCCC"><input name="ID" type="hidden" value="<?=$row['ID'];?>" />
              <input name="StatusID" type="hidden" value="<?=$row['StatusID'];?>" />
              <strong>MERCHANT   TFC</strong> : <span class="red">EDIT PROFILE
                <? //if($edit=='add') echo ' - New User Created';?>
              </span></td>
          <td colspan="2" bgcolor="#CCCCCC">ID :
            <?=$row['ID'];?>
            <? /*<select name="AccessType" <? if($this->session->userdata('ID')!=1 && $this->session->userdata('ID')!=2 && !$isAdmin) echo "disabled";?> >
              <option value="admin" <? if($row['AccessType']=="admin") echo "selected";?>>Admin -&gt; Full Access</option>
              <option value="user" <? if($row['AccessType']=="user") echo "selected";?>>User -&gt; Limited Access</option>
              </select>
			  */ ?>
              <input id="AccessType" name="AccessType" type="hidden" value="user">              </td>
          </tr>
        <tr  bgcolor="#FFB3B3">
          <td  nowrap="nowrap" bgcolor="#FFB3B3">TFC Branch</td>
          <td  bgcolor="#FFB3B3"><?
		  	$disableGroup = ' disabled="disabled" ';
			if( $this->session->userdata('ID')==1 ) 	 $disableGroup = '';
			if( $this->session->userdata('ID')==2 ) 	 $disableGroup = ''; 
			if( $this->session->userdata('AccessType')=='admin' && $this->session->userdata('GroupID')==1) $disableGroup = '';
			//foreach($rowgrp as $rowgrp) foreach($rowgrp as $key => $value) echo "<br>$key => $value"; 
			//echo $row['GroupID']; exit;
		  	?>
              <select name="GroupID" id="GroupID" <?=$disableGroup;?> onchange="get_branch_data( $('select#GroupID').val() )" >
                <option value="-1"></option>
                <? foreach($rowgrp as $rowgrp){  ?>
                <option value="<?=$rowgrp['id'];?>" <? if($row['GroupID']==$rowgrp['id']){ echo 'selected="selected"'; $GroupName=$rowgrp['group']; $GroupDesc=$rowgrp['description']; }?> >
                <?=$rowgrp['group']; ?>
                </option>
                <? } ?>
            </select> </td>
          <td colspan="2" rowspan="2" bgcolor="#FFB3B3"><div id="branch_data"><div class="size20 bold"><?=$GroupName;?></div><div style="padding:3px 0;"><?=$GroupDesc;?></div></div></td>
          </tr>
        <tr  bgcolor="#FFB3B3">
          <td  nowrap="nowrap" bgcolor="#FFB3B3">PIC-Officer-Name</td>
          <td  bgcolor="#FFB3B3"><input name="TFCMerchantAE" type="text" id="TFCMerchantAE" value="<?=$row['TFCMerchantAE'];?>" size="16" autocomplete="off" /></td>
        </tr>
        <tr>
          <td bgcolor="#C6E7FF">Merchant ID <span class="red">*</span></td>
          <td bgcolor="#C6E7FF"><input <? echo ' disabled="disabled" '; ?> name="TFCMerchantID" type="text" id="TFCMerchantID" value="<?=$row['TFCMerchantID'];?>" size="10" autocomplete="off" /></td>
          <td width="120" nowrap="nowrap" bgcolor="#efefef">Register Date<br /></td>
          <td bgcolor="#efefef"><input id="TFCMerchantRegisterDate" name="TFCMerchantRegisterDate" type=" " size="7" maxlength="18"  value="<? if(empty($row['TFCMerchantRegisterDate']))echo date("Y-m-d");else echo $row['TFCMerchantRegisterDate'];?>" readonly="readonly">
            *yyyy-mm-dd</td>
        </tr>
        <tr  bgcolor="#efefef">
          <td bgcolor="#C6E7FF">Merchant Name </td>
          <td bgcolor="#C6E7FF"><input name="TFCMerchantName" type="text" id="TFCMerchantName" value="<?=$row['TFCMerchantName'];?>" size="35" autocomplete="off" /></td>
          <td nowrap="nowrap" bgcolor="#ffffff"> Valid Date <span class="red">*</span></td>
          <td bgcolor="#ffffff"><input <? echo ' disabled="disabled" '; ?> name="TFCMerchantValidDateBegin" type="text" id="TFCMerchantValidDateBegin" value="<?=$row['TFCMerchantValidDateBegin'];?>" size="7" maxlength="12" />
            thru 
              <input <? echo ' disabled="disabled" '; ?> name="TFCMerchantValidDateEnd" type="text" id="TFCMerchantValidDateEnd" value="<?=$row['TFCMerchantValidDateEnd'];?>" size="7" maxlength="12" /></td>
        </tr>
        
        <tr bgcolor="#FFFFFF">
          <td valign="middle" nowrap="nowrap" bgcolor="#E8FFD9">Merchant Logo</td>
          <td valign="top" bgcolor="#E8FFD9"><input type="file" name="uploadMerchantLogo" id="uploadMerchantLogo" /><?=$row['TFCMerchantLogo'];?></td>
          <td valign="middle" bgcolor="#FFFFCC">Merchant Status <span class="red">*</span></td>
          <td bgcolor="#FFFFCC"><span class="red size16"><?=$row['TFCMerchantStatus'];?> </span>   =&gt;
            <select name="TFCMerchantStatus" id="TFCMerchantStatus" <?//=$disableGroup;?> >
           	  <? if(empty($row['ID'])){ ?>
              <option value="REGISTER" selected="selected" >REGISTER</option>
              <? }else{ ?>  
              <option value="REGISTER" 	<? if($row['TFCMerchantStatus']=="REGISTER") echo 'selected="selected"';?> >REGISTER</option>
              <option value="PAID" 		<? if($row['TFCMerchantStatus']=="PAID") 	 echo 'selected="selected"';?> >PAID</option> 
              <option value="VALID" 	<? if($row['TFCMerchantStatus']=="VALID") 	 echo 'selected="selected"';?> >VALID</option>
              <option value="EXPIRED" 	<? if($row['TFCMerchantStatus']=="EXPIRED")  echo 'selected="selected"';?> >EXPIRED</option>
              <? } ?>
            </select> </td>
        </tr>
        <tr bgcolor="#efefef">
          <td bgcolor="#E8FFD9">Merchant Photo </td>
          <td bgcolor="#E8FFD9"><input type="file" name="uploadMerchantPhoto" id="uploadMerchantPhoto" /><?=$row['TFCMerchantPhoto'];?></td>
          <td bgcolor="#ffffff">Accepted Cards</td>
          <td bgcolor="#ffffff"><?
			$tbl = "md_tfc_card";
			$slc_key = "TFCMerchantAcceptCardID";
			$rowData = $this->allmodel->getTableWhere($tbl);
		  	?>
            <select name="<?=$slc_key;?>" id="<?=$slc_key;?>" <?//=$disableGroup;?> >
              <option value="-1"></option>
              <? foreach($rowData as $rowRes){  ?>
              <option value="<?=$rowRes['id'];?>" <? if($row[$slc_key]==$rowRes['id']) echo 'selected="selected"';?> >
              <?=$rowRes['name']; ?>
              </option>
              <? } ?>
            </select></td>
        </tr> <tr valign="top" bgcolor="#efefef">
          <td colspan="4" valign="middle" nowrap="nowrap" bgcolor="#efefef"><span class="red"><em> </em></span></td>
          </tr>
        <tr valign="top" bgcolor="#efefef">
          <td colspan="4" bgcolor="#CCCCCC"><em>PRODUCTS/SERVICES</em></td>
        </tr>
        <tr valign="top" bgcolor="#efefef">
          <td valign="middle" nowrap="nowrap" bgcolor="#efefef"> Category</td>
          <td valign="middle" bgcolor="#efefef">
            <?
			$tbl = "md_merchant_category";
			$slc_key = "TFCMerchantCategoryID";
			$rowData = $this->allmodel->getTableWhere($tbl);
		  	?>
            <select name="<?=$slc_key;?>" id="<?=$slc_key;?>" <?//=$disableGroup;?> >
              <option value="-1"></option>
              <? foreach($rowData as $rowRes){  ?>
              <option value="<?=$rowRes['id'];?>" <? if($row[$slc_key]==$rowRes['id']) echo 'selected="selected"';?> >
              <?=$rowRes['name']; ?>
              </option>
              <? } ?>
            </select></td>
          <td valign="middle" bgcolor="#efefef">Value-Type</td>
          <td valign="middle" bgcolor="#efefef"><?
			$tbl = "md_merchant_type";
			$slc_key = "TFCMerchantTypeID";
			$rowData = $this->allmodel->getTableWhere($tbl);
		  	?>
              <select name="<?=$slc_key;?>" id="<?=$slc_key;?>" <?//=$disableGroup;?> >
                <option value="-1"></option>
                <? foreach($rowData as $rowRes){  ?>
                <option value="<?=$rowRes['id'];?>" <? if($row[$slc_key]==$rowRes['id']) echo 'selected="selected"';?> ><?=$rowRes['name'];?></option>
                <? } ?>
              </select></td>
        </tr>
        <tr valign="top">
          <td nowrap="nowrap" bgcolor="#ffffff"> Products /<br />
            Fasilities</td>
          <td colspan="3" bgcolor="#ffffff"> 
          <table width="100%" border="0" cellpadding="3" cellspacing="0">
            <? 
			$n = 0;
			foreach ($rowProduct as $key => $RowP) {  //echo "<br>$key => $RowP"; ?> 
            <tr>
              <td align="right" nowrap="nowrap"><?=$n+1;?>.</td>
              <td><input name="product_name[<?=$RowP['id'];?>]" type="text" id="product_name[<?=$RowP['id'];?>]" value="<?=$RowP['product_name'];?>" size="19" maxlength="32"  autocomplete="off"/></td>
              <td></td>
              <td nowrap="nowrap">Value:</td>
              <td><input name="product_value[<?=$RowP['id'];?>]" type="text" id="product_value[<?=$RowP['id'];?>]" value="<?=$RowP['product_value'];?>" size="1" maxlength="4"  autocomplete="off"/></td>
              <td nowrap="nowrap">/</td>
              <td nowrap="nowrap"> 
              <select name="product_periode[<?=$RowP['id'];?>]" id="product_periode[<?=$RowP['id'];?>]" <?//=$disableGroup;?> >
                <option value="-1"></option>
                <option value="dy" <? if($RowP['product_periode']=="dy") echo 'selected="selected"'?> >day</option>
                <option value="mo" <? if($RowP['product_periode']=="mo") echo 'selected="selected"'?> >month</option>
                <option value="yr" <? if($RowP['product_periode']=="yr") echo 'selected="selected"'?> >year</option> 
              </select></td>
              <td nowrap="nowrap">=&gt;</td>
              <td nowrap="nowrap">Amount-Value: Rp.<span class="red">*</span>
                <input name="product_credit[<?=$RowP['id'];?>]" type="text" id="product_credit[<?=$RowP['id'];?>]" value="<?=$RowP['product_credit'];?>" size="12" maxlength="12"  autocomplete="off"/>
                </td>
              <td></td>
              <td>Term</td>
              <td><input name="product_term[<?=$RowP['id'];?>]" type="text" id="product_term[<?=$RowP['id'];?>]" value="<?=$RowP['product_term'];?>" size="25" maxlength="64"  autocomplete="off"/></td>
            </tr> 
           <? $n++;
		   } ?> 
           </table> 
            <div id="add_product_<?=$n?>"> 
              <table width="100%" border="0" cellpadding="3" cellspacing="0">
                <tr>
                  <td width="20"></td>
                  <td colspan="7"><input class="bt_formreg" onclick="merchant_add_product(<?=$n?>,'add_product_<?=$n?>')" name="add_product" id="add_product" value="add" type="button" />                   </td>
                </tr>
              </table>   
            </div>
            <span class="red">* amount-value  don't use any chars , or . </span>            </td>
          </tr>
        <tr valign="top">
          <td bgcolor="#efefef">Open Time</td>
          <td bgcolor="#efefef"><textarea name="TFCMerchantOpen" cols="32" rows="3" autocomplete="off"><?=$row['TFCMerchantOpen'];?></textarea></td>
          <td colspan="2" bgcolor="#efefef"><em>example:</em><br />
            Senin-Jumat: 09.00 - 21.00
            <br />
            Sabtu-Minggu:09.00 - 17.00
            <br />
            Hari raya tetap buka seperti biasa.</td>
          </tr>
        <tr valign="top">
          <td colspan="4" bgcolor="#CCCCCC"><em> CONTACT/LOCATION</em></td>
        </tr>
        <tr valign="top">
          <td valign="top" bgcolor="#ffffff">Merchant <br />
            Address</td>
          <td valign="top" bgcolor="#ffffff"><textarea name="TFCMerchantAddress" cols="32" rows="4" autocomplete="off"><?=$row['TFCMerchantAddress'];?></textarea>
            <br />
            <br />
            <input name="TFCMerchantLocationID" type="" id="TFCMerchantLocationID" value="<?=$row['TFCMerchantLocationID'];?>" size="3" /></td>
          <td colspan="2" valign="middle" bgcolor="#ffffff"><table border="0" cellpadding="2" cellspacing="1" > 
					<input name="TABLE" type="hidden" id="TABLE" value="<?=$TABLE;?>" />  
					<input name="ci_func" type="hidden" id="ci_func" value="<?=$ci_func;?>" />
                
         
            	<tr >
                  <td>Negara</td>
                  <td colspan="2" nowrap="nowrap"><div id="listloc02" class="float_l" style="width:100%;display:block;"><?=$coun_idx2;?></div></td> 
                </tr> 
                <tr >
                  <td>Provinsi</td>
                  <td colspan="2" nowrap="nowrap"><div id="listloc12" class="float_l" style="width:100%;"><?=$prov_idx2;?></div></td> 
                </tr> 
                <tr >
                  <td nowrap="nowrap">Kabupaten/Kota &nbsp;</td>
                  <td colspan="2" nowrap="nowrap"><div id="listloc22" class="float_l" style="width:100%;"><?=$city_idx2;?></div></td> 
                </tr> 
                <tr >
                  <td>Kecamatan</td>
                  <td colspan="2" nowrap="nowrap"><div id="listloc32" class="float_l" style="width:100%;"><?=$area_idx2;?></div></td> 
                </tr> 
                <tr >
                  <td>Kelurahan</td>
                  <td colspan="2"  nowrap="nowrap"><div id="listloc42" class="float_l" style="width:100%;"><?=$venu_idx2;?></div></td>
                 </tr>
                <tr >
                  <td valign="middle">Postcode</td>
                  <td  nowrap="nowrap"><input name="TFCMerchantPostCode" type="text" id="TFCMerchantPostCode" value="<?=$row['TFCMerchantPostCode'];?>" size="5" autocomplete="off" /></td>
                  <td  nowrap="nowrap"> &nbsp; - &nbsp; INDONESIA</td>
                </tr>  
                </table></td>
          </tr>
        <tr valign="top">
          <td valign="middle" bgcolor="#efefef"> Merchant Phone</td>
          <td valign="middle" bgcolor="#efefef"><input name="TFCMerchantPhone" type="text" id="TFCMerchantPhone" value="<?=$row['TFCMerchantPhone'];?>" size="35" autocomplete="off" /></td>
          <td valign="middle" bgcolor="#efefef">Merchant Email</td>
          <td valign="middle" bgcolor="#efefef"><input name="TFCMerchantEmail" type="text" id="TFCMerchantEmail" value="<?=$row['TFCMerchantEmail'];?>" size="35" autocomplete="off" /></td>
        </tr>
        <tr valign="top">
          <td valign="middle" bgcolor="#ffffff">Merchant Fax</td>
          <td valign="middle" bgcolor="#ffffff"><input name="TFCMerchantFax" type="text" id="TFCMerchantFax" value="<?=$row['TFCMerchantFax'];?>" size="35" autocomplete="off" /></td>
          <td valign="middle" bgcolor="#ffffff"> Merchant Website</td>
          <td valign="middle" bgcolor="#ffffff"><input name="TFCMerchantWebsite" type="text" id="TFCMerchantWebsite" value="<?=$row['TFCMerchantWebsite'];?>" size="35" autocomplete="off" />            </td>
        </tr>
        
        
        
        <tr valign="top" bgcolor="#efefef">
          <td colspan="4" bgcolor="#CCCCCC"><em>MERCHANT SOCIAL MEDIA</em></td>
          </tr>
        <tr >
          <td valign="top">Contact &amp; <br />
            Social
            Media</td>
          <td valign="top"><label></label>
            <em>Contact Online :</em><br />
            <table border="0" cellpadding="4" cellspacing="0">
              <tr>
                <td colspan="2"></td>
              </tr>
              <?
				$tbl = "md_contact_media";
				$slc_key = "TFCMerchantContactMediaID"; // array
				
				$rowData = $this->allmodel->getTableWhere($tbl);
 
				$arrContactMediaID   = explode(",",$row['TFCMerchantContactMediaID']);
				$arrContactMediaData = explode(",",$row['TFCMerchantContactMediaData']);
				
				foreach($rowData as $rowRes){  
					$Chkstr = ''; $ChkVal = '';
					foreach($arrContactMediaID as $keyChk => $valChk){ 
						if($rowRes['id']==$valChk){
							//echo "<br>".$rowRes['id']." -- $keyChk => $valChk";
							//echo "<br>".$rowRes['name'];
							$Chkstr = 'checked="checked"';
							$ChkVal = $arrContactMediaData[$keyChk];
						}else{
						
						//$Chkstr = ''; $ChkVal = '';
						}
						
					}
		  	  ?>
              <tr>
                <td><input name="TFCMerchantContactMediaID[<?=$rowRes['id'];?>]" type="checkbox" id="TFCMerchantContactMediaID[<?=$rowRes['id'];?>]" value="1" <?=$Chkstr;?> /> <?=$rowRes['name']?></td>
                <td><input name="TFCMerchantContactMediaData[<?=$rowRes['id'];?>]" id="TFCMerchantContactMediaID[<?=$rowRes['id'];?>]" type="text" value="<?=$ChkVal;?>" size="11" autocomplete="off" /></td>
              </tr>
              <? } ?>
            </table> </td>
          <td colspan="2" valign="top"><em>Social Media Online :</em><br />
              <table border="0" cellpadding="4" cellspacing="0">
                <tr>
                  <td colspan="2"></td>
                </tr>
                <?
				$tbl = "md_social_media";
				$slc_key = "TFCMerchantSocialMediaID"; // array
				
				$rowData = $this->allmodel->getTableWhere($tbl);
 
				$arrSocialMediaID   = explode(",",$row['TFCMerchantSocialMediaID']);
				$arrSocialMediaData = explode(",",$row['TFCMerchantSocialMediaData']);
				
				foreach($rowData as $rowRes){  
					$Chkstr = ''; $ChkVal = '';
					foreach($arrSocialMediaID as $keyChk => $valChk){ 
						if($rowRes['id']==$valChk){ 
							$Chkstr = 'checked="checked"';
							$ChkVal = $arrSocialMediaData[$keyChk];
						}
					}
		  	  ?>
                <tr>
                  <td><input name="TFCMerchantSocialMediaID[<?=$rowRes['id'];?>]" id="TFCMerchantSocialMediaID[<?=$rowRes['id'];?>]" type="checkbox" <?=$Chkstr;?> />
                      <?=$rowRes['name']?>                  </td>
                  <td><input name="TFCMerchantSocialMediaData[<?=$rowRes['id'];?>]" id="TFCMerchantSocialMediaData[<?=$rowRes['id'];?>]" type="text" value="<?=$ChkVal;?>" size="35" autocomplete="off" /></td>
                </tr>
                <? } ?>
            </table></td>
        </tr>
        
        
        <tr valign="top" bgcolor="#efefef">
          <td colspan="4" bgcolor="#CCCCCC"><em> MERCHANT GPS -&gt; GOOGLE-MAP </em></td>
          </tr>
        <tr >
          <td  bgcolor="#efefef">Geo-Coordinate </td>
          <td colspan="3" bgcolor="#efefef"><input name="TFCMerchantMapGeo" id="TFCMerchantMapGeo" type="text" value="<?=$row['TFCMerchantMapGeo'];?>" size="35" autocomplete="off" />
            <em>*google-map standard format</em></td>
          </tr>
        <tr valign="top">
          <td valign="middle">Map-Label</td>
          <td valign="middle"><input name="TFCMerchantMapLabel" type="text" id="TFCMerchantMapLabel" value="<?=$row['TFCMerchantMapLabel'];?>" size="35" autocomplete="off" /></td>
          <td valign="middle">Map-Description</td>
          <td valign="middle"><textarea name="TFCMerchantMapDesc" cols="35" rows="1" id="TFCMerchantMapDesc" autocomplete="off"><?=$row['TFCMerchantMapDesc'];?></textarea></td>
        </tr>
        <tr valign="top">
          <td valign="middle" bgcolor="#E8FFD9">Map-Photo</td>
          <td colspan="3" valign="middle" bgcolor="#E8FFD9"><input type="file" name="uploadMapPhoto" id="uploadMapPhoto" /><?=$row['TFCMerchantMapPhoto'];?></td>
          </tr>
 
        <tr valign="top" bgcolor="#efefef">
          <td colspan="4" bgcolor="#CCCCCC"><em> PIC/OWNER DATA</em></td>
          </tr>
        <tr valign="top">
          <td valign="middle">PIC Position</td>
          <td colspan="3" valign="middle"><div id="slc_position" style="display:inline-block;">
            <?
			$tbl = "md_position";
			$slc_key = "TFCMerchantPIC";
			$rowData = $this->allmodel->getTableWhere($tbl);
		  	?>
            <select name="<?=$slc_key;?>" id="<?=$slc_key;?>" <?//=$disableGroup;?> >
              <option value="-1"></option>
              <? foreach($rowData as $rowRes){  ?>
              <option value="<?=$rowRes['id'];?>" <? if($row[$slc_key]==$rowRes['id']) echo 'selected="selected"';?> >
              <?=$rowRes['name']; ?>
              </option>
              <? } ?>
            </select>
          </div>
               
<input class="bt_formreg" onclick="popupwindow('/master_data/edit_data/0/position/1/2','Add Position',330,205)" name="add_position" id="add_position" value="add" type="hidden" /></td>
          </tr>
        <tr valign="top">
          <td valign="middle" bgcolor="#efefef">Title</td>
          <td valign="middle" bgcolor="#efefef"><?
			$tbl = "md_title";
			$slc_key = "TitleName";
			$rowData = $this->allmodel->getTableWhere($tbl,'',0,1,'id');
		  	
			foreach($rowData as $rowRes){ ?>
            <input name="<?=$slc_key;?>" type="radio" id="<?=$slc_key;?>3" value="<?=$rowRes['id'];?>" <? if($row[$slc_key]==$rowRes['id']) echo 'checked="checked"';?> />
            <?=$rowRes['name'];?>
            .
            <? } ?>            <label></label></td>
          <td valign="middle" bgcolor="#efefef">Marital Status</td>
          <td valign="middle" bgcolor="#efefef"><?
			$tbl = "md_marital_status";
			$slc_key = "MaritalStatusID";
			$rowData = $this->allmodel->getTableWhere($tbl);

		  	?>
            <select name="<?=$slc_key;?>" id="<?=$slc_key;?>" >
              <option value="-1"></option>
              <? foreach($rowData as $rowRes){  ?>
              <option value="<?=$rowRes['id'];?>" <? if($row[$slc_key]==$rowRes['id']) echo 'selected="selected"';?> >
              <?=$rowRes['name']; ?>
              </option>
              <? } ?>
            </select>
            <input class="bt_formreg11" onclick="popupwindow('/master_data/edit_data/0/religion/1/2','Add Religion',330,205)" name="add_religion2" id="add_religion2" value="add" type="hidden" /></td>
        </tr>
        <tr valign="top" bgcolor="#efefef">
          <td valign="middle" bgcolor="#FFFFFF">Name</td>
          <td valign="middle" bgcolor="#FFFFFF"><span class="red">
            <input name="FullName" type="text" value="<?=$row['FullName'];?>" size="35" autocomplete="off" />
          </span></td>
          <td valign="middle" bgcolor="#FFFFFF">Religion</td>
          <td valign="middle" bgcolor="#FFFFFF"><?
			$tbl = "md_religion";
			$slc_key = "ReligionID";
			$rowData = $this->allmodel->getTableWhere($tbl);
		  	?>
              <select name="<?=$slc_key;?>" id="<?=$slc_key;?>" >
                <option value="-1"></option>
                <? foreach($rowData as $rowRes){  ?>
                <option value="<?=$rowRes['id'];?>" <? if($row[$slc_key]==$rowRes['id']) echo 'selected="selected"';?> >
                <?=$rowRes['name']; ?>
                </option>
                <? } ?>
              </select>
              <input class="bt_formreg1" onclick="popupwindow('/master_data/edit_data/0/religion/1/2','Add Religion',330,205)" name="add_religion" id="add_religion" value="add" type="hidden" /></td>
        </tr>
<tr valign="top" bgcolor="#FFFFFF">
          <td valign="middle" bgcolor="#efefef">Phone <span class="red">*</span></td>
          <td valign="middle" bgcolor="#efefef"><input name="Phone" type="text" id="Phone" value="<?=$row['Phone'];?>" size="35" autocomplete="off" /></td>
          <td valign="middle" bgcolor="#efefef">Email <span class="red">*</span></td>
          <td valign="middle" bgcolor="#efefef"><input name="Email" type="text" value="<?=$row['Email'];?>" size="35" autocomplete="off" /></td>
        </tr>
        <tr valign="top">
          <td valign="middle" bgcolor="#FFFFFF">Birth Place, Date <span class="red">*</span></td>
          <td colspan="3" valign="middle" bgcolor="#FFFFFF"><input name="BirthPlace" type="text" id="BirthPlace" value="<?=$row['BirthPlace'];?>" size="16" autocomplete="off" />
,
  <input name="BirthDate" type="text" id="datepicker4" value="<?=$row['BirthDate'];?>" size="8" maxlength="12" />
*yyyy-mm-dd
<? /* <span class="red">Star : Leo</span><span class="red">Shio : Tikus</span> */ ?></td>
          </tr> 
        <tr  bgcolor="#efefef">
          <td valign="top" bgcolor="#efefef">Home Address <span class="red">*</span></td>
          <td valign="top"><textarea name="Address" cols="32" rows="4" autocomplete="off"><?=$row['Address'];?></textarea>
            <br />
            <br />
            <input name="LocationID" type="" id="LocationID" value="<?=$row['LocationID'];?>" size="3" /></td>
          <td colspan="2" valign="top"><table border="0" cellpadding="2" cellspacing="1" >
              <input name="TABLE" type="hidden" id="TABLE" value="<?=$TABLE;?>" />
              <input name="ci_func" type="hidden" id="ci_func" value="<?=$ci_func;?>" />
              <tr >
                <td>Negara</td>
                <td colspan="2" nowrap="nowrap"><div id="listloc0" class="float_l" style="width:100%;display:block;">
                  <?=$coun_idx;?>
                </div></td>
              </tr>
              <tr >
                <td>Provinsi</td>
                <td colspan="2" nowrap="nowrap"><div id="listloc1" class="float_l" style="width:100%;">
                  <?=$prov_idx;?>
                </div></td>
              </tr>
              <tr >
                <td nowrap="nowrap">Kabupaten/Kota &nbsp;</td>
                <td colspan="2" nowrap="nowrap"><div id="listloc2" class="float_l" style="width:100%;">
                  <?=$city_idx;?>
                </div></td>
              </tr>
              <tr >
                <td>Kecamatan</td>
                <td colspan="2" nowrap="nowrap"><div id="listloc3" class="float_l" style="width:100%;">
                  <?=$area_idx;?>
                </div></td>
              </tr>
              <tr >
                <td>Kelurahan</td>
                <td colspan="2"  nowrap="nowrap"><div id="listloc4" class="float_l" style="width:100%;">
                  <?=$venu_idx;?>
                </div></td>
              </tr>
              <tr >
                <td>Kode Pos</td>
                <td  nowrap="nowrap"><input name="PostCode" type="text" id="PostCode" value="<?=$row['PostCode'];?>" size="5" autocomplete="off" /></td>
                <td  nowrap="nowrap"> &nbsp; - &nbsp; INDONESIA</td>
                </tr>
          </table></td>
        </tr>
        
         <tr valign="top" bgcolor="#efefef">
          <td colspan="4" bgcolor="#CCCCCC"><em>PIC/OWNER SOCIAL MEDIA</em></td>
          </tr>
        <tr >
          <td valign="top">Contact &amp; <br />
            Social
            Media</td>
          <td valign="top"><label></label>
            <em>Contact Online :</em><br />
            <table border="0" cellpadding="4" cellspacing="0">
              <tr>
                <td colspan="2"></td>
              </tr>
              <?
				$tbl = "md_contact_media";
				$slc_key = "ContactMediaID"; // array
				
				$rowData = $this->allmodel->getTableWhere($tbl);
 
				$arrContactMediaID   = explode(",",$row['ContactMediaID']);
				$arrContactMediaData = explode(",",$row['ContactMediaData']);
				
				foreach($rowData as $rowRes){  
					$Chkstr = ''; $ChkVal = '';
					foreach($arrContactMediaID as $keyChk => $valChk){ 
						if($rowRes['id']==$valChk){
							//echo "<br>".$rowRes['id']." -- $keyChk => $valChk";
							//echo "<br>".$rowRes['name'];
							$Chkstr = 'checked="checked"';
							$ChkVal = $arrContactMediaData[$keyChk];
						}else{
						
						//$Chkstr = ''; $ChkVal = '';
						}
						
					}
		  	  ?>
              <tr>
                <td><input name="ContactMediaID[<?=$rowRes['id'];?>]" id="ContactMediaID[<?=$rowRes['id'];?>]" type="checkbox" value="1" <?=$Chkstr;?> />
            <?=$rowRes['name']?>                </td>
                <td><input name="ContactMediaData[<?=$rowRes['id'];?>]" id="ContactMediaData[<?=$rowRes['id'];?>]" type="text" value="<?=$ChkVal;?>" size="11" autocomplete="off" /></td>
              </tr>
              <? } ?>
            </table> </td>
          <td colspan="2" valign="top"><em>Social Media Online :</em><br />
              <table border="0" cellpadding="4" cellspacing="0">
                <tr>
                  <td colspan="2"></td>
                </tr>
                <?
				$tbl = "md_social_media";
				$slc_key = "SocialMediaID"; // array
				
				$rowData = $this->allmodel->getTableWhere($tbl);
 
				$arrSocialMediaID   = explode(",",$row['SocialMediaID']);
				$arrSocialMediaData = explode(",",$row['SocialMediaData']);
				
				foreach($rowData as $rowRes){  
					$Chkstr = ''; $ChkVal = '';
					foreach($arrSocialMediaID as $keyChk => $valChk){ 
						if($rowRes['id']==$valChk){ 
							$Chkstr = 'checked="checked"';
							$ChkVal = $arrSocialMediaData[$keyChk];
						}
					}
		  	  ?>
                <tr>
                  <td><input name="SocialMediaID[<?=$rowRes['id'];?>]" id="SocialMediaID[<?=$rowRes['id'];?>]" type="checkbox"  <?=$Chkstr;?> />
                      <?=$rowRes['name']?>                  </td>
                  <td><input name="SocialMediaData[<?=$rowRes['id'];?>]" id="SocialMediaData[<?=$rowRes['id'];?>]" type="text" value="<?=$ChkVal;?>" size="35" autocomplete="off" /></td>
                </tr>
                <? } ?>
            </table></td>
        </tr>
        
        <tr valign="top">
          <td colspan="4" bgcolor="#CCCCCC">&nbsp;</td>
          </tr>
        <tr >
          <td valign="top" bgcolor="#FFFFFF">Comment<br />
            (Kesan/Pesan)</td>
          <td colspan="3" bgcolor="#FFFFFF"><textarea name="CommentText" cols="70" rows="4" id="CommentText" autocomplete="off"><?=$row['CommentText'];?></textarea></td>
        </tr>
        
        <tr bgcolor="#efefef"  align="left">
          <td colspan="4" bgcolor="#FFFFFF"><span class="red">*) must be filled out before submitting the form</span></td>
        </tr>
      </table> 
 

	 
           
            <table width="100%" border="0" cellpadding="8" cellspacing="0" bgcolor="#999">
              <tr align="right" >
                <td height=" " align="left"  class="red tahoma10"><? /**Edit Previlegs changeable by &quot;Admin/Super User &quot;. */ ?></td>
                <td ><? if($row['StatusID']==2){ ?>
                  User Status :
                  <select name="StatusIDChg2" id="StatusIDChg2">
                      <option value="1">REACTIVATE USER</option>
                      <option value="2" selected="selected">KEEP DELETED</option>
                    </select>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;
                  <? } ?>
                  <input type="submit" name="Submit" value="Submit" style="cursor:pointer" />
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
              </tr>
      </table>            
       </form> 
           
           <? } // end else if ID==0 ?>
           
           
           
           
           
           
           
       
       	  <? if(!empty($menuAccessUsr)){ ?> 
          
      <form id="form2" action="<?=base_url()?>user_manage/qedit_usr" method="post"  onsubmit="return validateFormAccess('form2')" >
      
	  	  <input type="hidden" name="ID" id="ID" value="<?=$row['ID'];?>"> 
          <input type="hidden" name="curGroupID" id="curGroupID" value="<?=$row['GroupID'];?>">
          <input type="hidden" name="chgGroupID" id="chgGroupID" value="<?=$row['GroupID'];?>">
     
	  <table width="100%" border="0" cellpadding="8" cellspacing="0" bgcolor="#FFFFFF">
        <tr bgcolor="#CCCCCC">
          <td colspan="2"><strong> Edit Member Privileges</strong> &nbsp; | &nbsp; Group : <strong><?=$row['group'];?></strong></td>
        </tr>
        <tr bgcolor="#5A91B1">
          <td>Menu</td>
          <td> &nbsp;Access </td>
        </tr> 
		<?=$menuAccessUsr;?>  
        <tr bgcolor="#999999">
          <td></td>
          <td align="right"> <input type="submit" name="SubmitAccess" value="Update Privileges" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr> 
      </table>             
               
       </form> 
      
	  <? } //else echo '<br><div class="white pad5">=> To Edit <strong>User Privileges</strong>, Select "Group" than enter Submit.</div>'; ?>
 
       
       
      </td>
         </tr>
           
            
            
            
            
       </table>
			
			<br /><br />
			
			
   	 	</div>  
 
	</div> 
</div> 
<? require_once('include/bottom.php'); ?>
 