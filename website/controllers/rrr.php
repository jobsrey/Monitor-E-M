<?php  
//session_start(); 
//error_reporting(E_ALL ^ E_NOTICE); 
 
class Rrr extends Controller { 
	function Rrr(){   
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
	
	//topup_transaction
 
 function sales_transaction($dt1="",$dt2="",$owner_id=0,$terminal_id=0,$product_id=0,$item_id=0){  
		
		if(empty($dt1)) $first = 1;
		
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit);  
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;


		$data['ci_ctrl']  = $ci_ctrl  = strtolower(__CLASS__);
		$data['ci_func']  = $ci_func  = strtolower(__FUNCTION__);
		
		$data['callfunc'] 	= $callfunc   = '/report_data'; //-- form filter data, submit to this function
		$data['reportfunc'] = $reportfunc = 'sales_transaction'; //-- form filter data, submit to this function
  
		if(empty($dt1)) $data['dt1'] = date("Y-m-d"); else $data['dt1'] = $dt1;  
		if(empty($dt2)) $data['dt2'] = date("Y-m-d"); else $data['dt2'] = $dt2; 
 
 		//--var list owner
		$lmenu['select_name_id'] 	= 'owner_id';
  		$lmenu['slc_key']			= 'id';
 		$lmenu['selected']			= $owner_id;
 		$lmenu['show_key_name']		= 'name'; 
 		$lmenu['first_item_val'] 	= 0;
 		$lmenu['first_item_text']	= 'all';  
		$datalist = $this->allmodel->getTableWhere('md_terminal_owner','id',0,1); 
 		//foreach($datalist as $k => $v) foreach($v as $k2 => $v2) echo "<br>$k => $k2 => $v2"; 
		$str_onchange = ' onchange="loadcontent(\''.base_url().$ci_ctrl.'/list_data_child_2/0/\'+$(\'select#owner_id\').val()+\'/'.$terminal_id.'/'.$product_id.'/'.$item_id.'\',\'tproductlist\')" ';
 
		$data['listmenu_0'] = $this->allfunc->listmenuarray2($lmenu,$datalist,$str_onchange); 
 		$data['listmenu_1'] = $this->list_data_child(11,$owner_id,$terminal_id,$product_id,$item_id); 
 		$data['listmenu_2'] = $this->list_data_child(22,$owner_id,$terminal_id,$product_id,$item_id); 
		$data['listmenu_3'] = '';//$this->list_data_child(33,$owner_id,$terminal_id,$product_id,$item_id);
		
		
		
		 
		//---form vars 
		$owner 	  	= 'all';
		$terminal 	= 'none';
		$ip 	  	= 'none';		
		$product 	= 'none';			
		$address 	= 'none';		
		$location 	= 'none';
		$total_item = 0;	
		$total_amount = 0;	
		
		//$qData = $this->allmodel->getTableWhere('md_terminal_owner','id',$owner_id,1); 
 		//foreach($datalist as $k => $v) foreach($v as $k2 => $v2) echo "<br>$k => $k2 => $v2";  
		//if(isset( $row1['name'])) $owner = $row1['name'];
		//$strOWN = '';
		//foreach($qData as $k => $row){
			//$strOWN .= $row['IP'].","; 
		//}
		//$qData2 = $this->allmodel->getTableWhere('vending_terminal','id',$terminal_id,1); 
		//foreach($row2 as $k => $v) foreach($v as $k2 => $v2) echo "<br>$k => $k2 => $v2";  
				 
		$q = $this->allmodel->getQueryTable('vending_terminal'); 
  
		$qData = $this->db->query($q); 
		$strOWN = $strIP = $strPID = $strADD = $strLOC = $strTXID = '';
		
		if($qData->num_rows()) 
		foreach($qData->result_array() as $k => $row){
			$strIP  .= $row['IP'].",";
			$strTID .= $row['terminal_ID'].","; 
			$strOID .= $row['terminal_owner'].","; 
			$strPID .= $row['product_id'].",";  
			$strADD .= $row['terminal_address'].",";  
			$strLOC .= $row['terminal_tenant']."--- ".$row['venue']."--- ".$row['area']."--- ".$row['city']."--- ".$row['province']."--- ".$row['country'].",";  
			$strTXID .= $row['trx_code_id'].","; 
		} 
		$strIP 	= substr($strIP,0,strlen($strIP)-1);
		$strOID = substr($strOID,0,strlen($strOID)-1);
		
		$strTID	= substr($strTID,0,strlen($strTID)-1); 
		$strADD = substr($strADD,0,strlen($strADD)-1);  
		$strLOC = substr($strLOC,0,strlen($strLOC)-1);  
		$strTXID= substr($strTXID,0,strlen($strTXID)-1); 
		
		$arrIP  = explode(",",$strIP);
		$arrTID = explode(",",$strTID);
		$arrOID = explode(",",$strOID);
		$arrPID = explode(",",$strPID);
		$arrADD = explode(",",$strADD);
		$arrLOC = explode(",",$strLOC);
		$arrTXID= explode(",",$strTXID);
 
		$aOID = array_unique($arrOID);
		$aPID = array_unique($arrPID); 
		
		$aTID = array_unique($arrTID);
		$aIP  = array_unique($arrIP);
		$aADD = array_unique($arrADD);
		$aLOC = array_unique($arrLOC);
		$aTXID = array_unique($arrTXID);
		 
		
		if(!empty($owner_id)) {
			$owner = $this->allmodel->getTableWhere('md_terminal_owner','id',$owner_id,1,'name','name');  
		}elseif(count($aOID)>1 || (count($aOID)==1&&!empty($owner_id)) ){ $owner = 'all';}
 
		if(!empty($terminal_id)) {
			$tid = $this->allmodel->getTableWhere('vending_terminal','id',$terminal_id,1,'id','terminal_id'); 
			//$ip		  = $this->allmodel->getTableWhere('vending_terminal','id',$terminal_id,1,'id','IP');  
			foreach($aTID as $kk => $vv)  //echo "<br>$kk => $vv => $tid";
			if($vv==$tid){  
				$ip 	  = $aIP[$kk];
				$terminal = $aTID[$kk]; 
				$address  = $aADD[$kk];
				$location = str_replace("---",",",$aLOC[$kk]);
			}  
		}elseif(count($aTID)>1 || (count($aTID)==1&&!empty($terminal_id))){ $terminal = $ip = $address  = $location  = 'all'; }
 
		if(!empty($product_id)) {
			$product = $this->allmodel->getTableWhere('pd_product','id',$product_id,1,'product','product');  
		}elseif(count($aPID)>1 || (count($aPID)==1&&!empty($product_id)) ){ $product = 'all';}
 
 
		
		
		
		//-- query TRX
		// id 	kdtrx 	dt 	tm 	vmid 	 jmlbeli 	hargabeli 	isikartu 	biayakartu 	totalbayar
		// kdtrx 	dt 	tm 	vmid
		$strTRXID = '';
		foreach($aTXID as $k => $varkey) if($varkey){ //echo "<br>$k => $varkey";
			$TRX_ID = $this->allmodel->getTableWhere('md_transaction_code','id',$varkey,1,'trx_code','trx_code'); 
			$strTRXID .= " kdtrx = '".$TRX_ID."' or";
		} 
		$strTRXID = substr($strTRXID,0,strlen($strTRXID)-2);
		if(!empty($strTRXID))
		$strTRXID = "( ".$strTRXID." )";
		
		$strTID = '';
		if($terminal=='none'||$terminal=='all'){
			foreach($aTID as $k => $varkey) if($varkey){  //echo "<br>$k => $varkey";  
				 $strTID .= " vmid = '".$varkey."' or"; 
			} 
			$strTID = substr($strTID,0,strlen($strTID)-2);
		} else { 	
			$strTID .= " vmid = '".$terminal."'";
		}
		
		if(!empty($strTID))
		$strTID = " and ( ".$strTID." )";
 
		$strDT = "and ( `dt` >= '".$data['dt1']."' and `dt` <= '".$data['dt2']."' ) ";  
 
		$q = "Select * From `trx` Where $strTRXID $strTID $strDT Order By id Desc ";
 		 
		$tData = $this->db->query($q); 
		$jmlbeli=$totalbayar=0;
 		if($tData->num_rows()) 
		foreach($tData->result_array() as $rowTrx){
			//foreach($rowTrx as $k2 => $v2) echo "<br>$k => $k2 => $v2"; 
			$jmlbeli 	+= $rowTrx['jmlbeli'];
			$totalbayar += $rowTrx['totalbayar']; 
		}
		$total_item   = $jmlbeli." items.";
		$total_amount = "Rp. ".number_format($totalbayar,0,',','.');
		
		$data['rowTrx']  =  $tData->result_array();
		 
		
		
		//exit;
 
 
		$data['owner'] 	      = $owner; 
		$data['terminal']     = $terminal; 
		$data['ip'] 	      = $ip; 
		$data['product']  	  = $product;  
		$data['address']  	  = $address; 
		    
		if($location!="all") 
		$data['location'] = substr($location,1,strlen($location));  
		else 
		$data['location'] = $location; 
		
		$data['total_item']   = $total_item; 
		$data['total_amount'] = $total_amount; 
 
		$data['table_trx'] 	  = "trx";    
 
		$data['indexData']  = '';//$this->funcreport->indexDataTable($data['ci_ctrl'],$data['ci_func'],$data['TABLE'],$curpage,$data['limit'],$status_id,$sort,$order,$ci_changePage,$result_id,0,$lval2,$data['dl1'],$data['dl2']); 

		$this->load->view('report/table_data_view',$data);  
 
	}
	
