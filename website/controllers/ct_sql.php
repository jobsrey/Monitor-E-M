<?php  
//session_start(); 
class Ct_sql extends Controller {  

	function Ct_sql()   
	{ 
		parent::Controller();   
		$this->load->helper('url');  		
		//$this->load->model('allmodel'); 
		//$this->load->library('allfunc');  
		$this->load->database();  
	} 
	
	function index(){  
		
		//-- chk new chk file : /upload/chk_terminal/*.txt
		$arrFileDBox = array();
		$pathSource  = $_SERVER['DOCUMENT_ROOT']."/upload/chk_terminal/";
		$arrFileSQL  = glob($pathSource."/*.txt"); 
		
		foreach ($arrFileSQL as $sqlfile) { 
			//echo "<br>-- source file : ".$val ;  
			//-- open file 
			$q = file_get_contents($sqlfile,true);
			$qData = $this->db->query($q); 
			
			//-- del file src
			unlink($sqlfile);
				
		}	 
		 
	}  
	   
} 