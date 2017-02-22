<?php  
//session_start();  
class User_manage extends Controller { 
	function User_manage(){   
		parent::Controller(); 
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		$this->load->library('allfunc');  
		$this->load->library('funcdbindex'); 
		$this->load->database(); 
		$this->load->library('session'); 
		//if(!$this->session->userdata('logged_in')) re_direct('login','refresh');
		if(!$this->session->userdata('logged_in')) 
		echo '<meta http-equiv="Refresh" content="0;URL=/login" />' ; 
		  
	} 
	function index(){  
 
 		echo "Hello U"; 
	}  
	
	function mainvars($ci_func='',$status_id=1,$limit=10){  
	
		$_ci_func	= $ci_func;
		$_status_id	= $status_id;
		$_limit		= $limit;
		
		$data = $this->allfunc->reflector(__CLASS__,$ci_func); 
 
		$data['navMenu']   	= $this->allfunc->navMenu(1);  
		$data['ci_menu'] 	= $this->allfunc->navMenu(1,1);
		$data['ci_ctrl'] 	= strtolower(__CLASS__);  
     	$data['ci_func']	= $_ci_func; 
		$data['TABLE'] 		= "user_group_table";   
		$strTable 			= ucwords(str_replace("_"," ",$data['TABLE'])); 
		
     	$data['status_id'] 	= $_status_id;  
     	$data['limit'] 		= $_limit;  
		
     	$data['pageTITLE']	= ucwords(str_replace("_"," ",$data['ci_ctrl'].' - '.str_replace("table","",$strTable)));  
     	$data['pageLABEL'] 	= ucwords(str_replace("_"," ",$data['ci_menu'].' > '.str_replace("table","",$strTable)));  
 
		return $data; 

	} 
	
