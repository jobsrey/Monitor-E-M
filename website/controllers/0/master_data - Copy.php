<?php  
//session_start();   
class Master_data extends Controller { 
	function Master_data(){   
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
	
		$limit = 2; 
	
		$data['navMenu']   	= $this->allfunc->navMenu(2);  
		$data['ci_menu'] 	= $this->allfunc->navMenu(2,1); 
		$data['ci_ctrl'] 	= strtolower(str_replace(" ","_",str_replace(" / ","_",$data['ci_menu'])));  
     	$data['ci_func']	= $ci_func; 
		$data['TABLE'] 		= "md_".$ci_func;  
		$strTable 			= ucwords(str_replace("_"," ",$data['TABLE'])); 

     	$data['status_id'] 	= $status_id;  
     	$data['limit'] 		= $limit;  
		
     	$data['pageTITLE']	= $data['ci_menu'].' - '.str_replace("Md ","",$strTable);  
     	$data['pageLABEL'] 	= $data['ci_menu'].' > '.str_replace("Md ","",$strTable);  
		
 		return $data;  
	} 
	
 
	function ownerddd(){  
		
		$ci_func			= 'owner'; 
		$data 				= $this->mainvars($ci_func);
  
		$data['indexData']  = $this->funcdbindex->indexDataTable($data['ci_ctrl'],$data['ci_func'],$data['TABLE']);  
		
		$this->load->view('index/table_data_view',$data);  
		
	}
	function owner($curpage=1,$limit=0,$status_id=1,$sort="id",$order="asc",$ci_ctrl="",$ci_changePage="changepage",$result_id="dspdata"){  
	
		echo __FUNCTION__;
		exit;
	
		$ci_func			= 'owner'; 
		$data 				= $this->mainvars($ci_func,$status_id,$limit);  
		$data['indexData']  = $this->funcdbindex->indexDataTable($data['ci_ctrl'],$data['ci_func'],$data['TABLE'],$curpage,$data['limit'],$status_id,$sort,$order,$ci_changePage,$result_id); 

		$this->load->view('index/table_data_view',$data);  
	} 
	function area($curpage=1,$limit=0,$status_id=1,$sort="id",$order="asc",$ci_ctrl="",$ci_changePage="changepage",$result_id="dspdata"){  
		$ci_func			= 'area'; 
		$data 				= $this->mainvars($ci_func,$status_id,$limit);  
		$data['indexData']  = $this->funcdbindex->indexDataTable($data['ci_ctrl'],$data['ci_func'],$data['TABLE'],$curpage,$data['limit'],$status_id,$sort,$order,$ci_changePage,$result_id); 

		$this->load->view('index/table_data_view',$data);  
	} 
	function terminal_location($curpage=1,$limit=0,$status_id=1,$sort="id",$order="asc",$ci_ctrl="",$ci_changePage="changepage",$result_id="dspdata"){  
		$ci_func			= 'location'; 
		$data 				= $this->mainvars($ci_func,$status_id,$limit);  
		$data['indexData']  = $this->funcdbindex->indexDataTable($data['ci_ctrl'],$data['ci_func'],$data['TABLE'],$curpage,$data['limit'],$status_id,$sort,$order,$ci_changePage,$result_id); 

		$this->load->view('index/table_data_view',$data);  
	}



	function changepage($curpage,$limit,$status_id,$sort,$order,$ci_changePage,$result_id,$ci_ctrl,$ci_func,$TABLE){  
		$data['data'] = $this->funcdbindex->indexDataTable($ci_ctrl,$ci_func,$TABLE,$curpage,$limit,$status_id,$sort,$order,$ci_changePage,$result_id); 
		$this->load->view('data_view',$data);
	} 
	
	
	//--- edit data
	
	function edit_data($id,$TABLE){ 
		 
		$data 				= $this->mainvars($TABLE); 
		$strTable 			= ucwords(str_replace("md","",str_replace("_"," ",$TABLE)));
		
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
		 
		$data['location_idx'] = $this->allmodel->getMDdata("md_location"); 
		$data['area_idx']	 = $this->allmodel->getMDdata("md_area");
		$data['owner_idx']	 = $this->allmodel->getMDdata("md_terminal_owner");  
		
		error_reporting(E_ALL ^ E_NOTICE);
		$this->load->view('index/edit_data_view',$data);  
		error_reporting(E_ALL);
	} 
	
	function qedit(){ 
 		//foreach($_POST as $k => $v) echo "<br>$k => $v"; 
		if(isset($_POST['bdel'])) if($_POST['bdel']=="DELETE"){		 
			$q = "UPDATE `".$_POST['TABLE']."` SET `status_id` = 0 WHERE `id` = '".$_POST['id']."' LIMIT 1"; 
			$this->db->query($q); 
			$strUrlTable = strtolower(str_replace("md_","",$_POST['TABLE']));
		    redirect('/master_data/'.$strUrlTable.'/','refresh'); 
			exit;
			///dealer_terminal/edit_data/5/authorize_dealer
		}
		 /*
		 TABLE => authorize_dealer
		 id => 0
		 dealer => dealer
		 name => name
		 email => email
		 address => address
		 phone_1 => 11111
		 phone_2 => 22222
		 phone_3 => 33333
		 phone_4 => 44444
		 button => Submit 
		 
		 button => ACTIVATE 
		 bdel => DELETE

		 */ 
		 			
		$qstr1 = $qstr2 = $qstr3 = '';
			
		foreach($_POST as $k => $v){
				
				$$k = $v;
				
				if( 
					( $TABLE=="md_terminal_owner" && $k!="TABLE" && $k!="ci_func" && $k!="button" && $k!="status_id" && $v!="Submit" ) 
				
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
			$q = "INSERT INTO ".$TABLE." (".$qstr1.")VALUES(".$qstr2.")";
			$this->db->query($q); 
			$cid = mysql_insert_id();  
		 }else{ //-- edit data
			$qstr3 = substr($qstr3,0,strlen($qstr3)-1); 
			
			$stractive = '';
			if($_POST['button']=="ACTIVATE"){
				if(!empty($qstr3)) $stractive = ', status_id=1 ';
				else $stractive = ' status_id=1 ';
			}
			$q = "UPDATE ".$TABLE." SET ". $qstr3.$stractive. " WHERE `id` = ".$id." LIMIT 1"; 
						
			$this->db->query($q);  
			$cid = $id; 
		 } 
		 redirect('/master_data/edit_data/'.$cid.'/'.$TABLE.'/','refresh');
 
	}  
}