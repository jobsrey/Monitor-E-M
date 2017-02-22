<? require_once('include/top.php'); ?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
<script>
function slcmenu(url){  
	window.location.assign(url);
}
</script>
<div class="container"> 
  <div class="lblpage" align="right"> 
    <div class="float_l tahoma size18"> 
      <?=$pageLABEL;?> 
    </div> 
    <div class="float_r arial12 grey9"> </div> 
  </div> 
  <div class="linelbl"></div> 
  <div id="contMenu"> 
    <div style="clear:both"></div> 
    <table border="0" cellpadding="0" cellspacing="0"> 
      <tr> 
        <td> <table width="100%" border="0" cellpadding="1" cellspacing="10"> 
            <tr> 
              <td><strong>Select Media Files</strong> :
                <select name="selecttype" id="selecttype"  onchange="slcmenu('/terminal_tools/media_database/'+encodeURIComponent($('select#selecttype').val())+'/'+$('select#selectstatus').val())" >
                  <option value="video" <? if($type=='video') echo 'selected';?>>Video</option>
             <? /*     <option value="image" <? if($type=='image') echo 'selected';?>>Image</option> */ ?>
                  <option value="patch" <? if($type=='patch') echo 'selected';?>>Patch</option>
                  <option value="0" <? if($type=='0') echo 'selected';?>>All</option> 
                </select></td> 
              <td align="right">Status :
                <select name="selectstatus" id="selectstatus"   onchange="slcmenu('/terminal_tools/media_database/'+$('select#selecttype').val()+'/'+$('select#selectstatus').val())" >
                  <option value="1" <? if($status_id=='1') echo 'selected';?>>Active</option>
                  <option value="0" <? if($status_id=='0') echo 'selected';?>>Delete</option> 
                </select></td> 
            </tr> 
          </table> 
          <div id="dspdata"> 
		  <?=$indexData;?>
		  <? /*  bgcolor="#cccccc"bgcolor="#eeeeee"
            <table width="100%" border="0" cellpadding="1" cellspacing="0"> 
              <tr> 
                <td bgcolor="#666666"><table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF"> 
                    <tr bgcolor="#666666"> 
                      <td bgcolor="#666666"><span class="style1">No.</span></td> 
                      <td bgcolor="#666666"><span class="style1">Title</span></td> 
                      <td><span class="style1">File</span></td> 
                      <td><span class="style1">Size</span></td> 
                      <td><span class="style1">Dimension</span></td> 
                      <td><span class="style1">Durasi</span></td> 
                      <td nowrap="nowrap" bgcolor="#666666"><span class="style1">Created Date </span></td> 
                      <td nowrap="nowrap" bgcolor="#666666"><span class="style1">Created By</span></td> 
                      <td align="center" nowrap="NOWRAP" bgcolor="#666666"><span class="style1">Status </span></td> 
                      <td colspan="2" align="center" nowrap="NOWRAP" bgcolor="#666666"><span class="style1">Edit</span></td> 
                    </tr> 
                    <tr bgcolor="#CCCC66"> 
                      <td bgcolor="#CCCC66"><div align="right">1.</div></td> 
                      <td nowrap="nowrap" bgcolor="#CCCC66"><input name="textfield2" type="text" value="VId-Promo-eMoney-Mandiri" size="30" /></td> 
                      <td nowrap="nowrap">xxx.mp4</td> 
                      <td nowrap="nowrap">30Mb</td> 
                      <td nowrap="nowrap">320x240px</td> 
                      <td nowrap="nowrap">3 menit</td> 
                      <td nowrap="nowrap" bgcolor="#CCCC66">2014-11-09 00:00:00<br /> </td> 
                      <td nowrap="nowrap" bgcolor="#CCCC66">Admin</td> 
                      <td align="center" bgcolor="#CCCC66">Active</td> 
                      <td width="100%" align="center" bgcolor="#CCCC66"><input type="button" name="Button2" value="SAVE" onclick="window.location.assign('user_edit.php')"/></td> 
                      <td width="100%" align="center" bgcolor="#CCCC66"> <input type="button" name="Button" value="DEL" onclick="window.location.assign('user_edit.php')"/> </td> 
                    </tr>  
                  </table></td> 
              </tr> 
            </table> 
			*/ ?>
          </div> 
		  
        </td> 
      </tr> 
    </table> 
    <br>
    <hr size="1" />
    <br> 
	<table width="100%" border="0" cellpadding="0" cellspacing="0"> 
            <form action="/terminal_tools/uploadmedia" method="post" enctype="multipart/form-data"  > 
              <tr> 
                <td><table border="0" cellpadding="8" cellspacing="0"> 
                    <tr bgcolor="#FFFFFF">
                      <td colspan="2" nowrap="nowrap"><strong>&nbsp;&nbsp;Add to Media Database</strong></td>
                    </tr>
                    <tr bgcolor="#dddddd"> 
                      <td nowrap="nowrap"><p>Type</p></td> 
                      <td nowrap="nowrap" bgcolor="#dddddd"><select name="slcTipe" id="select" >
                          <option value="" <? if($type=='0') echo 'selected';?>>Pilih Media:</option>
                          <option value="video" <? if($type=='video') echo 'selected';?>>Video</option>
                          <option value="image" <? if($type=='image') echo 'selected';?>>Image</option>
                          <option value="patch" <? if($type=='patch') echo 'selected';?>>Patch</option>
                        </select></td>
                    </tr>   
                    <tr bgcolor="#efefef"> 
                      <td nowrap="nowrap">Title </td> 
                      <td nowrap="nowrap"><input name="txtTitle" type="text" size="30" /></td> 
                    </tr>
                    <tr bgcolor="#dddddd">
                      <td nowrap="nowrap">File</td>
                      <td nowrap="nowrap"><input type="file" name="file" /></td>
                    </tr>
                    <tr bgcolor="#999999">
                      <td nowrap="nowrap">&nbsp;</td>
                      <td nowrap="nowrap"><input name="uploadvideo" type="submit" id="uploadvideo"  value="Upload" /></td>
                    </tr> 
                  </table></td> 
              </tr> 
            </form> 
    </table>
  </div> 
</div> 
<? require_once('include/bottom.php'); ?> 
