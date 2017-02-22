<?php  
//session_start();  
class Media extends Controller { 

	function Media(){   
		parent::Controller(); 
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		$this->load->library('allfunc');   
		$this->load->database();   
	} 

	function index(){  
  
     	$data['pageTITLE'] = 'Lunari Web Admin - Media';
		 
		$this->load->view('uploader',$data);  
   
	} 
	 
	function listdata($type=0,$statusid=1){  
 
     	$data['pageTITLE'] = 'Lunari Web Admin - List Media';
		 
		$this->load->view('uploader',$data); 
 
	}  
}