		//topup_transaction
 
 function topup_transaction($dt1="",$dt2="",$owner_id=0,$terminal_id=0,$product_id=0,$item_id=0){  
		
		if(empty($dt1)) $first = 1;
		
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit);  
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;


		$data['ci_ctrl']  = $ci_ctrl  = strtolower(__CLASS__);
		$data['ci_func']  = $ci_func  = strtolower(__FUNCTION__);
		
		$data['callfunc'] 	= $callfunc   = '/report_data'; //-- form filter data, submit to this function
		$data['reportfunc'] = $reportfunc = 'topup_transaction'; //-- form filter data, submit to this function
  
		if(empty($dt1)) $data['dt1'] = date("Y-m-d"); else $data['dt1'] = $dt1;  
		if(empty($dt2)) $data['dt2'] = date("Y-m-d"); else $data['dt2'] = $dt2; 
 
 		//--var list owner
		$lmenu['select_name_id'] 	= 'owner_id';
  		$lmenu['slc_key']			= 'id';
 		$lmenu['selected']			= $owner_id;
 		$lmenu['show_key_name']		= 'name'; 
 		$lmenu['first_item_val'] 	= 0;
 		$lmenu['first_item_text']	= 'all';  
		$datalist = $this->allmodel->getTableWhere('md_terminal_owner','id',0,1); 
 		//foreach($datalist as $k => $v) foreach($v as $k2 => $v2) echo "<br>$k => $k2 => $v2"; 
		$str_onchange = ' onchange="loadcontent(\''.base_url().$ci_ctrl.'/list_data_child_2/0/\'+$(\'select#owner_id\').val()+\'/'.$terminal_id.'/'.$product_id.'/'.$item_id.'\',\'tproductlist\')" ';
 
		$data['listmenu_0'] = $this->allfunc->listmenuarray2($lmenu,$datalist,$str_onchange); 
 		$data['listmenu_1'] = $this->list_data_child(11,$owner_id,$terminal_id,$product_id,$item_id); 
 		$data['listmenu_2'] = $this->list_data_child(22,$owner_id,$terminal_id,$product_id,$item_id); 
		$data['listmenu_3'] = '';//$this->list_data_child(33,$owner_id,$terminal_id,$product_id,$item_id);
		
		
		
		 
		//---form vars 
		$owner 	  	= 'all';
		$terminal 	= 'none';
		$ip 	  	= 'none';		
		$product 	= 'none';			
		$address 	= 'none';		
		$location 	= 'none';
		$total_item = 0;	
		$total_amount = 0;	
		
		//$qData = $this->allmodel->getTableWhere('md_terminal_owner','id',$owner_id,1); 
 		//foreach($datalist as $k => $v) foreach($v as $k2 => $v2) echo "<br>$k => $k2 => $v2";  
		//if(isset( $row1['name'])) $owner = $row1['name'];
		//$strOWN = '';
		//foreach($qData as $k => $row){
			//$strOWN .= $row['IP'].","; 
		//}
		//$qData2 = $this->allmodel->getTableWhere('vending_terminal','id',$terminal_id,1); 
		//foreach($row2 as $k => $v) foreach($v as $k2 => $v2) echo "<br>$k => $k2 => $v2";  
				 
