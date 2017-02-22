<? require_once('include/top.php'); ?>
<div class="container">

	<!-- pageLabel -->
	<div class="lblpage">
    	<div class="float_l tahoma size18"><?=$pageLABEL;?></div>
    	<div class="float_r arial12" style="padding-left:20px;">Data Status :
        <? if($this->allfunc->isAdmin()) $disabled = 'disabled="disabled"'; else $disabled = ''; ?>
	        <select <?=$disabled?> name="selStatus" id="selStatus"  onchange="loadcontent('<?=base_url()?><?=$ci_ctrl?>/<?=$ci_changePage?>/1/<?=$limit?>/'+$('select#selStatus').val()+'/<?=$sort?>/<?=$order?>/<?=$ci_changePage?>/<?=$result_id?>/<?=$ci_ctrl?>/<?=$ci_func?>/<?=$TABLE?>','<?=$result_id?>')"> 
            	<option value="1" <? if($status_id==1){ ?> selected="selected" <? } ?>>Active</option> 
            	<option value="0" <? if($status_id==0){ ?> selected="selected" <? } ?>>Deleted</option>  
    		</select> 
        </div>  
		<div class="float_r" style="padding-right:20px;border-right:1px dotted grey;"><input <?=$disabled?>  type="button" name="addnew" value="ADD NEW" onclick="window.location.assign('/<?=$ci_ctrl?>/edit_data/0/<?=$ci_func?>')" /></div> 
	</div> 
	<!-- /pageLabel -->
    
    <div class="linelbl"></div> 
    
	<!-- pageContent -->    
  	<div id="contMenu"> 
   		<div style="clear:both"></div> 
        <? if(isset($headerData)) echo $headerData;?>
    	<div id="dspdata"> 
      		<?=$indexData?> 
   	 	</div>  
	</div> 
	<!-- /pageContent -->
    
</div> 
<? require_once('include/bottom.php'); ?>