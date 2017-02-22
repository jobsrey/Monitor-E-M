<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title><?=$pageTITLE;?></title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" media="screen" href="/asset/css/main.css" /> 
<script type="text/javascript" language="javascript" src="/asset/js/jquery.js"></script>   
</head>
<body>
<table width="100%" border="0" cellpadding="1" cellspacing="1" bordercolor="#CCCCCC">
  <tr>
    <td rowspan="2" valign="bottom"><img src="/images/logo.png" width="180" height="43" /></td>
    <td rowspan="2" nowrap="NOWRAP"><br /><br />
    - Web Administrator</td>
    <td width="100%" rowspan="2" valign="bottom" nowrap="nowrap"><br /></td>
    <td height="24" align="left" valign="bottom" nowrap="nowrap">      <div align="left">Sign In as <strong><span class="style2">
        <?=$this->session->userdata('Username')?>
        </span><br />
    </strong></div></td><td rowspan="2" valign="bottom" nowrap="nowrap"><div align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div></td>
    <td valign="bottom" nowrap="nowrap"><div align="right" class="style3"><a href="/login/logout">LOGOUT</a></div></td>
    <td rowspan="2" valign="bottom" nowrap="nowrap">&nbsp;</td>
  </tr>
  <tr>
    <td valign="bottom" nowrap="NOWRAP"><span class="style1"><?=$this->session->userdata('SigninLog')?></span></td>
    <td valign="bottom" nowrap="nowrap">&nbsp;</td>
  </tr>
</table>
<div class="linetop"></div>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" bgcolor="#FFFFFF">
		<div class="lblmainmenu">MAIN MENU</div>
    	<?=$navMenu?>
	</td>
    <td width="100%" valign="top" nowrap="nowrap">&nbsp; 
	 
 
	
	
	

	</td>
  </tr>
</table> 

</body>
<script>
$(document).ready(function(){ 
	$('#cssmenu > ul > li ul').each(function(index, element){
  		var count = $(element).find('li').length;
  		var content = '<span class="cnt"> > </span>'; /*'<span class="cnt">' + count + '</span>';*/
  		$(element).closest('li').children('a').append(content); 
	}); 
	$('#cssmenu ul ul li:odd').addClass('odd');
	$('#cssmenu ul ul li:even').addClass('even'); 
	$('#cssmenu > ul > li > a').click(function() { 
		var checkElement = $(this).next(); 
		$('#cssmenu li').removeClass('active');
		$(this).closest('li').addClass('active');  
		if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
			$(this).closest('li').removeClass('active');
			checkElement.slideUp('normal');
		}
		if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
			$('#cssmenu ul ul:visible').slideUp('normal');
			checkElement.slideDown('normal');
		} 
		if($(this).closest('li').find('ul').children().length == 0) {
			return true;
		} else {
			return false; 
  		} 
	}); 
});
</script>
</html>