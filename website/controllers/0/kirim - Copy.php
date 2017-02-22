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
   
		echo $file = $_SERVER['DOCUMENT_ROOT'].'blank.gif';// 
		exit;
		$newfile = '\\\\server:lunari@25.100.127.173\\imagecopy\\';
		if ( copy($file, $newfile) ) {
			echo "Copy success!";
		}else{
			echo "Copy failed.";
		}

   
	}   
	
}
?>