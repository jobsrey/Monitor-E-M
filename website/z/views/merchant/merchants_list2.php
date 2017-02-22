<? require_once('include/top.php'); ?>
<div class="container">

	<div class="lblpage" align="right">
		<div class="float_l tahoma size18"><?=$pageLABEL;?></div>
		<div class="float_r arial12 grey9">
		  Status : <? $liststatus=array(array(1,'Active'),array(2,'Delete')); ?>  
                <select name="selStatus" id="selStatus"  <?=$this->allfunc->isAdmin();?> 
                onchange="loadcontent('<?=base_url()?>merchant_manage/changepage/1/<?=$limit?>/'+$('select#selStatus').val()+'/<?=$sort?>/<?=$order?>/<?=$ci_ctrl?>/<?=$ci_changePage?>/<?=$result_id?>','<?=$result_id?>')"> 
                  <? foreach($liststatus as $row){ ?> 
                  <option value="<?=$row[0]?>" <? if($row[0]==$statusid){ ?> selected="selected" <? } ?> ><?=$row[1]?></option> 
                  <? } ?> 
                </select>  
		</div> 
		<? //if($this->allfunc->isAdmin(1)||$this->allfunc->isAdminGroup(1)||$strAccessType=="Admin"){ ?> 
        <div class="float_r tahoma " align="right">
        <input name="i1" type="button" id="i1" value="ADD MERCHANT" onClick="window.location.assign('/merchant_manage/merchant_edit/0')">
        &nbsp;&nbsp;&nbsp;
        </div>
        <? if($this->session->userdata('GroupID')==1){ ?>
        <div class="float_r tahoma " align="right"> Group Media :  
        <select name="GroupID" id="GroupID" onchange="window.location.assign('<?=base_url().$ci_ctrl;?>/<?=$ci_func;?>/1/<?=$limit?>/<?=$statusid;?>/<?=$sort?>/<?=$order?>/'+$('select#GroupID').val())" > 
                <option value="0">ALL</option> 
                <? foreach($rowgrp as $rowgrp) if($rowgrp['id']>1) {  ?>
                <option value="<?=$rowgrp['id'];?>" <? if($group_id==$rowgrp['id']) echo 'selected="selected"'; ?> >
                  <?=$rowgrp['group']; ?>
                </option>
                <? } ?>
        </select>
        &nbsp; &nbsp; &nbsp;
        </div>
		<? } ?> 
		<? //} ?>
		 
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