		$q = $this->allmodel->getQueryTable('vending_terminal'); 
  
		$qData = $this->db->query($q); 
		$strOWN = $strIP = $strPID = $strADD = $strLOC = $strTXID = '';
		
		if($qData->num_rows()) 
		foreach($qData->result_array() as $k => $row){
			$strIP  .= $row['IP'].",";
			$strTID .= $row['terminal_ID'].","; 
			$strOID .= $row['terminal_owner'].","; 
			$strPID .= $row['product_id'].",";  
			$strADD .= $row['terminal_address'].",";  
			$strLOC .= $row['terminal_tenant']."--- ".$row['venue']."--- ".$row['area']."--- ".$row['city']."--- ".$row['province']."--- ".$row['country'].",";  
			$strTXID .= $row['trx_code_id'].","; 
		} 
		$strIP 	= substr($strIP,0,strlen($strIP)-1);
		$strOID = substr($strOID,0,strlen($strOID)-1);
		
		$strTID	= substr($strTID,0,strlen($strTID)-1); 
		$strADD = substr($strADD,0,strlen($strADD)-1);  
		$strLOC = substr($strLOC,0,strlen($strLOC)-1);  
		$strTXID= substr($strTXID,0,strlen($strTXID)-1); 
		
		$arrIP  = explode(",",$strIP);
		$arrTID = explode(",",$strTID);
		$arrOID = explode(",",$strOID);
		$arrPID = explode(",",$strPID);
		$arrADD = explode(",",$strADD);
		$arrLOC = explode(",",$strLOC);
		$arrTXID= explode(",",$strTXID);
 
		$aOID = array_unique($arrOID);
		$aPID = array_unique($arrPID); 
		
		$aTID = array_unique($arrTID);
		$aIP  = array_unique($arrIP);
		$aADD = array_unique($arrADD);
		$aLOC = array_unique($arrLOC);
		$aTXID = array_unique($arrTXID);
		 
		
		if(!empty($owner_id)) {
			$owner = $this->allmodel->getTableWhere('md_terminal_owner','id',$owner_id,1,'name','name');  
		}elseif(count($aOID)>1 || (count($aOID)==1&&!empty($owner_id)) ){ $owner = 'all';}
 
		if(!empty($terminal_id)) {
			$tid = $this->allmodel->getTableWhere('vending_terminal','id',$terminal_id,1,'id','terminal_id'); 
			//$ip		  = $this->allmodel->getTableWhere('vending_terminal','id',$terminal_id,1,'id','IP');  
			foreach($aTID as $kk => $vv)  //echo "<br>$kk => $vv => $tid";
			if($vv==$tid){  
				$ip 	  = $aIP[$kk];
				$terminal = $aTID[$kk]; 
				$address  = $aADD[$kk];
				$location = str_replace("---",",",$aLOC[$kk]);
			}  
		}elseif(count($aTID)>1 || (count($aTID)==1&&!empty($terminal_id))){ $terminal = $ip = $address  = $location  = 'all'; }
 
		if(!empty($product_id)) {
			$product = $this->allmodel->getTableWhere('pd_product','id',$product_id,1,'product','product');  
		}elseif(count($aPID)>1 || (count($aPID)==1&&!empty($product_id)) ){ $product = 'all';}
 
 
		
		
		
		//-- query TRX
		// id 	kdtrx 	dt 	tm 	vmid 	 jmlbeli 	hargabeli 	isikartu 	biayakartu 	totalbayar
		// kdtrx 	dt 	tm 	vmid
		$strTRXID = '';
		foreach($aTXID as $k => $varkey) if($varkey){ //echo "<br>$k => $varkey";
			$TRX_ID = $this->allmodel->getTableWhere('md_transaction_code','id',$varkey,1,'trx_code','trx_code'); 
			//$strTRXID .= " kdtrx = '".$TRX_ID."' or";
			$strTRXID .= " kdtrx = '' or";
		} 
		$strTRXID = substr($strTRXID,0,strlen($strTRXID)-2);
		if(!empty($strTRXID))
		$strTRXID = '';//"( ".$strTRXID." )";
		
		$strTID = '';
		if($terminal=='none'||$terminal=='all'){
			foreach($aTID as $k => $varkey) if($varkey){  //echo "<br>$k => $varkey";  
				 $strTID .= " terminal_id = '".$varkey."' or"; 
			} 
			$strTID = substr($strTID,0,strlen($strTID)-2);
		} else { 	
			$strTID .= " terminal_id = '".$terminal."'";
		}
		
		if(!empty($strTID))
		$strTID = " ( ".$strTID." ) ";//" and ( ".$strTID." )";
 
		$strDT = "and ( `date` >= '".$data['dt1']." 00:00:00' and `date` <= '".$data['dt2']." 23:59:59' ) ";  
 
		echo $q = "Select * From `topup_mandiri` Where $strTRXID $strTID $strDT Order By id Desc ";
 		
		$tData = $this->db->query($q); 
		$jmlbeli=$totalbayar=0; $n=0;
 		if($tData->num_rows()) 
		foreach($tData->result_array() as $rowTrx){
			//foreach($rowTrx as $k2 => $v2) echo "<br>$k => $k2 => $v2"; 
			$jmlbeli 	+= $rowTrx['jmlbeli'];
			$totalbayar += $rowTrx['value']; 
			$n++;
		} 
		$total_item   = $n ."";
		$total_amount = "Rp. ".number_format($totalbayar,0,',','.');
		
		$data['rowTrx']  =  $tData->result_array();
		 
		
		
		 
 
 
		$data['owner'] 	      = $owner; 
		$data['terminal']     = $terminal; 
		$data['ip'] 	      = $ip; 
		$data['product']  	  = $product;  
		$data['address']  	  = $address;     
		if($location!="all") 
		$data['location'] = substr($location,1,strlen($location));  
		else 
		$data['location'] = $location;
		
		$data['total_item']   = $total_item; 
		$data['total_amount'] = $total_amount; 
 
		$data['table_trx'] 	  = "topup_mandiri";    
 
		$data['indexData']  = '';//$this->funcreport->indexDataTable($data['ci_ctrl'],$data['ci_func'],$data['TABLE'],$curpage,$data['limit'],$status_id,$sort,$order,$ci_changePage,$result_id,0,$lval2,$data['dl1'],$data['dl2']); 

