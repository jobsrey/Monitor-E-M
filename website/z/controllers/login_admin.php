<?php
class Login_admin extends Controller { 

	function Login_admin() {
		parent::Controller();
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		$this->load->library('session');
		$this->load->library('simplelogin');
		$this->load->library('allfunc'); 
		$this->load->database();	
		 
	}
	
	function index() {		 
		//re_direct('/login_admin/signin', 'refresh'); 
		//echo "www"; exit; 
		echo '<meta http-equiv="Refresh" content="0;URL=/login_admin/signin" />' ; 
		
	}
	
	function signin() { 
 
		$data['result']= '' ;
		
		$data['login_type']= 'login_admin' ;
		
		if($this->session->userdata('logged_in')){	  
			//re_direct("/", 'refresh'); 
			echo '<meta http-equiv="Refresh" content="0;URL=/" />' ; 
			//echo "xxx"; exit;
			
		}else{
			
			//echo "yyy"; exit;
 
			if($_POST){ 
				$login = $this->input->post('username');  
				$ID = 0; 
				$Username = '';
				$Email = '';
				$goLogin = 0;					 
				//$q = "select * from user_table Where Username = '".$login."' OR Email = '".$login."' Limit 1";
				$q = "select * from user_table Where ( Username = '".$login."' OR Email = '".$login."' ) And StatusID='1' Limit 1";
				
				$qlogin =  $this->db->query($q); 
				if( $qlogin->num_rows() ){
					$datalog 	= $qlogin->row_array(); 
					$ID 	  	= $datalog['ID'];  
					$Username 	= $datalog['Username'];  
					$Email 		= $datalog['Email']; 
					$goLogin=1;
				} else {
					$data['result']='*User Not Exist. <br>Please Try again!<br><br>';
				}
				if($goLogin){ 
					if ($this->simplelogin->login(trim($Username),$this->input->post('password'))){ 
						//-- last login date
						$dtime = $strSignin = '';
						$q = "SELECT `datetime` From `log_admin_action` WHERE `user_id` = '".$this->session->userdata('ID')."' And `activity` = 'logout' Order BY ID Desc LIMIT 1";
						$qdata = $this->db->query($q); 
						if($qdata->num_rows()){ 
							$userlog = $qdata->row_array(); 
							$dtime = substr($userlog['datetime'],0,strlen($userlog['datetime'])-3);
						}   
						//-- update login date  
						if(!empty($dtime)) $strSignin = "Last Login : ".$dtime." from IP : ".$_SERVER['REMOTE_ADDR'];		
						$q = "UPDATE `user_table` SET `SigninLog` = '".$strSignin."' WHERE `Username`= '".$Username."' LIMIT 1"; 
						$this->db->query($q);
						
						//$q = "INSERT INTO `log_admin_action` (`ID`, `datetime`, `user_id`, `activity`, `description`) 
						//VALUES ('', NOW(), '".$this->session->userdata('ID')."', 'login', 'signin from ".$_SERVER['REMOTE_ADDR']."')";						 
						//$this->db->query($q); 
						
						//--create log
				 		$this->allfunc->createLog('user',$this->session->userdata('ID'),'login','signin from ip: '.$_SERVER['REMOTE_ADDR']);
						
						//re_direct('login_admin/signin', 'refresh'); 
						echo '<meta http-equiv="Refresh" content="0;URL=/login_admin/signin" />' ; 
						//echo "xxxx";
						exit;
					}else{
						$data['result']='*NOT VALID <br>Username & Password. <br>Please Try again!';
					}
					
					 
				}
			}
		}
		
		$this->load->view('login_admin_view',$data);
		 
	}
	
	function logout() { 			
		//echo "logout";
		if(!$this->session->userdata('logged_in')) 
		echo '<meta http-equiv="Refresh" content="0;URL=/login_admin" />' ; 
		//re_direct('login_admin','refresh');
		
		//-- update logout data	
		//$q = "INSERT INTO `log_admin_action` (`ID`, `datetime`, `user_id`, `activity`, `description`) 
		//VALUES ('', NOW(), '".$this->session->userdata('ID')."', 'logout', 'logout from ".$_SERVER['REMOTE_ADDR']."')";			
 		//$this->db->query($q);  
		
		//--create log
 		$this->allfunc->createLog('user',$this->session->userdata('ID'),'logout','logout from ip: '.$_SERVER['REMOTE_ADDR']);
						
						
		$this->simplelogin->logout();			
        echo '<meta http-equiv="Refresh" content="0;URL=/login_admin" />' ; 
		//re_direct('/login_admin','refresh');
	}	
 
}
