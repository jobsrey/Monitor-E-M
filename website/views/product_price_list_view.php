<? require_once('include/top.php'); ?>
<div class="container">

	<!-- pageLabel -->
	<div class="lblpage">
    	<div class="float_l tahoma size18"><?=$pageLABEL;?></div>
    	<div class="float_r arial12" style="padding-left:20px;">  </div>  
		<div class="float_r" style="padding-right:20px;border-right:1px dotted grey;"><input type="button" name="addnew" value="ADD NEW" onclick="window.location.assign('/<?=$ci_ctrl?>/edit_data/0/<?=$ci_func?>')" /></div> 
	</div> 
	<!-- /pageLabel -->
    
    <div class="linelbl"></div> 
    
	<!-- pageContent -->    
  	<div id="contMenu"> 
   		<div style="clear:both"></div> 
    	<div id="dspdata"> 
      		<?=$indexData?>
            
            <table id="tableindex" width="" border="0" cellpadding="5" cellspacing="1" bgcolor="#bbbbbb">
              <thead>
                <tr bgcolor="#666666">
                  <td align="center" class="lightgrey">No.</td>
                  <td nowrap="nowrap"><span class="tblhead">Product</span><span class=""></span></td>
                  <td nowrap="nowrap">Suplier</td>
                  <td nowrap="nowrap"><span class="tblhead">Item Name</span><span class=""></span></td>
                  <td nowrap="nowrap"><span class="tblhead">Item Price</span><span class=""></span></td>
                  <td align="center" class="lightgrey">Edit</td>
                </tr>
              </thead>
              <tbody>
                <tr bgcolor="#ffffff">
                  <td align="right">1.&nbsp;</td>
                  <td>eMoney</td>
                  <td>Bank Mandiri</td>
                  <td>Prepaid Card eMoney</td>
                  <td>50000</td>
                  <td><input  type="button" name="EDIT" value="EDIT" onclick="window.location.assign('http://lunari/product_data/edit_data/1/product_price')"/>
                  <input name="id" type=" " value="1" /></td>
                </tr>
                <tr bgcolor="#ffffff">
                  <td align="right">2.&nbsp;</td>
                  <td width="100" bgcolor="#ffffff">Pulsa Elektonik A</td>
                  <td>Telesindo</td>
                  <td>Telkomsel AS10</td>
                  <td>10000</td>
                  <td>&nbsp;</td>
                </tr>
              </tbody>
            </table>
     
   	 	</div>  
	</div> 
	<!-- /pageContent -->
    
</div> 
<? require_once('include/bottom.php'); ?>