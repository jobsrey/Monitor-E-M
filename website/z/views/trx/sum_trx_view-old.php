<? require_once('include/top.php'); ?>
<link rel="stylesheet" href="/asset/css/jquery-ui-1.9.2.css" />    
<script 
type="text/javascript" language="javascript" src="/asset/js/jquery-ui-1.9.2.js"></script>
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
        <form action="<?=base_url().$ci_ctrl.$callfunc;?>" method="post"> 
        <input type="hidden" name="reportfunc" id="reportfunc" value="<?=$reportfunc;?>"/> 
        <table>
          <tr>
            <td colspan="4">Select Report  by:</td>
          </tr>
          <tr>  
            <td>Owner : </td>
            <td><?=$listmenu_0;?></td> 
            <td width="11"></td>
            <td>
            <div id="tproductlist">
            	<span>Terminal : </span>	
            	<span id="vmlist"><?=$listmenu_1;?></span>
                <? /* 
            	<span>&nbsp; &nbsp; Product : </span>	
            	<span id="productlist"><?=$listmenu_2;?></span>
                
            	<span>&nbsp; &nbsp; Item : </span>	
            	<span id="productlist"><?=$listmenu_3;?></span> 
                */ ?>
            </div>
            </td> 
          </tr>
        </table>
        <table> 
          <tr>  
            <td>Date from : </td>
            <td><div class="ibDtPict">
			<input name="dt1" type="text" id="datepicker" value="<?=$dt1?>" maxlength="12">
			&nbsp; to &nbsp; 
			<input name="dt2" type="text" id="datepicker2" value="<?=$dt2?>" maxlength="12">
			</div></td>
            <td>&nbsp;</td>
            <td><span class="float_r arial12" style="padding-left:20px; display:inline-block">
              <input type="submit" name="button" id="button" value="Submit" />
            </span></td>
          </tr>
        </table>
	  </form>
        
   		<div class="pad5"></div> 
    	<div class="linelbl"></div> 
   		<div style="clear:both"></div> 
    	<div id="dspdata"> 
      		<?//=$indexData?> 
           
   		  <h2 style="color: #096"><? //if($table_trx=="topup_mandiri") echo "Topup Mandiri - "; else echo "Sales"; ?> Summary Transaction</h2>
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
			 <strong class="style3">&nbsp; Detail transactions</strong>
		  <div style="padding:8px"></div>  
          
           
          
         <table class="tbldetail2 tdline" width="" border="0" cellpadding="5" cellspacing="0">
		 		<thead>
					  <tr bgcolor="#FFFFFF"  align="center" >
					    <td align="center" class="xlightgrey">No.</td> 
                        <td>Terminal</td> 
					    <td>Date Time</td> 
					    <td>Product Type</td> 
					    <td>Transaction</td> 
					    <td>Quantity</td> 
					    <td align="right">Payment</td>
				      </tr>
			  	</thead>
					<tbody>
                    <? 
					$x=1; $curtid = $curdt = $last_tid = $last_date = '';
					
					foreach($rowTrxSum as $k => $v){ 
						$tid = $k; 
						
						//echo "<br>".$last_tid = $k;
						
						//echo "<br>".$curtid ;
						
						foreach($v as $k2 => $v2){  //echo "<br>$k => $k2 => $v2";  
							$dt = $k2;  
							//if($k2!=$last_date) { $last_date = $curdt = $k2;  }
							//else $curdt = '';  
						foreach($v2 as $k3 => $v3){  
						 	$trx_type = $k3;
						 	if($k3=='card') 
 
							$curtid = "";  
							if($tid!=$last_tid) { $curtid = $tid; }
							$last_tid = $tid;
 
							$curdt = "";  
							if($dt!=$last_date) { $curdt = $dt; }
							$last_date = $dt;
							
							?>
					  <tr bgcolor="#ffffff"> 
					    <td align="right"><?=$x;?>.&nbsp;<input name="id" type="hidden" value="1" /></td> 
								<td><?=$curtid;?></td>
								<td><?=$curdt;?></td>  
								<td><?=$trx_type;?></td> 
								<td align="center"><?=$rowTrxSum[$tid][$dt][$trx_type]['trx'];?></td> 
								<td align="center"><?=$rowTrxSum[$tid][$dt][$trx_type]['item'];?></td> 
						<td align="right"><?=number_format($rowTrxSum[$tid][$dt][$trx_type]['payment'],0,',','.');?></td>
							  </tr> 
							  <? 
				  			$x++;	
				  		} 
				   		}
				  		
                  	} ?>
		  			<tr>  
						<td class="tdtotal" ></td> 
						<td class="tdtotal" ></td> 
						<td class="tdtotal" ></td> 
					  <td align="right" class="tdtotal" >TOTAL :</td> 
						<td class="tdtotal" align="center"><?=$jmltrx;?></td> 
					  <td class="tdtotal" align="center"><?=$jmlbeli;?></td> 
					  <td class="tdtotal" align="right"><?=$total_amount;?></td>
		  			</tr>
		  		</tbody>	
		  	</table>
          
          <p></p>
			 
  	  </div>  
	</div> 
	<!-- /pageContent -->
    
</div> 
<? require_once('include/bottom.php'); ?>