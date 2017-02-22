<? require_once('include/top.php'); ?>
<div class="container">

	<div class="lblpage" align="right">
		<div class="float_l tahoma size18"><?=$pageLABEL;?></div>
		<div class="float_r arial12 grey9">
		  Status : <? $liststatus=array(array(1,'Active'),array(2,'Delete')); ?>  
                <select name="selStatus" id="selStatus"  onchange="loadcontent('<?=base_url()?>user_manage/changepage/1/<?=$limit?>/'+$('select#selStatus').val()+'/<?=$sort?>/<?=$order?>/<?=$ci_ctrl?>/<?=$ci_changePage?>/<?=$result_id?>','<?=$result_id?>')"> 
                  <? foreach($liststatus as $row){ ?> 
                  <option value="<?=$row[0]?>" <? if($row[0]==$statusid){ ?> selected="selected" <? } ?> ><?=$row[1]?></option> 
                  <? } ?> 
                </select> 
				<? /*
				loadcontent('<?=base_url()?>user_manage/indexData/1/<?=$limit?>/'+$('select#selStatus').val()+'/<?=$sort?>/<?=$order?>/<?=$ci_ctrl?>/<?=$ci_changePage?>/<?=$result_id?>','<?=$result_id?>')"
		  		
	      &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  
		  <input type="text" name="textfield"> 
		  <input name="b1" type="button" id="b1" value="Search">
		  */ ?>
		</div> 
		<div class="float_r tahoma " align="right"><input name="i1" type="button" id="i1" value="ADD USER" onClick="window.location.assign('/user_manage/user_edit/0')">&nbsp;&nbsp;&nbsp;</div>
		 
	</div> 
	
    <div class="linelbl"></div> 
  	<div id="contMenu"> 
   		<div style="clear:both"></div> 
    	<div id="dspdata"> 
      		<?=$indexData?> 
   	 	</div>  
 
	</div> 
</div> 
<? require_once('include/bottom.php'); ?>