<?php  
//session_start(); 
error_reporting(E_ALL ^ E_NOTICE);
 
class Reporting extends Controller { 
	function Reporting(){   
		parent::Controller(); 
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		$this->load->library('allfunc'); 
		$this->load->library('funcreport');  
		$this->load->database(); 
		$this->load->library('session'); 
		//if(!$this->session->userdata('logged_in')) redirect('login','refresh');
		  
	} 
	function index(){ 
 		echo "Hello U"; 
	} 
	
	function mainvars($ci_func='',$status_id=1,$limit=10){  
		
		$data = $this->allfunc->reflector(__CLASS__,$ci_func); 
	
		//$limit = 2; //-- for test
 
		$data['navMenu']   	= $this->allfunc->navMenu(11);  
		$data['ci_menu'] 	= $this->allfunc->navMenu(11,1);
		$data['ci_ctrl'] 	= strtolower(__CLASS__);  
     	$data['ci_func']	= $ci_func; 
		$data['TABLE'] 		= $ci_func;   
		$strTable 			= ucwords(str_replace("_"," ",$data['TABLE'])); 
		
     	$data['status_id'] 	= $status_id;  
     	$data['limit'] 		= $limit;  
		
     	$data['pageTITLE']	= ucwords(str_replace("_"," ",$data['ci_ctrl'].' - '.str_replace("Md ","",$strTable)));  
     	$data['pageLABEL'] 	= ucwords(str_replace("_"," ",$data['ci_menu'].' > '.str_replace("Md ","",$strTable)));  
		 
 
 		return $data;   

	} 
 
 
	function card_transaction($curpage=1,$limit=10,$status_id=1,$sort="id",$order="asc",$ci_ctrl="",$ci_changePage="changepage",$result_id="dspdata",$dt="",$dt2=""){  

		$data['owner_id'] = $owner_id = '1';
 
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit); 
		//foreach($data as $k => $val) echo "<br>$k => $val"; exit; 
		
		if($_POST){ 
			foreach($_POST as $k => $val){ //echo "<br>$k => $val"; exit; 
				$$k = $val;
				$data[$k] = $val; 
			}
		/*
		owner_id => 1
		vmid => 0
		t1 => 2014-10-10
		t2 => 2014-10-10
		button => Submit
		*/
			
		} 
 
		$data['TABLE'] 		= "trx"; 
		$data['mselect'] 	= "owner_id"; 
		$data['mtable'] 	= "vending_terminal"; 
		
		$data['mlistname']	= "vmid"; 
		$data['mstatus_id'] = "1"; 
		
		$data['mwhere_key'] = "vmid";
		$data['mwhere_val'] = 1;
		
		$data['mselected']  = "0";
		$data['mresult_id'] = "vmlist";
		$data['mfirstitem'] = array(0=>"All");
		
		$data['listmenu_1'] = '';//$this->allfunc->listmenu($data['mtable'],$data['mlistname'],$data['mstatus_id'],$data['mwhere_key'],$data['mwhere_val'],$data['mselected'],$data['mresult_id'],$data['mfirstitem']); 
 
		
		if(empty($dt))  $data['dt']  = date("Y-m-d"); else $data['dt']  = $dt;  
		if(empty($dt2)) $data['dt2'] = date("Y-m-d"); else $data['dt2'] = $dt2;   
		$data['dl1']		= $data['dt'];  
		$data['dl2']		= $data['dt2'];  
		
		$data['owner_idx']	= $this->allmodel->getMDdata("md_terminal_owner",0,'$owner_id');  
 
		$data['indexData']  = '';//$this->funcreport->indexDataTable($data['ci_ctrl'],$data['ci_func'],$data['TABLE'],$curpage,$data['limit'],$status_id,$sort,$order,$ci_changePage,$result_id); 

