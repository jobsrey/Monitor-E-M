<?php  
//session_start(); 
//error_reporting(E_ALL ^ E_NOTICE);
 
class Sim extends Controller { 
	function Sim(){    
		parent::Controller(); 
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		$this->load->library('allfunc'); 
		$this->load->library('funcdbindex');  
		$this->load->database();  
		  
	} 
	function index() { 
		$this->load->view('sim1_view',$data); 
	} 

}
