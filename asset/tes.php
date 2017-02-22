<?
$file = 'blank.gif';// 
$newfile = '\\\\server:lunari@25.100.127.173\\imagecopy\\';
if ( copy($file, $newfile) ) {
    echo "Copy success!";
}else{
    echo "Copy failed.";
}




?>
