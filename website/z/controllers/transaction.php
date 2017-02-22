<?php   
//session_start(); 
//error_reporting(E_ALL ^ E_NOTICE); 
//error_reporting(E_ALL); 
 
class Transaction extends Controller { 
	function Transaction(){    
		parent::Controller(); 
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		$this->load->library('allfunc'); 
		$this->load->library('funcreport');  
		$this->load->database(); 
		$this->load->library('session'); 
		////if(!$this->session->userdata('logged_in')) re_direct('login','refresh');
		if(!$this->session->userdata('logged_in')) 
		echo '<meta http-equiv="Refresh" content="0;URL=/login" />' ; 
		  
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
	
	function summary_transaction($GroupID=0,$TFCNumber="all",$trx_merchant_local=1,$trx_merchant_national=1,$TFCMerchantID='all',$dt1=0,$dt2=0,$set_available=1,$set_done='done',$set_notvalid=0,$order='transaction_date',$sort='desc'){  
 		 
		if($GroupID=='0' && $this->session->userdata('GroupID')=='1') $GroupID = "all";  
		if($this->session->userdata('GroupID')>2) $GroupID = $this->session->userdata('GroupID'); 
		$data['GroupID'] = $GroupID;
		
		//$TFCNumber="all",$trx_merchant_local=1,$trx_merchant_national=1,$TFCMerchantID='all',$dt1=0,$dt2=0,$set_available=1,$set_done=1,$set_notvalid=1
		$data['TFCNumber'] = $TFCNumber;
		$data['trx_merchant_local'] = $trx_merchant_local;
		$data['trx_merchant_national'] = $trx_merchant_national;
		$data['TFCMerchantID'] = $TFCMerchantID; 
		if(empty($dt1)) $dt1 = date("Y-m-d");
		if(empty($dt2)) $dt2 = date("Y-m-d");
		$data['dt1'] = $dt1;
		$data['dt2'] = $dt2;
		
		$data['set_available'] = $set_available;
		$data['set_done'] = $set_done;
		$data['set_notvalid'] = $set_notvalid;
		
		$data['order'] = $order;
		$data['sort'] = $sort;
		
		//$set_available=1,$set_done='done',$set_notvalid=0
		
		if($set_available==1&&$set_done==1){
			$set_status = 2; 
		}else{
			if($set_available) $set_status = 0;
			if($set_done) 	   $set_status = 1; 
		}
		$data['set_status'] = $set_status;
		
		if($_POST){
		

		
			foreach($_POST as $key => $value){
				// echo "<br>$key => $value";
				/*
				GroupID => 0
				TFCNumber => all
				trx_merchant_local => 1
				trx_merchant_national => 1
				TFCMerchantID => all
				dt1 =>
				dt2 =>
				set_available => 1
				set_done => 1
				set_notvalid => 1
				button => Submit
				
				set_trx_id => Array
				redir => /transaction/summary_transaction/0/all/0/0/all/2016-03-01/2016-03-27/1/1/1/transaction_date/desc
				settlement => Submit
				*/
				$$key = $value;
				$data[$key] = $value;
			} 
			//--- if update SETTLEMENT
			if(isset($_POST['settlement']))
			if(isset($_POST['set_trx_id'])) 
			if(is_array($set_trx_id)){
				foreach($set_trx_id as $trx_id => $v){
				 	//echo "<br>$trx_id => $v";
					$qset = "Update tfc_trx set settlement_status = '".$v."' where id = '".$trx_id."' Limit 1"; 
					$this->db->query($qset);
				}
				echo '<meta http-equiv="Refresh" content="0;URL='.$redir.'" />' ; 
				exit;
			}
			
			
			
			
			
			if(empty($dt1)) $dt1 = date("Y-m-d");
			if(empty($dt2)) $dt2 = date("Y-m-d");
			
			if(!isset($_POST['trx_merchant_local'])) { $trx_merchant_local = 0 ; $data['trx_merchant_local'] = 0;}
			if(!isset($_POST['trx_merchant_national'])) { $trx_merchant_national = 0 ; $data['trx_merchant_national'] = 0;}
			if(!isset($_POST['set_available'])) { $set_available = 0 ; $data['set_available'] = 0;}
			if(!isset($_POST['set_done'])) { $set_done = 0 ; $data['set_done'] = 0;}
			if(!isset($_POST['set_notvalid'])) { $set_notvalid = 0 ; $data['set_notvalid'] = 0;}
			
			if(!isset($_POST['GroupID'])) {
				$GroupID = $this->session->userdata('GroupID');
				$data['GroupID'] = $GroupID;
			} 
			echo '<meta http-equiv="Refresh" content="0;URL=/'."transaction/summary_transaction/$GroupID/$TFCNumber/$trx_merchant_local/$trx_merchant_national/$TFCMerchantID/$dt1/$dt2/$set_available/$set_done/$set_notvalid/transaction_date/desc".'" />' ; 
			//re_direct("transaction/summary_transaction/$GroupID/$TFCNumber/$trx_merchant_local/$trx_merchant_national/$TFCMerchantID/$dt1/$dt2/$set_available/$set_done/$set_notvalid/transaction_date/desc",'refresh');
		}	 
  
		//--- default is login as USER
		//$strAccount = "merchant"; $group_id = 0; $is_member = 0; $is_merchant = 1; 
		//if($this->session->userdata('is_merchant'))	{ $strAccount = "merchant"; $is_merchant = 1; } //-- login as MERCHANT  

     	$data['pageTITLE']  = 'TFC Web Admin - Transaction'; 
     	$data['pageLABEL'] 	= 'Transaction > Summary Transaction';
		$data['navMenu']   	= $this->allfunc->navMenu(6); 
		 
		$data['indexData']  = '';//$this->indexDataLog($curpage,$limit,$statusid,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$type); 
		 
		
		
		$data['rowgrp'] 			= $this->allmodel->getTableWhere('user_group_table');   //$tbl='',$key='',$val=0,$status_id=1,$orderby='' 
		$data['rowTFCMerchantID'] 	= $this->allmodel->getTableWhere2('merchant_table','TFCMerchantID',0,1,'TFCMerchantID','',0,$GroupID);
		
		$data['rowTrx'] 			= $this->getTableTRX($GroupID,$TFCNumber,$trx_merchant_local,$trx_merchant_national,$TFCMerchantID,$dt1,$dt2,$set_status,
														 $order,$sort);
														 
		$arrCheck 					= $data['rowTrx'];
		$data['rowTFCNumber'] 		= $this->allmodel->getTableWhere2('member_table','TFCNumber',0,1,'TFCNumber','',0,$GroupID,$arrCheck,$trx_merchant_local,$trx_merchant_national); //-- all member trx on all merchant selected + member
		 
		 
		$this->load->view('trx/summary_trx_view',$data);  
 
	}
	
	function getTableTRX(
				$GroupID='',
				$TFCNumber="all",
				$trx_merchant_local=1,
				$trx_merchant_national=1,
				$TFCMerchantID="all",
				$dt1="",
				$dt2="",
				$set_status=0,
				$order='transaction_date',
				$sort='desc') { 
 
		if(empty($dt1)) $dt1 = date("Y-m-d");
		if(empty($dt2)) $dt2 = date("Y-m-d");
			
		if(empty($order)) $order = "order by id ".$sort;
		else			  $order = "order by `".$order."` ".$sort;
 
		$strwhere = " where a.transaction_type = 'TRX' and a.status_id = 1 "; 
		$grp = '';
		if($GroupID>2) { 
			$grp = $this->allmodel->valGroup3Chr($GroupID);
			$strwhere .= "and substr(a.transaction_id,1,3) = '".$grp."' " ;
		} 
	 
	 	//--TFCNumber  
		$card_number = "";
		if($TFCNumber!="all"||empty($TFCNumber)) $card_number = " and a.card_number = '".$TFCNumber."' ";
		$strwhere .= $card_number; 
	 	
		//--TFCMerchantID  
		$merchant_id = ""; 
		if($TFCMerchantID!="all"||empty($TFCMerchantID)) $merchant_id = " and a.merchant_id = '".$TFCMerchantID."' "; 
		$strwhere .= $merchant_id; 
 
		
		//--set_status   
		if($set_status<2)
		$strwhere .= " and a.settlement_status = '".$set_status."' "; 
		
		
		//--dt1  dt2
		$strwhere .= " and a.transaction_date >= '".$dt1." 00:00:00' and a.transaction_date <= '".$dt2." 23:59:59' "; 
		
		
	 
		$strwhere = str_replace("where and","where",$strwhere);
		if(str_replace(" ","",$strwhere)=="where") $strwhere=''; 
		
		 		
		//$q = "select * from `tfc_trx` ".$strwhere." ".$order." ";
		
		$q = "Select a.*, b.product_name,b.product_credit
			 From `tfc_trx` a 
			 Inner Join db_merchant_product b on b.id = a.merchant_product
			 ".$strwhere." 
			 ".$order."
			 ";
		
 		//echo $q."<br>";
  
		$gData = $this->db->query($q);
		$row = $gData->result_array();
		  
 		if($gData->num_rows()){  
			return $row;   
		} else return array();
	}
	
	
	function settlement_transaction($dtm1="",$dtm2="",$owner_id=0,$terminal_id=0,$product_id=0,$item_id=0,$sort_date="asc"){ 
	

		 
	  	//echo '/'.strtolower(__CLASS__).'/'.$_POST['ci_func'].'/','refresh'); 
	  
	
	
		//http://lunari/reporting/settlement_transaction/2015-06-09--00.00/2015-06-09--23.59/0/1/0/0/desc
	
	
		
		if(empty($dt1)) $first = 1;
		
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit);  
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;
 
		$data['ci_ctrl']  = $ci_ctrl  = strtolower(__CLASS__);
		$data['ci_func']  = $ci_func  = strtolower(__FUNCTION__);
		
		$data['callfunc'] 	= $callfunc   = '/report_data'; 	//-- form filter data, submit to this function
		$data['reportfunc'] = $reportfunc = $data['ci_func']; 	//-- form filter data, submit to this function
  
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
		//echo " ";
		 $data['tm1'] = substr($tm1,0,5);
		//echo "<br>"; 
		 $data['dt2'] = $dt2;
		//echo " ";
		 $data['tm2'] = substr($tm2,0,5);
		//echo "<br>";
 
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
 		$data['listmenu_2'] = '';//$this->list_data_child(22,$owner_id,$terminal_id,$product_id,$item_id); 
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

		$this->load->view('report/settlement_trx_view.php',$data);  
 
	}
	
	
	
	
	
	
	
	
		
