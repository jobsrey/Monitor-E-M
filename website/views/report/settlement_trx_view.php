<? require_once('include/top.php'); ?>
<link rel="stylesheet" href="/asset/css/jquery-ui-1.9.2.css" />    
<script type="text/javascript" language="javascript" src="/asset/js/jquery-ui-1.9.2.js"></script>
<script> $(function() { $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' }); }); </script>
<script> $(function() { $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' }); }); </script>
<script> $(document).ready(function(){ $("#but-filter").click(function(){ $("#form-filter").toggle(); });});</script>
<script> $(document).ready(function(){ $("#but-desc").click(function(){ $("#form-desc").toggle(); });});</script>
<style type="text/css">
.style3{font-weight: bold;color: #F60;}
.lblpage{padding-top:20px;} 
button{font:normal 9px Arial;} 
.tdline thead td{ border-top:0px solid #aaa;}
.tdline tbody td{ border-bottom:0px solid #aaa;}
.ibDtPict input#datepicker,.ibDtPict input#datepicker2, .ibDtPict select{font:normal 13px arial;}
.ibDtPict input#datepicker,.ibDtPict input#datepicker2 {height:18px;width:65px;}
.ibDtPict select{height:20px;}

</style>

<div class="container">

	<!-- pageLabel -->
	<div class="lblpage">
    	<div class="float_l tahoma size15 bold"><?=$pageLABEL;?></div>
    	<div class="float_r arial12" style="padding-left:20px; display:inline-block">&nbsp;</div>  
  	</div> 
	<!-- /pageLabel -->
    
    <div class="linelbl"></div> 
    
	<!-- pageContent -->    
  	<div id="contMenu"> 
   		<div style="clear:both"></div> 
        <button id="but-filter">Show/Hide</button>  
        <div id="form-filter">
            <div class="pad5"></div> 
        <form action="<?=base_url().$ci_ctrl.$callfunc;?>" method="post"> 
        <input type="hidden" name="reportfunc" id="reportfunc" value="<?=$reportfunc;?>"/> 
        <table cellpadding="3">
          <tr>  
            <td>Owner </td>
            <td>:</td> 
            <td width="11"><?=$listmenu_0;?></td>
            <td colspan="2" style="padding-left:8px;">&nbsp; &nbsp;
            <div id="tproductlist" class="float_l">
            	<span>Terminal : </span>	
            	<span id="vmlist"><?=str_replace("all","",$listmenu_1);?></span>
                <? /* 
				<? if($ci_func=="card_transaction"){ ?>
            	<span>&nbsp; &nbsp; Product : </span>	
            	<span id="productlist"><?=$listmenu_2;?></span>
                <? } ?>
                
            	<span>&nbsp; &nbsp; Item : </span>	
            	<span id="productlist"><?=$listmenu_3;?></span> 
                */ ?> 
                <? if($notif_vmselect) echo '<span class="red blink"> <- Please Select Terminal!</span>'; ?>
            </div>            </td> 
          </tr>
          <tr>
            <td>Date Time
              <?
                    $arr_TM = array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23"); 
                    if(!isset($tm1)) $tm1 = "00";
                    if(!isset($tm2)) $tm2 = "23"; 
                    //echo $tm1;
                ?> </td>
            <td>:</td>
            <td colspan="2"><div class="ibDtPict"> 
              <input name="dt1" type="text" id="datepicker" value="<?=$dt1?>" maxlength="12" />
              <select name="tm1" id="tm1">
                <?  
                        foreach($arr_TM as $k => $v){
                            if($tm1==$v.":00") $str_slc1 = 'selected="selected"';
                            else $str_slc1 = ''; 
                            echo "<option $str_slc1>$v:00</option>"; 
                        } 
                    ?>
              </select>
              &nbsp; to &nbsp; 
              <input name="dt2" type="text" id="datepicker2" value="<?=$dt2?>" maxlength="12">
              <select name="tm2" id="tm2">
                <?  
                        foreach($arr_TM as $k => $v){
                            if($tm2==$v.":59") $str_slc2 = 'selected="selected"';
                            else $str_slc2 = ''; 
                            echo "<option $str_slc2>$v:59</option>"; 
                        } 
                    ?>
              </select>
            </div></td>
            <td><input name="sort_date" type="hidden" id="sort_date" value="<?=$sort_date?>"><input type="submit" name="button" id="button" value="Submit" /></td>
          </tr>
        </table> 
              
        </form>
		</div>   
	  <div class="pad5"></div> 
    	<div class="linelbl"></div> 
   		<div style="clear:both"></div> 
        
        
    	<div id="dspdata"> 
      		<?//=$indexData?> 
   		  	<button id="but-desc">Show/Hide</button>
   		  	<h3 style="color: #096"><?=ucwords(str_replace("_"," ",$ci_func));?></h3>
        	<div id="form-desc">
            
            <table border="0" cellpadding="3" cellspacing="0" class="tbldetail">
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
                <td></td>
                <td></td>
                <td nowrap="nowrap"><?//=$product;?></td>
              </tr>
              <tr>
                <td colspan="7" nowrap><strong class="style3">Transaction </strong></td>
              </tr>
              <tr>
                <td nowrap>Date Begin</td>
                <td>:</td>
                <td nowrap="nowrap"><?=$dt1;?> - <?=$tm1;?> </td>
                <td></td>
                <? if($table_trx=="topup_mandiri"){ ?>
                <td nowrap>Transactions</td>
                <td>:</td>
                <td><?=$total_item;?> </td>
                <? } else { ?>
                <td nowrap>Transactions</td>
                <td>:</td>
                <td><?=$total_item;?> </td>
                <? } ?>
              </tr>
              <tr>
                <td nowrap>Date End</td>
                <td>:</td>
                <td nowrap="nowrap"><?=$dt2;?> - <?=$tm2;?></td>
                <td></td>
                <td nowrap>Total amount</td>
                <td>:</td>
                <td><?=$total_amount;?></td>
              </tr>

            </table>
			<div class="pad5"></div> 
			<div style="border-bottom:1px solid #aaaaaa"></div>  
			<div class="pad5"></div>   
            </div>
            
			<strong class="style3">Table Transactions</strong>
		  	<div style="padding:8px"></div> 
          
          <? /*
		  if ($table_trx == 'topup_mandiri') { ?>
          
          <table class="tbldetail2 tdline" width="" border="0" cellpadding="5" cellspacing="0">
		 		<thead>
					  <tr>
					    <td align="center" class="xlightgrey">No.</td>
					    <? if($terminal=="all"){?>
                        <td>Terminal</td>
					    <? } ?>
					    <td>Date Time</td> 
					    <td>Product</td> 
					    <td align="right">Topup-Value</td>
				      </tr>
			  	</thead>
					<tbody>
                    <? 
					$x=1;
					foreach($rowTrx as $row){
						//foreach($rowTrx as $k2 => $v2) echo "<br>$k => $k2 => $v2"; 
			?>
					<tr bgcolor="#ffffff"> 
					  <td align="right"><?=$x;?>.&nbsp;<input name="id" type="hidden" value="1" /></td>
                      	<? if($terminal=="all"){?> 
					    <td><?=$row['terminal_id'];?></td>
					    <? } ?>
						<td><?=$row['date'];?></td> 
						<td>TopUp - Prepaid Card Mandiri<?//=$row['tm'];?></td> 
						<td align="right"><?=number_format($row['value'],0,',','.');?></td>
					  </tr>
		  		  <? $x++;
                   } ?>
		  			<tr>  
						<td class="tdtotal" >&nbsp;</td> 
						<td class="tdtotal" colspan="<? if($terminal=="all") echo "3"; else echo "2";?>" align="right">TOTAL :</td> 
						<td class="tdtotal" align="right"><?=$total_amount;?></td>
		  			</tr>
		  		</tbody>	
	  	  </table>
          
          	<? 
			*/
			
			//if ($table_trx == 'topup_mandiri') { 
			//} else { //-- card transaction 
			 
			?>
            
       	  <table class="tbldetail2 tdline" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">
  
				<thead bgcolor="#efefef">
					<tr >
					    <td rowspan="2" align="center" style="border-bottom:2px solid #006699;color:#999999;">No.</td> 
                        <td rowspan="2" align="center" style="border-bottom:2px solid #006699;"><strong>Terminal</strong></td> 
                        <td rowspan="2" align="center" style="border-bottom:2px solid #006699;" nowrap="nowrap"><strong>Date Time</strong></td>  
				      	<td colspan="2" align="center" bgcolor="#F2D0C6"><strong>eMoney Card - Mandiri </strong></td> 
					    <td colspan="5" align="center" bgcolor="#B3DFF2"><strong>eMoney Top-Up - Mandiri</strong></td>
					    <td rowspan="2" align="center" style="border-bottom:2px solid #006699;"><strong>Amount</strong></td>
					    <td rowspan="2" align="center" style="border-bottom:2px solid #006699;color:#999999;">Trx_Qua</td>
			          	<td rowspan="2" align="center" style="border-bottom:2px solid #006699;color:#999999;">Trx_Num</td> 
					</tr>
                    <tr bgcolor="#efefef" align="center"> 
					    <td style="border-bottom:2px solid #006699; background-color: #F2D0C6;">Qua</td> 
					    <td style="border-bottom:2px solid #006699; background-color: #F2D0C6;">Amount</td> 
					    <td style="border-bottom:2px solid #006699; background-color: #B3DFF2;">Qua-20k</td>
					    <td style="border-bottom:2px solid #006699; background-color: #B3DFF2;">Qua-50k</td>
					    <td style="border-bottom:2px solid #006699; background-color: #B3DFF2;">Qua-100k</td>
					    <td style="border-bottom:2px solid #006699; background-color: #B3DFF2;">Amount</td> 
					    <td style="border-bottom:2px solid #006699; background-color: #B3DFF2;color:#999999">TxSlot</td> 
				      </tr>
				</thead>
				<tbody>
                    <? 
					$x=1; 
					$tot_quaCrd = $tot_amountCrd = $tot_qua20 = $tot_qua50 = $tot_qua100 = $tot_amountTup = $tot_bayar = 0;
					
					$count_qua_tbk = 0;
					$count_qua_p1 = 0; 
					$count_qua_p2_20 = 0;
					$count_qua_p2_50 = 0; 
					$count_qua_p2_100 = 0;  
					$count_amount_Tup = 0; 
					$count_amount_Crd = 0;
					$count_total_bayar = 0;
					
					//$tot_qua_tbk = 0;
					//$tot_qua_p1 = 0; 
					//$tot_qua_p2_50 = 0; 
					//$tot_qua_p2_100 = 0;  
					//$tot_amount_Tup = 0; 
					//$tot_amount_Crd = 0;
					
					foreach($rowTrx as $row){
						//foreach($rowTrx as $k2 => $v2) 
						//foreach($v2 as $k3 => $v3) echo "<br>$k => $k2 => $k3 => $v3"; 
						//echo $row['kdprd'];
						
						//
						
						$quaCrd = $amountCrd = $qua20 = $qua50 = $qua100 = $amountTup = $txSlot = '';
						
						
						
						if ($row['kdprd'] == 'crd') {
							$prd = "Prepaid Card Mandiri -> eMONEY";
							$tot = $row['totalbayar']; 
							//--card vars:
							$quaCrd 	= $row['jmlbeli'];
							$amountCrd 	= $row['totalbayar'];
							
							if(!empty($quaCrd)) 	 $tot_quaCrd 	+= $quaCrd;
							if(!empty($amountCrd)) 	{$tot_amountCrd += $amountCrd; $count_amount_Crd  += $amountCrd; } 
							
							$count_qua_p1 	+= $row['jmlbeli'];
							$count_qua_tbk  += $row['jmlbeli']; 
							//$count_qua_tbk = 1;
							
							$count_total_bayar += $row['totalbayar'];
							
							
						} elseif ($row['kdprd'] == 'tup') {  
							$prd = "Prepaid Card Mandiri -> TOP-UP";
							// $tot = $row['totalbayar']; 
							//--TUP vars: 
							if($row['totalbayar']==20000)  $qua20  = 1;
							if($row['totalbayar']==50000)  $qua50  = 1;
							if($row['totalbayar']==100000) $qua100 = 1; 
							$amountTup 	= $row['totalbayar']; 
							$txSlot 	= $row['slot']; 
 
							if(!empty($qua20)) 		{$tot_qua20 	+= $qua20;  	$count_qua_p2_20  += $qua20; } 
							if(!empty($qua50)) 		{$tot_qua50 	+= $qua50;  	$count_qua_p2_50  += $qua50; } 
							if(!empty($qua100)) 	{$tot_qua100 	+= $qua100; 	$count_qua_p2_100 += $qua100; } 
							if(!empty($amountTup)) 	{$tot_amountTup += $amountTup;	$count_amount_Tup  += $amountTup; }  	 
 
							$count_qua_tbk += $row['jmlbeli'];
							//$count_qua_tbk = 1;
							
							$count_total_bayar += $row['totalbayar'];
							
						}  else { 
							$prd = "-";
							$tot = 0; 
							
							$tot_qua_p1 = $count_qua_p1; 
							$count_qua_p1 = 0;
							
							$tot_qua_p2_20 = $count_qua_p2_20; 
							$count_qua_p2_20 = 0;
							
							$tot_qua_p2_50 = $count_qua_p2_50; 
							$count_qua_p2_50 = 0;
							
							$tot_qua_p2_100 = $count_qua_p2_100; 
							$count_qua_p2_100 = 0;
							
							$tot_qua_tbk = $count_qua_tbk; 
							$count_qua_tbk = 0;
							
							$tot_amount_Tup = $count_amount_Tup; 
							$count_amount_Tup = 0;
							
							$tot_amount_Crd = $count_amount_Crd; 
							$count_amount_Crd = 0;
							
							
							$tot_total_bayar = $count_total_bayar; 
							$count_total_bayar = 0;
							
							
							 
							
							
							
						} 
						
						if($ci_func=="summary_transaction") 
						$tot = $row['totalbayar'];
						
						$clr_tbk = 'style="color:#F5D996"';
						
			?>
				
						<? if($row['kdprd']=='tbk'){ $x=$x-1; ?>
                  	<tr bgcolor="#996633" > 
					  	<td align="right" style="color:#999999"><strong <?=$clr_tbk;?> >Total</strong>&nbsp;<input name="id" type="hidden" value="1" /></td> 
     
					    <td align="center" <?=$clr_tbk;?> colspan="2"></td>  
                        <td align="center" <?=$clr_tbk;?>><?=$tot_qua_p1;?></td>
                        <td align="right"  <?=$clr_tbk;?>><?=number_format($tot_amount_Crd,0,',','.');?></td>
                        <td align="center" <?=$clr_tbk;?>><?=$tot_qua_p2_20;?></td>
                        <td align="center" <?=$clr_tbk;?>><?=$tot_qua_p2_50;?></td>
                        <td align="center" <?=$clr_tbk;?>><?=$tot_qua_p2_100;?></td>
                        <td align="right"  <?=$clr_tbk;?>><?=number_format($tot_amount_Tup,0,',','.');?></td>
                        <td align="right"  <?=$clr_tbk;?>>&nbsp;</td>
                        <td align="right"  <?=$clr_tbk;?>><?=number_format($tot_total_bayar,0,',','.');?></td>
                        <td align="center" <?=$clr_tbk;?>><?=$tot_qua_tbk;?></td>
						<td align="center" <?=$clr_tbk;?>><?=$row['totaltrx'];?></td>
				  	</tr>
                    
                    <tr bgcolor="#663300" > 
					  	<td align="right" style="color:#999999"><strong <?=$clr_tbk;?> >TBK</strong>&nbsp;<input name="id" type="hidden" value="1" /></td> 
     
					    <td align="center" <?=$clr_tbk;?>><?=$row['vmid'];?></td> 
						<td align="center" <?=$clr_tbk;?>><?=$row['dt'];?> <?=$row['tm'];?><?=$row['date'];?></td> 
                        <td align="right" <?=$clr_tbk;?> colspan="6">Settlement Amount :</td>
                         
                        <td align="right"  <?=$clr_tbk;?>><?=number_format($row['totalbayar'],0,',','.');?></td>
                        <td align="center" <?=$clr_tbk;?>><?//=$tot_qua_tbk;?></td>
						<td align="center" <?=$clr_tbk;?>><?=$row['totaltrx'];?></td>
				  	</tr>
                    
                        
						<? } else { ?>
                	<tr bgcolor="#ffffff"> 
					  	<td align="right" style="color:#999999"><? if($row['kdprd']!='tbk') echo $x."."; else { echo "<strong ".$clr_tbk.">TBK</strong>"; $x=$x-1;}; ?>&nbsp;<input name="id" type="hidden" value="1" /></td> 
             
					    <td align="center"><?=$row['vmid'];?></td> 
						<td align="center"><?=$row['dt'];?> <?=$row['tm'];?><?=$row['date'];?></td> 
                       	<td align="center" bgcolor="#FDF4F1"><?=$quaCrd;?></td> 
                       	<td align="right"  bgcolor="#FDF4F1"><? if($amountCrd) echo number_format($amountCrd,0,',','.');?></td>
                       	<td align="center" bgcolor="#E9F7FD"><?=$qua20;?></td>
                       	<td align="center" bgcolor="#E9F7FD"><?=$qua50;?></td>
                       	<td align="center" bgcolor="#E9F7FD"><?=$qua100;?></td>
                       	<td align="right"  bgcolor="#E9F7FD"><? if($amountTup) echo number_format($amountTup,0,',','.');?></td>  
                        <td align="center" bgcolor="#E9F7FD" style="color:#999999"><?=$txSlot;?></td>
						<td align="right"> <?=number_format($row['totalbayar'],0,',','.');?></td>
						<td align="center" style="color:#999999"><?=$row['jmlbeli'];?></td>
                        <td align="center" style="color:#999999"><?=$row['trx_num'];?></td> 
                        
				  	</tr>
                        <? } //e: if($row['kdprd']=='tbk'){?>
                        
                    
		  		  	<?
				  		$x++;
                   	} 
				   	?>
		  			<tr>   
						<td class="tdtotal" colspan="3" align="right">TOTAL :</td>
                          
                        <td class="" align="center" bgcolor="#D6B4AA"><?=$tot_quaCrd;?></td>
                        <td class="" align="right" bgcolor="#D6B4AA"><?=number_format($tot_amountCrd,0,',','.');?></td>
                        <td class="" align="center" bgcolor="#99C4D8"><?=$tot_qua20;?></td> 
                        <td class="" align="center" bgcolor="#99C4D8"><?=$tot_qua50;?></td> 
                        <td class="" align="center" bgcolor="#99C4D8"><?=$tot_qua100;?></td> 
                        <td class="" align="right" bgcolor="#99C4D8"><?=number_format($tot_amountTup,0,',','.');?></td>
                        <td class="" align="center" bgcolor="#99C4D8"></td>  
						<td class="tdtotal" align="right"><?=$total_amount;?></td>
						<td class="tdtotal" align="center"><?=($tot_quaCrd+$tot_qua20+$tot_qua50+$tot_qua100); //=$total_item;?></td> 
                        <td class="tdtotal" align="center"></td>  
		  			</tr>
		  		</tbody>	
	  	  </table>
<? //} //--end if trx ?>
		  	<p></p>
			 
  	  </div>  
	</div> 
	<!-- /pageContent -->
    
</div> 
<? require_once('include/bottom.php'); ?>