		$this->load->view('report/table_data_view',$data);  
 
	}
 
	function getlist($table="",$listname='',$status_id=1,$where_key='id',$where_val=0,$selected=0,$result_id='',$firstitem=''){ 
		
		echo  $this->allfunc->listmenu($table,$listname,$status_id,$where_key,$where_val,$selected,$result_id,$firstitem); 
 
	} 
	function qselect(){ 
 		//foreach($_POST as $k => $v) echo "<br>$k => $v";  exit;
		
	
	}
	
	
	
	
	
	
	
	
	
	function changepage($curpage,$limit,$status_id,$sort,$order,$ci_changePage,$result_id,$ci_ctrl,$ci_func,$TABLE){  
		$data['data'] = $this->funcreport->indexDataTable($ci_ctrl,$ci_func,$TABLE,$curpage,$limit,$status_id,$sort,$order,$ci_changePage,$result_id); 
		$this->load->view('data_view',$data);
	} 
	
	
	//--- edit data
	
	function edit_data($id,$ci_func){ 
		 
		$data 				= $this->mainvars($ci_func); 
		$strTable 			= ucwords(str_replace("_"," ",$ci_func));
		
	 	$mode = "Edit";
		if(empty($id))$mode = "Add New"; 
     	$data['pageLABEL'] 	= $data['pageLABEL']." > $mode Data";   
		
		$data['id'] 		= $id;  
		//$data['TABLE']     	= $TABLE;  
		$data['tablemod']  	= $mode; 
		$data['tablelbl']  	= $strTable;  
		
		//echo $data['TABLE']; exit;
		
		//--get data db
		if($id){
			$gData = $this->allmodel->getTableByID($data['TABLE'],$id);
			foreach($gData as $key => $val){ //echo "<br>$key => $val";
			 	$data[$key] = $val;
			}
		}
		 
		$data['location_idx'] = $this->allmodel->getMDdata("md_location"); 
		$data['area_idx']	  = $this->allmodel->getMDdata("md_area");
		$data['owner_idx']	  = $this->allmodel->getMDdata("md_terminal_owner");  
		
		//error_reporting(E_ALL ^ E_NOTICE);
		$this->load->view('report/edit_data_view',$data);  
		//error_reporting(E_ALL);
	} 
	
	function qedit(){ 
 		//foreach($_POST as $k => $v) echo "<br>$k => $v";  exit;
		
		if(isset($_POST['bdel'])) if($_POST['bdel']=="DELETE"){		 
			$q = "UPDATE `".$_POST['TABLE']."` SET `status_id` = 0 WHERE `id` = '".$_POST['id']."' LIMIT 1"; 
			$this->db->query($q); 
			
			//--create log
			$this->allfunc->createLog('user',$this->session->userdata('ID'),strtolower(__CLASS__),$_POST['TABLE'].' - DEL id: '.$_POST['id']);
			
		    redirect('/'.strtolower(__CLASS__).'/'.$_POST['ci_func'].'/','refresh'); 
			exit;
			///dealer_terminal/edit_data/5/authorize_dealer
		}
		 /*
 
			TABLE => md_terminal_owner
			ci_func => owner
			id => 1
			name => Bank Mandiri Tbk.
			description => Divisi Penjualan Prepaid111
 
		 	button => Submit  
		 	button => ACTIVATE 
		 	bdel => DELETE

		 */ 
		 			
		$qstr1 = $qstr2 = $qstr3 = '';
			
		foreach($_POST as $k => $v){ //echo "<br>$k => $v";
				
				$$k = $v;
				
				if( 
				
					//( $TABLE=="authorize_dealer" && $k!="TABLE" && $k!="ci_func" && $k!="button" && $k!="status_id" && $v!="Submit" ) 
					//||
					//( $TABLE=="vending_terminal" && $k!="TABLE" && $k!="ci_func" && $k!="button" && $k!="status_id" && $v!="Submit" )  
					//||
					($k!="TABLE" && $k!="ci_func" && $k!="button" && $k!="status_id" && $v!="Submit")
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
		
		if(empty($id)){ //-- add new data 
			$qstr1 = substr($qstr1,0,strlen($qstr1)-1);
			$qstr2 = substr($qstr2,0,strlen($qstr2)-1); 
			$q = "INSERT INTO `".$TABLE."` (".$qstr1.")VALUES(".$qstr2.")";
			$this->db->query($q); 
			$cid = mysql_insert_id();  
			
			//--create log
			$this->allfunc->createLog('user',$this->session->userdata('ID'),strtolower(__CLASS__),$_POST['TABLE'].' - ADDid : '.$cid);
			
		 }else{ //-- edit data
			$qstr3 = substr($qstr3,0,strlen($qstr3)-1); 
			
			$stractive = '';
			if($_POST['button']=="ACTIVATE") $stractive = ', `status_id`=1 ';
			
			$q = "UPDATE `".$TABLE."` SET ". $qstr3.$stractive. " WHERE `id` = ".$id." LIMIT 1"; 
						
			$this->db->query($q);  
			$cid = $id; 
 
			//--create log
			$this->allfunc->createLog('user',$this->session->userdata('ID'),strtolower(__CLASS__),$_POST['TABLE'].' - UPDATE id: '.$_POST['id']);
			
		 } 
		 redirect('/'.strtolower(__CLASS__).'/edit_data/'.$cid.'/'.$ci_func.'/','refresh');
 
	}  
}
