<?php  
//session_start(); 
//error_reporting(E_ALL ^ E_NOTICE); 
//error_reporting(E_ALL); 
 
class Chgdatetrx extends Controller { 
	function Chgdatetrx(){    
		parent::Controller(); 
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		$this->load->library('allfunc'); 
		$this->load->library('funcreport');  
		$this->load->database(); 
		$this->load->library('session');  
		  
	} 
	function index(){ 
	
		$dt_begin 	= "2015-01-01";
		$dt_end 	= "2015-01-02";
		$tm_1		= "00:00:00";
		 
		 $q = " SELECT id,dt,tm 
				FROM  `tbk` 
				WHERE  
				`dt` >=  '2015-01-01' and `dt` <=  '2015-12-31' 
				
				"
				;//and `tm` >=  '00:00:00' and `tm` <  '06:00:00' 
				
		$tData = $this->db->query($q); 
		$n=0; $arr_chg_date = array();
 		if($tData->num_rows()) 
		foreach($tData->result_array() as $rowTrx){ 
			//echo "<br> - ".$rowTrx['id']." --- ".$rowTrx['dt']." --- ".$rowTrx['tm']." "; 
			// - 117 --- 2015-01-30 --- 00:19:01 
			
			$dt = explode(":",$rowTrx['tm']);
			
			//echo "<br> - ".$dt[2];	
			
			if($dt[0]=='00') $dt2 = '12';
			elseif($dt[0]=='01') $dt2 = '13';
			elseif($dt[0]=='02') $dt2 = '14';
			elseif($dt[0]=='03') $dt2 = '15';
			elseif($dt[0]=='04') $dt2 = '16';
			elseif($dt[0]=='05') $dt2 = '17';
			elseif($dt[0]=='06') $dt2 = '18';
			else $dt2 = $dt[0];
			
			//if($dt[0]=='05') $dt2 = '17';
			 
			$newdt = $dt2.":".$dt[1].":".$dt[2];
			
			$tid = $rowTrx['id'];
			
			$arr_chg_date[$tid]['dat'] = $rowTrx['dt'];
			$arr_chg_date[$tid]['org'] = $rowTrx['tm'];
			$arr_chg_date[$tid]['new'] = $newdt;
			
			  
			$n++;
			 
		} 		
		
		foreach($arr_chg_date as $id => $time){
		
			echo "<br> - arr_chg_date : [".$id."] --- ".$time['org']." --- ".$time['new']." "; 
		 	//echo "<br>";
			$q = " UPDATE `tbk` SET  `tm` =  '".$time['new']."' , `datetime` =  '".$time['dat']." ".$time['org']."' WHERE `id` = ".$id." LIMIT 1 ";
				
			$this->db->query($q); 
				
				
		}
		
	
	
 		 
	}
 
	
 }