	//--- index group 
	function group($curpage=1,$limit=10,$status_id=1,$sort="id",$order="asc",$ci_ctrl=__CLASS__,$ci_changePage="changepagegrp",$result_id="dspdata"){  
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit);
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;
		$data = $this->indexpage($data); 
	}  
	function indexpage($data=array()){  
		$data['ci_ctrl'] = strtolower($data['ci_ctrl']);  
		$data['indexData']  = $this->funcdbindex->indexDataTable($data['ci_ctrl'],$data['ci_func'],$data['TABLE'],$data['curpage'],$data['limit'],$data['status_id'],$data['sort'],$data['order'],$data['ci_changePage'],$data['result_id']); 
		$this->load->view('index/table_data_view',$data);
	}  
	function changepagegrp($curpage,$limit,$status_id,$sort,$order,$ci_changePage,$result_id,$ci_ctrl,$ci_func,$TABLE){  
		$ci_ctrl = strtolower($ci_ctrl); 
		$data['data'] = $this->funcdbindex->indexDataTable($ci_ctrl,$ci_func,$TABLE,$curpage,$limit,$status_id,$sort,$order,$ci_changePage,$result_id); 
		$this->load->view('data_view',$data);
	} 
	
	function get_branch_data($GroupID){ 
		$groupname = $this->allmodel->getGroupbyID($GroupID) ;
		$groupdesc = $this->allmodel->getGroupbyID($GroupID,1) ; 
		echo '
			<div class="size20 bold ">'.$groupname.'</div>
          	<div style="padding:3px 0; "></div>'.$groupdesc ; 
	}
	
	//--- edit data 
	function edit_data($id,$ci_func,$is_ajax=0,$is_pop=0){  
	
		$data 				= $this->mainvars($ci_func);   
		$strTable 			= ucwords(str_replace("_"," ",$ci_func)); 
 
	 	$mode = "Edit";
		if(empty($id))$mode = "Add New"; 
     	$data['pageLABEL'] 	= $data['pageLABEL']." > $mode Data";   
 
		$data['id'] 		= $id; 
		$data['tablemod']  	= $mode; 
		$data['tablelbl']  	= $strTable; 
		$data['is_ajax']  	= $is_ajax; 
		$data['is_pop']  	= 0;//$is_pop;  
 
		//--get data db -> for non $data['TABLE']=="md_location"
		if($data['id']){
			$gData = $this->allmodel->getTableByID($data['TABLE'],$data['id']); 
			if(!empty($gData))
			foreach($gData as $key => $val){  //echo "<br>$key => $val";
			 	$data[$key] = $val; 
			} 
		}  
 
		//foreach($data as $key => $val) echo "<br>data[$key] = $val"; exit;
		if(empty($data['group_access_id'])) $data['group_access_id'] = 1;
 
		$this->load->library('funcuser');  
 		
		$data['menuAccessGrp'] = $this->funcuser->mainMenuAccessGrp($data['group_access_id']); 
		
		$data['editFormTable'] = $this->funcdbindex->editFormTable($data);
 
		$this->load->view('index/edit_data_view',$data);   
	} 
 
	function qedit(){ 
		//foreach($_POST as $k => $v) echo "<br>$k => $v";  exit; 
 		
		//echo $_POST['TABLE']; exit;
		
		//-- delete items
		if(isset($_POST['bdel'])) if($_POST['bdel']=="DELETE"){		 
			$q = "UPDATE `".$_POST['TABLE']."` SET `status_id` = 0 WHERE `id` = '".$_POST['id']."' LIMIT 1"; 
			$this->db->query($q);
			//--create log
			$this->allfunc->createLog('user',$this->session->userdata('ID'),strtolower(__CLASS__),$_POST['TABLE'].' - DEL id: '.$_POST['id']);
		    echo '<meta http-equiv="Refresh" content="0;URL=/'.strtolower(__CLASS__).'/'.$_POST['ci_func'].'/" />' ; 
			//re_direct('/'.strtolower(__CLASS__).'/'.$_POST['ci_func'].'/','refresh');  
			exit;
		}
 			
		$arrAccess = array();
		$str_group_access_id = $qstr1 = $qstr2 = $qstr3 = ''; 
		foreach($_POST as $k => $v){ //echo "<br>$k => $v"; 
				//$$k = $v; 
				
			if(substr($k,0,4)=="Prev"){  
				if($v) array_push($arrAccess,$v);  
			}else{
				$$k = $v; 
				if( 
					($k!="TABLE" && $k!="ci_func" && $k!="gid" && $k!="button" && $k!="status_id" && $v!="Submit")
				   ){ 
					$qstr1 .= "`".$k."`,";  
					
					if($k=="id") 
					$qstr2 .= "'',";
					else
					$qstr2 .= "'".$v."',";  
						
					if($k!="id")
					$qstr3 .= "`".$k."` = '".$v."',";  
				}  
			}   
		} 
		$str_group_access_id = $arrAccess = implode(",",$arrAccess);
	 
	 	if(!empty($str_group_access_id)){ 
			$qstr1 .= "`group_access_id`,";
			$qstr2 .= "'".$str_group_access_id."',"; 
			$qstr3 .= "`group_access_id`='".$str_group_access_id."',";;
		}

		if(empty($id)){ //-- add new data 
			$qstr1 = substr($qstr1,0,strlen($qstr1)-1);
			$qstr2 = substr($qstr2,0,strlen($qstr2)-1); 
			$q = "INSERT INTO `".$TABLE."` (".$qstr1.")VALUES(".$qstr2.")";
			$this->db->query($q); 
			$cid = mysql_insert_id();  
			
			//--create log
			$this->allfunc->createLog('user',$this->session->userdata('ID'),strtolower(__CLASS__),$_POST['TABLE'].' - ADD id : '.$cid);
			
		 }else{ //-- edit data
			$qstr3 = substr($qstr3,0,strlen($qstr3)-1); 
			
			$stractive = '';
			if($_POST['button']=="ACTIVATE") $stractive = ', `status_id`=1 ';
			if($_POST['TABLE']=="user_group_table"){
			
				$qstr3 = str_replace("`gid` =","`id` =",$qstr3);
				
			} //$stractive .= ', `id`= '.$_POST['gid'].' ';
			
			 
			$q = "UPDATE `".$TABLE."` SET ". $qstr3.$stractive. " WHERE `id` = ".$id." LIMIT 1"; 

			
			$this->db->query($q); 
			
			if($_POST['TABLE']=="user_group_table") 
			$cid = $gid;  
 			else 
			$cid = $id; 
			//--create log
			$this->allfunc->createLog('user',$this->session->userdata('ID'),strtolower(__CLASS__),$_POST['TABLE'].' - UPDATE id: '.$_POST['id']); 
		} 
		echo '<meta http-equiv="Refresh" content="0;URL=/'.strtolower(__CLASS__).'/edit_data/'.$cid.'/'.$ci_func.'/" />' ; 
		//re_direct('/'.strtolower(__CLASS__).'/edit_data/'.$cid.'/'.$ci_func.'/','refresh');
 
	}
	//------------------------------------------------------------------------------------------------------------------------------------------ 
 
 

 	function chgpwd($StatusID=0,$ID=0){  
	
		if($_POST){ 
			$ID = $_POST['ID'];
			$PassCur = $_POST['Password'];
			$PassNew = $_POST['PasswordNew1'];
			$PassNew2 = $_POST['PasswordNew2'];
			
			//-- chk current password
			$row['Password'] = '';
			$qData = $this->allmodel->getUserById($ID,"user_table");
			$row = $qData->row_array(); 
			if(md5($PassCur)!=$row['Password']) $err = "Wrong Enter Current Password";
			else $err = 0; 
			
			//echo md5($PassCur);
			//echo "<br>";
			//echo $row['Password'];
			//echo "<br>";
			//echo $err;  
			
			if(empty($err)){
				$q = "Update user_table Set Password = '".md5($PassNew2)."' Where `ID`= '".$ID."' Limit 1";	 
		    	$this->db->query($q); 
				
				//--create log
				 $this->allfunc->createLog('user',$this->session->userdata('ID'),'change password', 'user_id: '.$ID);
 
			} 
			$data['err'] 		= $err; 
			$data['isPOST'] 	= true;  
			
		} else {   
		 
			$data['StatusID']	= $StatusID;    
			$data['ID'] 		= $ID;    
			$data['isPOST'] 	= false;  
		
		} 
		
     	$data['pageTITLE'] 	= 'Change User Password'; 
     	$data['pageLABEL'] 	= 'Change User Password';  
		 
		$this->load->view('user/user_pass_pop',$data);
   
	} 
	
	function user_delete($del_id,$curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_changePage,$result_id){  
 
		$this->allmodel->editStatusIDUser(2,$del_id,'user_table');
		
		
		//--create log
		$this->allfunc->createLog('user',$this->session->userdata('ID'),'delete user', 'user_id: '.$del_id);
				 
 
		$data['data']=$this->indexData($curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_changePage,$result_id);
		$this->load->view('data_view',$data);
		
	}
	
	function user_edit($ID,$edit='',$error=''){  
   
     	$data['pageTITLE'] 	= 'User Management > Users'; 
     	$data['pageLABEL'] 	= 'User Management > Edit User Profile';
		if(empty($ID)) 
     	$data['pageLABEL'] 	= 'User Management > Add User '; 
		
		$data['navMenu']   	= $this->allfunc->navMenu(1);   
		$data['edit'] 		= $edit; 
		
		$data['ID'] 		= $ID; 
 
		$qData 				= $this->allmodel->getUserById($ID,"user_table");  
		
		$data['row'] 		= $qData->row_array();
 
 		//echo $data['row']['AccessID']; exit;
 
		$data['isAdmin'] 	= 0;
		if($this->session->userdata('AccessType')=='admin') $data['isAdmin'] = 1;
		
		$data['rowgrp'] 	= $this->allmodel->getTableWhere('user_group_table','',0,1,'group_access_id');  
 
		$data['StatusID'] = '';
		if(isset($data['row']['AccessID'])) $data['StatusID'] = $data['row']['StatusID'];
		
		
		
		//echo $data['row']['AccessID']; exit;
		
		if(isset($data['row']['AccessID'])){
			$userAccessID 		= $data['row']['AccessID']; 
		}else{	 
			$userAccessID 		= '';	
			$data['row'] = array(
			'ID' => '',
			'AccessType' => '',
			'Username' => '',
			'Phone' => '', 
			'FullName' => '', 
			'Comment' => '',
			'StatusID' => '',
			'GroupID' => 0,
			'Email' => '' 
			); 
			
		}  
		
		
		
		$cur_grp = 1; $strGrpAccessId = '';
		if($this->session->userdata('GroupID')>1){
			$cur_grp = $this->session->userdata('GroupID'); 
			//--group_access 
			$getGrpData = $this->allmodel->getTableByID('user_group_table',$cur_grp);  
			$strGrpAccessId = $getGrpData['group_access_id'];
  
		}
		//echo $strGrpAccessId; exit;
		
		$c_grp = $data['row']['GroupID']; 
		$getGrpData = $this->allmodel->getTableByID('user_group_table',$c_grp);
		if(isset($getGrpData['group']))
		$data['row']['group'] = $getGrpData['group'];
 
		$this->load->library('funcuser');   
 		
		//echo $data['row']['GroupID']."---".$userAccessID; exit;
 
 
		
		if($ID) 
		$data['menuAccessUsr'] = $this->funcuser->accessUserByGroup($data['row']['GroupID'],$userAccessID); 
		//$data['menuAccessUsr'] = $this->funcuser->mainMenuAccess($strGrpAccessId,$userAccessID); 
		else
		$data['menuAccessUsr'] = '';
 
		
		//foreach($data as $key => $val) echo "<br>data[$key] = $val"; exit;
		
		//$data['editFormTable'] = $this->funcdbindex->editFormTable($data);
		
 
		$this->load->view('user/user_edit',$data); 
 
   
	}  
 
	function qedit_usr(){  
   		$arrAccess = array();
		foreach($_POST as $key => $value){ //echo "<br>$key => $value";
			/*
			ID => 73
			AccessType => user
			Username => user1
			Phone =>
			Phone2 =>
			FullName => user1
			Phone3 =>
			Address =>
			Email => user1namanya@domain.co.id
			Prev-1 => 1
			Prev-2 => 0
			Prev-3 => 0
			Prev-4 => 0
			Prev-5 => 0
			Prev-6 => 0
			Prev-7 => 0
			Prev-8 => 8
			Prev-9 => 0
			Prev-10 => 10
			Submit => SUBMIT
			*/
			
			if(substr($key,0,4)=="Prev"){  //echo "<br>$key => $value"; 
				if($value) array_push($arrAccess,$value) ;
			}else{
				$$key = $value;
			} 
		}
 
		if(isset($_POST['SubmitAccess'])){
			/*
			ID => 15
			curGroupID => 4
			chgGroupID => 4
			Prev-1 => 0
			Prev-12 => 0
			Prev-13 => 0
			SubmitAccess => Update Privileges
			*/	
			
			$AccessID = implode(",",$arrAccess);
			//foreach($arrAccess as $key => $value)  echo "<br>$key => $value";
			
			$q = "Update user_table Set   
			`AccessID` = '".$AccessID."',
			ModifiedDate = '".date('Y-m-d H:i:s')."',
			ModifiedBy = '".$this->session->userdata('ID')."'  
			Where `ID`= '".$ID."' Limit 1";	 
			
			$this->db->query($q);
			
			//--create log
			//$this->allfunc->createLog('user',$this->session->userdata('ID'),'edit user privileges', 'user_id: '.$ID);
			 
			echo '<meta http-equiv="Refresh" content="0;URL=/user_manage/user_edit/'.$ID.'" />' ; 
			//re_direct('/user_manage/user_edit/'.$ID,'refresh');
			
			exit;  
			
		}
 
 
 
		//-- chg Status ID from deleted item
		$StatusIDChg = $StatusID;
		$strPasswordUpdate = '';
		if(isset($_POST['StatusIDChg'])) if($_POST['StatusIDChg']==1||$_POST['StatusIDChg']==2) { 
			$StatusID = $_POST['StatusIDChg'];
		 	$strPasswordUpdate = " Password = '".md5($Password)."', "; 
		}	 
			$AccessID = 0;
			if(count($arrAccess)>0)
			$AccessID = implode(",",$arrAccess);
		
			if(isset($GroupID)) 
				 $strGroupID = "GroupID = '".$GroupID."',"; 
			else $strGroupID = '';
			
			if(isset($AccessType)) 
				 $strAccessType = "AccessType = '".$AccessType."',";
			else $strAccessType = '';
			
		//foreach($arrAccess as $key => $value)  echo "<br>$key => $value";
 
		if(empty($_POST['ID'])){
		
			//-- default groupID is same admin group / not SU
			if(empty($GroupID)) $GroupID = $this->session->userdata('GroupID');
			
			
		
 			
			$q = "INSERT INTO `user_table` (
			`ID`, `Username`, `Password`, `FullName`, `SigninLog`, `Email`, 
			`CreatedDate`, `CreatedBy`, `ModifiedDate`, `ModifiedBy`, 
			`StatusID`, `GroupID`, `AccessID`, `AccessType`, 
			`Comment`, `Phone`
			) VALUES (
			'', '".$Username."', '".md5($Password)."', '".$FullName."', '', '".$Email."', 
			'".date('Y-m-d H:i:s')."', '".$this->session->userdata('ID')."', NULL, NULL, 
			'1', '".$GroupID."', '".$AccessID."', '".$AccessType."', 
			'".$Comment."', '".$Phone."' ) ";
			$this->db->query($q);
			$uid = mysql_insert_id();
			//--create log
			$this->allfunc->createLog('user',$this->session->userdata('ID'),'create user', 'user_id: '.$uid);
		
 
		}else{

			//-- if user limited access = > cant change username
			//$this->session->userdata('AccessType')=="user"; exit;
 
			$str_chg_user = '';
			if($this->session->userdata('AccessType')=="admin") $str_chg_user = "Username = '".$Username."',";
  
 
			$q = "Update user_table Set   
			".$str_chg_user."
			FullName = '".$FullName."',
			Comment = '".$Comment."', 
			Phone = '".$Phone."', 
			Comment = '".$Comment."',
			Email = '".$Email."',
			StatusID = '".$StatusID."',
			".$strGroupID."  
			".$strAccessType."
			".$strPasswordUpdate."
			ModifiedDate = '".date('Y-m-d H:i:s')."',
			ModifiedBy = '".$this->session->userdata('ID')."'  
			Where `ID`= '".$ID."' Limit 1";	 
			
		
			$this->db->query($q);
			
			//--create log
			$this->allfunc->createLog('user',$this->session->userdata('ID'),'edit profile', 'user_id: '.$ID);
		}
		
		if(empty($_POST['ID'])) $ID = mysql_insert_id()."/add";
		if(isset($uid)) $ID = $uid."/add";
		
		echo '<meta http-equiv="Refresh" content="0;URL=/user_manage/user_edit/'.$ID.'" />' ; 
		//re_direct('/user_manage/user_edit/'.$ID,'refresh');
   
	}  
 
	  
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//------ USER ADMIN MANAGEMENT  

	function users($curpage=1,$limit=10,$statusid=1,$sort="ID",$order="desc",$group_id=0,$ci_ctrl="user_manage",$ci_changePage="changepage",$result_id="dspdata"){  
  
     	$data['pageTITLE'] 		= 'User Management > Users'; 
     	$data['pageLABEL'] 		= 'User Management > Users';
		$data['navMenu']   		= $this->allfunc->navMenu(1);  
		$data['limit'] 			= $limit;
		$data['statusid'] 		= $statusid;
		$data['sort'] 			= $sort;
		$data['order'] 			= $order;
		$data['ci_ctrl'] 		= $ci_ctrl;
		$data['ci_changePage']	= $ci_changePage;
		$data['result_id'] 		= $result_id;
 
		$data['group_id'] 		= $group_id;

		$data['rowgrp'] 		= $this->allmodel->getTableWhere('user_group_table','',0,1,'group_access_id');  

		//$this->session->userdata('GroupID');

		$data['indexData']  = $this->indexData($curpage,$limit,$statusid,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id);
 
		$this->load->view('user/users',$data); 

	}
	
	function indexData($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id){ 
 
		if($order=="asc") $orderO="desc";
		elseif($order=="desc") $orderO="asc";
		 
		$content=$disableAll='';
		
		$start=($curpage*$limit)-$limit;
  
		if($start >= 0){
 
			$qData=$this->allmodel->selectUser($start,$limit,$status_id,$sort,$order,$group_id,"user_table"); 
			
			if($qData->num_rows()){ 
				$col1 = "#ffffff";
				$col2 = "#f6f6f6";
				$col3 = "#FFDDFF";
				
				//$this->allfunc->isAdmin();
				 
				if($this->session->userdata('AccessType')=='admin') $disableAll = ''; 
				if($this->session->userdata('AccessType')=='user')  $disableAll = ' disabled="disabled" '; 
				 
				 $content.=
						'<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#bbbbbb">
						<thead>
							<tr bgcolor="#666666" class="">
							  <td align="center" class="lightgrey" >No.</td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/users/1/'.$limit.'/'.$status_id.'/GroupID/'.$orderO.'/'.$group_id.'\')">Group</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/users/1/'.$limit.'/'.$status_id.'/AccessType/'.$orderO.'/'.$group_id.'\')">Access Type</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/users/1/'.$limit.'/'.$status_id.'/Username/'.$orderO.'/'.$group_id.'\')">Username</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/users/1/'.$limit.'/'.$status_id.'/Fullname/'.$orderO.'/'.$group_id.'\')">Name</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/users/1/'.$limit.'/'.$status_id.'/Phone/'.$orderO.'/'.$group_id.'\')">Phone</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/users/1/'.$limit.'/'.$status_id.'/Email/'.$orderO.'/'.$group_id.'\')">Email</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/users/1/'.$limit.'/'.$status_id.'/SigninLog/'.$orderO.'/'.$group_id.'\')">Last Login</a></td>
							  <td align="center" class="lightgrey" >Edit</td> 
							  <td align="center" class="lightgrey" >Delete</td>  
							</tr>
						</thead>
						<tbody>';
 
				$x=$start+1;
				foreach($qData->result_array() as $row){
					$n = fmod($x,2);
 
 					//-- format time las login
					if(!empty($row['SigninLog'])){
						$dt = substr($row['SigninLog'],13,10); 
						$tm = substr($row['SigninLog'],24,5);  
						$fdatetime = $this->allfunc->formatDateTime($dt." ".$tm,4);
					}else $fdatetime = '';
					
					if($n) $clr = $col1;
					else  $clr = $col2;
					
					$disable  = $disableAll;
					$disable2 = $disableAll; 
					
					$is_del = 0;
					if($row['Username']==$this->session->userdata('Username')){
						$clr = $col3; 
						$disable = ''; 
						$disable2 = ''; 
						$is_del = 1;
					} 
					if( $row['AccessType']=='user' && $this->session->userdata('AccessType')=='user')  $disable2 = ' disabled="disabled" '; 
					
					if( $row['AccessType']=='admin') 	 $strAccessType =  "Super User";
					elseif( $row['AccessType']=='user'){
						$strAccessType = "Admin";
						
						$this->load->library('funcuser'); 
 						if($this->funcuser->chkFinanceAccess($row['ID'])) $strAccessType = "Finance" ;
						
					}
					
					$getGroup = $this->allmodel->getTableByID('user_group_table',$row['GroupID']);
					
					$grp = $row['GroupID'];
					//echo $getGroup['group'];
					
					if(empty($getGroup['group']))  $strGroupID =  "";
					else $strGroupID = $getGroup['group'];
					
					
					//if(
					//	(($this->session->userdata('AccessType')=="user")&&($this->session->userdata('ID')==$row['ID']))
					//	or
					//	($this->session->userdata('AccessType')=="admin")
						
					//){ //&& $strAccessType=="User"
					
					$content.='<tr bgcolor="'.$clr.'">
					  <td align="right">'.$x.'.&nbsp;</td>
					  <td>'.$strGroupID.'</td>
					  <td>'.$row['AccessType'].'</td>
					  <td><strong>'.$row['Username'].'</strong></td>
					  <td>'.$row['FullName'].'</td>
					  <td>'.$row['Phone'].'</td>
					  <td>'.$row['Email'].'</td>
					  <td nowrap="nowrap">'.$fdatetime.'</td>
					  <td align="center" >';
					  
					  $x++;
					  
					//}
					  
					if(
					$this->session->userdata('ID')==1 || 
					$this->session->userdata('ID')==2 || 
					$this->session->userdata('ID')==$row['ID'] || 
					$this->session->userdata('AccessType')=='super_user'
					)   
					$content.='<input '.$disable.' type="button" name="EDIT" value="EDIT" onclick="window.location.assign(\''.base_url().$ci_ctrl.'/user_edit/'.$row['ID'].'\')"/>';
					
					$content.='</td>';
					$content.='<td align="center" >';
					
					if($this->session->userdata('ID')==1 || $this->session->userdata('ID')==2 || $this->session->userdata('AccessType')=='super_user'){   
					
						if($status_id!=2 && !$is_del) 
						$content.='<input '.$disable2.' type="submit" name="DEL" value="DEL" onclick="confirmdelete(\''.base_url().$ci_ctrl.'/user_delete/'.$row['ID'].'/'.$curpage.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$group_id.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'/'.$group_id.'\',\''.$result_id.'\')"/>';
					}
					
					$content.='</td>'; 
					$content.='</tr>'; 
					
				}	 
			}
		}
		$content.='</tbody>';
		$content.='</table>';		
		 
		$content.=$this->pagenav($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id);
		
		return $content;
	} 
	
	function pagenav($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id){
 
		$cData=$this->allmodel->countUser($status_id,'user_table',$group_id); 
		 
		$var='<div class="pagenave">';
		if($cData->num_rows()){
			$tempData=$cData->result_array();
			$totalData=$tempData[0]['count'];
			$totalPage=ceil($totalData/$limit);
			
			if(($curpage-1)>0){
				$prev=($curpage-1);
			}else{
				$prev=$curpage;
			}
			if(($curpage+1) < $totalPage){
				$next=($curpage+1);
			}else{
				$next=$totalPage;
			} 
	 		$var.='<table width="100%" cellpadding="0" cellspacing="5" border="0">
			  		<tr>';
					
			$var.='		<td nowrap="nowrap" style="border-right:1px dotted grey">';
				$var.='<a href="javascript:void(0);loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/'.$prev.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$group_id.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'\',\''.$result_id.'\')"><img src="/asset/icons/arrow_left.gif" width="16" height="16" />prev</a>';
				$var.='&nbsp; &nbsp;'; 
				$var.='<a href="javascript:void(0);loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/'.$next.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$group_id.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'\',\''.$result_id.'\')">next<img src="/asset/icons/arrow_right.gif" width="16" height="16" /></a>';
				$var.='&nbsp; &nbsp;'; 
			
			$var.='		</td>';
				
			$var.='		<td width="100%" nowrap="nowrap" >';
							$var.='&nbsp; &nbsp;Page: <select name="page" id="page" onchange="loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/\'+$(this).val()+\'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$group_id.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'\',\''.$result_id.'\')">'; 
				for($i=1;$i<=$totalPage;$i++){ 
					$var.='<option value="'.$i.'"';
					if($curpage==$i){
						$var.=' selected';
					}
					$var.='>'.$i.'</option>';
				}
				$var.='</select>';
				$var.=' of <b>'.$totalPage.'</b> pages ';			
				$var.='&nbsp;-&nbsp; Total <strong>'.$totalData.'</strong> records found.';
			$var.='		</td>';  
			$var.='		<td align="right" nowrap="nowrap" >';
				$var.='Show <select name="view" id="view" onchange="loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/1/\'+$(this).val()+\'/'.$status_id.'/'.$sort.'/'.$order.'/'.$group_id.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'\',\''.$result_id.'\')" >';
				$arrView=array(10,20,50,100);
				foreach($arrView as $val){ 
					$var.= '<option value="'.$val.'"';  
					if($limit==$val){
						$var.=' selected';
					}
					$var.='>'.$val.'</option>';  
				}
				$var.='</select> item/page';
			$var.='		</td>'; 
			$var.='	</tr> 
				   </table>';  
		}
		$var.='</div>';
		return $var;
	} 
	function changepage($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id){	 
		$data['data']=$this->indexData($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id);
		$this->load->view('data_view',$data);
	} 
}
