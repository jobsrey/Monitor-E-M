<?php
class Login extends Controller { 
	function Login() {
		parent::Controller(); 
	} 
	function index() { 
		$this->load->view('login1_view',$data); 
	} 
}
