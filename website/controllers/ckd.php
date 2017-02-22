<?php  
//session_start(); 
 
class Ckd extends Controller {  

	function Ckd()  
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
//$QT = "dt=12082014---tm=115223---vmid=VMEMON01---totaltrx=000001---uangmasuk=2---
//cardfull=50000---kartukeluar=30000---sisakartu=20000";

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
		//foreach($arrKEY as $k => $v )   echo "<br>$k => $v";
		//foreach($arrVALUE as $k => $v ) echo "<br>$k => $v";
		
		//$arrVALUE[0];12082014
		//$arrVALUE[1];115223
		
		//$strDT = substr($arrVALUE[0],0,2) substr($arrVALUE[0],2,2) substr($arrVALUE[0],2,2)

		$strDT = substr($arrVALUE[1],4,4)."-".substr($arrVALUE[1],2,2)."-".substr($arrVALUE[1],0,2);
		$strTM = substr($arrVALUE[2],0,2).":".substr($arrVALUE[2],2,2).":".substr($arrVALUE[2],4,2);


 
 //http://25.59.219.254/ckd/query/kdtrx=TBK---dt=12082014---tm=111523---stprinter=0001---stba=100---stcd=100000---cardfull=50


		$q = "INSERT INTO `ckd` (
			`id`, 
			`kdtrx`, 
			`dt`, 
			`tm`, 
			`vmid`, 
			`stprinter`, 
			`stba`, 
			`stcd`, 
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
			'".$QT."'
			);";
 
			if($this->db->query($q)) echo 'true'; 
		 
	} 
	
	 
	 
  

	 
} 