<?php  
//session_start(); 
error_reporting(E_ALL ^ E_NOTICE);
 
class Dealer_terminal extends Controller { 
	function Dealer_terminal(){   
		parent::Controller(); 
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		$this->load->library('allfunc'); 
		$this->load->library('funcdbindex');  
		$this->load->database(); 
		$this->load->library('session'); 
		//if(!$this->session->userdata('logged_in')) redirect('login','refresh');
		  
	} 
	function index(){ 
 		echo "Hello U"; 
	} 
	
	function mainvars($ci_func='',$status_id=1,$limit=10){  
		
		$data = $this->allfunc->reflector(__CLASS__,$ci_func); 
 
		$data['navMenu']   	= $this->allfunc->navMenu(3);  
		$data['ci_menu'] 	= $this->allfunc->navMenu(3,1);
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
	
	function authorize_dealer($curpage=1,$limit=10,$status_id=1,$sort="id",$order="asc",$ci_ctrl=__CLASS__,$ci_changePage="changepage",$result_id="dspdata"){   
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit); 
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;   
		$data = $this->indexpage($data); 
	} 
	 
	function vending_terminal($curpage=1,$limit=10,$status_id=1,$sort="id",$order="asc",$ci_ctrl=__CLASS__,$ci_changePage="changepage",$result_id="dspdata"){   
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit); 
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;   
		$data = $this->indexpage($data); 
	} 
	
	//--- index page 
	function indexpage($data=array()){  
	//echo $data['sort'];		
		$data['indexData']  = $this->funcdbindex->indexDataTable(strtolower($data['ci_ctrl']),$data['ci_func'],$data['TABLE'],$data['curpage'],$data['limit'],$data['status_id'],$data['sort'],$data['order'],$data['ci_changePage'],$data['result_id']); 
		$this->load->view('index/table_data_view',$data);
	}  
	function changepage($curpage,$limit,$status_id,$sort,$order,$ci_changePage,$result_id,$ci_ctrl,$ci_func,$TABLE){   
		$data['data'] = $this->funcdbindex->indexDataTable($ci_ctrl,$ci_func,$TABLE,$curpage,$limit,$status_id,$sort,$order,$ci_changePage,$result_id); 
		$this->load->view('data_view',$data);
	} 
	//--- edit data
	
	function edit_data($id,$TABLE){ 
		 
		$data 				= $this->mainvars($TABLE); 
		$strTable 			= ucwords(str_replace("_"," ",$TABLE));
	 	$mode = "Edit";
		if(empty($id))$mode = "Add New"; 
     	$data['pageLABEL'] 	= $data['pageLABEL']." > $mode Data";   
		
		$data['id'] 		= $id;  
		$data['TABLE']     	= $TABLE;  
		$data['tablemod']  	= $mode; 
		$data['tablelbl']  	= $strTable;  
		
		//--get data db
		if($id){
			$gData = $this->allmodel->getTableByID($TABLE,$id);
			foreach($gData as $key => $val){ //echo "<br>$key => $val";
			 	$data[$key] = $val;
			}
		}
		 
		$data['location_idx'] = '';//$this->allmodel->getMDdata("md_location");  
		$data['owner_idx']	 = $this->allmodel->getMDdata("md_terminal_owner");  
		
		//error_reporting(E_ALL ^ E_NOTICE);
		$this->load->view('index/edit_data_view',$data);  
		//error_reporting(E_ALL);
	} 
	
	//------------------------------------------------------------------------------------------------------------------------------------------
	function qedit(){ 
 		//foreach($_POST as $k => $v) echo "<br>$k => $v";  exit; 
		if(isset($_POST['bdel'])) if($_POST['bdel']=="DELETE"){		 
			$q = "UPDATE `".$_POST['TABLE']."` SET `status_id` = 0 WHERE `id` = '".$_POST['id']."' LIMIT 1"; 
			$this->db->query($q); 
			
			//--create log
			$this->allfunc->createLog('user',$this->session->userdata('ID'),strtolower(__CLASS__),$_POST['TABLE'].' - DEL id: '.$_POST['id']);
		    
			redirect('/'.strtolower(__CLASS__).'/'.$_POST['ci_func'].'/','refresh');  
			exit; 
		}  	
		$qstr1 = $qstr2 = $qstr3 = ''; 
		foreach($_POST as $k => $v){ //echo "<br>$k => $v"; 
			$$k = $v; 
			if(  //( $TABLE=="vending_terminal" && $k!="TABLE" && $k!="ci_func" && $k!="button" && $k!="status_id" && $v!="Submit" ) ||
				($k!="TABLE" && $k!="ci_func" && $k!="button" && $k!="status_id" && $v!="Submit")
			  ){ $qstr1 .= "`".$k."`,";  
				 if($k=="id") 	$qstr2 .= "'',";
				 else 			$qstr2 .= "'".$v."',";   
				 if($k!="id") 	$qstr3 .= "`".$k."` = '".$v."',";  
			} 
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
			
			$q = "UPDATE `".$TABLE."` SET ". $qstr3.$stractive. " WHERE `id` = ".$id." LIMIT 1";  
			$this->db->query($q);  
			$cid = $id; 
 
			//--create log
			$this->allfunc->createLog('user',$this->session->userdata('ID'),strtolower(__CLASS__),$_POST['TABLE'].' - UPDATE id: '.$_POST['id']); 
		} 
		redirect('/'.strtolower(__CLASS__).'/edit_data/'.$cid.'/'.$ci_func.'/','refresh');
		exit; 
 
	}
	//------------------------------------------------------------------------------------------------------------------------------------------ 
}
