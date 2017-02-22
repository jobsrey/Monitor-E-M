<?php  
//session_start(); 
 
class Trx extends Controller {  

	function Trx()  
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
	
	function query($QT){ 

	 	//echo str_replace("---","<br>",$QT);
 
		//25.59.219.254/trx/query/kdtrx=CRD01---dt=22092014---tm=022442---vmid=210-00-000-0-111---nourut=3---jmlbeli=1---hargabeli=50000---isikartu=30000---biayakartu=20000---totalbayar=50000---uangmasuk=100000---uangkeluar=50000---cashbox=0---lbrcashbox=0---payout=150000---lbrpayout=3---sisakartu=20---kdtrx=xxx


		$arrKEY = array();
		$arrVALUE = array();
	 	$arrQT = explode("---",$QT);
		$arrRequest = array();
		foreach($arrQT as $key => $value){
			//echo "<br>$key => $value";
			$arrVars = explode("=",$value);
			$arrRequest[$arrVars[0]] = $arrVars[1];
			/*
			foreach($arrVars as $key1 => $value1){
				//echo "<br>$key1 => $value1";
				if ($key1==0) array_push($arrKEY,$value1);
				if ($key1==1) array_push($arrVALUE,$value1); 
				//$$key1 = $value1; 
 			}
			*/
		}  
		$strDT = substr($arrRequest['dt'],4,4)."-".substr($arrRequest['dt'],2,2)."-".substr($arrRequest['dt'],0,2);
		$strTM = substr($arrRequest['tm'],0,2).":".substr($arrRequest['tm'],2,2).":".substr($arrRequest['tm'],4,2);


		$arrRequest['id'] = '' ;
		$arrRequest['dt'] = $strDT;
		$arrRequest['tm'] = $strTM;

		$strKey = $strVal = "";
		
		foreach($arrRequest as $k => $v ){ //echo "<br>$k => $v"; 
			$strKey .=  "`".$k."`,"; 
			$strVal .=  "'".$v."',"; 
		}
		$strKey = substr($strKey,0,strlen($strKey)-1);
		$strVal = substr($strVal,0,strlen($strVal)-1);
		$strKey .=  ",`string_request`"; 
		$strVal .=  ",'".$QT."'"; 
		
		$q = " INSERT INTO `trx` ( ".$strKey. " ) VALUES ( ".$strVal." ); ";
		
		//$this->db->query($q);
		
		if($this->db->query($q)) echo 'ok'; 
		exit;
		//foreach($arrVALUE as $k => $v ) echo "<br>$k => $v";
		
		//$arrVALUE[0];12082014
		//$arrVALUE[1];115223
		
		//$strDT = substr($arrVALUE[0],0,2) substr($arrVALUE[0],2,2) substr($arrVALUE[0],2,2)

		//$strDT = substr($arrVALUE[1],4,4)."-".substr($arrVALUE[1],2,2)."-".substr($arrVALUE[1],0,2);
		//$strTM = substr($arrVALUE[2],0,2).":".substr($arrVALUE[2],2,2).":".substr($arrVALUE[2],4,2);

		$q = "INSERT INTO `trx` (
			`id` ,
			`kdtrx` ,
			`dt` ,
			`tm` ,
			`vmid` ,
			`nourut` ,
			`jmlbeli` ,
			`hargabeli` ,
			`isikartu` ,
			`biayakartu` ,
			`totalbayar` , 
			`cashbox` ,
			`lbrcashbox` ,
			`payout` ,
			`lbrpayout` ,
			`sisakartu` , 
			`string_request`
			)
			VALUES (
			'' , 
			'".$arrVALUE[0]."',
			'".$strDT."', 
			'".$strTM."', 
			'".$arrVALUE[3]."', 
			'".$arrVALUE[4]."', 
			'".$arrVALUE[5]."', 
			'".$arrVALUE[6]."', 
			'".$arrVALUE[7]."', 
			'".$arrVALUE[8]."', 
			'".$arrVALUE[9]."',  
			'".$arrVALUE[10]."',
			'".$arrVALUE[11]."', 
			'".$arrVALUE[12]."', 
			'".$arrVALUE[13]."', 
			'".$arrVALUE[14]."',  
			'".$QT."'
			);";
			
			//`uangmasuk` ,
			//`uangkeluar` , 
			
			//'".$arrVALUE[15]."', 
			//'".$arrVALUE[16]."', 

 		 exit;
 
			//if($this->db->query($q)) echo 'true'; 
		 
	} 
	
	 
	 
  

	 
} 