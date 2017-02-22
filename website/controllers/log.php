<?php  
//session_start();  
class Log extends Controller { 
	function Log(){   
		parent::Controller(); 
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		$this->load->library('allfunc');   
		$this->load->database();   
	} 
	function index(){  
  
     	$data['pageTITLE'] = 'Lunari Web Admin - Trace Log Viewer';
		 
		$data['getLogs'] = $this->allfunc->getLogs(); 
		 
		$this->load->view('trace_log_viewer',$data); 
 
   
	}  
	 
}
