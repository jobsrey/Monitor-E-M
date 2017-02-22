<? 
$arr = $contents = '';
exec("fileselectall.exe",$arr);

do { 
	$filename = $_SERVER['DOCUMENT_ROOT']."/upload/selectedfile.txt";
	$handle = fopen($filename, "r");
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	echo $contents; 
	//-- delete file
	//unlink($filename);
	
} while($arr=="Array");
 
 


 
?> 