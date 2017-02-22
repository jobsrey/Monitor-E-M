<? require_once('include/top.php'); ?>
<div class="container">

	<div class="lblpage" align="right">
		<div class="float_l tahoma size18"><?=$pageLABEL;?></div> 
		<? if($this->session->userdata('GroupID')==1){ ?>
        <div class="float_r arial12 grey9">
		  	&nbsp;&nbsp;&nbsp; Status : <? $liststatus=array(array(1,'Active'),array(2,'Delete')); ?>  
        	<select name="selStatus" id="selStatus" 
                onchange="loadcontent('<?=base_url()?>user_manage/changepage/1/<?=$limit?>/'+$('select#selStatus').val()+'/<?=$sort?>/<?=$order?>/<?=$ci_ctrl?>/<?=$ci_changePage?>/<?=$result_id?>/<?=$group_id?>','<?=$result_id?>')"> 
                  <? foreach($liststatus as $row){ ?> 
                  <option value="<?=$row[0]?>" <? if($row[0]==$statusid){ ?> selected="selected" <? } ?> ><?=$row[1]?></option> 
                  <? } ?> 
            </select>  
		</div> 
        <? } ?> 
       <? if($this->session->userdata('AccessType')=="super_user"||$this->session->userdata('GroupID')==1){ ?> 
        <div class="float_r tahoma " align="right">
        &nbsp; &nbsp; &nbsp; <input name="i1" type="button" id="i1" value="ADD USER" onClick="window.location.assign('/user_manage/user_edit/0')"> 
        </div>
		<? } ?>  
        <? if($this->session->userdata('GroupID')==1){ ?>
        <div class="float_r tahoma " align="right"> Group Media :  
        	<select name="GroupID" id="GroupID" onchange="window.location.assign('<?=base_url().$ci_ctrl;?>/users/1/<?=$limit?>/<?=$statusid;?>/<?=$sort?>/<?=$order?>/'+$('select#GroupID').val())" > 
                <option value="0">ALL</option> 
                <? foreach($rowgrp as $rowgrp){  ?>
                <option value="<?=$rowgrp['id'];?>" <? if($group_id==$rowgrp['id']) echo 'selected="selected"'; ?> >
                  <?=$rowgrp['group']; ?>
                </option>
                <? } ?>
        	</select> 
        </div>
		<? } ?> 
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