<?php 
 if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Func_v2 extends Allmodel{ 

  	function Func_v2(){    
    	parent::Allmodel();     
  	} 
	
	
	function getColChkDev($code){ 
		$q = "select * from md_respons_code where `code` = '".$code."' limit 1"; 
		
		$qdata = $this->db->query($q); 
		$arrResult = array();
		if($qdata->num_rows())   
		foreach($qdata->result_array() as $k => $row) {
			foreach( $row as $key => $value){ 
				//echo "<br>$key => $value";
				$arrResult[$key] = $value;
			}
		}	 
		return $arrResult;
		/**/
		
	 
	}
	
}
?>