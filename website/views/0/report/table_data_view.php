<? require_once('include/top.php'); ?>

<link rel="stylesheet" href="/asset/css/jquery-ui-1.9.2.css" />    
<script type="text/javascript" language="javascript" src="/asset/js/jquery-ui-1.9.2.js"></script>
<script> $(function() { $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' }); }); </script>
<script> $(function() { $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' }); }); </script>

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
        <form action="<?=base_url()?><?=$ci_ctrl?>/<?=$ci_func?>/" method="post">
        <table>
          <tr>
            <td colspan="10">Select Report  by:</td>
          </tr>
          <tr> 
            <td>Owner : </td>
            <td> <?=$listmenu_0;?>
            <? /*
 				<select name="<?=$mselect?>" id="<?=$mselect?>" onchange="loadcontent('<?=base_url()?><?=$ci_ctrl?>/getlist/<?=$mtable?>/<?=$mlistname?>/<?=$mstatus_id?>/<?=$mselect?>/'+$('select#<?=$mselect?>').val()+'/<?=$mselected?>/<?=$mresult_id?>','<?=$mresult_id?>')">  
					<option value="0" selected="selected">All</option>
                <? // $table,$listname,$status_id,$where_key,$where_val,$selected,$result_id,$firstitem 
				  foreach($owner_idx as $key => $arr){ ?>
                	<option value="<?=$arr['id'];?>" <? if($owner_id==$arr['id']) echo 'selected="selected"' ?> ><?=$arr['name'];?></option>
                <? } ?>  
                </select>
                */ ?>
				
			</td> 
            <td width="11"></td>
            <td>Terminal : </td>
            <td><div id="vmlist"><?=$listmenu_1;?></div></td>
             
            <td width="11">&nbsp;</td>
            <td>Date : </td>
            <td><div class="ibDtPict">
			
			<input name="t1" type="text" id="datepicker" value="<?=$dl1?>" maxlength="12">
			-
			<input name="t2" type="text" id="datepicker2" value="<?=$dl2?>" maxlength="12">
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
      		<?=$indexData?> 
   	 	</div>  
	</div> 
	<!-- /pageContent -->
    
</div> 
<? require_once('include/bottom.php'); ?>