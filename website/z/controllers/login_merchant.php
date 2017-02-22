<?php
class Login_merchant extends Controller { 

	function Login_merchant(){
		parent::Controller();
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		$this->load->library('session');
		$this->load->library('simplelogin3');
		$this->load->library('allfunc'); 
		$this->load->database();	
	}

	function index(){		 
		echo '<meta http-equiv="Refresh" content="0;URL=/login_merchant/signin" />' ; 
		//re_direct('/login_merchant/signin', 'refresh'); 
	}

	function signin(){ 
		$data['result']= '' ;
		
		$data['login_type']= 'login_merchant' ;
		
		//$this->session->userdata('USERTYPE')
		
		
		if($this->session->userdata('logged_in')){	 
			echo '<meta http-equiv="Refresh" content="0;URL=/home" />' ; 
			//re_direct('home', 'refresh');  
			//re_direct('/reporting/summary_transaction', 'refresh'); 
			//re_direct('/login_member', 'refresh');
		}else{
			if($_POST){ 
				$login = $this->input->post('username');  
				$ID = 0; 
				$Username = '';
				$Email = '';
				$goLogin = 0;					 
				$q = "select * from merchant_table Where Username = '".$login."' OR Email = '".$login."' Limit 1";
				$qlogin =  $this->db->query($q); 
				if( $qlogin->num_rows() ){
					$datalog 	= $qlogin->row_array(); 
					$ID 	  	= $datalog['ID'];  
					$Username 	= $datalog['Username'];  
					$Email 		= $datalog['Email']; 
					$GroupID	= $datalog['GroupID']; 
					$goLogin=1;
				} else {
					$data['result']='*Merchant Not Exist. <br>Please Try again!<br><br>';
				}
				
				if($goLogin){ 
					if ($this->simplelogin3->login(trim($Username),$this->input->post('password'))){ 
						//-- last login date
						$dtime = $strSignin = '';
						$q = "SELECT `datetime` From `log_merchant_action` WHERE `user_id` = '".$this->session->userdata('ID')."' And `activity` = 'logout' Order BY ID Desc LIMIT 1";
						$qdata = $this->db->query($q); 
						if($qdata->num_rows()){ 
							$userlog = $qdata->row_array(); 
							$dtime = substr($userlog['datetime'],0,strlen($userlog['datetime'])-3);
						}   
						//-- update login date  
						if(!empty($dtime)) $strSignin = "Last Login : ".$dtime." from IP : ".$_SERVER['REMOTE_ADDR'];		
						$q = "UPDATE `merchant_table` SET `SigninLog` = '".$strSignin."' WHERE `Username`= '".$Username."' LIMIT 1"; 
						$this->db->query($q);
						
						//$q = "INSERT INTO `log_admin_action` (`ID`, `datetime`, `user_id`, `activity`, `description`) 
						//VALUES ('', NOW(), '".$this->session->userdata('ID')."', 'login', 'signin from ".$_SERVER['REMOTE_ADDR']."')";						 
						//$this->db->query($q); 
						
						//--create log
//				 		$this->allfunc->createLog('user',$this->session->userdata('ID'),'login','signin from ip: '.$_SERVER['REMOTE_ADDR']);
						
						
						$newdata = array( 
							'is_merchant' => TRUE , 
							'group_name' => $this->allmodel->getGroupbyID($GroupID)				
						); 
						$this->session->set_userdata($newdata); 
 
						echo '<meta http-equiv="Refresh" content="0;URL=/login_merchant/signin" />' ; 
						//re_direct('/login_merchant/signin', 'refresh');
						//echo "xxxx";
						exit;
					}else{
						$data['result']='*NOT VALID <br>Username & Password. <br>Please Try again!';
					}
				}
			}
		}
		
		$this->load->view('login_view',$data);
		 
	}
	
	function logout(){
	 			
		//echo "logout";
		if(!$this->session->userdata('logged_in')) echo '<meta http-equiv="Refresh" content="0;URL=/login_merchant" />' ; 
		//re_direct('/login_merchant','refresh');

		//-- update logout data	
		//$q = "INSERT INTO `log_admin_action` (`ID`, `datetime`, `user_id`, `activity`, `description`) 
		//VALUES ('', NOW(), '".$this->session->userdata('ID')."', 'logout', 'logout from ".$_SERVER['REMOTE_ADDR']."')";			
 		//$this->db->query($q);  

		//--create log
// 		$this->allfunc->createLog('merchant',$this->session->userdata('ID'),'logout','logout from ip: '.$_SERVER['REMOTE_ADDR']);
 			
		$this->simplelogin3->logout();			
        echo '<meta http-equiv="Refresh" content="0;URL=/login_merchant" />' ; 
		//re_direct('/login_merchant','refresh');
	}	
 
}
