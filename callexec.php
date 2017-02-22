<p><br />
    <a href="?print=now">PRINT-CARD NOW</a><br />
  </p>
<p>jika diklik, akan membuka software photoshop.exe di : C:\Program Files\Adobe\Photoshop CS\Photoshop.exe</p>
<p><br />
<?php 
if(isset($_GET['print']))
if($_GET['print']=="now"){   
	$argument = '';
	exec("C:\Program Files\Adobe\Photoshop CS\Photoshop.exe $argument");  
}
?>
----------------------------------------------------------</p>
<p>&lt;?php <br />
  if(isset($_GET['print']))<br />
  if($_GET['print']==&quot;now&quot;){ <br />
$argument = '';<br />
exec(&quot;C:\Program Files\Adobe\Photoshop CS\Photoshop.exe $argument&quot;); <br />
}<br />
?&gt;</p>
<p>----------------------------------------------------------</p>
