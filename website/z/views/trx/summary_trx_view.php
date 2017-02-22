<? require_once('include/top.php'); ?>
<link rel="stylesheet" href="/asset/css/jquery-ui-1.9.2.css" />    
<script type="text/javascript" language="javascript" src="/asset/js/jquery-ui-1.9.2.js"></script>
<script> $(function() { $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' }); }); </script>
<script> $(function() { $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' }); }); </script>
<style type="text/css">
.style1{color: #003366}
.style3{
	font-weight: bold;
	color: #F60;
}
</style>
<div class="container">
 

	<!-- pageLabel -->
	<div class="lblpage">
    	<div class="float_l tahoma size18"><?=$pageLABEL;?></div>
    	<div class="float_r arial12" style="padding-left:20px; display:inline-block">&nbsp;</div>  
  </div> 
	<!-- /pageLabel -->
    
    <div class="linelbl"></div> 
    
	<!-- pageContent -->    
  	<div id="contMenu"> 
   		<div style="clear:both"></div> 
        
        <form action="/transaction/summary_transaction" method="post">  
        <table cellpadding="5" cellspacing="0">
          <tr>
            <td colspan="4">Select Transaction  by:</td>
          </tr>
          <tr>  
            <td>TFC Branch </td>
            <td width="1">:</td> 
            <td colspan="2" nowrap="nowrap">
			<?
		  		$disableGroup = ' disabled="disabled" ';
				if( $this->session->userdata('ID')==1 ) 	 $disableGroup = '';
				if( $this->session->userdata('ID')==2 ) 	 $disableGroup = ''; 
				if( $this->session->userdata('AccessType')=='admin' && $this->session->userdata('GroupID')==1) $disableGroup = '';
						
				//if( empty($row['GroupID']) && empty($row['ID']) && $this->session->userdata('ID')!=1 && $this->session->userdata('ID')!=2 ){ 
					//$row['GroupID'] = $this->session->userdata('GroupID');
				//}  
				//--- GroupID  000 000 0000
				$grpID = $this->session->userdata('GroupID'); 
				$grp = $grpID; 
				if(strlen(trim($grp))==0) $grp = "000".$grp;
				if(strlen(trim($grp))==1) $grp = "00".$grp;
				if(strlen(trim($grp))==2) $grp = "0".$grp;  
				//echo $grp; 
				
				$viewgrp=1;
				if($this->session->userdata('GroupID')=='1')  $viewgrp=0;
				
				
			?>
              <select name="GroupID" id="GroupID" <?=$disableGroup;?>  >
              	<? if(!$viewgrp){ ?>
                <option value="0">all</option>
                <? } ?> 
                <? foreach($rowgrp as $rowgrp){  ?>
                <option value="<?=$rowgrp['id'];?>" <? if($GroupID==$rowgrp['id']) echo 'selected="selected"'; ?> >
                  <?=$rowgrp['group']; ?>
                </option>
                <? } ?>
              </select>              </td>
          </tr>
          <tr>
            <td>Merchant</td>
            <td>:</td>
            <td colspan="2" nowrap="nowrap"><select name="TFCMerchantID" id="TFCMerchantID">
              <option value="all" <? if($TFCMerchantID=="all") echo 'selected="selected"'; ?>>all</option>
              <? foreach($rowTFCMerchantID as $rowTFCMerchant) 
			  	 if(!empty($rowTFCMerchant['TFCMerchantID'])){
			  	 	if($viewgrp){
						if(substr($rowTFCMerchant['TFCMerchantID'],0,3)==$grp){
						?>
              <option value="<?=$rowTFCMerchant['TFCMerchantID'];?>" <? if($TFCMerchantID==$rowTFCMerchant['TFCMerchantID']) echo 'selected="selected"'; ?> >
              <?=$rowTFCMerchant['TFCMerchantID']." - ".$rowTFCMerchant['TFCMerchantName']; ?>
              </option>
              <? }
					}else{ 
					?>
              <option value="<?=$rowTFCMerchant['TFCMerchantID'];?>" <? if($TFCMerchantID==$rowTFCMerchant['TFCMerchantID']) echo 'selected="selected"'; ?> >
              <?=$rowTFCMerchant['TFCMerchantID']." - ".$rowTFCMerchant['TFCMerchantName']; ?>
              </option>
              <?
					} 
				} 
			?>
            </select> 
              *show merchant on selected TFC-Branch.</td>
          </tr>
          <tr>
            <td>Card Number </td>
            <td>:</td>
            <td nowrap="nowrap">
          	
 
            <select name="TFCNumber" id="TFCNumber" >
              <option value="all" <? if(TFCNumber=="all") echo 'selected="selected"';?>>all</option>
              <? foreach($rowTFCNumber as $rowTFCNum) 
			  	 if(!empty($rowTFCNum['TFCNumber'])){
			  	 	if($viewgrp){
						if(substr($rowTFCNum['TFCNumber'],0,3)==$grp){
						?>
              <option value="<?=$rowTFCNum['TFCNumber'];?>" <? if($TFCNumber==$rowTFCNum['TFCNumber']) echo 'selected="selected"'; ?> >
              <?=$rowTFCNum['TFCNumber']." - ".$rowTFCNum['FullName']; ?>
              </option>
               			<? }
					}else{ 
					?>
              <option value="<?=$rowTFCNum['TFCNumber'];?>" <? if($TFCNumber==$rowTFCNum['TFCNumber']) echo 'selected="selected"'; ?> >
              <?=$rowTFCNum['TFCNumber']." - ".$rowTFCNum['FullName']; ?>
              </option>
					<?
					} 
				} 
			?> 
            </select></td>
            <td nowrap="nowrap"><table border="0" cellpadding="0" cellspacing="0">
              <? if($GroupID>2){ ?>
              <tr>
                <td>-&gt;&nbsp;</td>
                <td nowrap="nowrap">   Trx on merchant : </td>
                <td><input name="trx_merchant_local" type="checkbox" id="trx_merchant_local" value="1" <? if($trx_merchant_local) echo 'checked="checked"'; ?> /></td>
                <td><?=$this->allmodel->getGroupbyID($GroupID);?>. </td>
                <td>&nbsp;</td>
                <td><input name="trx_merchant_national" type="checkbox" id="trx_merchant_national" value="1" <? if($trx_merchant_national) echo 'checked="checked"'; ?> /></td>
                <td>National</td>
              </tr>
              <? } ?>
              
            </table>                </td>
          </tr>
          <tr>
            <td>Date from</td>
            <td>:</td>
            <td colspan="2"><table cellpadding="0" cellspacing="0"> 
          <tr>   
            <td><div class="ibDtPict">
			<input name="dt1" type="text" id="datepicker" value="<?=$dt1?>" maxlength="12">
			&nbsp; to &nbsp; 
			<input name="dt2" type="text" id="datepicker2" value="<?=$dt2?>" maxlength="12">
			</div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
          </tr>
          <tr>
            <td>Settlement</td>
            <td>:</td>
            <td colspan="2"><table width="200" border="0" cellpadding="0" cellspacing="0">
              <tr>  
                <td><input name="set_available" type="checkbox" id="set_available" value="1" <? if($set_available) echo 'checked="checked"'; ?> /></td>
                <td nowrap="nowrap">Available</td>
                <td>&nbsp;</td>
                <td><input name="set_done" type="checkbox" id="set_done" value="1" <? if($set_done) echo 'checked="checked"'; ?> /></td>
                <td>Done</td>
                <td>&nbsp;</td>
                <td><input name="set_notvalid" type="hidden" id="set_notvalid" value="1" <? if($set_notvalid) echo 'checked="checked"'; ?> /></td>
                <td nowrap="nowrap"> </td>
              </tr>
              
            </table></td>
          </tr>
          <tr>
            <td><input name="order" type="hidden" id="order" value="<?=$order;?>" />
            <input name="sort" type="hidden" id="sort" value="<?=$sort;?>" /></td>
            <td>&nbsp;</td>
            <td colspan="2">              <input type="submit" name="button" id="button" value="Submit" />            </td>
          </tr>
        </table>
        
	  </form>
        
   		<div class="pad5"></div> 
    	<div class="linelbl"></div> 
   		<div style="clear:both"></div> 
	  <h2 style="color: #096">Summary Transaction</h2>
    	 
	    <? /*<table border="0" cellpadding="3" cellspacing="0" class="tbldetail">
              <tr>
                <td colspan="7"><span class="style3">Terminal</span></td>
              </tr>
              <tr>
                <td>Owner</td>
                <td>:</td>
                <td nowrap="nowrap"><?=$owner;?></td>
              
                <td width="30" nowrap>&nbsp;</td>
                <td>Address</td>
                <td>:</td>
                <td nowrap="nowrap"><?=$address;?></td>
              </tr>
              <tr>
                <td>Terminal ID</td>
                <td>:</td>
                <td nowrap="nowrap"><?=$terminal;?></td>
                <td>&nbsp;</td>
                <td>Location</td>
                <td>:</td>
                <td nowrap="nowrap"><?=$location;?></td>
              </tr>
              <tr>
                <td>IP Address</td>
                <td>:</td>
                <td nowrap="nowrap"><?=$ip;?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td nowrap="nowrap">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="7" nowrap><strong class="style3">Transaction </strong></td>
              </tr>
              <tr>
                <td nowrap>Date Begin</td>
                <td>:</td>
                <td nowrap="nowrap"><?=$dt1;?> - 00:00 </td>
                <td></td>
                <? if($table_trx=="topup_mandiri"){ ?>
                <td nowrap>Total transaction</td>
                <td>:</td>
                <td><?=$total_item;?> </td>
                <? } else { ?>
                <td nowrap>Total items</td>
                <td>:</td>
                <td><?=$total_item;?> </td>
                <? } ?>
              </tr>
              <tr>
                <td nowrap>Date End</td>
                <td>:</td>
                <td nowrap="nowrap"><?=$dt2;?> - 23.59</td>
                <td></td>
                <td nowrap>Total amount</td>
                <td>:</td>
                <td><?=$total_amount;?></td>
              </tr>
            </table>
	  <div class="pad5"></div>
	    <div style="xborder-bottom:1px solid #aaaaaa"></div>
	    <div class="pad5"></div>
            */ ?>
	     <strong class="style3">Detail transactions</strong>
	  <div style="padding:8px"></div>
	  <table border="0" cellpadding="0" cellspacing="0" bgcolor="#999999">
			<form action="/transaction/summary_transaction" method="post"> 
		 <tr>
		   <td> 
			<table class="tbldetail tdline" width="" border="0" cellpadding="5" cellspacing="1"> 
					  <tr bgcolor="#ADDDA2">
					    <td align="center">No.</td> 
                        <td>Date</td> 
                        <td>Transaction-ID</td>
					    <td>card_number</td>
					    <td>card_serial</td>
					    <td>credit</td>
					    <td>merchant_id</td>
					    <td>merchant_product</td> 
					    <td align="right">amount</td>
					    <td align="center" bgcolor="#FF9966">SETTLEMENT</td>
					    <td align="left">merchant-note</td>
			         </tr> 
                    <? 
					/*
					idxxx
					transaction_typexxx
					transaction_date 	
					transaction_id 	
					card_number 	
					card_serialnumber 	
					member_credit 	
					merchant_id 	
					merchant_product 	
					product_groupxxx
					string_requestccc 	
					status_idccc
					settlement_by 	
					settlement_date 	
					settlement_amount 	
					settlement_status
					*/
					$x=1;
					$col1 = "#ffffff";
					$col2 = "#efefef";
					$total_amount = 0;
					foreach($rowTrx as $row){
						//foreach($rowTrx as $k2 => $v2) echo "<br>$k => $k2 => $v2"; 
						
						$n = fmod($x,2);
						if($n) $clr = $col1;
						else  $clr = $col2;
					?>
					<tr bgcolor="<?=$clr;?>" > 
					  	<td align="right"><?=$x;?>.&nbsp;</td>   
                      	<td><?=$row['transaction_date'];?></td> 
						<td><?=$row['transaction_id'];?></td> 
						<td><?=$row['card_number'];?></td> 
						<td><?=$row['card_serialnumber'];?></td> 
						<td align="center"><?=$row['member_credit'];?></td> 
						<td><?=$row['merchant_id'];?></td> 
						<td><?=$row['product_name'];?></td>   
						<td align="right">
						<?
						//echo $row['product_type']; DISCOUNT  
						if($row['product_type']=="DISCOUNT") 
							 $valAmount = $row['diskon_amount'];
						else $valAmount = $row['product_credit'];
						
						echo $this->allmodel->number_rp($valAmount,0); 
						
						
						$total_amount += $valAmount; 
						
						?>
                        &nbsp;</td> 
						<td align="center"><? if($row['settlement_status']==1) echo "DONE"; else { 
						if($this->session->userdata('AccessType')=='admin' || $this->session->userdata('GroupID')==1){?>
					    <input type="checkbox" name="set_trx_id[<?=$row['id'];?>]" id="set_trx_id[<?=$row['id'];?>]" value="1">
						<? } else echo "-"; } ?></td> 
                        <td align="center"><?=$row['merchant_note']?></td> 
                        
              </tr>
		  		  <? $x++;
                   } ?>
		  			<tr>   
						<td class="tdtotal" colspan="8" align="right">TOTAL :</td>
						<td class="tdtotal" ><?=$this->allmodel->number_rp($total_amount);?></td>   
						<td class="tdtotal" align="center">
						<input name="redir" type="hidden" id="redir" value="<?=$_SERVER['REQUEST_URI'];?>">
						<? if( $this->session->userdata('AccessType')=='admin' || $this->session->userdata('GroupID')==1){ ?> 
						<input name="settlement" type="submit" id="settlement" value="Submit">
						<? } ?></td>
                        <td class="tdtotal" align="center"></td>
		  			</tr> 
		  	</table>           </td>
            
        </tr>
		</form>
       </table>
	    <p></p>
  </div> 
	<!-- /pageContent -->
    
</div> 
<? require_once('include/bottom.php'); ?>