 	function summary_transactionx($dtm1="",$dtm2="",$owner_id=0,$terminal_id=0,$product_id=0,$item_id=0){  
 
		if(empty($dt1)) $first = 1;
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit);  
		foreach($data as $key => $val){
			if(isset($$key)) $data[$key] = $$key;
			//echo "<br>$key => $val";	
		}

 
		//---- temp
		//$data['is_pop']  = 1; 
 
		$data['ci_ctrl']  = $ci_ctrl  = strtolower(__CLASS__);
		$data['ci_func']  = $ci_func  = strtolower(__FUNCTION__);
 
		$data['callfunc'] 	= $callfunc   = '/report_data'; //-- form filter data, submit to this function
		$data['reportfunc'] = $reportfunc = $data['ci_func']; //-- form filter data, submit to this function
		
		
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
		//echo " ";
		$data['tm1'] = substr($tm1,0,5);
		//echo "<br>"; 
		$data['dt2'] = $dt2;
		//echo " ";
		$data['tm2'] = substr($tm2,0,5);
		//echo "<br>";
		
 
 //exit;
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
		$arr_summary_trx2 = array(); 
		$crd_tot_item = $crd_tot_payment = $tup_tot_item = $tup_tot_payment = 0; 
		
		$tup_tot_item50 = $tup_tot_item100 = 0;
		