		$this->load->view('report/table_data_view',$data);  
 
	}
	
	 function summary_transaction($dt1="",$dt2="",$owner_id=0,$terminal_id=0,$product_id=0,$item_id=0){  

		if(empty($dt1)) $first = 1;
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit);  
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;




		//---- temp
		$data['is_pop']  = 1; 
		
		
		
		$data['ci_ctrl']  = $ci_ctrl  = strtolower(__CLASS__);
		$data['ci_func']  = $ci_func  = strtolower(__FUNCTION__);
		
		
		
		$data['callfunc'] 	= $callfunc   = '/report_data'; //-- form filter data, submit to this function
		$data['reportfunc'] = $reportfunc = 'summary_transaction'; //-- form filter data, submit to this function
  
		if(empty($dt1)) $data['dt1'] = date("Y-m-d"); else $data['dt1'] = $dt1;  
		if(empty($dt2)) $data['dt2'] = date("Y-m-d"); else $data['dt2'] = $dt2; 
 
 		//--var list owner
		$lmenu['select_name_id'] 	= 'owner_id';
  		$lmenu['slc_key']			= 'id';
 		$lmenu['selected']			= $owner_id;
 		$lmenu['show_key_name']		= 'name'; 
 		$lmenu['first_item_val'] 	= 0;
 		$lmenu['first_item_text']	= 'all';  
		$datalist = $this->allmodel->getTableWhere('md_terminal_owner','id',0,1); 
 		//foreach($datalist as $k => $v) foreach($v as $k2 => $v2) echo "<br>$k => $k2 => $v2"; 
		$str_onchange = ' onchange="loadcontent(\''.base_url().$ci_ctrl.'/list_data_child_21/0/\'+$(\'select#owner_id\').val()+\'/'.$terminal_id.'/'.$product_id.'/'.$item_id.'\',\'tproductlist\')" ';
 
		$data['listmenu_0'] = $this->allfunc->listmenuarray2($lmenu,$datalist,$str_onchange); 
 		$data['listmenu_1'] = $this->list_data_child(11,$owner_id,$terminal_id,$product_id,$item_id); 
 		$data['listmenu_2'] = '';//$this->list_data_child(22,$owner_id,$terminal_id,$product_id,$item_id); 
		$data['listmenu_3'] = '';//$this->list_data_child(33,$owner_id,$terminal_id,$product_id,$item_id);
		
		
		
		 
		//---form vars 
		$owner 	  	= 'all';
		$terminal 	= 'none';
		$ip 	  	= 'none';		
		$product 	= '';//'none';			
		$address 	= 'none';		
		$location 	= 'none';
		$total_item = 0;	
		$total_amount = 0;	
 		
		//$qData = $this->allmodel->getTableWhere('md_terminal_owner','id',$owner_id,1); 
 		//foreach($datalist as $k => $v) foreach($v as $k2 => $v2) echo "<br>$k => $k2 => $v2";  
		//if(isset( $row1['name'])) $owner = $row1['name'];
		//$strOWN = '';
		//foreach($qData as $k => $row){
			//$strOWN .= $row['IP'].","; 
		//}
		//$qData2 = $this->allmodel->getTableWhere('vending_terminal','id',$terminal_id,1); 
		//foreach($row2 as $k => $v) foreach($v as $k2 => $v2) echo "<br>$k => $k2 => $v2";  
				 
		$q = $this->allmodel->getQueryTable('vending_terminal'); 
  
		$qData = $this->db->query($q); 
		$strOWN = $strIP = $strPID = $strADD = $strLOC = $strTXID = '';
		
		if($qData->num_rows()) 
		foreach($qData->result_array() as $k => $row){
			$strIP  .= $row['IP'].",";
			$strTID .= $row['terminal_ID'].","; 
			$strOID .= $row['terminal_owner'].","; 
			$strPID .= $row['product_id'].",";  
			$strADD .= $row['terminal_address'].",";  
			$strLOC .= $row['terminal_tenant']."--- ".$row['venue']."--- ".$row['area']."--- ".$row['city']."--- ".$row['province']."--- ".$row['country'].",";  
			$strTXID .= $row['trx_code_id'].","; 
		} 
		$strIP 	= substr($strIP,0,strlen($strIP)-1);
		$strOID = substr($strOID,0,strlen($strOID)-1);
		
		$strTID	= substr($strTID,0,strlen($strTID)-1); 
		$strADD = substr($strADD,0,strlen($strADD)-1);  
		$strLOC = substr($strLOC,0,strlen($strLOC)-1);  
		$strTXID= substr($strTXID,0,strlen($strTXID)-1); 
		
		$arrIP  = explode(",",$strIP);
		$arrTID = explode(",",$strTID);
		$arrOID = explode(",",$strOID);
		$arrPID = explode(",",$strPID);
		$arrADD = explode(",",$strADD);
		$arrLOC = explode(",",$strLOC);
		$arrTXID= explode(",",$strTXID);
 
		$aOID = array_unique($arrOID);
		$aPID = array_unique($arrPID); 
		
		$aTID = array_unique($arrTID);
		$aIP  = array_unique($arrIP);
		$aADD = array_unique($arrADD);
		$aLOC = array_unique($arrLOC);
		$aTXID = array_unique($arrTXID);
		 
		
		if(!empty($owner_id)) {
			$owner = $this->allmodel->getTableWhere('md_terminal_owner','id',$owner_id,1,'name','name');  
		}elseif(count($aOID)>1 || (count($aOID)==1&&!empty($owner_id)) ){ $owner = 'all';}
 
		if(!empty($terminal_id)) {
			$tid = $this->allmodel->getTableWhere('vending_terminal','id',$terminal_id,1,'id','terminal_id'); 
			//$ip		  = $this->allmodel->getTableWhere('vending_terminal','id',$terminal_id,1,'id','IP');  
			foreach($aTID as $kk => $vv)  //echo "<br>$kk => $vv => $tid";
			if($vv==$tid){  
				$ip 	  = $aIP[$kk];
				$terminal = $aTID[$kk]; 
				$address  = $aADD[$kk];
				$location = str_replace("---",",",$aLOC[$kk]);
			}  
		}elseif(count($aTID)>1 || (count($aTID)==1&&!empty($terminal_id))){ $terminal = $ip = $address  = $location  = 'all'; }
 
		if(!empty($product_id)) {
			$product = $this->allmodel->getTableWhere('pd_product','id',$product_id,1,'product','product');  
		}elseif(count($aPID)>1 || (count($aPID)==1&&!empty($product_id)) ){ $product = 'all';}
 
 
		
		
		
		//-- query TRX
		// id 	kdtrx 	dt 	tm 	vmid 	 jmlbeli 	hargabeli 	isikartu 	biayakartu 	totalbayar
		// kdtrx 	dt 	tm 	vmid
		$strTRXID = '';
		foreach($aTXID as $k => $varkey) if($varkey){ //echo "<br>$k => $varkey";
			$TRX_ID = $this->allmodel->getTableWhere('md_transaction_code','id',$varkey,1,'trx_code','trx_code'); 
			//$strTRXID .= " kdtrx = '".$TRX_ID."' or";
			$strTRXID .= " kdtrx = '' or";
		} 
		$strTRXID = substr($strTRXID,0,strlen($strTRXID)-2);
		if(!empty($strTRXID))
		$strTRXID = '';//"( ".$strTRXID." )";
		
		$strTID = '';
		if($terminal=='none'||$terminal=='all'){
			foreach($aTID as $k => $varkey) if($varkey){  //echo "<br>$k => $varkey";  
				 //$strTID .= " tid = '".$varkey."' or"; 
				 $strTID1 .= " 'tid' = '".$varkey."' or";  
			} 
			//$strTID = substr($strTID,0,strlen($strTID)-2);
			$strTID1 = substr($strTID1,0,strlen($strTID1)-2);
		} else { 	
			//$strTID .= " tid = '".$terminal."'";
			$strTID1 .= " 'tid' = '".$terminal."'"; 
		}
		
		$strTID11 = str_replace("'tid'", "vmid",$strTID1);
		$strTID12 = str_replace("'tid'", "terminal_id",$strTID1);
		
 
		
		if(!empty($strTID))
		$strTID = " ( ".$strTID." ) ";//" and ( ".$strTID." )";
 
		//$strDT = "and ( `date` >= '".$data['dt1']." 00:00:00' and `date` <= '".$data['dt2']." 23:59:59' ) ";  
 
 		 $strDT1s1 = " SUBSTRING_INDEX(REPLACE(dt,'-',''),' ',1) >= ".str_replace("-","",str_replace(":","",str_replace(" ","",$data['dt1']))) ;
		 $strDT1e1 = " SUBSTRING_INDEX(REPLACE(dt,'-',''),' ',1) <= ".str_replace("-","",str_replace(":","",str_replace(" ","",$data['dt2']))) ; 
 
 		 $strDT1s2 = " SUBSTRING_INDEX(REPLACE(date,'-',''),' ',1) >= ".str_replace("-","",str_replace(":","",str_replace(" ","",$data['dt1']))) ;
		 $strDT1e2 = " SUBSTRING_INDEX(REPLACE(date,'-',''),' ',1) <= ".str_replace("-","",str_replace(":","",str_replace(" ","",$data['dt2']))) ; 
 
 
		//echo $q = "Select * From `topup_mandiri` Where $strTRXID $strTID $strDT Order By id Desc ";
		
		
 		
		$q =  "SELECT
					dt, 
					vmid as tid, 
					'card_prepaid' as trx_type, 
					CONCAT(dt,' ',tm) as datetime_order, 
					jmlbeli as item, 
					totalbayar as payment
					
					FROM trx 
					Where ( $strTID11 ) and $strDT1s1 and $strDT1e1
					 
 
					UNION 
					
					SELECT 
					 
					SUBSTRING_INDEX(date,' ',1) as dt, 
					terminal_id as tid, 
					'topup_mandiri', 
					date as datetime_order, 
					'1', 
					value as payment
					
					FROM topup_mandiri 
					
					Where ( $strTID12 ) and $strDT1s2 and $strDT1e2 
 
					ORDER BY datetime_order DESC 
					";
		
		
		$tData = $this->db->query($q); 
		$jmlbeli=$totalbayar=0; $n=0;
		
		$arr_summary = array();
		
 		if($tData->num_rows()) 
		foreach($tData->result_array() as $k =>  $rowTrx){
			//foreach($rowTrx as $k2 => $v2) echo "<br>$k => $k2 => $v2"; 
			$rowtid  = $rowTrx['tid'];
			$rowdt   = $rowTrx['dt'];
			$rowtype = $rowTrx['trx_type'];
			$rowqua = $rowTrx['item'];
			$rowprc = $rowTrx['payment'];
			$arr_summary[$rowtid][$rowdt][$rowtype]['item'][$n] 	= $rowTrx['item'];
			$arr_summary[$rowtid][$rowdt][$rowtype]['payment'][$n] 	= $rowTrx['payment']; 
			
			$jmlbeli 	+= $rowTrx['item'];
			$totalbayar += $rowTrx['payment']; 
 
			$n++;
		} 
		
		/* 
		foreach($arr_summary as $k => $v)
		foreach($v as $k2 => $v2)  
		foreach($v2 as $k3 => $v3) 
		foreach($v3 as $k4 => $v4) 
		foreach($v4 as $k5 => $v5)//{
		//if($k4=='tot_items') 
		echo "<br>$k => $k2 => $k3 => $k4 => $k5 => $v5"; 
		//if($k4=='tot_payments') 
		echo "<br>$k => $k2 => $k3 => $k4 => $k5 => $v5"; 
		//}
		exit;
		
		//--- 210-00-000-0-111 => 2014-12-22 => card_prepaid => item => 0 => 2
		//--- 210-00-000-0-111 => 2014-12-22 => card_prepaid => payment => 0 => 100000
 
		echo "<br>jmlbeli=".$jmlbeli;
		echo "<br>totalbayar=".$totalbayar;
		echo "<br>";
		*/ 
 
		$arr_summary_trx = array(); 
		$crd_tot_item = $crd_tot_payment = $tup_tot_item = $tup_tot_payment = 0; 
		
		$cur_tid = '';
		foreach($arr_summary as $k => $v){  
			foreach($v as $k2 => $v2){ 
				foreach($v2 as $k3 => $v3){  
					if($k3=='card_prepaid'){
						foreach($v3 as $k4 => $v4){ 
							if($k4=='item'){    //echo "<br>".count($v4); 
								$tot_item = 0;
								foreach($v4 as $k5 => $v5){  
									//echo "<br>$k => $k2 => $k3 => $k4 => $k5 => $v5"; 
									//210-00-000-0-111 => 2014-12-22 => card_prepaid => item => 0 => 2
									$tot_item += $v5;
								}
								$arr_summary_trx[$k][$k2]['card']['item'] = $tot_item;
								//echo "<br>".$tot_item;
								//exit; 
							}
							//if($k4=='payment') echo "<br>".count($v4);  
							if($k4=='payment'){    //echo "<br>".count($v4); 
								$tot_payment = 0;
								foreach($v4 as $k5 => $v5){   
									$tot_payment += $v5;
								}
								$arr_summary_trx[$k][$k2]['card']['payment'] = $tot_payment; 
							} 
						}
		 			}
					if($k3=='topup_mandiri'){
						foreach($v3 as $k4 => $v4){ 
							if($k4=='item'){    //echo "<br>".count($v4); 
								$tot_item = 0;
								foreach($v4 as $k5 => $v5){  
									//echo "<br>$k => $k2 => $k3 => $k4 => $k5 => $v5"; 
									//210-00-000-0-111 => 2014-12-22 => card_prepaid => item => 0 => 2
									$tot_item += $v5;
								}
								$arr_summary_trx[$k][$k2]['topup']['item'] = $tot_item;
								//echo "<br>".$tot_item;
								//exit; 
							}
							//if($k4=='payment') echo "<br>".count($v4);  
							if($k4=='payment'){    //echo "<br>".count($v4); 
								$tot_payment = 0;
								foreach($v4 as $k5 => $v5){   
									$tot_payment += $v5;
								}
								$arr_summary_trx[$k][$k2]['topup']['payment'] = $tot_payment; 
							} 
						}
		 			}
		
		
				} 
			} 
		}
		/* 
		foreach($arr_summary_trx as $k => $v)
		foreach($v as $k2 => $v2)  
		foreach($v2 as $k3 => $v3) 
		//foreach($v3 as $k4 => $v4)//{
		//if($k4=='tot_items') 
		echo "<br>$k => $k2 => $k3 => $v3"; 
		//if($k4=='tot_payments') echo "<br>$k => $k2 => $k3 => $k4 => $v4"; 
		//}
		exit; 
		
		echo "<br>";
		echo $tot_item;
		echo "<br>";
		echo $tot_payment;
		//$arr_summary_trx[][][][] = ; //
		exit;
		//--- combine same vm and date
		
		*/
 
		$total_item   = $n ."";
		$total_amount = "Rp. ".number_format($totalbayar,0,',','.');
 
		$data['owner'] 	      = $owner; 
		$data['terminal']     = $terminal; 
		$data['ip'] 	      = $ip; 
		$data['product']  	  = $product;  
		$data['address']  	  = $address;     
		if($location!="all") 
		$data['location'] = substr($location,1,strlen($location));  
		else 
		$data['location'] = $location;
		
		$data['total_item']   = $total_item; 
		$data['jmlbeli']   	  = $jmlbeli;
		$data['total_amount'] = $total_amount; 

		$data['table_trx'] 	  = "topup_mandiri";    
 
		$data['indexData']    = '';//$this->funcreport->indexDataTable($data['ci_ctrl'],$data['ci_func'],$data['TABLE'],$curpage,$data['limit'],$status_id,$sort,$order,$ci_changePage,$result_id,0,$lval2,$data['dl1'],$data['dl2']); 


		$data['rowTrx']  	  = $tData->result_array();
		$data['rowTrxSum']    = $arr_summary_trx;
		
		
		$this->load->view('report/sum_trx_view',$data);  
 
	}
	//-- khusus summary	
 	function list_data_child_21($num=0,$owner_id,$terminal_id,$product_id,$item_id=0){ 
 
 			$listmenu_1 = $this->list_data_child(11,$owner_id,0,$product_id,$item_id);
 			$listmenu_2 = $this->list_data_child(22,$owner_id,$terminal_id,0,$item_id);
 			$listmenu_3 = $this->list_data_child(33,$owner_id,$terminal_id,$product_id,0); 
			echo $result = '
				<span>Terminal : </span>	
            	<span id="vmlist">'.$listmenu_1.'</span> '; 
            	//<span> &nbsp; Item : </span>	
            	//<span id="productlist">'.$listmenu_3.'</span>'; 
	}
	
	
	 
 
	function report_data(){ 
		
		if($_POST){ 
			foreach($_POST as $k => $val){  //echo "<br>$k => $val";  
				/*
				reportfunc => sales_transaction
				owner_id => 3
				terminal_id => 0
				product_id => 0
				dt1 => 2014-09-01
				dt2 => 2014-10-30
				button => Submit
				*/
				$$k = $val;   
			}  
		 	if(empty($owner_id)) 	$owner_id 	 = "0";
		 	if(empty($terminal_id)) $terminal_id = "0"; 
		 	if(empty($product_id)) 	$product_id  = "0"; 
			
			//echo "<br>"; 
			//$ci_ctrl  = strtolower($ci_ctrl);
			//$strredir = "$curpage/$limit/$status_id/$sort/$order/".$ci_ctrl."/$ci_changePage/$result_id/".$owner_id."/".$terminal_id."/".$product_id."/$t1/$t2";
		    redirect('/'.strtolower(__CLASS__).'/'.$reportfunc.'/'.$dt1.'/'.$dt2.'/'.$owner_id.'/'.$terminal_id.'/'.$product_id.'/0','refresh'); 
			exit;
			
			//sales_transaction($dt1="",$dt2="",$owner_id=0,$terminal_id=0,$product_id=0,$item_id=0){
		} 	
	
	
	
	}
	 
	
	
 	/*	
	function sales_transactionxxxxx($curpage=1,$limit=10,$status_id=1,$sort="id",$order="asc",$ci_ctrl=__CLASS__,$ci_changePage="changepage",$result_id="dspdata",
	$listval1="0",$listval2="0",$listval3="0",$dt1="",$dt2=""){  
 
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit); 
		 
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;

		if($_POST){ 
			foreach($_POST as $k => $val){  //echo "<br>$k => $val";  
				$$k = $val; 
				$data[$k] = $val;  
			}  
		 	if(empty($owner_id)) 	$owner_id = "0";
		 	if(empty($terminal_id)) $terminal_id = "0"; 
		 	if(empty($product_id)) $product_id = "0"; 
			
			//echo "<br>";
			$ci_ctrl  = strtolower($ci_ctrl);
			$strredir = "$curpage/$limit/$status_id/$sort/$order/".$ci_ctrl."/$ci_changePage/$result_id/".$owner_id."/".$terminal_id."/".$product_id."/$t1/$t2";
		    redirect('/'.strtolower(__CLASS__).'/'.strtolower(__FUNCTION__).'/'.strtolower($strredir),'refresh'); 
			exit;
		} 
		
		$data['ci_ctrl'] = $ci_ctrl = strtolower($data['ci_ctrl']);
		$data['ci_func'] = $ci_func = strtolower($data['ci_func']);
 
  		$lmenu['select_name_id'] 	= 'owner_id';
  		$lmenu['slc_key']			= 'id';
 		$lmenu['selected']			= $listval1;
 		$lmenu['show_key_name']		= 'name'; 
 		$lmenu['first_item_val'] 	= 0;
 		$lmenu['first_item_text']	= 'all';  
		$datalist = $this->allmodel->getTableWhere('md_terminal_owner','id',0,1); 
 		foreach($datalist as $k => $v) foreach($v as $k2 => $v2) echo "<br>$k => $k2 => $v2"; 

 
		$data['callfunc'] = '/report_data'; //-- form filter data, submit to this function
		
		$str_onchange = ' onchange="loadcontent(\''.base_url().$ci_ctrl.
		'/list_data_child_2/0/\'+$(\'select#owner_id\').val()+\'/'.$listval2.'/'.$listval3.'\',\'tproductlist\')" ';
 
		$data['listmenu_0'] = $this->allfunc->listmenuarray2($lmenu,$datalist,$str_onchange);	 
 		$data['listmenu_1'] = $this->list_data_child(11,$listval1,$listval2,$listval3);
 		$data['listmenu_2'] = $this->list_data_child(22,$listval1,$listval2,$listval3);
 
		if(empty($d1)) $data['dt']  = date("Y-m-d"); else $data['dt']  = $d1;  
		if(empty($d2)) $data['dt2'] = date("Y-m-d"); else $data['dt2'] = $d2;   
		
		$data['dl1']		= $data['dt'];  
		$data['dl2']		= $data['dt2'];  
 
		$data['TABLE'] 		= "trx";   
 
		$data['indexData']  = $this->funcreport->indexDataTable($data['ci_ctrl'],$data['ci_func'],$data['TABLE'],$curpage,$data['limit'],$status_id,$sort,$order,$ci_changePage,$result_id,0,$lval2,$data['dl1'],$data['dl2']); 

		$this->load->view('report/table_data_view',$data);  
 
	}
	*/
	
	
	
	function list_data_child_2($num=0,$owner_id,$terminal_id,$product_id,$item_id=0){ 
 
 			$listmenu_1 = $this->list_data_child(11,$owner_id,0,$product_id,$item_id);
 			$listmenu_2 = $this->list_data_child(22,$owner_id,$terminal_id,0,$item_id);
 			$listmenu_3 = $this->list_data_child(33,$owner_id,$terminal_id,$product_id,0);
		
			echo $result = '
				<span>Terminal : </span>	
            	<span id="vmlist">'.$listmenu_1.'</span>
            	<span> &nbsp; Product : </span>	
            	<span id="productlist">'.$listmenu_2.'</span>';
				
            	//<span> &nbsp; Item : </span>	
            	//<span id="productlist">'.$listmenu_3.'</span>'; 
 
	} 
	
		function list_data_child_3($num=0,$owner_id,$terminal_id,$product_id,$item_id=0){ 
 
 			$listmenu_1 = $this->list_data_child(11,$owner_id,0,$product_id,$item_id);
 			$listmenu_2 = $this->list_data_child(22,$owner_id,$terminal_id,0,$item_id);
 			$listmenu_3 = '';//$this->list_data_child(33,$owner_id,$terminal_id,$product_id,0);
		
			echo $result = '
				<span>Terminal : </span>	
            	<span id="vmlist">'.$listmenu_1.'</span>
            	<span> &nbsp; Product : </span>	
            	<span id="productlist">'.$listmenu_2.'</span>';
				
            	//<span> &nbsp; Item : </span>	
            	//<span id="productlist">'.$listmenu_3.'</span>'; 
 
	} 
	
	
	function list_data_child($num=1,$owner_id,$terminal_id,$product_id,$item_id){ 
	 
		if($num==1||$num==11){
			
			$lmenu['select_name_id'] 	= 'terminal_id';
			$lmenu['slc_key']			= 'id';
			$lmenu['selected']			= $terminal_id;
			$lmenu['show_key_name']		= 'terminal_id';
			$lmenu['first_item_val'] 	= 0;
			$lmenu['first_item_text']	= 'all'; 
			
			$datalist = $this->allmodel->getTableWhere('vending_terminal','owner_id',$owner_id,1,'terminal_id'); 
			//foreach($dlist as $k => $v) foreach($v as $k2 => $v2) echo "<br>$k => $k2 => $v2"; exit; 
	 
			$str_onchange = ' onchange="loadcontent(\''.base_url().
			strtolower(__CLASS__).'/list_data_child/2/'.$owner_id.'/\'+$(\'select#terminal_id\').val()+\'/'.$product_id.'\',\'productlist\')" ';
	 
			$result = $this->allfunc->listmenuarray2($lmenu,$datalist,$str_onchange);	 
 
			if($num==1)  echo $result;
			if($num==11) return $result;
			
		}
		elseif($num==2||$num==22){
			
			$lmenu['select_name_id'] 	= 'product_id';
			$lmenu['slc_key']			= 'id';
			$lmenu['selected']			= $product_id;
			$lmenu['show_key_name']		= 'product';
			$lmenu['first_item_val'] 	= 0;
			$lmenu['first_item_text']	= 'all'; 
 
			$datalist = $this->allmodel->getTableProductByTerminalID($owner_id,$terminal_id,1); 
			//foreach($datalist as $k => $v) foreach($v as $k2 => $v2) echo "<br>$k => $k2 => $v2"; exit; 
	 
			$str_onchange = ' onchange="loadcontent(\''.base_url().strtolower(__CLASS__).'/list_product/'.$owner_id.'/\'+$(\'select#terminal_id\').val()+\'/'.$terminal_id.'/'.$product_id.'\',\'productlist\')" ';
	 		
			$result = $this->allfunc->listmenuarray2($lmenu,$datalist,$str_onchange);
			
			if($num==2)  echo $result;
			if($num==22) return $result;
			
		}
		elseif($num==3||$num==33){
			
			$lmenu['select_name_id'] 	= 'item_id';
			$lmenu['slc_key']			= 'id';
			$lmenu['selected']			= $item_id;
			$lmenu['show_key_name']		= 'item';
			$lmenu['first_item_val'] 	= 0;
			$lmenu['first_item_text']	= 'all'; 
 
			$datalist = $this->allmodel->getTableProductByTerminalID($owner_id,$terminal_id,1); 
			//foreach($datalist as $k => $v) foreach($v as $k2 => $v2) echo "<br>$k => $k2 => $v2"; exit; 
	 
			$str_onchange = ' onchange="loadcontent(\''.base_url().strtolower(__CLASS__).'/list_product/'.$owner_id.'/\'+$(\'select#terminal_id\').val()+\'/'.$terminal_id.'/'.$product_id.'\',\'productlist\')" ';
	 		
			$result = $this->allfunc->listmenuarray2($lmenu,$datalist,$str_onchange);
			
			if($num==3)  echo $result;
			if($num==33) return $result;
			
		}
		
 
	}
