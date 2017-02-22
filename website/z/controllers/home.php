<?php  
//error_reporting(E_ALL); 
//session_start();   
class Home extends Controller { 
	function Home(){   
		parent::Controller(); 
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		$this->load->library('allfunc');  
		$this->load->database(); 
		$this->load->library('session'); 
		//if(!$this->session->userdata('logged_in')) re_direct('login','refresh');
		if(!$this->session->userdata('logged_in')){ 
			echo '<meta http-equiv="Refresh" content="0;URL=/login" />' ;  
			exit;
		}	
	} 
	function index(){  
  
     	$data['is_pop']    = 0;
     	$data['pageTITLE'] = 'TFC Web Admin';
     	$data['pageLABEL'] = 'Welcome';
		$data['navMenu']   	= $this->allfunc->navMenu(0);   
		/*  
		$newdata = array(
        'username'  => 'johndoe',
        'email'     => 'johndoe@some-site.com',
        'logged_in' => TRUE
		); 
		$this->session->set_userdata($newdata); 
		echo   $this->session->userdata('username');
		*/  
		
		//echo site_url();
		$this->load->view('main',$data);  ;
		
 
	}  
	function logout(){
	
		
		$this->session->unset_userdata();
		session_destroy();  
		//$this->session->sess_destroy();
		//re_direct('login','refresh');
		echo '<meta http-equiv="Refresh" content="0;URL=/login" />' ; 
		  
	}
	 
}
