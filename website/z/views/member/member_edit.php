<? require_once('include/top.php'); ?>

<link rel="stylesheet" href="/asset/css/jquery-ui-1.9.2.css" />    
<script type="text/javascript" language="javascript" src="/asset/js/jquery-ui-1.9.2.js"></script> 
<? if($row['TFCStatus']!="PRINTCARD"&&$row['TFCStatus']!="VALID"&&$row['TFCStatus']!="EXPIRED") { ?>
<script> $(function() { $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' }); }); </script>
<? } ?>
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
<?
if(empty($row['GroupID'])) $row['GroupID'] = $this->session->userdata('GroupID');
?> 
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
           <form id="form" action="<?=base_url()?>member_manage/qedit_usr" method="post"  onsubmit="return validateFormUser('form')" >
      <table width="100%" border="0" cellpadding="8" cellspacing="1" bgcolor="#FFFFFF">
           
           
        <tr bgcolor="#CCCCCC">
          <td colspan="2" nowrap bgcolor="#CCCCCC"><input name="ID" type="hidden" value="<?=$row['ID'];?>"><input name="StatusID" type="hidden" value="<?=$row['StatusID'];?>">
          <strong>MEMBER   TFC</strong> : <span class="red">EDIT PROFILE<? //if($edit=='add') echo ' - New User Created';?></span></td>
          <td colspan="2" bgcolor="#CCCCCC">ID :
            <?=$row['ID'];?>
            <? /*
          <select name="AccessType" <? if($this->session->userdata('ID')!=1 && $this->session->userdata('ID')!=2 && !$isAdmin) echo "disabled";?> >
            <option value="admin" <? if($row['AccessType']=="admin") echo "selected";?>>Admin -> Full Access</option> 
            <option value="user" <? if($row['AccessType']=="user") echo "selected";?>>User -> Limited Access</option>
          </select>
          */ ?>
            <input id="AccessType" name="AccessType" type="hidden" value="user">          </td>
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
			//foreach($rowgrp as $rowgrp) foreach($rowgrp as $key => $value) echo "<br>$key => $value"; 
			//echo $row['GroupID']; exit;
		  	
			
			?>
            	<select name="GroupID" id="GroupID" <?=$disableGroup;?> onchange="get_branch_data( $('select#GroupID').val() )" >
                <option value="-1"></option>
                <? foreach($rowgrp as $rowgrp){  ?>
                <option value="<?=$rowgrp['id'];?>" <? if(trim($row['GroupID'])==trim($rowgrp['id'])){ echo 'selected="selected"'; $GroupName=$rowgrp['group']; $GroupDesc=$rowgrp['description']; }?> ><?=$rowgrp['group']; ?></option>
                <? } ?>
			</select></td>
          <td bgcolor="#FFB3B3">Card Type </td>
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
        <tr  bgcolor="#FFFFFF">
          <td rowspan="2" bgcolor="#C6E7FF">TFC Branch</td>
          <td rowspan="2" bgcolor="#C6E7FF"> 
          <div id="branch_data">
          <div class="size20 bold "><?=$GroupName;?></div>
          <div style="padding:3px 0; "></div><?=$GroupDesc;?>
          </div> </td>
          <td width="120" nowrap bgcolor="#efefef">Account Executive<br /></td>
          <td bgcolor="#efefef">
          
<input name="TFCOfficerName" type="text" value="<?=$row['TFCOfficerName'];?>" size="35" autocomplete="off" /></td>
          </tr>
        <tr  bgcolor="#efefef">
          <td nowrap="nowrap" bgcolor="#ffffff">Register Date <span class="red">*</span></td>
          <td bgcolor="#ffffff"> 
          <?
		  	$readonly = 'readonly="readonly"';
		  	$disabled = 'disabled="disabled"';
			//echo $row['GroupID'];
			//echo $this->session->userdata('GroupID');
			
			if( $row['GroupID']=='1' || $row['GroupID']=='561' || $row['GroupID']=='431' || $row['GroupID']=='411' ) { $readonly = ''; $disabled = ''; } 
		    if($row['TFCStatus']=="PRINTCARD"||$row['TFCStatus']=="VALID"||$row['TFCStatus']=="EXPIRED") $readonly = 'readonly="readonly"'; 
		  ?>
            <input size="7"  id="datepicker" name="TFCRegisterDate" type=" " value="<? if(empty($row['TFCRegisterDate']))echo date("Y-m-d");else echo $row['TFCRegisterDate'];?>" <?=$readonly?>>
            *yyyy-mm-dd</td>
        </tr>
        <tr  bgcolor="#efefef">
          <td  nowrap bgcolor="#FFFFCC">Card Number <span class="red">*</span></td>
          <td bgcolor="#FFFFCC" ><input  <? echo ' disabled="disabled" '; ?> name="TFCNumber" type="text" value="<?=$row['TFCNumber'];?>" size="20" autocomplete="off" /></td>
          <td nowrap="nowrap" bordercolor="#F0F0F0" bgcolor="#FFFFCC">Card Valid Date <span class="red">*</span></td>
          <td bordercolor="#F0F0F0" bgcolor="#FFFFCC"><input <?=$disabled;?> name="TFCValidDateBegin" type="text" id="datepicker2" value="<?=$row['TFCValidDateBegin'];?>" size="7" maxlength="12" />
            thru 
              <input <?=$disabled;?> name="TFCValidDateEnd" type="text" id="datepicker3" value="<?=$row['TFCValidDateEnd'];?>" size="7" maxlength="12" /></td>
        </tr>
        <tr  bgcolor="#FFFFFF">
          <td nowrap="nowrap" bgcolor="#FFFFCC">Card Serial Num <span class="red">*</span></td>
          <td bgcolor="#FFFFCC"><input <? echo ' disabled="disabled" ';  ?> name="TFCSerialNumber" type="text" value="<?=$row['TFCSerialNumber'];?>" size="20" autocomplete="off" /></td>
          <td nowrap="nowrap" bgcolor="#FFFFCC">Member Status <span class="red">*</span></td>
          <td nowrap="nowrap" bgcolor="#FFFFCC">
          <? if(empty($row['ID'])) $row['TFCStatus']="REGISTER"; ?>
          <span class="red size16"><?=$row['TFCStatus'];?></span> 
          <? 
		  
		  /*
           =&gt;
            <select name="TFCStatus" id="TFCStatus" >
              <? if(empty($row['ID'])){ ?>
              <option value="REGISTER" selected="selected" >REGISTER</option>
              		<? if($row['GroupID']=='1' || $row['GroupID']=='561' || $row['GroupID']=='431' || $row['GroupID']=='411'){ ?>
                    
              		<option value="PAID" 		<? if($row['TFCStatus']=="PAID") 	 echo 'selected="selected"';?> >PAID</option>
                    
                    <? } ?>
              
              <? }else{ ?>
              <option value="REGISTER" 	<? if($row['TFCStatus']=="REGISTER") echo 'selected="selected"';?> >REGISTER</option>
              <? /*
              <option value="PAID" 		<? if($row['TFCStatus']=="PAID") 	 echo 'selected="selected"';?> >PAID</option>
			  <option value="VALID" 	<? if($row['TFCStatus']=="VALID")  	 echo 'selected="selected"';?> >VALID</option>
              <option value="EXPIRED"  	<? if($row['TFCStatus']=="EXPIRED")  echo 'selected="selected"';?> >EXPIRED</option>
              */ 
			  /*
			  ?>
              <? } ?>
            </select>
            */ ?>
            </td>
        </tr>
        <tr  bgcolor="#efefef">
          <td>Title</td>
          <td><?
			$tbl = "md_title";
			$slc_key = "TitleName";
			$rowData = $this->allmodel->getTableWhere($tbl,'',0,1,'id');
		  	
			foreach($rowData as $rowRes){ ?>
            <input name="<?=$slc_key;?>" type="radio" id="<?=$slc_key;?>4" value="<?=$rowRes['id'];?>" <? if($row[$slc_key]==$rowRes['id']) echo 'checked="checked"';?> />
            <?=$rowRes['name'];?>
            .
            <? } ?>
            <span class="red" id="strGender"></span></td>
          <td nowrap="nowrap">Agency</td>
          <td><div id="slc_agent" style=" display:inline-block;">
 			<?
			$tbl = "md_agent";
			$slc_key = "TFCAgentID";
			$rowData = $this->allmodel->getTableWhere($tbl);
		  	?>
            <select name="<?=$slc_key;?>" id="<?=$slc_key;?>" <?//=$disableGroup;?> >
              <option value="-1"></option>
              <? foreach($rowData as $rowRes){  ?>
              <option value="<?=$rowRes['id'];?>" <? if($row[$slc_key]==$rowRes['id']) echo 'selected="selected"';?> >
              <?=$rowRes['Nama']; ?>
              </option>
              <? } ?>
            </select>
            </div>
            <input class="bt_formreg" onclick="popupwindow('/master_data/edit_data/0/agent/1/2','Add Agent',330,345)" name="add_agent" id="add_agent" value="add" type="button" /></td>
        </tr>
        <?  /*
        <tr >
          <td valign="middle" bgcolor="#999999">PIN / Password</td>
          <td colspan="3" bgcolor="#999999">123456 
            <input name="chgPassword" type="button" id="chgPassword" value="Change Password"  onclick="popupwindow('/member_manage/chgpwd/<?=$row['StatusID']?>/<?=$row['ID']?>', 'Member Change Password', 320, 280)" style="cursor:pointer" /></td>
          </tr>
         */ ?>   
        <tr  bgcolor="#efefef">
          <td bgcolor="#ffffff">Name (fullname)</td>
          <td bgcolor="#ffffff"><input name="FullName" type="text" id="FullName" value="<?=$row['FullName'];?>" size="35" autocomplete="off" <? if($row['TFCStatus']=="PRINTCARD"||$row['TFCStatus']=="VALID"||$row['TFCStatus']=="EXPIRED") echo 'readonly="readonly"' ;?>/></td>
          <td bgcolor="#ffffff">No. Polisi Mobil <span class="red"></span></td>
          <td bgcolor="#ffffff"><input name="TFCNoPolisi" type="text" value="<?=$row['TFCNoPolisi'];?>" size="9" autocomplete="off" <? if($row['TFCStatus']=="PRINTCARD"||$row['TFCStatus']=="VALID"||$row['TFCStatus']=="EXPIRED") echo 'readonly="readonly"' ;?>/></td>
        </tr>
        <tr  bgcolor="#efefef">
          <td colspan="4" bgcolor="#CCCCCC"><span class="red"><em>*) setting this on menu member validation</em>
          
          <? if( $row['GroupID']=='1' || $row['GroupID']=='561' || $row['GroupID']=='431' || $row['GroupID']=='411' ) {  ?>
		  		<br /><br /> &nbsp;  &nbsp; UTK TRIBUN => PONTIANAK, MAKASAR DAN MANADO  
                <br /> &nbsp;  &nbsp; Pengisian untuk Member Existing (migrasi kartu existing), silahkan isikan :  <strong>Register Date</strong>, <strong>Card Valid Date</strong> dan <strong>Member Status = "PAID"</strong>.
				<br /> &nbsp;  &nbsp; Untuk <strong>Card Number</strong> dan <strong>Card Serial Num</strong> akan dinput oleh admin Pusat. Sehingga nomor kartu existing akan berubah juga nantinya.    
                 
		  <? } ?>
          
          </span></td>
          </tr>
        <tr  bgcolor="#efefef">
          <td valign="top">Home Address <span class="red"></span></td>
          <td valign="top"><textarea name="Address" cols="32" rows="4" autocomplete="off"><?=$row['Address'];?></textarea></td>
          <td colspan="2" valign="top"><table border="0" cellpadding="2" cellspacing="1" > 
					<input name="TABLE" type="hidden" id="TABLE" value="<?=$TABLE;?>" />  
					<input name="ci_func" type="hidden" id="ci_func" value="<?=$ci_func;?>" />
                
         
            	<tr >
                  <td>Negara</td>
                  <td nowrap="nowrap"><div id="listloc0" class="float_l" style="width:100%;display:block;"><?=$coun_idx;?></div></td> 
                </tr> 
                <tr >
                  <td>Provinsi</td>
                  <td nowrap="nowrap"><div id="listloc1" class="float_l" style="width:100%;"><?=$prov_idx;?></div></td> 
                </tr> 
                <tr >
                  <td nowrap="nowrap">Kabupaten/Kota &nbsp;</td>
                  <td nowrap="nowrap"><div id="listloc2" class="float_l" style="width:100%;"><?=$city_idx;?></div></td> 
                </tr> 
                <tr >
                  <td>Kecamatan</td>
                  <td nowrap="nowrap"><div id="listloc3" class="float_l" style="width:100%;"><?=$area_idx;?></div></td> 
                </tr> 
                <tr >
                  <td>Kelurahan</td>
                  <td  nowrap="nowrap"><div id="listloc4" class="float_l" style="width:100%;"><?=$venu_idx;?></div></td>
                 </tr>
                <tr >
                  <td>Kode Pos</td>
                  <td  nowrap="nowrap"><input name="PostCode" type="text" id="PostCode" value="<?=$row['PostCode'];?>" size="5" autocomplete="off" /></td>
                </tr>
                <tr >
                  <td>INDONESIA</td>
                  <td align="right" valign="middle"  nowrap="nowrap"><input name="LocationID" type="hidden" id="LocationID" value="<?=$row['LocationID'];?>" size="3" /></td>
                </tr> 
                  
	    				 
              
     
                </table>			</td>
          </tr>
        <tr >
          <td>Phone <span class="red"></span></td>
          <td colspan="3"><input name="Phone" type="text" id="Phone" value="<?=$row['Phone'];?>" size="35" autocomplete="off" /></td>
          </tr>
        <tr >
          <td bgcolor="#efefef">Email <span class="red"></span></td>
          <td colspan="3" bgcolor="#efefef"><input name="Email" type="text" value="<?=$row['Email'];?>" size="35" autocomplete="off" /></td>
          </tr>
        <tr >
          <td colspan="4" bgcolor="#CCCCCC">&nbsp;</td>
          </tr>
        <tr >
          <td bgcolor="#ffffff">Occupation</td>
          <td colspan="3" bgcolor="#ffffff">
          
          <div id="slc_occupation" style=" display:inline-block;">
              <?php
			$tbl = "md_occupation";
			$slc_key = "OccupationID";
			$rowData = $this->allmodel->getTableWhere($tbl);
		  	?>
              <select name="<?=$slc_key;?>" id="<?=$slc_key;?>" <?//=$disableGroup;?>>
            	<option value="-1"></option> 
                <? foreach($rowData as $rowRes){  ?>
                <option value="<?=$rowRes['id'];?>" <? if($row[$slc_key]==$rowRes['id']) echo 'selected="selected"';?> >
                  <?=$rowRes['name']; ?>
                  </option>
                <? } ?>
              </select>
            </div> 
            <input  class="bt_formreg" onclick="popupwindow('/master_data/edit_data/0/occupation/1/2','Add Occupation',330,205)" name="add_occupation" id="add_occupation" value="add" type="hidden" />          </td>
          </tr>
        <tr >
          <td bgcolor="#efefef">Position</td>
          <td colspan="3" bgcolor="#efefef"><div id="slc_position" style=" display:inline-block;">
              <?php
			$tbl = "md_position";
			$slc_key = "PositionID";
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
            <input class="bt_formreg" onclick="popupwindow('/master_data/edit_data/0/position/1/2','Add Position',330,205)" name="add_position" id="add_position" value="add" type="hidden" />          </td>
          </tr>
        <tr >
          <td bgcolor="#ffffff">Education</td>
          <td colspan="3" bgcolor="#ffffff"><div id="slc_education" style=" display:inline-block;">
              <?php
			$tbl = "md_education";
			$slc_key = "EducationID";
			$rowData = $this->allmodel->getTableWhere($tbl);
		  	?>
              <select name="<?=$slc_key;?>" id="<?=$slc_key;?>" <?//=$disableGroup;?>>
                <option value="-1"></option>
                <? foreach($rowData as $rowRes){  ?>
                <option value="<?=$rowRes['id'];?>" <? if($row[$slc_key]==$rowRes['id']) echo 'selected="selected"';?> >
                  <?=$rowRes['name']; ?>
                  </option>
                <? } ?>
              </select>
            </div>
            <input class="bt_formreg" onclick="popupwindow('/master_data/edit_data/0/education/1/2','Add Education',330,205)" name="add_education" id="add_education" value="add" type="hidden" />          </td>
          </tr>
        <tr  bgcolor="#efefef">
          <td valign="top">Work Address</td>
          <td valign="top"><textarea name="WorkAddress" cols="32" rows="4" id="WorkAddress" autocomplete="off"><?=$row['WorkAddress'];?></textarea></td>
          <td colspan="2" valign="top">
          
          	<table border="0" cellpadding="2" cellspacing="1" > 
					<input name="TABLE" type="hidden" id="TABLE" value="<?=$TABLE;?>" />  
					<input name="ci_func" type="hidden" id="ci_func" value="<?=$ci_func;?>" /> 
            	<tr >
                  <td>Negara</td>
                  <td nowrap="nowrap"><div id="listloc02" class="float_l" style="width:100%;display:block;"><?=$coun_idx2;?></div></td> 
                </tr> 
                <tr >
                  <td>Provinsi</td>
                  <td nowrap="nowrap"><div id="listloc12" class="float_l" style="width:100%;"><?=$prov_idx2;?></div></td> 
                </tr> 
                <tr >
                  <td nowrap="nowrap">Kabupaten/Kota &nbsp;</td>
                  <td nowrap="nowrap"><div id="listloc22" class="float_l" style="width:100%;"><?=$city_idx2;?></div></td> 
                </tr> 
                <tr >
                  <td>Kecamatan</td>
                  <td nowrap="nowrap"><div id="listloc32" class="float_l" style="width:100%;"><?=$area_idx2;?></div></td> 
                </tr> 
                <tr >
                  <td>Kelurahan</td>
                  <td  nowrap="nowrap"><div id="listloc42" class="float_l" style="width:100%;"><?=$venu_idx2;?></div></td>
                 </tr>
                <tr >
                  <td valign="middle">Postcode</td>
                  <td  nowrap="nowrap"><input name="WorkPostCode" type="text" id="WorkPostCode" value="<?=$row['WorkPostCode'];?>" size="5" autocomplete="off" /></td>
                </tr>
                <tr >
                  <td valign="middle">INDONESIA</td>
                  <td align="right" valign="middle"  nowrap="nowrap"><input name="WorkLocationID" type="hidden" id="WorkLocationID" value="<?=$row['WorkLocationID'];?>" size="3" /></td>
                </tr>  
                </table>
                
				<br /></td>
          </tr>
        <tr >
          <td bgcolor="#ffffff"> Income</td>
          <td colspan="3" bgcolor="#ffffff"><div id="slc_income" style=" display:inline-block;">
		  <?
			$tbl = "md_income";
			$slc_key = "IncomeID";
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
            <input class="bt_formreg" onclick="popupwindow('/master_data/edit_data/0/income/1/2','Add Income',330,205)" name="add_income" id="add_income" value="add" type="hidden" /></div></td>
          </tr>
        <tr >
          <td colspan="4" bgcolor="#CCCCCC">&nbsp;</td>
          </tr>
        <tr >
          <td bgcolor="#efefef">Birth Place, Date <span class="red"></span></td>
          <td colspan="3" bgcolor="#efefef"><input name="BirthPlace" type="text" id="BirthPlace" value="<?=$row['BirthPlace'];?>" size="16" autocomplete="off" />
            , 
              <input name="BirthDate" type="text" id="datepicker4" value="<?=$row['BirthDate'];?>" size="8" maxlength="12" />
              *yyyy-mm-dd
              <? /* <span class="red">Star : Leo</span><span class="red">Shio : Tikus</span> */ ?></td>
          </tr>
        <tr >
          <td bgcolor="#ffffff">Marital Status</td>
          <td colspan="3" bgcolor="#ffffff"><div id="slc_marital_status" style=" display:inline-block;"><?
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
            <input class="bt_formreg1" onclick="popupwindow('/master_data/edit_data/0/marital_status/1/2','Add Marital Status',330,205)" name="add_marital_status" id="add_marital_status" value="add" type="hidden" /></div></td>
          </tr>
        <tr >
          <td bgcolor="#efefef"> Religion</td>
          <td colspan="3" bgcolor="#efefef"><div id="slc_religion" style=" display:inline-block;"><?
			$tbl = "md_religion";
			$slc_key = "ReligionID";
			$rowData = $this->allmodel->getTableWhere($tbl);
		  	?>
            <select name="<?=$slc_key;?>" id="<?=$slc_key;?>" > 
            	<option value="-1"></option> 
          	  <? foreach($rowData as $rowRes){  ?>   
              <option value="<?=$rowRes['id'];?>" <? if($row[$slc_key]==$rowRes['id']) echo 'selected="selected"';?> ><?=$rowRes['name']; ?></option> 
              <? } ?>   
            </select>
            <input class="bt_formreg" onclick="popupwindow('/master_data/edit_data/0/religion/1/2','Add Religion',330,205)" name="add_religion" id="add_religion" value="add" type="hidden" /></div></td>
          </tr>
        <tr >
          <td valign="top">Contact &amp; <br />
            Social
            Media</td>
          <td valign="top"><label></label>            Contact Online :<br /> 
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
                <td><input name="ContactMediaID[<?=$rowRes['id'];?>]" type="checkbox" id="ContactMediaID[<?=$rowRes['id'];?>]" value="1" <?=$Chkstr;?> />
                  <?=$rowRes['name']?> </td>
                <td><input name="ContactMediaData[<?=$rowRes['id'];?>]" type="text" value="<?=$ChkVal;?>" size="12" autocomplete="off" /></td>
              </tr>
              <? } ?>
            </table>
            <br /></td>
          <td colspan="2" valign="top">Social Media Online :<br /> 
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
                <td><input name="SocialMediaID[<?=$rowRes['id'];?>]" type="checkbox" id="SocialMediaID[<?=$rowRes['id'];?>]" <?=$Chkstr;?> />
                    <?=$rowRes['name']?>                </td>
                <td><input name="SocialMediaData[<?=$rowRes['id'];?>]" type="text" value="<?=$ChkVal;?>" size="32" autocomplete="off" /></td>
              </tr>
              <? } ?>
            </table></td>
          </tr>
        <tr >
          <td valign="top" bgcolor="#efefef"> <br />
            Hobby</td>
          <td valign="top" bgcolor="#efefef"><table border="0" cellpadding="4" cellspacing="0">
              <tr>
                <td colspan="2"></td>
              </tr>
              <?
				$tbl = "md_hobby";
				$slc_key = "HobbyID"; // array
				
				$rowData = $this->allmodel->getTableWhere($tbl); 
				 
				$arrHobbyID   = explode(",",$row['HobbyID']);
				$n = 0;
				foreach($rowData as $rowRes){    
					$Chkstr = ''; 
					foreach($arrHobbyID as $keyChk => $valChk){ 
						if($rowRes['id']==$valChk){ 
							$Chkstr = 'checked="checked"'; 
						}
					}  
				$n++; 
		  	  ?>
			   <tr>
                <td><input name="HobbyID[<?=$rowRes['id'];?>]" type="checkbox" id="HobbyID[<?=$rowRes['id'];?>]" value="1" <?=$Chkstr;?> /> <?=$rowRes['name']?> </td>
              </tr>	
              <? } ?>
 
            </table>
            
            <div id="add_hobby_<?=$n?>"> 
              <table width="100%" border="0" cellpadding="3" cellspacing="0">
                <tr>
                  <td width="20"></td>
                  <td colspan="7"><input class="bt_formreg" onclick="member_add_hobby(<?=$n?>,'add_hobby_<?=$n?>')" name="add_hobby" id="add_hobby" value="add" type="hidden" /></td>
                </tr>
              </table>   
            </div>            </td>
          <td colspan="2" valign="top" bgcolor="#efefef">&nbsp;</td>
          </tr>
        <tr >
          <td valign="top" bgcolor="#FFFFFF"> <br />
            Rubric Favorite</td>
          <td valign="top" bgcolor="#FFFFFF"><table border="0" cellpadding="4" cellspacing="0">
              <tr>
                <td colspan="2"></td>
              </tr>
              
                <?
				$tbl = "md_rubric_favorite";
				$slc_key = "RubricFavoriteID"; // array 
				
				$rowData = $this->allmodel->getTableWhere($tbl); 
				
				
				$arrHobbyID   = explode(",",$row['RubricFavoriteID']);
				$n = 0;
				foreach($rowData as $rowRes){    
					$Chkstr = ''; 
					foreach($arrHobbyID as $keyChk => $valChk){ 
						if($rowRes['id']==$valChk){ 
							$Chkstr = 'checked="checked"'; 
						}
					}  
					$n++; 
		  	  ?>
			   <tr>
                <td><input name="RubricFavoriteID[<?=$rowRes['id'];?>]" type="checkbox" id="RubricFavoriteID[<?=$rowRes['id'];?>]" value="1" <?=$Chkstr;?> /> <?=$rowRes['name']?> </td>
              </tr>	
              <? } ?>
 
            </table>
            
            <div id="add_rubric_favorite_<?=$n?>"> 
              <table width="100%" border="0" cellpadding="3" cellspacing="0">
                <tr>
                  <td width="20"></td>
                  <td colspan="7"><input class="bt_formreg" onclick="member_add_rubric_favorite(<?=$n?>,'add_rubric_favorite_<?=$n?>')" name="add_rubric_favorite" id="add_rubric_favorite" value="add" type="hidden" /></td>
                </tr>
              </table>   
            </div>            </td>
          <td colspan="2" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        <? /*
        <tr >
          <td bgcolor="#efefef"> Community</td>
          <td bgcolor="#efefef"><?
			$tbl = "md_community";
			$slc_key = "CommunityID";
			$rowData = $this->allmodel->getTableWhere($tbl);
		  	?>
            <select name="<?=$slc_key;?>" id="<?=$slc_key;?>" <?=$disableGroup;?>> 
              <option value=""></option>  
          	  <? foreach($rowData as $rowRes){  ?>   
              <option value="<?=$rowRes['id'];?>" <? if($row[$slc_key]==$rowRes['id']) echo 'selected="selected"';?> ><?=$rowRes['name']; ?></option> 
              <? } ?>   
            </select></td>
          <td bgcolor="#efefef"><input name="Add4" type="button" id="Add4" value="Add"  onclick="popupwindow('/user_manage/chgpwd/<?=$row['StatusID']?>/<?=$row['ID']?>', 'User Change Password', 320, 280)" /></td>
          <td bgcolor="#efefef">&nbsp;</td>
        </tr>
		*/ ?>
 
        <tr >
          <td colspan="4" bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
        <? /*      
        <tr >
          <td bgcolor="#FFFFFF">Q &amp; A<br />
            (Customer Survey)</td>
          <td colspan="3" bgcolor="#FFFFFF"><table border="0" cellpadding="4" cellspacing="0">
            <tr>
              <td colspan="3"></td>
            </tr>
            <tr>
              <td>1.</td>
              <td>Gadget yg dimiliki <br /></td>
              <td><input name="Phone22" type="text" size="35" autocomplete="off" /></td>
            </tr>
            <tr>
              <td>2.</td>
              <td>Bank prioritas<br /></td>
              <td><input name="Phone22" type="text" size="35" autocomplete="off" /></td>
            </tr>
            <tr>
              <td>3.</td>
              <td>Mall/Supermarket<br /></td>
              <td><input name="Phone22" type="text" size="35" autocomplete="off" /></td>
            </tr>
            <tr>
              <td>4.</td>
              <td>Olah Raga Favorite<br /></td>
              <td><input name="Phone22" type="text" size="35" autocomplete="off" /></td>
            </tr>
            <tr>
              <td>5.</td>
              <td>Langganan Koran <br /></td>
              <td><input name="Phone22" type="text" size="35" autocomplete="off" /></td>
            </tr>
            <tr>
              <td>6.</td>
              <td>Agen yg melayani<br /></td>
              <td><input name="Phone22" type="text" size="35" autocomplete="off" /></td>
            </tr>
          </table></td>
          </tr>
		 */ ?> 
        <tr >
          <td bgcolor="#efefef">Comment<br />
            (Kesan/Pesan)</td>
          <td colspan="3" bgcolor="#efefef"><textarea name="CommentText" cols="70" rows="4" id="CommentText" autocomplete="off"><?=$row['CommentText'];?></textarea></td>
          </tr>
        
        <tr bgcolor="#efefef"  align="left">
          <td colspan="4" bgcolor="#FFFFFF"><span class="red"><? /**) must be filled out before submitting the form */ ?></span></td>
        </tr>
      </table> 
 

	 
           
            <table width="100%" border="0" cellpadding="8" cellspacing="0" bgcolor="#999">
        <tr align="right" >
          <td height=" " align="left"  class="red tahoma10"> 
		  <? /**Edit Previlegs changeable by &quot;Admin/Super User &quot;. 
		  <input name="Cancel" type="button" id="Cancel" style="cursor:pointer" value="Cancel" />
  			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*/ ?></td>
          <td > 
		  <? if($row['StatusID']==2){ ?>User Status : 
		  <select name="StatusIDChg" id="StatusIDChg">
            <option value="1">REACTIVATE USER</option>
            <option value="2" selected>KEEP DELETED</option>
          </select> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<? } ?> 
          	
            <input type="submit" name="Submit" value="Submit" style="cursor:pointer" />
            </td></tr>
      </table>            
       </form> 
       	  <? 
		  
$menuAccessUsr = 0;////--- TEMP
		  
		  if(!empty($menuAccessUsr)){ ?> 
          
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
      
	  <? } else echo '<br><div class="white pad5">=> To Edit <strong>User Privileges</strong>, Select "Group" than enter Submit.</div>'; ?>
 
       
       
      </td>
         </tr>
           
            
            
            
            
       </table>
			
			
			</div>  
 
	</div> 
</div> 
<? require_once('include/bottom.php'); ?>
 