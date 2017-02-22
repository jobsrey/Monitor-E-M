<?php  
//session_start();  
class Kirim extends Controller { 
	function Kirim(){   
		parent::Controller(); 
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		$this->load->library('allfunc');   
		$this->load->database();   
	} 
	function index(){  
   /*
		$file = $_SERVER['DOCUMENT_ROOT'].'/blank.gif';// 
		
		echo $newfile = '\\\\PCKIOSK\imagecopy\\'.'blank.gif';
		
		if ( copy($file, $newfile) ) {
			echo "Copy success!";
		}else{
			echo "Copy failed.";
		}
*/
   
	}   
	function fname($src='',$type=''){  
   		
		$src = str_replace("yyyyy",":",$src);
		$src = str_replace("xxxxx","\\",$src);
		$src = str_replace("zzzzz"," ",$src);
		//echo $src; exit;
		
		if($type=="img")   { exec("d:/xampp/htdocs/upload/copyimg.exe");	echo "Send Image to Kiosk...."; }
		if($type=="mov")   { exec("d:/xampp/htdocs/upload/copymov.exe");	echo "Send Movie to Kiosk...."; }
		if($type=="patch") { exec("d:/xampp/htdocs/upload/copypat.exe");	echo "Send Patch to Kiosk...."; }
		
		
		
		//$handle = fopen($filename, "r");
		//$contents = fread($handle, filesize($filename));
		//fclose($handle);
		//echo $contents; 
		
		//-- delete file
		$filename = $_SERVER['DOCUMENT_ROOT']."/upload/selectedfile.txt";
		unlink($filename);
		
		
		redirect('terminal_tools', 'refresh'); 
	
		/*
		
		$file = $src; //$_SERVER['DOCUMENT_ROOT'].'/blank.gif';// 
		
		//$newfile = '\\\\PCKIOSK\imagecopy\\'.'blank.gif';
		$newfile = '\\\\PCKIOSK\imagecopy\\'.'blank.gif';
		 
		if ( copy($file, $newfile) ) {
			echo "Copy success!";
		}else{
			echo "Copy failed.";
		}
 
   */
	} 
	
}
?>