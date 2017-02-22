<?php  
//session_start(); 
//error_reporting(E_ALL ^ E_NOTICE);
 
class Replenishment extends Controller { 
	function Replenishment(){   
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
	
		$_ci_func	= $ci_func;
		$_status_id	= $status_id;
		$_limit		= $limit;
		
		$data = $this->allfunc->reflector(__CLASS__,$ci_func); 
 
		$data['navMenu']   	= $this->allfunc->navMenu(10);  
		$data['ci_menu'] 	= $this->allfunc->navMenu(10,1);
		$data['ci_ctrl'] 	= strtolower(__CLASS__);  
     	$data['ci_func']	= $_ci_func; 
		$data['TABLE'] 		= $_ci_func;   
		$strTable 			= ucwords(str_replace("_"," ",$data['TABLE'])); 
		
     	$data['status_id'] 	= $_status_id;  
     	$data['limit'] 		= $_limit;  
		
     	$data['pageTITLE']	= ucwords(str_replace("_"," ",$data['ci_ctrl'].' - '.str_replace("Md ","",$strTable)));  
     	$data['pageLABEL'] 	= ucwords(str_replace("_"," ",$data['ci_menu'].' > '.str_replace("Md ","",$strTable)));  
 
		return $data;
		  
		//echo __CLASS__;  
		//echo __FUNCTION__; 	exit;
		//echo __METHOD__; 		exit; //Dealer_terminal::mainvars

	} 
	
