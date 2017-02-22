<? require_once('include/top.php'); ?>
<div class="container">

	<div class="lblpage" align="right">
		<div class="float_l tahoma size18"><?=$pageLABEL;?></div>
		<div class="float_r arial12 grey9">
		  Status : <? $liststatus=array(array(1,'Active'),array(2,'Delete')); ?>  
                <select name="selStatus" id="selStatus"  onchange="loadcontent('<?=base_url()?>user_management/changepage/1/<?=$limit?>/'+$('select#selStatus').val()+'/<?=$sort?>/<?=$order?>/<?=$ci_ctrl?>/<?=$ci_changePage?>/<?=$result_id?>','<?=$result_id?>')"> 
                  <? foreach($liststatus as $row){ ?> 
                  <option value="<?=$row[0]?>" <? if($row[0]==$statusid){ ?> selected="selected" <? } ?> ><?=$row[1]?></option> 
                  <? } ?> 
                </select> 
				<? /*
				loadcontent('<?=base_url()?>user_management/indexData/1/<?=$limit?>/'+$('select#selStatus').val()+'/<?=$sort?>/<?=$order?>/<?=$ci_ctrl?>/<?=$ci_changePage?>/<?=$result_id?>','<?=$result_id?>')"
		  		
	      &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  
		  <input type="text" name="textfield"> 
		  <input name="b1" type="button" id="b1" value="Search">
		  */ ?>
		</div> 
		<div class="float_r tahoma " align="right"><input name="i1" type="button" id="i1" value="ADD USER" onClick="window.location.assign('/user_management/user_edit/0')">&nbsp;&nbsp;&nbsp;</div>
		 
	</div> 
	
    <div class="linelbl"></div> 
  	<div id="contMenu"> 
   		<div style="clear:both"></div> 
    	<div id="dspdata"> 
      		<?=$indexData?> 
   	 	</div>  
<? /* 
	  <p>&nbsp;</p>
	  <p>&nbsp;</p>
	  <p>&nbsp;</p>
	  <p>&nbsp;</p>
	  <p>&nbsp;</p>
	  <p>&nbsp;</p>
	  <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#bbbbbb">
        <tr bgcolor="#666666" class="style4 lightgrey">
          <td><span class="style4">No.</span></td>
          <td><span class="style4">User</span></td>
          <td><span class="style4">Name</span></td>
          <td><span class="style4">email</span></td>
          <td><span class="style4">Level</span></td>
          <td bgcolor="#666666"><span class="style4">Group</span></td>
          <td width="100%" nowrap="nowrap" bgcolor="#666666"><span class="style4">Last Login </span></td>
          <td><span class="style4">Edit</span></td>
        </tr>
        <tr bgcolor="#FFDDFF">
          <td>1.</td>
          <td><span class="style5">USer1</span></td>
          <td>Riawan</td>
          <td>riandul@oncom.com</td>
          <td>admin</td>
          <td>&nbsp;</td>
          <td> 15.00 pm - Jumat, 8 Agustus 2014</td>
          <td><input type="submit" name="Submit" value="EDIT" onclick="window.location.assign('user_edit.php')"/></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td>2.</td>
          <td>USer2</td>
          <td>Namamu</td>
          <td>riandul2@oncom.com</td>
          <td>user</td>
          <td nowrap="nowrap">&nbsp;</td>
          <td>12.00 pm - Jumat, 8 Agustus 2014 </td>
          <td><input type="submit" name="Submit3" value="EDIT" onclick="window.location.assign('user_edit.php')"/></td>
        </tr>
        <tr bgcolor="#eeeeee">
          <td>3.</td>
          <td>USer3</td>
          <td>Matamu</td>
          <td>riandu3l@oncom.com</td>
          <td>user</td>
          <td>&nbsp;</td>
          <td>11.00 am - Jumat, 9 Agustus 2014 </td>
          <td><input type="submit" name="Submit4" value="EDIT" onclick="window.location.assign('user_edit.php')"/></td>
        </tr>
      </table> 
    <p>Page 1 of 20 &nbsp;&nbsp;&nbsp;&lt;prev &nbsp;&nbsp;&nbsp;&nbsp;next&gt; </p>
	*/ ?>
	</div> 
</div> 
<? require_once('include/bottom.php'); ?>