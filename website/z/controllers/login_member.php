<?php
class Login_member extends Controller { 

	function Login_member(){
		parent::Controller();
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		$this->load->library('session');
		$this->load->library('simplelogin2');
		$this->load->library('allfunc'); 
		$this->load->database();	
	}

	function index(){		 
		echo '<meta http-equiv="Refresh" content="0;URL=/login_member/signin" />' ; 
		//re_direct('/login_member/signin', 'refresh'); 
	}

	function signin(){ 
		$data['result']= '' ;
		
		$data['login_type']= 'login_member' ;
		
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
				$q = "select * from member_table Where Username = '".$login."' OR Email = '".$login."' Limit 1";
				$qlogin =  $this->db->query($q); 
				if( $qlogin->num_rows() ){
					$datalog 	= $qlogin->row_array(); 
					$ID 	  	= $datalog['ID'];  
					$Username 	= $datalog['Username'];  
					$Email 		= $datalog['Email']; 
					$GroupID	= $datalog['GroupID']; 
					$goLogin=1;
				} else {
					$data['result']='*Member Not Exist. <br>Please Try again!<br><br>';
				}
				
				if($goLogin){ 
					if ($this->simplelogin2->login(trim($Username),$this->input->post('password'))){ 
						//-- last login date
						$dtime = $strSignin = '';
						$q = "SELECT `datetime` From `log_member_action` WHERE `user_id` = '".$this->session->userdata('ID')."' And `activity` = 'logout' Order BY ID Desc LIMIT 1";
						$qdata = $this->db->query($q); 
						if($qdata->num_rows()){ 
							$userlog = $qdata->row_array(); 
							$dtime = substr($userlog['datetime'],0,strlen($userlog['datetime'])-3);
						}   
						//-- update login date  
						if(!empty($dtime)) $strSignin = "Last Login : ".$dtime." from IP : ".$_SERVER['REMOTE_ADDR'];		
						$q = "UPDATE `member_table` SET `SigninLog` = '".$strSignin."' WHERE `Username`= '".$Username."' LIMIT 1"; 
						$this->db->query($q);
						
						//$q = "INSERT INTO `log_admin_action` (`ID`, `datetime`, `user_id`, `activity`, `description`) 
						//VALUES ('', NOW(), '".$this->session->userdata('ID')."', 'login', 'signin from ".$_SERVER['REMOTE_ADDR']."')";						 
						//$this->db->query($q); 
						
						//--create log
//				 		$this->allfunc->createLog('user',$this->session->userdata('ID'),'login','signin from ip: '.$_SERVER['REMOTE_ADDR']);
						
						
						$newdata = array( 
							'is_member' => TRUE , 
							'group_name' => $this->allmodel->getGroupbyID($GroupID)				
						); 
						$this->session->set_userdata($newdata); 
 
						echo '<meta http-equiv="Refresh" content="0;URL=/login_member/signin" />' ; 
						//re_direct('/login_member/signin', 'refresh');
						//echo "xxxx";
						//exit;
					}else{
						$data['result']='*NOT VALID <br>Username & Password. <br>Please Try again!';
					}
				}
			}
		}
		
		$this->load->view('login_view',$data);
		 
	}
	
	function logout() { 			
		//echo "logout";
		if(!$this->session->userdata('logged_in')) echo '<meta http-equiv="Refresh" content="0;URL=/login_member" />' ; 
		//re_direct('/login_member','refresh');
		
		//-- update logout data	
		//$q = "INSERT INTO `log_admin_action` (`ID`, `datetime`, `user_id`, `activity`, `description`) 
		//VALUES ('', NOW(), '".$this->session->userdata('ID')."', 'logout', 'logout from ".$_SERVER['REMOTE_ADDR']."')";			
 		//$this->db->query($q);  
		
		//--create log
 		$this->allfunc->createLog('member',$this->session->userdata('ID'),'logout','logout from ip: '.$_SERVER['REMOTE_ADDR']);
						
						
		$this->simplelogin2->logout();			
        echo '<meta http-equiv="Refresh" content="0;URL=/login_member" />' ; 
		//re_direct('/login_member','refresh');
	}	
 
}
