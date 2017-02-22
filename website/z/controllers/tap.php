<?php  
//session_start(); 
//error_reporting(E_ALL ^ E_NOTICE);
  
class Tap extends Controller { 
	function Tap(){    
		parent::Controller(); 
		//$this->load->helper('url'); 
		//$this->load->model('allmodel'); 
		//$this->load->library('allfunc'); 
		//$this->load->library('funcdbindex');  
		//$this->load->database();  
		  
	} 
	function index() { 
		$this->load->view('tap_view',$data); 
	} 

}