		$cur_tid = ''; //$jmltrx = 0;
		foreach($arr_summary as $k => $v){  
			foreach($v as $k2 => $v2){ 
			
				//$tot_item = $tot_payment = $tot_trx = $tot_item  = $tot_payment = $tot_trx2 = 0; 
				$tot_item  = $tot_payment  = $tot_trx  = 0; 
				$tot_item2 = $tot_payment2 = $tot_trx2 = 0; 
				$tot_prc50 = $tot_prc100 = 0; 
				
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
							$tot_trx = count($v4);
							$arr_summary_trx[$k][$k2]['card']['trx'] = $tot_trx; 
							//$jmltrx += $tot_trx; 
						}
		 			}
					
					$arr_summary_trx2[$k][$k2]['card_item'] 	= $tot_item;
					$arr_summary_trx2[$k][$k2]['card_payment'] 	= $tot_payment; 
					$arr_summary_trx2[$k][$k2]['card_trx'] 		= $tot_trx; 
 
					
					if($k3=='topup_mandiri'){
						foreach($v3 as $k4 => $v4){ 
							if($k4=='item'){    //echo "<br>".count($v4); 
								$tot_item = 0;
								foreach($v4 as $k5 => $v5){  
									//echo "<br>$k => $k2 => $k3 => $k4 => $k5 => $v5"; 
									//210-00-000-0-111 => 2014-12-22 => card_prepaid => item => 0 => 2
									$tot_item2 += $v5;
								}
								$arr_summary_trx[$k][$k2]['topup']['item'] = $tot_item2;
								//echo "<br>".$tot_item;
								//exit; 
							}
							//if($k4=='payment') echo "<br>".count($v4);  
							if($k4=='payment'){    //echo "<br>".count($v4); 
								$tot_payment = 0;
								foreach($v4 as $k5 => $v5){   
									$tot_payment2 += $v5;
									
									//echo "<br>".$v5;
									if($v5==50000) { $tot_prc50++;	$tup_tot_item50++; }
									if($v5==100000){ $tot_prc100++;	$tup_tot_item100++; }
									
								}
								$arr_summary_trx[$k][$k2]['topup']['payment'] = $tot_payment2; 
							} 
							$tot_trx2 = count($v4);
							$arr_summary_trx[$k][$k2]['topup']['trx'] = $tot_trx2; 
							//$jmltrx += $tot_trx2; 
						}
		 			}
		
