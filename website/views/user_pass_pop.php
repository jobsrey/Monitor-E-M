<? require_once('include/top.php'); ?>


<div class="container">

	<div class="lblpage" align="right">
		<div class="float_l tahoma size18"><?=$pageLABEL;?>ss</div> 
	</div> 
	
    <div class="linelbl"></div> 
  	<div id="contMenu"> 
   		<div style="clear:both"></div> 
    	<div id="dspdata"> 
      		 
			<table width="100%" border="0" cellpadding="1" cellspacing="0"> 
			<form id="form" action="<?=base_url()?>user_management/qedit" method="post"  onsubmit="return validateFormUser('form')" >
                            
         <tr>
           <td bgcolor="#999999"><table width="100%" border="0" cellpadding="8" cellspacing="0" bgcolor="#FFFFFF">
        <tr bgcolor="#5A91B1">
          <td colspan="3" nowrap>Change User Password </td>
          </tr>
        <tr valign="top" bgcolor="#FFFFFF">
          <td>Password</td>
          <td width="5">:</td>
          <td>            <span class="red">
            Enter OLD password :
                <br>
                <input name="Password" type="text" id="Password" /> 
            </span></td>
          </tr>
        <tr valign="top" bgcolor="#efefef">
          <td nowrap>&nbsp;</td>
          <td width="5">:</td>
          <td>			<span class="red"> </span>            <span class="red">Enter NEW password :<br>
              <input name="Password22" type="password" id="Password23" />
          </span><br>
            <span class="red"></span>
             
			 
						</td>
          </tr>
        <tr valign="top" bgcolor="#FFFFFF">
          <td>&nbsp;</td>
          <td width="5">:</td>
          <td>            <span class="red">
            Retype NEW password :<br>
              <input name="Password2" type="password" id="Password2" />
          </span></td>
          </tr>
        <tr valign="top" bgcolor="#efefef">
          <td>&nbsp;</td>
          <td width="5">:</td>
          <td><span class="red">
            <input type="submit" name="Submit" value="Submit" />
          </span>             
           </td>
          </tr>
        <tr valign="top" bgcolor="#efefef">
          <td colspan="3"><span class="red"> </span></td>
          </tr>
      </table> 
	  
	  
      <table width="100%" border="0" cellpadding="8" cellspacing="0" bgcolor="#FFFFFF">
        <tr bgcolor="#CCCCCC">
          <td colspan="2"><strong> User Privileges </strong></td>
        </tr>
        <tr bgcolor="#5A91B1">
          <td bgcolor="#5A91B1">Menu</td>
          <td> &nbsp;Access </td>
        </tr> 
		<?=$mainMenuTbl;?> 
      </table>
	  
	  
	  
	  
	  
	  
                        <br>
            </td>
         </tr>
            </form>
       </table>
			
			
			
			
   	 	</div>  
 
	</div> 
</div> 
<? require_once('include/bottom.php'); ?>
 