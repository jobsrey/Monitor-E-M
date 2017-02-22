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
            	<span>&nbsp; &nbsp; Product : </span>	
            	<span id="productlist"><?=$listmenu_2;?></span>
                <? /* 
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
           
   		  <h2 style="color: #096"><? if($table_trx=="topup_mandiri") echo "Topup Mandiri - "; else echo "Sales"; ?> Report</h2>
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
                <td>Products</td>
                <td>:</td>
                <td nowrap="nowrap"><?=$product;?></td>
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
          
          <? if ($table_trx == 'topup_mandiri') { ?>
          
          <table class="tbldetail2 tdline" width="" border="0" cellpadding="5" cellspacing="0">
		 		<thead>
					  <tr bgcolor="#FFFFFF">
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
          
          <? } else { 
		  
		  		
		  
		  ?>
          
			<table class="tbldetail2 tdline" width="" border="0" cellpadding="5" cellspacing="0">
				   <thead>
					  <tr bgcolor="#FFFFFF">
					    <td align="center" class="xlightgrey">No.</td>
					    <? if($terminal=="all"){?>
                        <td>Terminal</td>
					    <? } ?>
                        <td>Date</td>
					    <td>Time</td>
					    <td>Product</td>
					    <td align="center">Quantity</td>
					    <td align="right">Price</td>
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
					    <td><?=$row['vmid'];?></td>
                        <? } ?>
						<td><?=$row['dt'];?></td>
						<td><?=$row['tm'];?></td>
						<td>eMoney - Prepaid Card Mandiri<?//=$row['tm'];?></td>
						<td align="center"><?=$row['jmlbeli'];?></td>
						<td align="right"><?=number_format($row['totalbayar'],0,',','.');?></td>
					  
                      </tr>
		  		  <? $x++;
                   } ?>
		  			<tr>  
						<td class="tdtotal" >&nbsp;</td> 
						<td class="tdtotal" colspan="<? if($terminal=="all") echo "4"; else echo "3";?>" align="right">TOTAL :</td>
						<td class="tdtotal" ><?=$total_item;?></td>   
						<td class="tdtotal" align="right"><?=$total_amount;?></td>
		  			</tr>
		  		</tbody>	
		  	</table>
            <? } //--end if trx ?>
		  	<p></p>
			 
  	  </div>  
	</div> 
	<!-- /pageContent -->
    
</div> 
<? require_once('include/bottom.php'); ?>