					$arr_summary_trx2[$k][$k2]['topup_item'] 	= $tot_item2;
					$arr_summary_trx2[$k][$k2]['topup_payment'] = $tot_payment2; 
					$arr_summary_trx2[$k][$k2]['topup_trx'] 	= $tot_trx2; 
 
					$arr_summary_trx2[$k][$k2]['price_item50'] 	= $tot_prc50; 
					$arr_summary_trx2[$k][$k2]['price_item100'] = $tot_prc100;
		
				} 
			} 
		}
		/*
		foreach($arr_summary_trx2 as $k => $v)
		foreach($v as $k2 => $v2)  
		foreach($v2 as $k3 => $v3) 
		//foreach($v3 as $k4 => $v4)//{
		//if($k4=='tot_items') 
		echo "<br>$k => $k2 => $k3 => $v3"; 
		//if($k4=='tot_payments') echo "<br>$k => $k2 => $k3 => $k4 => $v4"; 
		//}
		exit; 
		
		210-00-000-0-111 => 2014-12-16 => card_item 	=> 16
		210-00-000-0-111 => 2014-12-16 => card_payment 	=> 800000
		210-00-000-0-111 => 2014-12-16 => card_trx 		=> 10
		210-00-000-0-111 => 2014-12-16 => topup_item 	=> 16
		210-00-000-0-111 => 2014-12-16 => topup_payment => 800000
		210-00-000-0-111 => 2014-12-16 => topup_trx 	=> 10
		
		 
		echo "<br>";
		echo $tot_item;
		echo "<br>";
		echo $tot_payment;
		//$arr_summary_trx[][][][] = ; //
		exit;
		//--- combine same vm and date
		
		*/
 
		$total_item   = $n ."";
		$total_amount = $totalbayar ;
 
		$data['owner'] 	      = $owner; 
		$data['terminal']     = $terminal; 
		
		
		$data['terminal_id']     = $terminal_id; 
		//$data['dt1']     = $dt1; 
		//$data['dt2']     = $dt2; 
		
		
		
		$data['ip'] 	      = $ip; 
		$data['product']  	  = $product;  
		$data['address']  	  = $address;     
		if($location!="all") 
		$data['location'] = substr($location,1,strlen($location));  
		else 
		$data['location'] = $location;
		
		$data['total_item']   = $total_item; 
		
		$data['jmltrx']   	  = $total_item;
		$data['jmlbeli']   	  = $jmlbeli;
		$data['total_amount'] = $total_amount; 

		$data['table_trx'] 	  = "kiosk";    
 
		$data['indexData']    = '';//$this->funcreport->indexDataTable($data['ci_ctrl'],$data['ci_func'],$data['TABLE'],$curpage,$data['limit'],$status_id,$sort,$order,$ci_changePage,$result_id,0,$lval2,$data['dl1'],$data['dl2']); 


		$data['rowTrx']  	  = $tData->result_array();
		//$data['rowTrxSum']    = $arr_summary_trx;
		$data['rowTrxSum']    = $arr_summary_trx2;
		
		
		$this->load->view('report/sum_trx_view',$data);  
 
	}
	
	  
	//-- khusus summary	
 	function list_data_child_21($num=0,$owner_id,$terminal_id,$product_id,$item_id=0){ 
 		$listmenu_1 = $this->list_data_child(11,$owner_id,0,$product_id,$item_id);
 		$listmenu_2 = $this->list_data_child(22,$owner_id,$terminal_id,0,$item_id);
 		$listmenu_3 = $this->list_data_child(33,$owner_id,$terminal_id,$product_id,0); 
		echo $result = ' 
           	<span id="vmlist">'.$listmenu_1.'</span> '; 
           	//<span> &nbsp; Item : </span>	
           	//<span id="productlist">'.$listmenu_3.'</span>'; 
	}
 
	//card_transaction
 
 	function card_transaction($dtm1="",$dtm2="",$owner_id=0,$terminal_id=0,$product_id=0,$item_id=0){  
 
		if(empty($dt1)) $first = 1;
		
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit);  
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;
 
		$data['ci_ctrl']  = $ci_ctrl  = strtolower(__CLASS__);
		$data['ci_func']  = $ci_func  = strtolower(__FUNCTION__);
		
		//-- form filter data, submit to this function
		$data['callfunc'] 	= $callfunc   = '/report_data'; 	
		$data['reportfunc'] = $reportfunc = $data['ci_func']; 
  
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
		//echo " ";
		 $data['tm1'] = substr($tm1,0,5);
		//echo "<br>"; 
		 $data['dt2'] = $dt2;
		//echo " ";
		 $data['tm2'] = substr($tm2,0,5);
		//echo "<br>";
 
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
 
  		$strDT1s1  = " and REPLACE(REPLACE(CONCAT(dt,'',tm),'-',''),':','') >= ".str_replace("-","",str_replace(":","",str_replace(" ","",$data['dt1'].$data['tm1'].":00"))) ;
 		$strDT1e1  = " and REPLACE(REPLACE(CONCAT(dt,'',tm),'-',''),':','') <= ".str_replace("-","",str_replace(":","",str_replace(" ","",$data['dt2'].$data['tm2'].":59"))) ; 

 
		// id	kdtrx	kdprd 			dt	tm	vmid nourut				jmlbeli				hargabeli			isikartu			biayakartu			totalbayar			uangmasuk	uangkembali				cashbox				lbrcashbox				payout			lbrpayout				sisakartu				string_request	status_id				null as totaltrx		null as cardfull		null as kartukeluar		null as sisakartu
		// id	kdtrx	null as kdprd   dt	tm	vmid null as nourut 	null as jmlbeli 	null as hargabeli	null as isikartu 	null as biayakartu 	null as totalbayar 	uangmasuk	null as uangkembali		null as cashbox 	null as lbrcashbox		null as payout	null as lbrpayout		null as sisakartu		string_request	null as status_id 		totaltrx				cardfull 				kartukeluar				sisakartu
    	$q = "
			Select CONCAT(dt,' ',tm) as datetime_order, id,kdtrx,'crd' as  kdprd,dt,tm,vmid,nourut,jmlbeli,hargabeli,isikartu,biayakartu,totalbayar,uangmasuk,uangkembali,cashbox,lbrcashbox,payout,lbrpayout,sisakartu,string_request,status_id, null as totaltrx, null as cardfull, null as kartukeluar, null as sisakartu 
			From `trx` 
			Where $strTRXID $strTID $strDT1s1 $strDT1e1 
			UNION  
			Select CONCAT(dt,' ',tm) as datetime_order, id,kdtrx, 'tbk' as kdprd,dt,tm,vmid,null as nourut,null as jmlbeli,null as hargabeli,null as isikartu,null as biayakartu,null as totalbayar,uangmasuk,null as uangkembali,null as cashbox,null as lbrcashbox,null as payout,null as lbrpayout,null as sisakartu,string_request,null as status_id,totaltrx,cardfull,kartukeluar,sisakartu
			From  `tbk` 
			Where $strTID $strDT1s1 $strDT1e1 and uangmasuk = 0
			ORDER BY datetime_order DESC 
			";	
 
			
					
 					
  		$q = str_replace("Where and","Where ",preg_replace('/\s\s+/', ' ',$q));
		 
		$tData = $this->db->query($q); 
		$jmlbeli=$totalbayar=$n=0;
 		if($tData->num_rows()) 
		foreach($tData->result_array() as $rowTrx){
			//foreach($rowTrx as $k2 => $v2) echo "<br>$k => $k2 => $v2"; 
			if($rowTrx['jmlbeli']){
			$jmlbeli 	+= $rowTrx['jmlbeli'];
			$totalbayar += $rowTrx['totalbayar']; 
			$n++;
			}
		}
		$total_item   = $jmlbeli."";

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

		$this->load->view('report/tab_trx_view.php',$data);  
 
	}
	

	//topup_transaction
 
 	function topup_transaction($dtm1="",$dtm2="",$owner_id=0,$terminal_id=0,$product_id=0,$item_id=0){  
		
		if(empty($dt1)) $first = 1;
		
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit);  
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;
 
		$data['ci_ctrl']  = $ci_ctrl  = strtolower(__CLASS__);
		$data['ci_func']  = $ci_func  = strtolower(__FUNCTION__);
		
		$data['callfunc'] 	= $callfunc   = '/report_data'; //-- form filter data, submit to this function
		$data['reportfunc'] = $reportfunc = $data['ci_func']; //-- form filter data, submit to this function
  
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
		//echo " ";
		 $data['tm1'] = substr($tm1,0,5);
		//echo "<br>"; 
		 $data['dt2'] = $dt2;
		//echo " ";
		 $data['tm2'] = substr($tm2,0,5);
		//echo "<br>";
		
		
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
		} else { 	
			$strTID .= " terminal_id = '".$terminal."'";
		}
		
		if(!empty($strTID))
		$strTID = " ( ".$strTID." ) ";//" and ( ".$strTID." )";
 
 		$strTID_TBK = str_replace("terminal_id","vmid",$strTID);
		
 
		$strDT = "and ( `date` >= '".$dt1." ".$tm1."' and `date` <= '".$dt2." ".$tm2."' ) ";  
		
  		$strDT1s1  = " and REPLACE(REPLACE(CONCAT(dt,'',tm),'-',''),':','') >= ".str_replace("-","",str_replace(":","",str_replace(" ","",$dt1.$tm1))) ;
 		$strDT1e1  = " and REPLACE(REPLACE(CONCAT(dt,'',tm),'-',''),':','') <= ".str_replace("-","",str_replace(":","",str_replace(" ","",$dt2.$tm2))) ; 


 
 
		// id	kdtrx	kdprd 			dt	tm	vmid nourut				jmlbeli				hargabeli			isikartu			biayakartu			totalbayar			uangmasuk	uangkembali				cashbox				lbrcashbox				payout			lbrpayout				sisakartu				string_request	status_id				null as totaltrx		null as cardfull		null as kartukeluar		null as sisakartu
		// id	kdtrx	null as kdprd   dt	tm	vmid null as nourut 	null as jmlbeli 	null as hargabeli	null as isikartu 	null as biayakartu 	null as totalbayar 	uangmasuk	null as uangkembali		null as cashbox 	null as lbrcashbox		null as payout	null as lbrpayout		null as sisakartu		string_request	null as status_id 		totaltrx				cardfull 				kartukeluar				sisakartu
 
 		// id, CONCAT(dt,' ',tm) as datetime_order, id,kdtrx,kdprd,dt,tm,vmid,nourut,jmlbeli,hargabeli,isikartu,biayakartu,totalbayar,uangmasuk,uangkembali,cashbox,lbrcashbox,payout,lbrpayout,sisakartu,string_request,status_id, null as totaltrx, null as cardfull, null as kartukeluar, null as sisakartu 

 
 
 
     	$q = " 
			Select id,	kdtrx,	'tup' as kdprd, terminal_id as vmid, date, value, uangmasuk, uangkeluar, 1 as jmlbeli
			
			From `topup_mandiri` 
			Where $strTRXID $strTID $strDT 
 
			UNION   
			
			Select id,	'tup' as kdprd,	'tbk' as kdprd,	vmid , CONCAT(dt,' ',tm) as date, null as value, null as uangmasuk, null as uangkeluar, null as jmlbeli
 
			From  `tbk` 
			Where $strTID_TBK $strDT1s1 $strDT1e1 and uangmasuk = 0
 
			ORDER BY date DESC 
		";
		
 		
		$tData = $this->db->query($q); 
		$jmlbeli=$totalbayar=0; $n=0;
 		if($tData->num_rows()) 
		foreach($tData->result_array() as $rowTrx){
			//foreach($rowTrx as $k2 => $v2) echo "<br>$k => $k2 => $v2"; 
			if($rowTrx['jmlbeli']){
			$jmlbeli 	+= $rowTrx['jmlbeli'];
			$totalbayar += $rowTrx['value']; 
			$n++;
			}
		} 
		$total_item   = $n ."";
		$total_amount = "Rp. ".number_format($totalbayar,0,',','.');
		
		$data['rowTrx']  		=  $tData->result_array();
 
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

		$this->load->view('report/tab_trx_view.php',$data);  
 
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
			echo '<meta http-equiv="Refresh" content="0;URL='.$str_redir.'" />' ; 
			//re_direct($str_redir,'refresh');
			
			//echo strtolower(__CLASS__).'/'.$reportfunc.'/'.$dt1.'/'.$dt2.'/'.$owner_id.'/'.$terminal_id.'/'.$product_id.'/0'; 
			  exit;
			
			//card_transaction($dt1="",$dt2="",$owner_id=0,$terminal_id=0,$product_id=0,$item_id=0){
		} 	
	
	
	
	}
	 
  
	
	function summary_tbk_transaction($dtm1="",$dtm2="",$owner_id=0,$terminal_id=0,$product_id=0,$item_id=0){  
		
		if(empty($dt1)) $first = 1;
		
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit);  
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;
 
		$data['ci_ctrl']  = $ci_ctrl  = strtolower(__CLASS__);
		$data['ci_func']  = $ci_func  = strtolower(__FUNCTION__);
		
		$data['callfunc'] 	= $callfunc   = '/report_data'; //-- form filter data, submit to this function
		$data['reportfunc'] = $reportfunc = $data['ci_func']; //-- form filter data, submit to this function
		
		
		//--- TBK
		$data['arr_TBK'] = array();
		$q = " 	Select id,	kdtrx,	'tbk' as kdprd,	vmid , CONCAT(dt,' ',tm) as date, uangmasuk 
				From  `tbk` 
				Where uangmasuk != 0 
				ORDER BY date DESC "; 
		$tData = $this->db->query($q);  
 		if($tData->num_rows()){ 
			
			$data['arr_TBK'] = $tData->result_array(); 
			
		}
		//foreach($data['arr_TBK'] as $rowTrx) 
		//foreach($rowTrx as $k2 => $v2) echo "<br>$k => $k2 => $v2"; 
		//exit;
		
		
		
		
		
		
		
  
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
		//echo " ";
		 $data['tm1'] = substr($tm1,0,5);
		//echo "<br>"; 
		 $data['dt2'] = $dt2;
		//echo " ";
		 $data['tm2'] = substr($tm2,0,5);
		//echo "<br>";
		
		
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
 		$data['listmenu_2'] = '';//$this->list_data_child(22,$owner_id,$terminal_id,$product_id,$item_id); 
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
		} else { 	
			$strTID .= " terminal_id = '".$terminal."'";
		}
		
		if(!empty($strTID))
		$strTID = " ( ".$strTID." ) ";//" and ( ".$strTID." )";
 
 		$strTID_TBK = str_replace("terminal_id","vmid",$strTID);
		
 
		$strDT = "and ( `date` >= '".$dt1." ".$tm1."' and `date` <= '".$dt2." ".$tm2."' ) ";  
		
  		$strDT1s1  = " and REPLACE(REPLACE(CONCAT(dt,'',tm),'-',''),':','') >= ".str_replace("-","",str_replace(":","",str_replace(" ","",$dt1.$tm1))) ;
 		$strDT1e1  = " and REPLACE(REPLACE(CONCAT(dt,'',tm),'-',''),':','') <= ".str_replace("-","",str_replace(":","",str_replace(" ","",$dt2.$tm2))) ; 
 
		 $q = "
			Select id,	kdtrx,	'crd' as kdprd,	vmid,	CONCAT(dt,' ',tm) as date,	totalbayar, uangmasuk,	uangkembali, jmlbeli 
			From `trx` 
			Where $strTRXID ".str_replace("terminal_id","vmid",$strTID)."  $strDT1s1 $strDT1e1  
			
			UNION
			
			Select id,	'TOPUP' as kdtrx,	'tup' as kdprd, terminal_id as vmid, date, value, uangmasuk, uangkeluar, 1 as jmlbeli
			
			From `topup_mandiri` 
			Where $strTRXID $strTID $strDT 
 
			UNION   
			
			Select id,	kdtrx,	'tbk' as kdprd,	vmid , CONCAT(dt,' ',tm) as date, null as value, null as uangmasuk, null as uangkeluar, null as jmlbeli
 
			From  `tbk` 
			Where $strTID_TBK $strDT1s1 $strDT1e1 and uangmasuk = 0
 
			ORDER BY date DESC 
		";
		
 		
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

		$this->load->view('report/tbk_trx_view.php',$data);  
 
	}
	
	
	
	function list_data_child_2($num=0,$owner_id,$terminal_id,$product_id,$item_id=0){ 
 
 			$listmenu_1 = $this->list_data_child(11,$owner_id,0,$product_id,$item_id);
 			$listmenu_2 = $this->list_data_child(22,$owner_id,$terminal_id,0,$item_id);
 			$listmenu_3 = $this->list_data_child(33,$owner_id,$terminal_id,$product_id,0);
		
			echo $result = '
				<span>Terminal : </span>	
            	<span id="vmlist">'.$listmenu_1.'</span>
            	';
				//<span> &nbsp; Product : </span>	
            	//<span id="productlist">'.$listmenu_2.'</span>';
				
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
			
		    echo '<meta http-equiv="Refresh" content="0;URL=/'.strtolower(__CLASS__).'/'.$_POST['ci_func'].'/" />' ; 
			//re_direct('/'.strtolower(__CLASS__).'/'.$_POST['ci_func'].'/','refresh'); 
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
		 echo '<meta http-equiv="Refresh" content="0;URL=/'.strtolower(__CLASS__).'/edit_data/'.$cid.'/'.$ci_func.'/" />' ; 
		 //re_direct('/'.strtolower(__CLASS__).'/edit_data/'.$cid.'/'.$ci_func.'/','refresh');
 
	}  
}
