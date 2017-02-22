<?php  
//session_start(); 
 
class Topup extends Controller {  

	function Topup()  
	{ 
		parent::Controller();   
		$this->load->helper('url');  		
		$this->load->model('allmodel'); 
		$this->load->library('allfunc');  
		$this->load->database();  
	} 
	
	function index(){  
	echo "Holaaa";
	} 
	
	function mandiri($QT){ 

	 	//echo str_replace("&&","<br>",$QT); 
		//IP-ADDRESS/topup/mandiri/
		//date=20140708130105&&nik=n001&&terminal=001&&institution=123456&&has_settle=false&&type=1&&value=9000&&samid=s001&&cardid=123456789101112&&kaid=ka001&&sam=sam001&&report_ka=OK&&has_push=true&&ka_idx=3&&ka_balance=1000&&ka_counter=1&&sam_counter=1&&trx_counter=1&&kl_id=KLID001&&card_balance=9000&&slot=1&&another=1&&terminal_id=210-00-000-0-111&&uangmasuk=100000&&uangkeluar=50000

		$arrKEY = array();
		$arrVALUE = array();
	 	$arrQT = explode("&&",$QT);
		$arrRequest = array();
		foreach($arrQT as $key => $value){
			//echo "<br>$key => $value";
			$arrVars = explode("=",$value);
			$arrKeys = $arrVars[0];
			$arrRequest[$arrKeys] = $arrVars[1];
			/*
			foreach($arrVars as $key1 => $value1){
				//echo "<br>$key1 => $value1";
				if ($key1==0) array_push($arrKEY,$value1);
				if ($key1==1) array_push($arrVALUE,$value1); 
				//$$key1 = $value1; 
 			}
			*/
		}  
 
		$strDT = substr($arrRequest['date'],0,4)."-".substr($arrRequest['date'],4,2)."-".substr($arrRequest['date'],6,2);
		$strTM = substr($arrRequest['date'],8,2).":".substr($arrRequest['date'],10,2).":".substr($arrRequest['date'],12,2);
 
		$arrRequest['date'] = $strDT." ".$strTM; 
		
		$strKey = $strVal = "";
		
		foreach($arrRequest as $k => $v )
		//if($k!='date')
		{  //echo "<br>$k => $v"; 
			$strKey .=  "`".$k."`,"; 
			$strVal .=  "'".$v."',"; 
		}
		$strKey = substr($strKey,0,strlen($strKey)-1);
		$strVal = substr($strVal,0,strlen($strVal)-1);
		$strKey .=  ",`string_request`"; 
		$strVal .=  ",'".$QT."'"; 
		$strKey .=  ",`datetime_settle`"; 
		$strVal .=  ",'".date("Y-m-d H:i:s")."'"; 
		
		$q = " INSERT INTO `topup_mandiri` ( ".$strKey. " ) VALUES ( ".$strVal." ); ";
	 
		//$this->db->query($q);
		
		if($this->db->query($q)) echo 'ok'; 
		else echo 'Error insert data to database !';
		
		exit;
 
		 
	} 
	
	 
	function update_settlement($QT){ 

	 	//echo str_replace("&&","<br>",$QT); 
		//IP-ADDRESS/topup/mandiri/
		//date=20140708130105&&nik=n001&&terminal=001&&institution=123456&&has_settle=false&&type=1&&value=9000&&samid=s001&&cardid=123456789101112&&kaid=ka001&&sam=sam001&&report_ka=OK&&has_push=true&&ka_idx=3&&ka_balance=1000&&ka_counter=1&&sam_counter=1&&trx_counter=1&&kl_id=KLID001&&card_balance=9000&&slot=1&&another=1&&terminal_id=210-00-000-0-111&&uangmasuk=100000&&uangkeluar=50000

		$arrKEY = array();
		$arrVALUE = array();
	 	$arrQT = explode("&&",$QT);
		$arrRequest = array();
		foreach($arrQT as $key => $value){
			//echo "<br>$key => $value";
			$arrVars = explode("=",$value);
			$arrKeys = $arrVars[0];
			$arrRequest[$arrKeys] = $arrVars[1];
			/*
			foreach($arrVars as $key1 => $value1){
				//echo "<br>$key1 => $value1";
				if ($key1==0) array_push($arrKEY,$value1);
				if ($key1==1) array_push($arrVALUE,$value1); 
				//$$key1 = $value1; 
 			}
			*/
		}  
 
		$strDT = substr($arrRequest['date'],0,4)."-".substr($arrRequest['date'],4,2)."-".substr($arrRequest['date'],6,2);
		$strTM = substr($arrRequest['date'],8,2).":".substr($arrRequest['date'],10,2).":".substr($arrRequest['date'],12,2);
 
		$arrRequest['date'] = $strDT." ".$strTM; 
		
		$strKey = $strVal = "";
		
		foreach($arrRequest as $k => $v )
		//if($k!='date')
		{  //echo "<br>$k => $v"; 
			$strKey .=  "`".$k."`,"; 
			$strVal .=  "'".$v."',"; 
		}
		$strKey = substr($strKey,0,strlen($strKey)-1);
		$strVal = substr($strVal,0,strlen($strVal)-1);
		$strKey .=  ",`string_request`"; 
		$strVal .=  ",'".$QT."'"; 
		$strKey .=  ",`datetime_settle`"; 
		$strVal .=  ",'".date("Y-m-d H:i:s")."'"; 
		
		$q = " INSERT INTO `topup_settlement_mandiri` ( ".$strKey. " ) VALUES ( ".$strVal." ); ";
	 
		//$this->db->query($q);
		
		if($this->db->query($q)) echo 'ok'; 
		else echo 'Error insert data to database !';
		
		exit;
 
		 
	} 
  
