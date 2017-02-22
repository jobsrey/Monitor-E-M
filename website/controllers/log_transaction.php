<?php  
//session_start();  
class Log_transaction extends Controller { 
	function Log_transaction(){   
		parent::Controller(); 
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		$this->load->library('allfunc');  
		$this->load->database(); 
		$this->load->library('session'); 
		if(!$this->session->userdata('logged_in')) redirect('login','refresh');
		  
	} 
	function index(){ 
 		echo "Hello U"; 
	}
		
	function mainvars($ci_func='',$status_id=1,$limit=10){  
		
		$data = $this->allfunc->reflector(__CLASS__,$ci_func); 
	
		//$limit = 2; //-- for test
 
		$data['navMenu']   	= $this->allfunc->navMenu(7);  
		$data['ci_menu'] 	= $this->allfunc->navMenu(7,1);
		$data['ci_ctrl'] 	= strtolower(__CLASS__);  
     	$data['ci_func']	= $ci_func; 
		//$data['TABLE'] 		= $ci_func;   
		//$strTable 			= ucwords(str_replace("_"," ",$data['TABLE'])); 

     	$data['status_id'] 	= $status_id;  
     	$data['limit'] 		= $limit;  

     	$data['pageTITLE']	= ucwords(str_replace("_"," ",$data['ci_ctrl'].' - '.str_replace("Md ","",$strTable)));  
     	$data['pageLABEL'] 	= ucwords(str_replace("_"," ",$data['ci_menu'].' > '.str_replace("Md ","",$strTable)));  

 		return $data;   

	} 
	
	function trx_tracking($dtm1="",$dtm2="",$ip=0,$terminal_id=0,$trx_type=0,$order_by='id',$sort="desc"){ 
 
		if(empty($dt1)) $first = 1;
		
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit);  
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;
 
		$data['ci_ctrl']  	= $ci_ctrl    = strtolower(__CLASS__);
		$data['ci_func']  	= $ci_func    = strtolower(__FUNCTION__); 
		$data['callfunc'] 	= $callfunc   = '/report_data'; 		//-- form filter data, submit to this function
		//$data['reportfunc'] = $reportfunc = $data['ci_func']; 		//-- form filter data, submit to this function
  
		if(empty($dt1)) $data['dt1'] = date("Y-m-d"); else $data['dt1'] = $dt1;  
		if(empty($dt2)) $data['dt2'] = date("Y-m-d"); else $data['dt2'] = $dt2; 
		
		//--- date time string 
		if (strpos($dtm1,"--") !== false) {
			//echo "True";
			$d1 = explode("--",$dtm1);
			$dt1 = $d1[0];
			$tm1 = str_replace(".",":",$d1[1]).":00";
		}else{
			//echo "False";
			$dt1 = date("Y-m-d");
			$tm1 = "00:00:00";   
		}
		if (strpos($dtm2,"--") !== false) {
			//echo "True";
			$d2 = explode("--",$dtm2);
			$dt2 = $d2[0];
			$tm2 = str_replace(".",":",$d2[1]).":00";
		}else{
			//echo "False";
			$dt2 = date("Y-m-d");
			$tm2 = "23:59:59";    
		}
		
 		$data['dt1'] = $dt1; 
		$data['tm1'] = substr($tm1,0,5); 
		$data['dt2'] = $dt2; 
		$data['tm2'] = substr($tm2,0,5);
 
 		//--var list owner
		$lmenu['select_name_id'] 	= 'owner_id';
  		$lmenu['slc_key']			= 'id';
 		$lmenu['selected']			= $owner_id;
 		$lmenu['show_key_name']		= 'name'; 
 		$lmenu['first_item_val'] 	= 0;
 		$lmenu['first_item_text']	= 'all';  
		$datalist = $this->allmodel->getTableWhere('md_terminal_owner','id',0,1); 
		
 		//foreach($datalist as $k => $v) foreach($v as $k2 => $v2) echo "<br>$k => $k2 => $v2"; 
		//$str_onchange = ' onchange="loadcontent(\''.base_url().$ci_ctrl.'/list_data_child_2/0/\'+$(\'select#owner_id\').val()+\'/'.$terminal_id.'/'.$product_id.'/'.$item_id.'\',\'tproductlist\')" ';
  