/*
	function list_report_slc($num=0,$listval1=0,$listval2=0,$listval3=0){
		 
		$lmenu1['ci_ctrl']			= strtolower(__CLASS__);
		//$lmenu1['status_id']		= 1;	 
		//$lmenu1['owner_id']			= $listval1;	 
		//$lmenu1['terminal_id']		= $listval2;	 
		//$lmenu1['product_id']		= $listval3;	 
		
		

 		if($num==0){
		$lmenu1['callfunc']			= 'terminallist';
		
		$lmenu1['table']			= 'md_terminal_owner';
		$lmenu1['where_key']		= 'owner_id';
		$lmenu1['where_val']		= $listval1;
		
		$lmenu1['select_name_id']	= 'owner_id';
		$lmenu1['show_key_name']	= 'name';
		$lmenu1['slc_key']		 	= 'id';		//selected value from first list 
		$lmenu1['first_item_val']  	= 0;
		$lmenu1['first_item_text'] 	= "All";
		$lmenu1['result_id'] 		= '';
		foreach($lmenu1 as $k => $val) $$k = $val;
 
		$lmenu2['table']			= 'vending_terminal';
		$lmenu2['where_key']		= 'terminal_id'; 
		$lmenu2['where_val']		= $listval2;  
		$lmenu2['select_name_id']	= 'terminal_id';
		$lmenu2['show_key_name']	= 'terminal_id';
		$lmenu2['slc_key']		 	= 'id'; 
		$lmenu2['first_item_val']  	= 0;
		$lmenu2['first_item_text'] 	= "All";
		$lmenu2['result_id'] 		= 'vmlist'; 
		foreach($lmenu2 as $k => $val){
			$vKey = $k."2"; 
			$$vKey = $val;
		} 
		/*
		$lmenu3['callfunc']			= 'getlistproduct';
		$lmenu3['table']			= 'pd_product';
		$lmenu3['where_key']		= $lkey3;
		$lmenu3['where_val']		= $lval3; 	 
		$lmenu3['select_name_id']	= 'product_id';
		$lmenu3['show_key_name']	= 'product';
		$lmenu3['slc_key']		 	= 'id'; 
		$lmenu3['first_item_val']  	= 0;
		$lmenu3['first_item_text'] 	= "All";
		$lmenu3['result_id'] 		= 'productlist'; 
		foreach($lmenu3 as $k => $val){
			$vKey = $k."3"; 
			$$vKey = $val;
		}
	 
		echo $str_onchange = ' onchange="loadcontent(\''.base_url().$ci_ctrl.'/'.$callfunc.'/'.
		$table2.'/'.$show_key_name2.'/'.$status_id.'/'.$where_val2.'/'.$where_key.'/\'+$(\'select#'.$select_name_id.'\').val()+\'/'.
		$select_name_id2.'/'.$result_id2.'/'.$firstitem2.'\',\''.
		$result_id2.'\')" ';
		
		return $this->allfunc->listmenuarray2($lmenu1,$str_onchange);
		
		}
		
		
		  
		
		$str_onchange2 = ' onchange="loadcontent(\''.base_url().$ci_ctrl.'/'.$callfunc3.'/'.
		$table3.'/'.$show_key_name3.'/'.$status_id.'/'.$where_val3.'/'.$where_key2.'/\'+$(\'select#'.$select_name_id2.'\').val()+\'/'.
		$select_name_id3.'/'.$result_id3.'/'.$firstitem3.'\',\''.
		$result_id3.'\')" ';
		 
		$data['listmenu_1'] =  $this->allfunc->listmenuarray2($lmenu2,$str_onchange2);
		
	 

		//getlist/md_terminal_owner/terminal_id/1/0/owner_id/3/vm_id/vmlist/
		//getlist/vending_terminal/terminal_id/1/0/owner_id/'+$('select#owner_id').val()+'/terminal_id/vmlist/
		 
		
		//echo $this->allfunc->listmenu($table,$rowname,$status_id,$selected,$where_key,$where_val,$listname,$result_id,$firstitem); 
 
	} 
	

	function terminallist($table="",$rowname='name',$status_id=1,$selected=0,$where_key='',$where_val=0,$listname='id',$result_id='listdata',$firstitem='All'){ 
		
		//getlist/md_terminal_owner/terminal_id/1/0/owner_id/3/vm_id/vmlist/
		//getlist/vending_terminal/terminal_id/1/0/owner_id/'+$('select#owner_id').val()+'/terminal_id/vmlist/
		
		//getlist/vending_terminal/terminal_id/1/0/terminal_id/'+$('select#owner_id').val()+'/terminal_id/vmlist/','vmlist')" 
		
		echo $this->allfunc->listmenu($table,$rowname,$status_id,$selected,$where_key,$where_val,$listname,$result_id,$firstitem); 
 
	} 
	function qselect(){ 
 		//foreach($_POST as $k => $v) echo "<br>$k => $v";  exit;
		
	
	}
	
 */	
	
	
	
	
	
	
	
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
 		foreach($_POST as $k => $v) echo "<br>$k => $v";  
		
		
		exit;
		
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