	function card_data		($curpage=1,$limit=10,$status_id=1,$sort="id",$order="asc",$ci_ctrl=__CLASS__,$ci_changePage="changepage",$result_id="dspdata"){  
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit); 
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;  
		$data = $this->indexpage($data); 
	} 
	
	
	function update_jumlah_kartu($tid=0){   
	 
		$data = $this->mainvars(__FUNCTION__);
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;  
		
     	$data['pageTITLE']	= 'Lunari Web Admin - Replenishment'; 
     	$data['pageLABEL'] 	= 'Replenishment > Update Jumlah Kartu'; 
 
		$data['clss']  		= "jumlah_kartu"; 
		$data['qMedia'] 	= $this->allmodel->getMediaDB(0,$data['clss']); 
		$data['qTerminal'] 	= $this->allmodel->getVendingTerminal(0);
 
		$qdata = $this->allmodel->getVendingTerminal($tid);  
		if( $qdata->num_rows() ){
			$qresdata = $qdata->result_array();  
			$data['rowtid'] = $qresdata[0]; 
			foreach( $qdata->result_array() as $row)
			foreach($row as $key => $val){ //echo "<br>$key => $val";
				$data[$key] 		 	= $val;
				//$data['IP'] 		 	= $row['IP']; 
				//$data['terminal_ID']	= $row['terminal_ID']; 
				//$data['terminal_owner'] = $row['terminal_owner']; 
			} 
		}
		//if(!isset($data['rowtid'])) $data['rowtid']['ip'] = '';
 
		$this->load->view('terminal_tools/tools_viewer',$data); 
 
	}  
	
	
	function generate_passwords($tid=0){   
	 
		$data = $this->mainvars(__FUNCTION__);
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;   
		$data['clss']  		= "generate_passwords"; 
		$data['qMedia'] 	= $this->allmodel->getMediaDB(0,$data['clss']); 
		$data['qTerminal'] 	= $this->allmodel->getVendingTerminal(0); 
		$qdata = $this->allmodel->getVendingTerminal($tid);  
		if( $qdata->num_rows() ){
			$qresdata = $qdata->result_array();   
			$data['rowtid'] = $qresdata[0]; 
			foreach( $qdata->result_array() as $row)
			foreach($row as $key => $val){ //echo "<br>$key => $val";
				$data[$key] 		 	= $val; 
			} 
		} 
		$this->load->view('terminal_tools/tools_viewer',$data); 
 
	}  
	
	
	   
	function update_generate_passwords($tid=0){  
		$data = $this->mainvars(__FUNCTION__);
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;  
     	$data['pageTITLE']	= 'Lunari Web Admin - Replenishment'; 
     	$data['pageLABEL'] 	= 'Replenishment > Generate Passwords'; 
		$data['clss']  		= "generate_passwords"; 
		$data['qMedia'] 	= $this->allmodel->getMediaDB(0,$data['clss']); 
		$data['qTerminal'] 	= $this->allmodel->getVendingTerminal(0); 
		$qdata = $this->allmodel->getVendingTerminal($tid);  
		if( $qdata->num_rows() ){
			$qresdata = $qdata->result_array();   
			$data['rowtid'] = $qresdata[0]; 
			foreach( $qdata->result_array() as $row)
			foreach($row as $key => $val){ //echo "<br>$key => $val";
				$data[$key] 		 	= $val; 
			} 
		} 
		$this->load->view('terminal_tools/tools_viewer',$data); 
	}  
	
 
 
	function replenish_approval($tid=0){   
	 
		$data = $this->mainvars(__FUNCTION__);
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;   
     	$data['pageTITLE']	= 'Lunari Web Admin - Replenishment'; 
     	$data['pageLABEL'] 	= 'Replenishment > Replenish Approval'; 
		$data['clss']  		= "replenish_approval"; 
		$data['qMedia'] 	= $this->allmodel->getMediaDB(0,$data['clss']); 
		$data['qTerminal'] 	= $this->allmodel->getVendingTerminal(0); 
		$qdata = $this->allmodel->getVendingTerminal($tid);  
		if( $qdata->num_rows() ){
			$qresdata = $qdata->result_array();   
			foreach( $qdata->result_array() as $row)
			foreach($row as $key => $val){ //echo "<br>$key => $val";
				$data[$key] 		 	= $val; 
			} 
		} 
		$this->load->view('terminal_tools/tools_viewer',$data); 
 
	}   
 function update_replenish_approval($tid=0){   
	 
		$data = $this->mainvars(__FUNCTION__);
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;  
		
     	$data['pageTITLE']	= 'Lunari Web Admin - Replenishment'; 
     	$data['pageLABEL'] 	= 'Replenishment > Replenishment Approval'; 
 
		$data['clss']  		= "replenish_approval"; 
		$data['qMedia'] 	= $this->allmodel->getMediaDB(0,$data['clss']); 
		$data['qTerminal'] 	= $this->allmodel->getVendingTerminal(0);
 
		$qdata = $this->allmodel->getVendingTerminal($tid);  
		if( $qdata->num_rows() ){
			$qresdata = $qdata->result_array();  
			//$data['rowtid'] = $qresdata[0]; 
			foreach( $qdata->result_array() as $row)
			foreach($row as $key => $val){ //echo "<br>$key => $val";
				$data[$key] 		 	= $val;
				//$data['IP'] 		 	= $row['IP']; 
				//$data['terminal_ID']	= $row['terminal_ID']; 
				//$data['terminal_owner'] = $row['terminal_owner']; 
			} 
		}
		//if(!isset($data['rowtid'])) $data['rowtid']['ip'] = '';
 
		$this->load->view('terminal_tools/tools_viewer',$data); 
 
	}  
	//--- index page 
	function indexpage($data=array()){  
		$data['ci_ctrl'] = strtolower($data['ci_ctrl']);  
		$data['indexData']  = $this->funcdbindex->indexDataTable($data['ci_ctrl'],$data['ci_func'],$data['TABLE'],$data['curpage'],$data['limit'],$data['status_id'],$data['sort'],$data['order'],$data['ci_changePage'],$data['result_id']); 
		$this->load->view('index/table_data_view',$data);
	}  
	function changepage($curpage,$limit,$status_id,$sort,$order,$ci_changePage,$result_id,$ci_ctrl,$ci_func,$TABLE){  
		$ci_ctrl = strtolower($ci_ctrl); 
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
 
		//$data['location_idx'] = '';//$this->allmodel->getMDdata("md_location");  
		//$data['owner_idx']	 = $this->allmodel->getMDdata("md_terminal_owner");  
		
		$data['editFormTable']	 = $this->editFormTable($data);
		
		//error_reporting(E_ALL ^ E_NOTICE);
		$this->load->view('index/edit_data_view',$data);  
		//error_reporting(E_ALL);
	} 

	function editFormTable($data){ 
	
		foreach( $data as $key => $val) $$key = $val   ;//echo "<br>$key => $val"; exit;
	
		//-- get table keys
		$arr_fields      = $this->allmodel->getTableKeys($TABLE,'all'); 
		//foreach( $arr_fields as $k => $varKey) echo "<br>$k ===> $varKey"; 
		//echo "<br><br>";
		$arr_fields_type = $this->allmodel->getTableKeysType($TABLE,'all'); 
		//foreach( $arr_fields_type as $k => $varKey) echo "<br>$k ===> $varKey"; exit;
		
		/*
		id ===> int(11)
		IP ===> varchar(255)
		terminal_ID ===> varchar(255)
		*/
 		
		$result = '';
		$col1 = "#ffffff";
		$col2 = "#f6f6f6";
		$x=0;
		foreach( $arr_fields as $key => $value){ //echo "<br>$key ===> $value"; 
			$n = fmod($x,2); 
			if($n) $clr = $col1; else $clr = $col2;
 		
			if(!$this->funcdbindex->hiddenfields($key)){
				//echo "<br>$k => $varKey"; 	 
				
				$inputsize = 'width:120px';
				if	  ($arr_fields_type[$key]=="varchar(255)") $inputsize = 'width:220px';
				elseif($arr_fields_type[$key]=="varchar(120)") $inputsize = 'width:160px'; 
 				
				//,'venue','area','city','province','country'
				if(!$this->funcdbindex->hiddenfieldsedit($key)){
					$result .= '<tr valign="top" bgcolor="'.$clr.'">'; 
					
					if($key=="venue")
					$result .= '  <td>Location</td>';
					else
					$result .= '  <td>'.$key.'</td>';
					
					if($key=="venue"){
						 
						$result .= '  <td>';
								//.$value.', '.$arr_fields['area'].', '.$arr_fields['city'].', '.$arr_fields['province'].', '.$arr_fields['country'].' 
							//&nbsp; &nbsp; <input type="button" name="button1" id="button1" value="Edit Location" />
							//location_id = '.$arr_fields['location_id'].'
							
							$qDataLoc=$this->allmodel->selectIndexTable(0,1000,1,'venue','asc','md_terminal_location'); 

							if($qDataLoc->num_rows()){ 
								$result .= '<select name="location_id" id="location_id">';  
								foreach($qDataLoc->result_array() as $row) {
									 $selected = '';
									 if($row['id']==$arr_fields['location_id']) $selected = 'selected="selected"';
									 $result .= '<option value="'.$row['id'].'" '.$selected.' >'.$row['Venue'].' -> '.$row['Area'].', '.$row['City'].', '.$row['Province'].', '.$row['Country'].'</option>'; 
								}
								$result .= '</select>';
							}
	
							
						$result .= ' 	<br><div style="padding:5px 0 0;">
										<input type="button" name="button1" id="button1" value="Edit Location" onclick="window.open(\'/master_data/edit_data/'.$arr_fields['location_id'].'/terminal_location\',\'edit_location\',\'height=1024,width=800\')" />
								   		</div>
								    </td>'; 
					}
					elseif($arr_fields_type[$key]=="text")
					$result .= '  <td><textarea rows="2" name="'.$varKey.'" id="'.$varKey.'" style="width:220px">'.$value.'</textarea></td>';
					else
					$result .= '  <td><input type="text" style="'.$inputsize.'" name="'.$varKey.'" id="'.$varKey.'" value="'.$value.'" /></td>';
					
					$result .= '</tr>';
				} 
		 
				$x++;
							
			}	 
		}
		

		
		
					
		return $result;			
					
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
			if( ($k!="TABLE" && $k!="ci_func" && $k!="button" && $k!="status_id" && $v!="Submit") ){ 
				$qstr1 .= "`".$k."`,";  
				if($k=="id") {	$qstr2 .= "'',";		$qstr3 .= "`".$k."` = '".$v."',"; } 
				else 			$qstr2 .= "'".$v."',";    
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
	}
	//------------------------------------------------------------------------------------------------------------------------------------------ 
}
