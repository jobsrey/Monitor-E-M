<?php  
//session_start();  
class Uploader extends Controller { 
	function Uploader(){   
		parent::Controller(); 
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		$this->load->library('allfunc');   
		$this->load->database();   
	} 
	function index(){  
  
     	$data['pageTITLE'] = 'Lunari Web Admin - Uploader';
		
 
		$this->load->view('uploader',$data); 
 
   
	}  
	function upload(){  
   
		 
 
   
	}  
}
