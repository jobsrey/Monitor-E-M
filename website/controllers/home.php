<?php  
error_reporting(E_ALL); 
//session_start();   
class Home extends Controller { 
	function Home(){   
		parent::Controller(); 
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		$this->load->library('allfunc');  
		$this->load->database(); 
		$this->load->library('session'); 
		if(!$this->session->userdata('logged_in')) redirect('login','refresh');
		  
	} 
	function index(){  
  
     	$data['is_pop']    = 0;
     	$data['pageTITLE'] = 'Lunari Web Admin';
     	$data['pageLABEL'] = 'Welcome';
		$data['navMenu']   	= $this->allfunc->navMenu(0);   
		  
		$this->load->view('main',$data);  ;
 
	}  
	 
}
