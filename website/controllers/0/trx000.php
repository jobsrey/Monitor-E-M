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
	 	//$QT = "dt=12082014---tm=115223---tid=VMEMON01---nourut=000001---jumbeli=2---hargabeli=50000---isikartu=30000---biayakartu=20000---totalbayar=50000---cashbox=200000---lbrcashbox=10---payout=10000---lbrpayout=1---sisakartu=3";
		$arrKEY = array();
		$arrVALUE = array();
	 	$arrQT = explode("---",$QT);
		foreach($arrQT as $key => $value){
			//echo "<br>$key => $value";
			$arrVars = explode("=",$value);
			foreach($arrVars as $key1 => $value1){
				//echo "<br>$key1 => $value1";
				if ($key1==0) array_push($arrKEY,$value1);
				if ($key1==1) array_push($arrVALUE,$value1);
 			}
		} 
		//foreach($arrKEY as $k => $v ) echo "<br>$k => $v";
		//foreach($arrVALUE as $k => $v ) echo "<br>$k => $v";
		
		//$arrVALUE[0];12082014
		//$arrVALUE[1];115223
		
		//$strDT = substr($arrVALUE[0],0,2) substr($arrVALUE[0],2,2) substr($arrVALUE[0],2,2)
		$strDT = substr($arrVALUE[0],4,4)."-".substr($arrVALUE[0],2,2)."-".substr($arrVALUE[0],0,2);
		$strTM = substr($arrVALUE[1],0,2).":".substr($arrVALUE[1],2,2).":".substr($arrVALUE[1],4,2);
		$q = "INSERT INTO `trx` (
			`id` ,
			`dt` ,
			`tm` ,
			`tid` ,
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
			'".$strDT."', 
			'".$strTM."', 
			'".$arrVALUE[2]."', 
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
			'".$QT."'
			);";
 
			if($this->db->query($q)) echo 'true'; 
		 
	} 
	
	 
	 
  

	 
} 