	function mandiri_balance($QT){ 
	
		//http://119.235.249.185/topup/mandiri_balance/
		//terminal=31020177&&status1=1&&limit1=9940000&&counter1=3&&balance1=10000000&&dtlast1=20160524123426&&
		//status2=1&&limit2=9930000&&counter2=2&&balance2=10000000&&dtlast2=20160523110034
		
		$arrKEY = array();
		$arrVALUE = array();
	 	$arrQT = explode("&&",$QT);
		$arrRequest = array();
		foreach($arrQT as $key => $value){
			//echo "<br>$key => $value"; 
 
			$arrVars  = explode("=",$value);
			$arrKeys  = $arrVars[0];
			$arrVals  = $arrVars[1];
			$$arrKeys = $arrVals;
			
			//echo "<br>".$arrKeys." => $arrVals"; 
			/*
			terminal => 31020177
			status1 => 1
			limit1 => 9940000
			counter1 => 3
			balance1 => 10000000
			dtlast1 => 20160524123426
			status2 => 1
			limit2 => 9930000
			counter2 => 2
			balance2 => 10000000
			dtlast2 => 20160523110034
			slot => 1
			*/
			
		}  		
		$string_request = base_url()."topup/mandiri_balance/".$QT; 
 
		if($slot==1) { $usebalance = $balance1; $usedtlast = $dtlast1; }
		if($slot==2) { $usebalance = $balance2; $usedtlast = $dtlast2;  }
		$strDT = substr($usedtlast,0,4)."-".substr($usedtlast,4,2)."-".substr($usedtlast,6,2);
		$strTM = substr($usedtlast,8,2).":".substr($usedtlast,10,2).":".substr($usedtlast,12,2); 
		$usedtlast = $strDT." ".$strTM; 
		
		$terminal_id = 0;
		
		$q = "Select terminal_id From vending_terminal Where TID = '".$terminal_id."' and status_id = '1' order by ID desc";
		$qdata = $this->db->query($q); 
		if($qdata->num_rows()){
			$arrResult = $qdata->result_array();
			
			$terminal_id = $arrResult[0]['terminal_id'];
		
		} 
		
		$strKey  = $strVal =  ""; 
		$strKey .=  "`date`,"; 
		$strVal .=  "'".date('Y-m-d H:i:s')."',"; 
		$strKey .=  "`terminal_id`,"; 
		$strVal .=  "'".$terminal_id."',"; 
		$strKey .=  "`TID`,"; 
		$strVal .=  "'".$terminal."',"; 
		$strKey .=  "`ka_slot`,"; 
		$strVal .=  "'".$slot."',"; 
		
		$strKey .=  "`ka_balance`,"; 
		$strVal .=  "'".$usebalance."',"; 
		$strKey .=  "`ka_date`,"; 
		$strVal .=  "'".$usedtlast."',"; 
		$strKey .=  "`string_request`,"; 
		$strVal .=  "'".$string_request."',"; 
		$strKey .=  "`status_id`"; 
		$strVal .=  "'1'"; 

		//-- chk if exist
		$q = "Select 1 FROM `topup_mandiri_balance` Where terminal_id = '".$terminal_id."' and TID = '".$terminal."' and ka_date = '".$usedtlast."' ";
		$qdata = $this->db->query($q); 
		
		//echo $qdata->num_rows();
		if(  $qdata->num_rows()==0 ){   
 
  			$q1 = " INSERT INTO `topup_mandiri_balance` ( ".$strKey. " ) VALUES ( ".$strVal." ); ";
 	
			if($this->db->query($q1)) echo 'ok'; 
			else echo 'Error insert data to database !';
		
		} else echo 'exist'; 
	}
	 
} 