 		$data['listmenu_vm'] = $this->list_data_child(11,$owner_id,$terminal_id,$product_id,$item_id);  
		

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
		// id,	kdtrx,	kdprd,	terminal_id, date, value, uangmasuk, uangkeluar
		// id	kdtrx	kdprd	terminal_id	datetime_settle	date	nik	terminal	institution	has_settle	type	value	samid	cardid	kaid	sam	report_ka	has_push	ka_idx	ka_balance	ka_counter	sam_counter	trx_counter	kl_id	card_balance	slot	another	uangmasuk	uangkeluar	string_request	status_id
		
		//-- tbk :
		// id	kdtrx	dt	tm	vmid	totaltrx	uangmasuk	cardfull	kartukeluar	sisakartu	string_request
 
		//--union: 
		// id,	kdtrx,	kdprd,			terminal_id, 			date, 							value, 			uangmasuk, uangkeluar
		// id,	kdtrx,	null as kdprd,	vmid as terminal_id, 	CONCAT(dt,' ',tm) as date		null as value	uangmasuk,	null as uangkeluar
 
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
			
			$strTID = " terminal_id = ''"; /////////////////////////--------------------- must select VM
			$data['notif_vmselect'] = 1;
			
		} else { 	
			$strTID .= " terminal_id = '".$terminal."'"; 
			$data['notif_vmselect'] = 0;
		}
		
		//echo $strTID; exit;
		
		if(!empty($strTID))
		$strTID = " ( ".$strTID." ) ";//" and ( ".$strTID." )";
 
 		$strTID_TBK = str_replace("terminal_id","vmid",$strTID);
		
 
		$strDT = "and ( `date` >= '".$dt1." ".$tm1."' and `date` <= '".$dt2." ".$tm2."' ) ";  
		
  		$strDT1s1  = " and REPLACE(REPLACE(CONCAT(dt,'',tm),'-',''),':','') >= ".str_replace("-","",str_replace(":","",str_replace(" ","",$dt1.$tm1))) ;
 		$strDT1e1  = " and REPLACE(REPLACE(CONCAT(dt,'',tm),'-',''),':','') <= ".str_replace("-","",str_replace(":","",str_replace(" ","",$dt2.$tm2))) ; 
 
		 $q = " 
		 	Select id,	kdtrx,	'crd' as kdprd,	vmid,	CONCAT(dt,' ',tm) as date,	totalbayar, jmlbeli, nourut as trx_num, null as slot, null as totaltrx 
			From `trx` 
			Where $strTRXID ".str_replace("terminal_id","vmid",$strTID)."  $strDT1s1 $strDT1e1  
			
			UNION
			
			Select id,	'TOPUP' as kdtrx,	'tup' as kdprd, terminal_id as vmid, date, value as totalbayar, 1 as jmlbeli, trx_counter as trx_num, slot, null as totaltrx 
			
			From `topup_mandiri` 
			Where $strTRXID $strTID $strDT
 
			UNION   
 
			Select id,	kdtrx,	'tbk' as kdprd,	vmid , CONCAT(dt,' ',tm) as date, uangmasuk as totalbayar, null as jmlbeli, null as trx_num, null as slot, totaltrx 
 
			From  `tbk` 
			Where $strTID_TBK $strDT1s1 $strDT1e1 and uangmasuk != 0
 
			ORDER BY date ".$sort_date." 
		"; // and uangmasuk != 0
		
 		
		$tData = $this->db->query($q); 
		$jmlbeli=$totalbayar=0; $n=0;
 		if($tData->num_rows()) 
		foreach($tData->result_array() as $rowTrx){
			//foreach($rowTrx as $k2 => $v2) echo "<br>$k => $k2 => $v2"; 
			if($rowTrx['jmlbeli']){
				$jmlbeli 	+= $rowTrx['jmlbeli'];
				$totalbayar += $rowTrx['totalbayar']; 
				$n++;
			}
		} 
		$total_item   = $n ."";
		$total_amount = number_format($totalbayar,0,',','.');
		
		$data['rowTrx']  	  =  $tData->result_array();
 
		$data['owner'] 	      = $owner; 
		$data['terminal']     = $terminal; 
		$data['ip'] 	      = $ip; 
		$data['product']  	  = $product;  
		$data['address']  	  = $address;    
		 
		if($location!="all") 
		$data['location'] 	  = substr($location,1,strlen($location));  
		else 
		$data['location'] 	  = $location;
		
		$data['total_item']   = $total_item; 
		$data['total_amount'] = $total_amount; 
 
		$data['table_trx'] 	  = "all";    
		
		$data['sort_date'] 	  = $sort_date;    
 
 		if($sort_date=="asc")  $chg_sort = "desc"; 
		if($sort_date=="desc") $chg_sort = "asc"; 
		
		$data['qs'] = "/".strtolower(__CLASS__)."/settlement_transaction/$dtm1/$dtm2/$owner_id/$terminal_id/$product_id/$item_id/$chg_sort"; 
 
		//$data['indexData']  = '';//$this->funcreport->indexDataTable($data['ci_ctrl'],$data['ci_func'],$data['TABLE'],$curpage,$data['limit'],$status_id,$sort,$order,$ci_changePage,$result_id,0,$lval2,$data['dl1'],$data['dl2']); 

		$this->load->view('log/log_trx_view.php',$data);  
 
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
			//foreach($datalist as $k => $v) foreach($v as $k2 => $v2) echo "<br>$k => $k2 => $v2"; exit; 
	 
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
	function report_data(){ 
		
		if($_POST){ 
			foreach($_POST as $k => $val){  echo "<br>$k => $val";  
				/*
				reportfunc => sales_transaction
				owner_id => 3
				terminal_id => 0
				product_id => 0
				dt1 => 2014-09-01
				dt2 => 2014-10-30
				button => Submit
				sort_date =>
				*/
				$$k = $val;   
			}  
		 	if(empty($owner_id)) 	$owner_id 	 = "0";
		 	if(empty($terminal_id)) $terminal_id = "0"; 
		 	if(empty($product_id)) 	$product_id  = "0"; 
			
			//echo "<br>"; 
			//$ci_ctrl  = strtolower($ci_ctrl);
			//$strredir = "$curpage/$limit/$status_id/$sort/$order/".$ci_ctrl."/$ci_changePage/$result_id/".$owner_id."/".$terminal_id."/".$product_id."/$t1/$t2";
		    $str_redir = '/'.strtolower(__CLASS__).'/'.$reportfunc.'/'.$dt1.'--'.str_replace(":",".",$tm1).'/'.$dt2.'--'.str_replace(":",".",$tm2).'/'.$owner_id.'/'.$terminal_id.'/'.$product_id.'/0/'.$sort_date; 
			//redirect($str_redir,'refresh');
			
			//echo strtolower(__CLASS__).'/'.$reportfunc.'/'.$dt1.'/'.$dt2.'/'.$owner_id.'/'.$terminal_id.'/'.$product_id.'/0'; 
			  exit;
			
			//card_transaction($dt1="",$dt2="",$owner_id=0,$terminal_id=0,$product_id=0,$item_id=0){
		} 	
	
	
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function string_request($id,$str){
  
		$data['data']  = '<pre style="padding:0px 15px; font-size:13px;">'.str_replace("&&","<br>",str_replace("---","<br>",$str)).'</pre>'; 
		$this->load->view('pop_data',$data);  
		
	}
	//-- trx_tracking	 
	function trx_trackingx($curpage=1,$limit=10,$statusid=1,$sort="id",$order="desc",$ci_ctrl="trace_log_viewer",$ci_changePage="changepage",$result_id="dspdata",$type=0){  
     	$data['pageTITLE']	= 'Lunari Web Admin - Log Transaction'; 
     	$data['pageLABEL'] 	= 'Log Transaction > TRX Tracking';
		$data['navMenu']   	= $this->allfunc->navMenu(7);   
		$data['limit'] 		= $limit;
		$data['statusid'] 	= $statusid;
		$data['sort'] 		= $sort;
		$data['order'] 		= $order;
		$data['ci_ctrl'] 	= $ci_ctrl;
		$data['ci_changePage'] = $ci_changePage;
		$data['result_id'] 	= $result_id; 
		$data['indexData']  = $this->indexDataLogAll($curpage,$limit,$statusid,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$type); 
		$this->load->view('log/trace_log_viewer',$data);  
		
		
	}
	 
	 function indexDataLogAll($curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$type){ 
 
		if($order=="asc") 		$orderO="desc";
		elseif($order=="desc") 	$orderO="asc"; 
		$content=$disableAll=''; 
		
		$w = 320;
		$h = 320;
		$start=($curpage*$limit)-$limit; 
		if($start >= 0){
		
			if($type==0){  
				$arr_fields = array('id','datetime','ip','vm','trx_code','string_request','response_status','trx_msg'); 
				//$qData=$this->allmodel->selectLog($start,$limit,$status_id,$sort,$order,'cmd'); 
				//$logType = "server_command";
				
					//selectLog($start=0,$limit=10,$status_id=1,$sort="ID",$order="desc",$tbl="trx"){
 
				$q = "
						select id, datetime, ip, vm, 'CMD' as trx_code , string_request, response_status, msg as trx_msg
						from `cmd` 
						Where datetime >= '2013-11-01 00:00:00'
						
						UNION
						
						select id, CONCAT(dt,' ',tm) as datetime, (select IP from vending_terminal where terminal_id = vmid) as ip , vmid as vm, 'CRD01' as trx_code ,string_request, 1 as response_status, null as trx_msg
						from `trx` 
						Where CONCAT(dt,' ',tm) >= '2013-11-01 00:00:00'
 
						UNION
						
						select id, CONCAT(dt,' ',tm) as datetime, (select IP from vending_terminal where terminal_id = vmid) as ip, vmid as vm, 'TBK' as trx_code,string_request, 1 as response_status, null as trx_msg 
						from `tbk` 
						Where CONCAT(dt,' ',tm) >= '2013-11-01 00:00:00'
 
						UNION
						
						select id, CONCAT(dt,' ',tm) as datetime, (select IP from vending_terminal where terminal_id = vmid) as ip, vmid as vm, 'CKD' as trx_code,string_request, CONCAT('PRN:',stprinter,', BA:',stba,', CD:',stcd) as response_status, null as trx_msg 
						from `ckd` 
						Where CONCAT(dt,' ',tm) >= '2013-11-01 00:00:00'
 
						UNION
						
						select id, date as datetime, (select IP from vending_terminal where terminal_id = topup_mandiri.terminal_id) as ip, terminal_id as vm, 'TUM' as trx_code,string_request, null as response_status, null as trx_msg 
						from `topup_mandiri` 
						Where date >= '2013-11-01 00:00:00'
 
						UNION
						
						select id, date as datetime, (select IP from vending_terminal where terminal_id = topup_settlement_mandiri.terminal_id) as ip, terminal_id as vm, 'TUSM' as trx_code, string_request, null as response_status, null as trx_msg 
						from `topup_settlement_mandiri` 
						Where date >= '2013-11-01 00:00:00'
						
						
						 
						ORDER BY datetime desc
					";
			 
			
			
			
			
			
			
			
			
					//echo $q; exit;
					$qData = $this->db->query($q);
	 
	
	
			} 			
			 

			if($qData->num_rows()){ 
				$col1 = "#ffffff";
				$col2 = "#f6f6f6";
				$col3 = "#FFDDFF";
				 
				//if($this->session->userdata('AccessType')=='admin') $disableAll = ''; 
				//if($this->session->userdata('AccessType')=='user')  $disableAll = ' disabled="disabled" '; 
 
				 $content.=
						'<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#bbbbbb">
						<thead>
							<tr bgcolor="#666666" class="style4 lightgrey">
							  <td align="center">No.</td>';
							  
						foreach($arr_fields as $k => $varKey){
							
							$w100 = '';
							//if($varKey=='string_request')
							//$w100 = ' align="right" ';
							
							if($varKey!='id')
							$content .='<td'.$w100.'><a class="lightgrey" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$logType.'/1/'.$limit.'/'.$status_id.'/'.$varKey.'/'.$orderO.'\')">'.$varKey.'</a></td>';
					
						}
						$content.='  
							</tr>
						</thead>
						<tbody>';
				  
				$x=$start+1;
				foreach($qData->result_array() as $row){
					$n = fmod($x,2); 
					if($n) $clr = $col1;
					else   $clr = $col2;
					 
					$content.='<tr bgcolor="'.$clr.'">';
					
					$content.='
					  <td align="right">'.$x.'.&nbsp;</td>';
					   
					foreach($arr_fields as $k => $varKey){ 
					  	if($varKey!='id'){ 
							
							if($varKey=='string_request') $nowrap = ' width="300"'; else $nowrap = ' nowrap="nowrap"';
							
							$content.='
								<td'.$nowrap.'>'.$row[$varKey].'</td>'; 
						} 
					 } 
					   
					
					$content.='</tr>'; 
					$x++;
				}	
				 
			}
		}
		$content.='</tbody>';
		$content.='</table>';		
		
		//$content.=$this->pagenav($curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$type);
		
		return $content;
	} 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	function server_command($curpage=1,$limit=10,$statusid=1,$sort="id",$order="desc",$ci_ctrl="trace_log_viewer",$ci_changePage="changepage",$result_id="dspdata",$type=0){  
     	$data['pageTITLE']	= 'Lunari Web Admin - Trace Log Viewer'; 
     	$data['pageLABEL'] 	= 'Log Viewer > History Server Command';
		$data['navMenu']   	= $this->allfunc->navMenu(6);   
		$data['limit'] 		= $limit;
		$data['statusid'] 	= $statusid;
		$data['sort'] 		= $sort;
		$data['order'] 		= $order;
		$data['ci_ctrl'] 	= $ci_ctrl;
		$data['ci_changePage'] = $ci_changePage;
		$data['result_id'] 	= $result_id; 
		$data['indexData']  = $this->indexDataLog($curpage,$limit,$statusid,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$type); 
		$this->load->view('log/trace_log_viewer',$data);  
	} 
	 
	function card_transaction_mandiri($curpage=1,$limit=10,$statusid=1,$sort="id",$order="desc",$ci_ctrl="trace_log_viewer",$ci_changePage="changepage",$result_id="dspdata",$type=1){  
     	$data['pageTITLE']	= 'Lunari Web Admin - Trace Log Viewer'; 
     	$data['pageLABEL'] 	= 'Log Viewer > History Transaction';
		$data['navMenu']   	= $this->allfunc->navMenu(6);   
		$data['limit'] 		= $limit;
		$data['statusid'] 	= $statusid;
		$data['sort'] 		= $sort;
		$data['order'] 		= $order;
		$data['ci_ctrl'] 	= $ci_ctrl;
		$data['ci_changePage'] = $ci_changePage;
		$data['result_id'] 	= $result_id; 
		$data['indexData']  = $this->indexDataLog($curpage,$limit,$statusid,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$type); 
		$this->load->view('log/trace_log_viewer',$data);  
	} 
	
	function tutup_buku($curpage=1,$limit=10,$statusid=1,$sort="id",$order="desc",$ci_ctrl="trace_log_viewer",$ci_changePage="changepage",$result_id="dspdata",$type=2){  
     	$data['pageTITLE']	= 'Lunari Web Admin - Trace Log Viewer'; 
     	$data['pageLABEL'] 	= 'Log Viewer > History Tutup Buku';
		$data['navMenu']   	= $this->allfunc->navMenu(6);   
		$data['limit'] 		= $limit;
		$data['statusid'] 	= $statusid;
		$data['sort'] 		= $sort;
		$data['order'] 		= $order;
		$data['ci_ctrl'] 	= $ci_ctrl;
		$data['ci_changePage'] = $ci_changePage;
		$data['result_id'] 	= $result_id; 
		$data['indexData']  = $this->indexDataLog($curpage,$limit,$statusid,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$type); 
		$this->load->view('log/trace_log_viewer',$data);  
	} 
	 
	function check_device($curpage=1,$limit=10,$statusid=1,$sort="id",$order="desc",$ci_ctrl="trace_log_viewer",$ci_changePage="changepage",$result_id="dspdata",$type=3){  
     	$data['pageTITLE']	= 'Lunari Web Admin - Trace Log Viewer'; 
     	$data['pageLABEL'] 	= 'Log Viewer > History Check Device';
		$data['navMenu']   	= $this->allfunc->navMenu(6);   
		$data['limit'] 		= $limit;
		$data['statusid'] 	= $statusid;
		$data['sort'] 		= $sort;
		$data['order'] 		= $order;
		$data['ci_ctrl'] 	= $ci_ctrl;
		$data['ci_changePage'] = $ci_changePage;
		$data['result_id'] 	= $result_id; 
		$data['indexData']  = $this->indexDataLog($curpage,$limit,$statusid,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$type); 
		$this->load->view('log/trace_log_viewer',$data);  
	} 
	//topup_mandiri
	function topup_transaction_mandiri($curpage=1,$limit=10,$statusid=1,$sort="id",$order="desc",$ci_ctrl="trace_log_viewer",$ci_changePage="changepage",$result_id="dspdata",$type=4){  
     	$data['pageTITLE']	= 'Lunari Web Admin - Trace Log Viewer'; 
     	$data['pageLABEL'] 	= 'Log Viewer > History Topup Mandiri';
		$data['navMenu']   	= $this->allfunc->navMenu(6);   
		$data['limit'] 		= $limit;
		$data['statusid'] 	= $statusid;
		$data['sort'] 		= $sort;
		$data['order'] 		= $order;
		$data['ci_ctrl'] 	= $ci_ctrl;
		$data['ci_changePage'] = $ci_changePage;
		$data['result_id'] 	= $result_id; 
		$data['indexData']  = $this->indexDataLog($curpage,$limit,$statusid,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$type); 
		$this->load->view('log/trace_log_viewer',$data);  
	} 
	
	function topup_settlement($curpage=1,$limit=10,$statusid=1,$sort="id",$order="desc",$ci_ctrl="trace_log_viewer",$ci_changePage="changepage",$result_id="dspdata",$type=5){  
     	$data['pageTITLE']	= 'Lunari Web Admin - Trace Log Viewer'; 
     	$data['pageLABEL'] 	= 'Log Viewer > History Topup Settlement Mandiri';
		$data['navMenu']   	= $this->allfunc->navMenu(6);   
		$data['limit'] 		= $limit;
		$data['statusid'] 	= $statusid;
		$data['sort'] 		= $sort;
		$data['order'] 		= $order;
		$data['ci_ctrl'] 	= $ci_ctrl;
		$data['ci_changePage'] = $ci_changePage;
		$data['result_id'] 	= $result_id; 
		$data['indexData']  = $this->indexDataLog($curpage,$limit,$statusid,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$type); 
		$this->load->view('log/trace_log_viewer',$data);  
	} 
	
	
 
	function indexDataLog($curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$type){ 
 
		if($order=="asc") 		$orderO="desc";
		elseif($order=="desc") 	$orderO="asc"; 
		$content=$disableAll=''; 
		
		$w = 320;
		$h = 320;
		$start=($curpage*$limit)-$limit; 
		if($start >= 0){
		
			if($type==0){  
				$arr_fields = array('id','datetime','ip','vm','type','refid','txid','msg','xdata','response_status','string_request'); 
				$qData=$this->allmodel->selectLog($start,$limit,$status_id,$sort,$order,'cmd'); 
				$logType = "server_command";
			} 			
			elseif($type==1){ 
				$arr_fields = array('id','kdtrx','dt','tm','vmid','nourut','jmlbeli','hargabeli','isikartu','biayakartu','totalbayar',
				'cashbox','lbrcashbox','payout','lbrpayout','sisakartu','string_request'); 
				$qData=$this->allmodel->selectLog($start,$limit,$status_id,$sort,$order,'trx'); 
				$logType = "transaction";
			} 
			elseif($type==2){ 
				$arr_fields = array('id','kdtrx','dt','tm','vmid','totaltrx','uangmasuk','cardfull','kartukeluar','sisakartu','string_request');  
				$qData=$this->allmodel->selectLog($start,$limit,$status_id,$sort,$order,'tbk'); 
				$logType = "tutup_buku";
			}	
			elseif($type==3){ 
				$arr_fields = array('id','kdtrx','dt','tm','vmid','stprinter','stba','stcd','string_request');  
				$qData=$this->allmodel->selectLog($start,$limit,$status_id,$sort,$order,'ckd'); 
				$logType = "check_device";
			}				
			elseif($type==4){ 
				$arr_fields = array('id','terminal_id','datetime_settle','date','nik','terminal','institution','has_settle','type','value','samid','cardid',
					'kaid','sam','report_ka','has_push','ka_idx','ka_balance','ka_counter','sam_counter','trx_counter','kl_id','card_balance',
					'slot','another','uangmasuk','uangkeluar','string_request'); 
				$qData=$this->allmodel->selectLog($start,$limit,$status_id,$sort,$order,'topup_mandiri'); 
				$logType = "topup_mandiri";
				
				$h = 500;
			}  			
			elseif($type==5){ 
				$arr_fields = array('id','terminal_id','datetime_settle','date','tm_id','settfile','slot','counterbegin',
					'counterend','totaltrx','inst','shift','string_request'); 
				$qData=$this->allmodel->selectLog($start,$limit,$status_id,$sort,$order,'topup_settlement_mandiri'); 
				$logType = "topup_settlement";
				$w = 500;
				$h = 300;
			}

			if($qData->num_rows()){ 
				$col1 = "#ffffff";
				$col2 = "#f6f6f6";
				$col3 = "#FFDDFF";
				 
				//if($this->session->userdata('AccessType')=='admin') $disableAll = ''; 
				//if($this->session->userdata('AccessType')=='user')  $disableAll = ' disabled="disabled" '; 
 
				 $content.=
						'<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#bbbbbb">
						<thead>
							<tr bgcolor="#666666" class="style4 lightgrey">
							  <td align="center">No.</td>';
							  
						foreach($arr_fields as $k => $varKey){
							
							$w100 = '';
							if($varKey=='string_request')
							$w100 = ' align="right" ';
							
							if($varKey!='id')
							$content .='<td'.$w100.'><a class="lightgrey" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$logType.'/1/'.$limit.'/'.$status_id.'/'.$varKey.'/'.$orderO.'\')">'.$varKey.'</a></td>';
					
						}
						$content.='  
							</tr>
						</thead>
						<tbody>';
				  
				$x=$start+1;
				foreach($qData->result_array() as $row){
					$n = fmod($x,2); 
					if($n) $clr = $col1;
					else   $clr = $col2;
					 
					$content.='<tr bgcolor="'.$clr.'">';
					
					$content.='
					  <td align="right">'.$x.'.&nbsp;</td>';
					   
					foreach($arr_fields as $k => $varKey){ 
					  	if($varKey!='id'){
						
							if($varKey!='string_request'){
							$content.='
								<td>'.$row[$varKey].'</td>';
						 	}else{
							$content.='
								<td width="100%" align="right">'; 
								
							//if($varKey=='string_request')
							//$content.= "xxxx";//str_replace("/","---",$row['string_request']);
							//else	
							$content.='	
								<input name="" type="button" value="View"  onclick="popupwindow(\'/trace_log_viewer/string_request/'.$row['id'].'/'.str_replace("/","---",$row['string_request']).'\', \'View String Request\', '.$w.', '.$h.')" />';
							
							$content.='
								</td>';
							} 
						} 
					 } 
					  
 
					
					$content.='</tr>'; 
					$x++;
				}	
				 
			}
		}
		$content.='</tbody>';
		$content.='</table>';		
		
		$content.=$this->pagenav($curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$type);
		
		return $content;
	} 
	
	function pagenav($curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$type){
	
		if($type==0) 	 $tbl='cmd'; 
		elseif($type==1) $tbl='trx'; 
		elseif($type==2) $tbl='tbk'; 
		elseif($type==3) $tbl='ckd';  
		elseif($type==4) $tbl='topup_mandiri'; 
		elseif($type==5) $tbl='topup_settlement_mandiri'; 
		
		$cData=$this->allmodel->countLog($tbl); 
		 
		
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
				$var.='<a href="javascript:void(0);loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/'.$prev.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'/'.$type.'\',\''.$result_id.'\')"><img src="/asset/icons/arrow_left.gif" width="16" height="16" />prev</a>';
				$var.='&nbsp; &nbsp;'; 
				$var.='<a href="javascript:void(0);loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/'.$next.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'/'.$type.'\',\''.$result_id.'\')">next<img src="/asset/icons/arrow_right.gif" width="16" height="16" /></a>';
				$var.='&nbsp; &nbsp;'; 
			
			$var.='		</td>';
				
			$var.='		<td width="100%" nowrap="nowrap" >';
							$var.='&nbsp; &nbsp;Page: <select name="page" id="page" onchange="loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/\'+$(this).val()+\'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'/'.$type.'\',\''.$result_id.'\')">'; 
				for($i=1;$i<=$totalPage;$i++){
					$var.='<option value="'.$i.'"';

					if($curpage==$i){
						$var.=' selected';
					}
					$var.='>'.$i.'</option>';
				}
				$var.='</select>';
				$var.=' of <b>'.$totalPage.'</b> pages &nbsp;-&nbsp; ';			
				$var.='Total <strong>'.$totalData.'</strong> records found.';
			$var.='		</td>';  
			$var.='		<td align="right" nowrap="nowrap" >';
				$var.='Show <select name="view" id="view" onchange="loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/1/\'+$(this).val()+\'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'/'.$type.'\',\''.$result_id.'\')" >';
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
	function changepage($curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$type){ 
		$data['data']=$this->indexDataLog($curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$type);
		$this->load->view('data_view',$data);
	} 
 	 
}
