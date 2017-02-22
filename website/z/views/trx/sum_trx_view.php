<? require_once('include/top.php'); ?>
<link rel="stylesheet" href="/asset/css/jquery-ui-1.9.2.css" />    
<script type="text/javascript" language="javascript" src="/asset/js/jquery-ui-1.9.2.js"></script>
<script> $(function() { $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' }); }); </script>
<script> $(function() { $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' }); }); </script>
<script> $(document).ready(function(){ $("#but-filter").click(function(){ $("#form-filter").toggle(); });});</script>
<script> $(document).ready(function(){ $("#but-desc").click(function(){ $("#form-desc").toggle(); });});</script>
<style type="text/css">
.style3{ font-weight: bold; color: #F60; }
#tbl_data{ border-right: 1px solid #ccc; } 
#tbl_data td { border-left: 1px solid #ccc } 
#tbl_data td a, #tbl_data td a:visited{ border-bottom: 1px solid red }	
.lblpage{padding-top:20px;} 
button{font:normal 9px Arial;}
</style>
<div class="container">

	<!-- pageLabel -->
	<div class="lblpage">
    	<div class="float_l tahoma size15 bold"><?=$pageLABEL;?></div>
    	<div class="float_r arial12" style="padding-left:20px; display:inline-block">&nbsp;</div>  
  	</div> 
	<!-- /pageLabel -->
    
    <div class="linelbl"></div> 
</head>
<body>

 
	<!-- pageContent -->    
  	<div id="contMenu"> 
   		<div style="clear:both"></div> 
        <button id="but-filter">Show/Hide</button>  
        <div id="form-filter">
            <div class="pad5"></div> 
            <form action="<?=base_url().$ci_ctrl.$callfunc;?>" method="post"> 
            <input type="hidden" name="reportfunc" id="reportfunc" value="<?=$reportfunc;?>"/>
            <table> 
              <tr>
                <td>Owner </td>
                <td>: </td>
                <td width="11"><div class="ibDtPict"><?=$listmenu_0;?></div></td>
                <td></td> 
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><span class="ibDtPict float_l">Terminal</span>-ID</td>
                <td>:</td>
                <td colspan="2"><div id="tproductlist" class="ibDtPict float_l" ><span id="vmlist"><?=$listmenu_1;?></span></div></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Date </td>
                <td>:</td>
                <td colspan="2"><div class="ibDtPict"><input name="dt1" type="text" id="datepicker" value="<?=$dt1?>" maxlength="12">
                &nbsp; to &nbsp; 
                <input name="dt2" type="text" id="datepicker2" value="<?=$dt2?>" maxlength="12">
                </div></td>
                <td>&nbsp;</td> 
              </tr>
              <tr>
                <td>Time </td>
                <td>:</td>
                <td colspan="2"><div class="ibDtPict">
                <?
                    $arr_TM = array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23"); 
                    if(!isset($tm1)) $tm1 = "00";
                    if(!isset($tm2)) $tm2 = "23"; 
                    //echo $tm1;
                ?>
                <select name="tm1" id="tm1" <? if($table_trx=='kiosk') echo 'disabled style="color:#999999"';?> > 
                    <?  
                        foreach($arr_TM as $k => $v){
                            if($tm1==$v.":00") $str_slc1 = 'selected="selected"';
                            else $str_slc1 = ''; 
                            echo "<option $str_slc1>$v:00</option>"; 
                        } 
                    ?> 
                  </select> 
                
                &nbsp; to &nbsp; 
                <select name="tm2" id="tm2" <? if($table_trx=='kiosk') echo 'disabled style="color:#999999"';?>> 
                    <?  
                        foreach($arr_TM as $k => $v){
                            if($tm2==$v.":59") $str_slc2 = 'selected="selected"';
                            else $str_slc2 = ''; 
                            echo "<option $str_slc2>$v:59</option>"; 
                        } 
                    ?> 
                  </select> 
                </div></td> 
                <td><span class="float_r arial12" style="padding-left:20px; display:inline-block">
                  <input type="submit" name="button" id="button" value="Submit" />
                </span></td>
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
                <td nowrap="nowrap"><?=$dt2;?> - <?=$tm2;?></td>
                <td></td>
                <td nowrap>Total amount</td>
                <td>:</td>
                <td><?=number_format($total_amount,0,',','.');?></td>
              </tr>

            </table>
			<div class="pad5"></div> 
			<div style="border-bottom:1px solid #aaaaaa"></div>  
			<div class="pad5"></div>   
            </div>
            
			<strong class="style3">Table Transactions</strong>
		  	<div style="padding:8px"></div>  
          
           
          
         <table id="tbl_data" class="tbldetail2 tdline" width="" border="0" cellpadding="5" cellspacing="0">
		 		<thead bgcolor="#efefef">
					  
					    <td rowspan="2" align="center" style="border-bottom:2px solid #006699;"><strong>No.</strong> </td> 
                        <td rowspan="2" align="center" style="border-bottom:2px solid #006699;"><strong>Terminal</strong> </td> 
					    <td rowspan="2" align="center" style="border-bottom:2px solid #006699;">Date Time </td> 
					    <td colspan="3" align="center" bgcolor="#F2D0C6"><strong>Prepaid-Mandiri </strong></td> 
					    <td colspan="4" align="center" bgcolor="#B3DFF2"><strong>Top Up-Mandiri</strong></td>
					    <td rowspan="2" align="center" style="border-bottom:2px solid #006699;"><strong>Total Trx</strong></td>
					    <td rowspan="2" align="center" style="border-bottom:2px solid #006699;"><strong>Total Qua</strong></td>
					    <td rowspan="2" align="center" style="border-bottom:2px solid #006699;"><strong>Total Amount</strong></td>
				      </tr>
					  <tr bgcolor="#efefef" align="center">
					    <td style="border-bottom:2px solid #006699; background-color: #F2D0C6;">Trx</td> 
					    <td style="border-bottom:2px solid #006699; background-color: #F2D0C6;">Qua</td> 
					    <td style="border-bottom:2px solid #006699; background-color: #F2D0C6;">Amount</td>
					    <td style="border-bottom:2px solid #006699; background-color: #B3DFF2;">Trx</td>
					    <td style="border-bottom:2px solid #006699; background-color: #B3DFF2;">Qua-50k</td>
					    <td style="border-bottom:2px solid #006699; background-color: #B3DFF2;">Qua-100k</td>
					    <td style="border-bottom:2px solid #006699; background-color: #B3DFF2;">Amount</td> 
				      </tr>
			  	</thead>
					<tbody>
                    <? 
					$x=1; 
					$curtid = $curdt = $last_tid = $last_date = ''; 
					$total_crd_trx = $total_crd_item = $total_crd_paid = 0;
					$total_tup_trx = $total_tup_item = $total_tup_paid = 0;
					
					$total_tup_item50 = $total_tup_item100 = 0;
							
					foreach($rowTrxSum as $k => $v){ 
						$tid = $k;  
						//echo "<br>".$last_tid = $k; 
						//echo "<br>".$curtid ; 
							
						
						foreach($v as $k2 => $v2){ //echo "<br>$k => $k2 => $v2";  
							$dt = $k2;  
						
							$tot_trx  = $tot_item = $tot_paid = 0; 
							//if($k2!=$last_date) { $last_date = $curdt = $k2;  }
							//else $curdt = '';  
						
							//foreach($v2 as $k3 => $v3){  
						 	//$trx_type = $k3;
						 	//if($k3=='card') 
 
							$curtid = "&nbsp;";  
							if($tid!=$last_tid) { $curtid = $tid; }
							$last_tid = $tid; 
 
							$curdt = "&nbsp;";  
							if($dt!=$last_date) { $curdt = $dt; }
							$last_date = $dt;
							
							//echo $rowTrxSum[$tid][$dt]['card_trx'],"----<br>";
							 
							 
							if(!$rowTrxSum[$tid][$dt]['card_trx']) 		$rowTrxSum[$tid][$dt]['card_trx'] 	= 0;
							if(!$rowTrxSum[$tid][$dt]['card_item']) 	$rowTrxSum[$tid][$dt]['card_item'] 	= 0;
							if(!$rowTrxSum[$tid][$dt]['card_payment'])  $rowTrxSum[$tid][$dt]['card_payment'] = 0;
							
							if(!$rowTrxSum[$tid][$dt]['topup_trx']) 	$rowTrxSum[$tid][$dt]['topup_trx'] 	= 0;
							if(!$rowTrxSum[$tid][$dt]['topup_item']) 	$rowTrxSum[$tid][$dt]['topup_item'] = 0;
							if(!$rowTrxSum[$tid][$dt]['topup_payment']) $rowTrxSum[$tid][$dt]['topup_payment'] = 0;
							
							if(!$rowTrxSum[$tid][$dt]['topup_item']) 	$rowTrxSum[$tid][$dt]['topup_item'] = 0;
							
							
							$total_crd_trx 	+= $rowTrxSum[$tid][$dt]['card_trx'];
							$total_crd_item += $rowTrxSum[$tid][$dt]['card_item'];
							$total_crd_paid += $rowTrxSum[$tid][$dt]['card_payment'];
							
							$total_tup_trx 	+= $rowTrxSum[$tid][$dt]['topup_trx']; 
							$total_tup_item += $rowTrxSum[$tid][$dt]['topup_item']; 
							$total_tup_paid += $rowTrxSum[$tid][$dt]['topup_payment'];  
							
							$total_tup_item50  += $rowTrxSum[$tid][$dt]['price_item50']; 
							$total_tup_item100 += $rowTrxSum[$tid][$dt]['price_item100']; 
							
							$cur_crd_trx 	+= $rowTrxSum[$tid][$dt]['card_trx'];
							$cur_crd_item 	+= $rowTrxSum[$tid][$dt]['card_item'];
							$cur_crd_paid 	+= $rowTrxSum[$tid][$dt]['card_payment'];
							
							$cur_tup_trx 	+= $rowTrxSum[$tid][$dt]['topup_trx']; 
							$cur_tup_item 	+= $rowTrxSum[$tid][$dt]['topup_item']; 
							$cur_tup_paid 	+= $rowTrxSum[$tid][$dt]['topup_payment']; 
							
							
							$tot_trx 	= $rowTrxSum[$tid][$dt]['card_trx']     + $rowTrxSum[$tid][$dt]['topup_trx'];
							$tot_item 	= $rowTrxSum[$tid][$dt]['card_item']    + $rowTrxSum[$tid][$dt]['topup_item'];
							$tot_paid 	= $rowTrxSum[$tid][$dt]['card_payment'] + $rowTrxSum[$tid][$dt]['topup_payment'];
							
							
							if(empty($rowTrxSum[$tid][$dt]['card_trx'])) $trxcrd = "#";
							else 
							$trxcrd = '/reporting/card_transaction/'.$dt.'/'.$dt.'/0/'.$terminal_id.'/0/0" " target="_blank';
							
							if(empty($rowTrxSum[$tid][$dt]['topup_trx'])) $trxtop = "#";
							else 
							$trxtop = '/reporting/topup_transaction/'.$dt.'/'.$dt.'/0/'.$terminal_id.'/0/0" " target="_blank';
							
							?>
					  <tr > 
					    <td align="right"><?=$x;?>.&nbsp;<input name="id" type="hidden" value="1" /></td> 
								<td><?=$curtid;?></td>
								<td><?=$curdt;?></td> 
								<td align="center" bgcolor="#FDF4F1"><a href="<?=$trxcrd?>"></a><?=$rowTrxSum[$tid][$dt]['card_trx'];?></td> 
								<td align="center" bgcolor="#FDF4F1"><?=$rowTrxSum[$tid][$dt]['card_item'];?></td> 
								<td align="right"  bgcolor="#FDF4F1"><?=number_format($rowTrxSum[$tid][$dt]['card_payment'],0,',','.');?></td>
                                <td align="center" bgcolor="#E9F7FD"><a href="<?=$trxtop?>"></a><?=$rowTrxSum[$tid][$dt]['topup_trx'];?></td> 
								<td align="center" bgcolor="#E9F7FD"><?=$rowTrxSum[$tid][$dt]['price_item50'];?></td> 
								<td align="center" bgcolor="#E9F7FD"><?=$rowTrxSum[$tid][$dt]['price_item100'];?></td> 
								<td align="right"  bgcolor="#E9F7FD"><?=number_format($rowTrxSum[$tid][$dt]['topup_payment'],0,',','.');?></td>
                        <td align="center"><?=$tot_trx;?></td>
                        <td align="center"><?=$tot_item;?></td>
                        <td align="right"><?=number_format($tot_paid,0,',','.');?></td>
							  </tr> 
							  <? 
				  			$x++;	
				  		//} 
				   		}
				  		
                  	} ?>
		  			<tr class="tdtotal">  
						<td>&nbsp;</td> 
						<td align="right" class=" " >TOTAL :</td> 
			       		<td class=" " >&nbsp;</td> 
				        <td class=" " align="center" bgcolor="#D6B4AA" ><?=$total_crd_trx;?></td>
					    <td class=" " align="center" bgcolor="#D6B4AA" ><?=$total_crd_item;?></td> 
					  	<td class=" " align="right"  bgcolor="#D6B4AA" ><?=number_format($total_crd_paid,0,',','.');?></td>
					    <td class=" " align="center" bgcolor="#99C4D8" ><?=$total_tup_trx;?></td>
					    <td class=" " align="center" bgcolor="#99C4D8" ><?=$total_tup_item50;?></td> 
					    <td class=" " align="center" bgcolor="#99C4D8" ><?=$total_tup_item100;?></td><?//=$total_tup_item;?> 
					  	<td class=" " align="right"  bgcolor="#99C4D8" ><?=number_format($total_tup_paid,0,',','.');?></td>
					  	<td class=" " align="center"><?=$jmltrx;?></td>
					  	<td class=" " align="center"><?=$jmlbeli;?></td>
					  	<td class=" " align="right"><?=number_format($total_amount,0,',','.');?></td>
		  			</tr>
		  		</tbody>	
		  	</table>
          
          <p></p>
			 
  	  </div>  
	</div> 
	<!-- /pageContent -->
    
</div> 
<? require_once('include/bottom.php'); ?>