<?php
class Allmodel extends Model {

    function Allmodel()
    {
        parent::Model();
		$this->load->database();
		$this->load->library('session'); 
    }
	
	
	//function getMediaTtype($type=''){
		//return $this->db->query("select * from `media_database` where `status_id`=1 and `type` = '".$type."' Order By `title` ");
	//} 
	
	function getMerchantProduct($merchant_id='0'){
		$q = 'select * from db_merchant_product where merchant_id = '.$merchant_id.' order by `product_name` asc' ;  
		$qdata = $this->db->query($q);
		return $qdata;
	}
	
	function getGroupbyID($id='0',$n=0){
		$q = 'select * from user_group_table where id = '.$id.' limit 1' ;  
		$qdata = $this->db->query($q);
		$return = '';
		if($qdata->num_rows()){ 
			$row = $qdata->result_array();
			if($n==0)  $key = "group";
			if($n==1)  $key = "description";
			$return = $row[0][$key]; 
		}	
		
		return $return;
		
	}
	function valGroup3Chr($grpID=''){
		$grp = ''; 
		if($grpID>2) {
			$grp = $grpID;
			if(strlen(trim($grp))==0) $grp = "000".$grp;
			if(strlen(trim($grp))==1) $grp = "00".$grp;
			if(strlen(trim($grp))==2) $grp = "0".$grp; 
		}
		return $grp;
	}	
	function number_rp($amount,$sign1=1,$sign2=1){ 
		$res = '';
		if(!empty($amount)){
			if($sign1) $si  = "Rp. "; else $si = "";
			if($sign1) $si2 = ",-";  else $si2 = "";
			
		$res = $si.number_format($amount,0,',','.').$si2;
		}
		return $res;
	}	
	
	
	//S:------- location tree -------------------------------------------------------
	function getListLocDesc($table,$status_id=1,$mode=0,$slcid=0){ 
		if($mode==0||$mode==1)
		$q = 'select * from '.$table.' where status_id = '.$status_id.' order by `loc` asc'; 
 
		if($mode==2)
		$q = 'select * from '.$table.' where status_id = '.$status_id.' and `id` = '.$slcid.' limit 1'; 
 
		return $this->db->query($q);  
	}
	
	function getLocationByID($table,$id){ 
		$q = 'select * from '.$table.' where id = '.$id.' limit 1'; 
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
	}
	function getChildByID($table,$id){ 
		$q = 'select * from '.$table.' where parent_id = '.$id; 
		$qdata = $this->db->query($q);  
		$arrResult = array(); 
		if($qdata->num_rows())   
		foreach($qdata->result_array() as $k => $row) {  
			$arrResult[$k] = $row; 		
		}	 
		return $arrResult; 
	}
	
	//E:------- location tree -------------------------------------------------------
	
	
	//S:------- All Index Table ----------------------------------------------------- 
	
	function getQueryTable($TABLE){
		$q = ''; 
		if($TABLE=='md_location'){
			$q = "
			Select 
			a.id as id,
			a.loc as Kelurahan, 
			b.loc as Kecamatan, 
			c.loc as Kotakab, 
			d.loc as Provinci, 
			e.loc as Negara
			
			From md_location a 
			Left join md_location b on b.id = a.parent_id 
			Left join md_location c on c.id = b.parent_id 
			Left join md_location d on d.id = c.parent_id 
			Left join md_location e on e.id = d.parent_id  
			where 
			
			a.lineage = 'kelurahan'
			
			"; 
			
			/*
			 and 
			b.lineage = 'area' and 
			c.lineage = 'city' and 
			d.lineage = 'province' and 
			e.lineage = 'country' 
			*/
		}
		if($TABLE=='md_agent'){
			$q = "
			Select *
			
			From md_agent "; 
			
			/*
			 and 
			b.lineage = 'area' and 
			c.lineage = 'city' and 
			d.lineage = 'province' and 
			e.lineage = 'country' 
			*/
		}
		
		if($TABLE=='md_product_group'){
			$q = "
			Select *
			
			From md_product_group "; 
			
			/*
			 and 
			b.lineage = 'area' and 
			c.lineage = 'city' and 
			d.lineage = 'province' and 
			e.lineage = 'country' 
			*/
		}
		return $q;
	}
	
	function getTableKeys($TABLE,$type='key'){
	
		$strQ = $this->getQueryTable($TABLE); 
		if(!empty($strQ)) $q = $this->getQueryTable($TABLE).' Limit 1'; 
		else $q = 'select * from '.$TABLE.' Limit 1'; 
 
		$qdata = $this->db->query($q);
		$arrKey = $arrVal = $arrResult = array();
		if($qdata->num_rows())   
		foreach($qdata->result_array() as $row) 
		foreach( $row as $key => $value){ 
			//echo "<br>$key => $value";
			$arrResult[$key] = $value; 
			array_push($arrKey,$key);
			array_push($arrVal,$value); 
		}	
		if($type=='key') return $arrKey;
		elseif($type=='val') return $arrVal;
		else return $arrResult; 
 
	}
	
 
	function getTableKeysType($TABLE,$type='val'){
 
		$q = 'SHOW COLUMNS FROM '.$TABLE.''; 
 
		$qdata = $this->db->query($q);
		$arrKey = $arrVal = $arrResult = array();
		if($qdata->num_rows())   
		foreach($qdata->result_array() as $row){ 
		 
			foreach( $row as $key => $value){ 
				//echo "<br>$key => $value";
				if($key=='Type'){ 
					array_push($arrVal,$value); 
					$rowType = $value; 
				}
				if($key=='Field'){ 
					array_push($arrKey,$value); 
					$rowKey = $value;
				}
			} 
			$arrResult[$rowKey] = $rowType;  
		}	
		if($type=='key')     return $arrKey;
		elseif($type=='val') return $arrVal;
		elseif($type=='all') return $arrResult; 
	}
	
	function selectIndexTable($start,$limit,$status_id,$sort,$order,$TABLE,$where=''){
 
  		$strWhere    = ' Where status_id='.$status_id.' ';
		if(!empty($where)) $strWhere = ' Where status_id='.$status_id.' and '.$where; 
 
		$strSortBy    = '';
		if(!empty($sort) && !empty($order) ) 
		$strSortBy = 'Order By `'.$sort.'` '.$order; 
		
		
		//echo $TABLE; exit;		
 
		if($TABLE=="md_location"){ 
			$strWhere    = ' and a.status_id='.$status_id;
			if(!empty($where)) 
			$strWhere = ' and a.status_id='.$status_id.' and '.$where;  
		} 
 
 
		$strQ = $this->getQueryTable($TABLE);
		if(!empty($strQ)) $qstr = $this->getQueryTable($TABLE); 
		else $qstr = 'select * from '.$TABLE ; 
		
		$q = $qstr.' '.$strWhere.' '.$strSortBy.' limit '.$start.','.$limit ; 
 
		return $this->db->query($q);
	}
	function countTable($TABLE,$status_id=1){ 
 
   		if($TABLE=='md_location') $strwhere = " and lineage = 'venue' "; else $strwhere = ""; 
		return $this->db->query(" select count(`id`) count from `".$TABLE."` where status_id='".$status_id."' ".$strwhere); 
	}
 
	function selectItemTableById($TABLE,$id){
 
		$q = 'select * from '.$TABLE.' where id = '.$id.' limit 1' ;  
		
		return $this->db->query($q);
	}
	//E:----------------------------------------------------------------------------- 
	
	function getUserNamebyID($id) {
		$return = '';
		$gData = $this->db->query("select Username from user_table Where ID = '".$id."' Limit 1" );
		$row = $gData->row_array();
 		if($gData->num_rows()) $return = $row['Username'];
		return $return; 
	} 
	
	
	function getVMByID($id) {
		$return = '';
		$gData = $this->db->query("select terminal_ID  from vending_terminal Where id = '".$id."' Limit 1" );
		$row = $gData->row_array();
 		if($gData->num_rows()) $return = $row['terminal_ID'];
		return $return; 
	} 
	
	function getMDdata($tbl='',$id=0,$select_id=0) {
		if(empty($id))
		$q = "select * from ".$tbl." where status_id=1 ";
		else
		$q = "select * from ".$tbl." where status_id=1 and id = '".$id."' limit 1";
 
		$gData = $this->db->query($q);
		$row = $gData->result_array();
		
		$return = '';
 		if($gData->num_rows()) $return = $row; 
		return $return; 
	} 	
	
	function getTableByID($tbl='',$id=0) { 
 
		$q = "select * from ".$tbl." where id = '".$id."' limit 1";
		
		$gData = $this->db->query($q);
		$row = $gData->row_array();
		
		$return = '';
 		if($gData->num_rows()) $return = $row; 
		return $return; 
	}
	
	function getTableWhere($tbl='',$key='',$val=0,$status_id=1,$orderby='',$result_key='',$allrow=0) { 
 
		
		 
		
		if(empty($orderby)) $order = "order by id asc";
		else				$order = "order by `".$orderby."` asc";
		
		
		if($tbl=='menu_table'||$tbl=='menu_table'||$tbl=='member_table'||$tbl=='merchant_table') $key_status_id = "StatusID"; else $key_status_id = "status_id";
		
		$strwhere = "where";
		//if(!empty($status_id)||!empty($val)) $strwhere .= " where";
		
		if(!empty($status_id)) 	$strwhere .= " and `".$key_status_id."` = '".$status_id."'";  
		
		if( ($tbl=='menu_table' && !empty($key)) || ($tbl!='menu_table' && !empty($val)) || ($tbl=='md_location' && empty($val)) ){ 
		
			$strwhere .= " and `".$key."` = '".$val."'";  
		}
		if( $tbl=='md_agent' &&  $this->session->userdata('GroupID') != '1' ){
		 
			$strwhere .= " and MediaID = '".$this->session->userdata('GroupID')."'";  
		}
 
		$strwhere = str_replace("where and","where",$strwhere);
		if(str_replace(" ","",$strwhere)=="where") $strwhere=''; 
		
		
 	
		$q = "select * from `".$tbl."` ".$strwhere." ".$order." ";
 		 //echo $q."<br>";
  
		$gData = $this->db->query($q);
		$row = $gData->result_array();
		  
 		if($gData->num_rows()){ 
			
			//if($allrow) return $row; 
			//else
			//if(!empty($result_key)) return $row[0][$result_key]; //
			//else 
			//if(!empty($result_key) && !empty($val)) return $row[0][$result_key]; //
			//else 
			return $row;  
			
		} else return array();
	}
	
	//--- TFC
	function getTableWhere2($tbl='',$key='',$val=0,$status_id=1,$orderby='',$result_key='',$allrow=0,$merchant_group=0,$arrCheck=array(),$trx_merchant_local=1,$trx_merchant_national=1) { 
 
		if(empty($orderby)) $order = "order by id asc";
		else				$order = "order by `".$orderby."` asc";
		
		
		if($tbl=='menu_table'||$tbl=='menu_table'||$tbl=='member_table'||$tbl=='merchant_table') $key_status_id = "StatusID"; else $key_status_id = "status_id";
		
		$strwhere = "where";
		//if(!empty($status_id)||!empty($val)) $strwhere .= " where";
		
		if(!empty($status_id)) 	$strwhere .= " and `".$key_status_id."` = '".$status_id."'";  
		
		//if( ($tbl=='menu_table' && !empty($key)) || ($tbl!='menu_table' && !empty($val)) || ($tbl=='md_location' && empty($val)) ){ 
		
			//$strwhere .= " and `".$key."` = '".$val."'";  
		//}
		if( $tbl=='md_agent' &&  $this->session->userdata('GroupID') != '1' ){
		 
			$strwhere .= " and MediaID = '".$this->session->userdata('GroupID')."'";  
		}
				
		if($merchant_group>2){ //-- TFC MERCHANT selected by group 
			//---
			if($tbl=="member_table"){
				$wcard = '';
				foreach($arrCheck as $row){ 
					//echo "<br>".$row['card_number'];
					$wcard .= " TFCNumber = '".$row['card_number']."' or";
				} 
				$wcard = substr($wcard,0,strlen($wcard)-2);
				
				if( $trx_merchant_local==1 && $trx_merchant_national==1){ 
					$strwhere .= " and ( ".$wcard." or substr(`".$key."`,1,3) = '".$this->valGroup3Chr($merchant_group)."' )";  
				} 
				elseif($trx_merchant_local==1){
					$strwhere .= " and substr(`".$key."`,1,3) = '".$this->valGroup3Chr($merchant_group)."'"; 
				}
				elseif($trx_merchant_national==1){
					$strnas = " and ( ".$wcard." and substr(`".$key."`,1,3) != '".$this->valGroup3Chr($merchant_group)."' )";  
 					$strnas = str_replace(" or"," and",$strnas);
					$strwhere .= str_replace("TFCNumber = '".$this->valGroup3Chr($merchant_group),"TFCNumber != '".$this->valGroup3Chr($merchant_group),$strnas);
					 
				}
				
				
			} else {
			
 				$strwhere .= " and substr(`".$key."`,1,3) = '".$this->valGroup3Chr($merchant_group)."'";  
			
			
			}
		}
		
		
		$strwhere = str_replace("where and","where",$strwhere);
		$strwhere = str_replace("  "," ",$strwhere);
		$strwhere = str_replace("  "," ",$strwhere);
		$strwhere = str_replace("and ( or ","and ( ",$strwhere);
		if(str_replace(" ","",$strwhere)=="where") $strwhere=''; 
		
		
 	
		$q = "select * from `".$tbl."` ".$strwhere." ".$order." ";
 		//echo $q."<br>";
  
		$gData = $this->db->query($q);
		$row = $gData->result_array();
		  
 		if($gData->num_rows()){ 
			
			//if($allrow) return $row; 
			//else
			//if(!empty($result_key)) return $row[0][$result_key]; //
			//else 
			//if(!empty($result_key) && !empty($val)) return $row[0][$result_key]; //
			//else 
			return $row;  
			
		} else return array();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function getTableProductByTerminalID($owner_id=0,$terminal_id='',$status_id=1) { 
 
		$str_owner = '';
		if(!empty($owner_id)) $str_owner = " and owner_id = '".$owner_id."' ";
		
		$str_terminal = '';
		if(!empty($terminal_id)) $str_terminal = " and id = '".$terminal_id."' ";		
		
		$q = "select product_id From vending_terminal   
			  Where status_id = ".$status_id." ".$str_terminal." ".$str_owner; 
 			  
		$gData = $this->db->query($q);
		$row = $gData->result_array();
		$str_ids = '';
		if($gData->num_rows()){  
			$str_ids .= " and ( ";
			foreach($row as $key => $val){ //echo "<br>$key => $val"; 
				$arrProduct = explode(",",$row[$key]['product_id']); 
				foreach($arrProduct as $k=>$v){
					$str_ids .= " `id`='".$v."' or";	 
				} 
			} 
			$str_ids = substr($str_ids,0,strlen($str_ids)-2); 
			$str_ids .= " ) ";  
		}
 		
		$return = '';
 
		if(!empty($str_ids)){
			
		$q = "select * From pd_product Where status_id = '".$status_id."' ".$str_ids." order by product asc" ;  
 
		$gData = $this->db->query($q);
		$row = $gData->result_array(); 
 		if($gData->num_rows()) $return = $row; 
		else $return = array();
		
		}
		return $return;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	//-----------------------------------------------------------------------------------
	
 
	
	//--- Media Database : --------------------------------------------------------------	
	function getVendingTerminal($id=0,$online_status=1,$status_id=1){ 
		$str_where = '';
		if($id||$online_status||$status_id){
			$str_where = " where ";
			if($id) 			$str_where .= "and a.id = '".$id."' ";
			if($online_status) 	$str_where .= "and a.online_status = '".$online_status."' ";
			if($status_id)  	$str_where .= "and a.status_id = '".$status_id."' ";
		}  
		$str_where = str_replace("where and"," where ",$str_where);
		$q = $this->getQueryTable('vending_terminal').$str_where." order by a.terminal_name";  
		return $this->db->query($q); 
	}
	
	function getVendingTerminalByID($id=0){
		$q = $this->getQueryTable('vending_terminal')." where a.online_status = 1 and a.id = '".$id."' Limit 1"; 
		return $this->db->query($q); 
		
	}
	function getVendingTerminalAll(){
		$q = $this->getQueryTable('vending_terminal')." where a.status_id = 1 Order By terminal_ID " ;
		return $this->db->query($q); 
	}
	//-----------------------------------------------------------------------------------	
	
	//--- Media Database : --------------------------------------------------------------	
	function getMediaDB($id=0,$type='',$status_id=1){
		$str_id = $str_type  = '';
		if($id)				$str_id   = " and `id`   = '".$id."' ";
		if(!empty($type))	$str_type = " and `type` = '".$type."' "; 
		$q = "select * from `media_database` where `status_id`= '".$status_id."'".$str_id.$str_type." Order By `title` ";
		return $this->db->query($q);
	}
	function selectMediaDB($start=0,$limit=10,$status_id=1,$sort="id",$order="desc",$type="0"){
		$strSortBy    = '';
		if(!empty($sort) && !empty($order) ) 
		$strSortBy = 'Order By '.$sort.' '.$order;
		
		$strWhere    = '';
		if($type=="video")     $strWhere = " And `type` = 'video' ";
		elseif($type=="image") $strWhere = " And `type` = 'image' ";
		elseif($type=="patch") $strWhere = " And `type` = 'patch' "; 
 
		$q = 'select * from media_database Where status_id='.$status_id.' '.$strWhere.' '.$strSortBy.' limit '.$start.','.$limit ;
		 
		return $this->db->query($q);
	}
	function countMediaDB($type="0",$status_id=1){
		$strWhere    = '';
		if($type=='video') $strWhere = " And `type` = 'video' ";
		if($type=='image') $strWhere = " And `type` = 'image' ";
		if($type=='patch') $strWhere = " And `type` = 'patch' "; 
	
		return $this->db->query('select count(id) count from media_database Where status_id='.$status_id.' '.$strWhere );
	}
	
	//-----------------------------------------------------------------------------------
	
	
	function selectLog($start=0,$limit=10,$status_id=1,$sort="ID",$order="desc",$tbl="trx"){
  
		$strSortBy    = '';
		if(!empty($sort) && !empty($order) ) 
		$strSortBy = 'Order By '.$sort.' '.$order;
		 
		$q = 'select * from `'.$tbl.'` '.$strSortBy.' limit '.$start.','.$limit ;

  		//echo $q; //exit;
		return $this->db->query($q);
	}
	function selectTrx($start=0,$limit=10,$status_id=1,$sort="ID",$order="desc"){
  
		$strStatusID = 'status_id='.$status_id.'';   
		  
		$strSortBy    = '';
		if(!empty($sort) && !empty($order) ) 
		$strSortBy = 'Order By '.$sort.' '.$order;
		 
		$q = 'select * from `trx` Where '.$strStatusID.' '.$strSortBy.' limit '.$start.','.$limit ;

  		//echo $q; //exit;
		return $this->db->query($q);
	}
	
	function selectUser($start=0,$limit=10,$status_id=1,$sort="ID",$order="desc",$group_id=0,$tbl="user_table"){
 
		$strStatusID = 'StatusID='.$status_id.'';  
		$strStatusID = 'StatusID='.$status_id.'';  
		
		if($status_id==0) $strStatusID = '';  
		else 			  $strStatusID = ' and '.$strStatusID;   
		  
		$strSortBy    = '';
		if(!empty($sort) && !empty($order) ) 
		$strSortBy = 'Order By '.$sort.' '.$order;
		 
		//if($this->session->userdata('GroupID')==1) $strGroup = '' ; //--- as Group  
		//else $strGroup = ' and GroupID = '.$this->session->userdata('GroupID');
		
		//echo $group_id;
		
		if($this->session->userdata('GroupID')==1 && $group_id==0) $strGroup = '' ;
		elseif($this->session->userdata('GroupID')==1 && $group_id==1) $strGroup = ' and GroupID = 1 ';
		elseif($this->session->userdata('GroupID')==1 && $group_id>1)  $strGroup = ' and GroupID = '.$group_id.' ';
		elseif($this->session->userdata('GroupID')>1)  $strGroup = ' and GroupID = '.$this->session->userdata('GroupID');
 
		if($tbl!="user_table") $str_admin_id = "";
		else $str_admin_id = "ID != 1 and ID != 2";
		 
		$q = 'select * from '.$tbl.' Where ( '.$str_admin_id.' '.$strGroup.') '.$strStatusID.' '.$strSortBy.' limit '.$start.','.$limit ;
		$q = str_replace("  "," ",$q);
		$q = str_replace(" ( ) and StatusID"," StatusID",$q);
		$q = str_replace(" Where (  and "," Where ( ",$q);
		
  		//echo $q; //exit;
		return $this->db->query($q);
	}
	
	function countUser($status_id=1,$table='',$group_id=0){
	
		//if($this->session->userdata('GroupID')==1) $strGroup = '' ; //--- as Group  
		//else $strGroup = ' and GroupID = '.$this->session->userdata('GroupID');
		
		if($this->session->userdata('GroupID')==1 && $group_id==0) $strGroup = '' ;
		elseif($this->session->userdata('GroupID')==1 && $group_id==1) $strGroup = ' and GroupID = 1 ';
		elseif($this->session->userdata('GroupID')==1 && $group_id>1)  $strGroup = ' and GroupID = '.$group_id.' ';
		elseif($this->session->userdata('GroupID')>1)  $strGroup = ' and GroupID = '.$this->session->userdata('GroupID');
		
		$q = 'select count(ID) count from '.$table.' Where ( ID != 1 and ID != 2 ) and StatusID='.$status_id.' '.$strGroup;
  		// echo $q;  //exit;
		return $this->db->query($q);
	}
	
	function getUserById($id,$table='member_table'){
		return $this->db->query('select * from '.$table.' where ID = '.$id.' Limit  1'); 
	}
	
	function editStatusIDUser($status_id,$id,$table='member_table'){
		return $this->db->query('update '.$table.' set StatusID='.$status_id.' Where ID='.$id);
	} 	

	function editStatusMemberPAID($TFCStatus,$id,$table='member_table'){
		return $this->db->query('update '.$table.' set TFCStatus='.$TFCStatus.' Where ID='.$id);
	} 
	
	function getMenu($ParentID=0){ 
		return $this->db->query("Select * from menu_table Where StatusID = 1 and ParentID = ".$ParentID." Order By LineAge asc");  
	}
	
	function getMenuAllByParent($ParentID=0){ 
		return $this->db->query("Select * from menu_table Where ParentID = ".$ParentID." Order By LineAge asc");  
	}
	function countLog($table='trx'){
		return $this->db->query('select count(`id`) count from `'.$table.'`');
	}
	

	
	function cutstr($string, $charcount) {
		$x = '';
		$countspace = $charcount - 1 ; 
		if (strlen($string) > $charcount) {
			while ($x != ' ') {
				$x = substr($string,$countspace,1);
				$countspace--;
			}
			return substr($string,0, $countspace + 1)."..";	 //return substr($string,0,$charcount)."...";
		}
		else { return $string; }
	}
	
	//-- functions date time 
	
	function dateIsExpire($dateCur="",$dateBeg="",$dateEnd="",$mode=0){
	
		if(empty($dateCur)) { return 0; exit; } //$dateCur=date("Y-m-d H:i:s");	
		if(empty($dateBeg)) { return 0; exit; } //$dateBeg=date("Y-m-d")." 00:00:01";	
		if(empty($dateEnd)) { return 0; exit; } //$dateEnd=date("Y-m-d")." 23:59:59";
		
		$dateCur = str_replace("-","",str_replace(":","",str_replace(" ","",$dateCur))); 
		$dateBeg = str_replace("-","",str_replace(":","",str_replace(" ","",$dateBeg))); //
		$dateEnd = str_replace("-","",str_replace(":","",str_replace(" ","",$dateEnd))); //."000001"
		
		if(strlen($dateCur)<12) $dateCur = $dateCur.date("His");
		if(strlen($dateBeg)<12) $dateBeg = $dateBeg."000001";
		if(strlen($dateEnd)<12) $dateEnd = $dateEnd."235959"; 
		
		/*
		echo "<br>";
		echo $dateBeg;
		echo "<br>";
		echo $dateCur;
		echo "<br>";
		echo $dateEnd;
		*/
		
		if( $dateCur >= $dateBeg && $dateCur <= $dateEnd ) return 0;
		else return 1;
		
		 
	} 
	
	function formatDateTime($vardate,$mode=0) {  
		
		$hari = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'); // dateformat --> w 
		$bulan = array(1=>'Januari', 2=>'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'); 
		$bulan2 = array(1=>'Jan', 2=>'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'); 
		$dywk = date('w',strtotime($vardate));  
		$dywk2 = $hari[$dywk];
		$dy = date('j',strtotime($vardate)); 
		$dy2 = date('d',strtotime($vardate));
		$mth = date('n',strtotime($vardate)); 
		$mth2 = date('m',strtotime($vardate));
		$bln = $bulan[$mth]; 
		$bln2 = $bulan2[$mth];
		$yr = date('Y',strtotime($vardate));
		$hr = date('H',strtotime($vardate));
		$mi = date('i',strtotime($vardate)); 
		$ss = date('s',strtotime($vardate));  
 
		if($mode==0){																				// -- 17:06   OR  ''.$dy2.'/'.$mth2.'';
			$dateDay = date("z",strtotime($vardate));
			$curDay  = date("z",strtotime(date("Y-m-d H:i:s")));
			if($curDay!==$dateDay)
			return  ''.$dy2.'/'.$mth2.'';
			else 
			return $hr.':'.$mi; 
		}
		elseif($mode==1) return $yr.'-'.$mth.'-'.$dy;  												// -- 2010-12-31 
		elseif($mode==2) return $dy.' '.$bln.' '.$yr; 												// -- 19 November 2009 
		elseif($mode==3) return $dywk2.', '.$dy.' '.$bln.' '.$yr; 									// -- Selasa, 19 November 2009		
		elseif($mode==4) return $dywk2.', '.$dy.' '.$bln2.' '.$yr.' - '.$hr.':'.$mi.' wib'; 			// -- Selasa, 17 Nov 2010 | 06:33 wib 			
		elseif($mode==5) return $dywk2.', '.$dy.' '.$bln.' '.$yr.' | '.$hr.':'.$mi.' WIB'; 			// -- Selasa, 19 November 2009 | 17:06 WIB
		elseif($mode==6) return $dywk2.' ('.$dy2.'/'.$mth2.')' ; 									// -- Selasa (17/05) 
		elseif($mode==7) return $dywk2.' ('.$dy2.'/'.$mth2.') | '.$hr.':'.$mi;						// -- Selasa (17/05) | 06:33
		elseif($mode==8) return $dywk2.' ('.$dy2.'/'.$mth2.') | '.$hr.':'.$mi.' WIB' ; 				// -- Selasa (17/05) | 06:33 WIB
		elseif($mode==9) return $hr.':'.$mi.' WIB ';												// -- 19:06 WIB
		elseif($mode==10) return  $dy2.'/'.$mth2 ; 													// -- 17/05
		elseif($mode==11) return '('.$dy2.'/'.$mth2.')';  											// -- (17/05)
		elseif($mode==12) return $dy.' '.$bln; 														// -- 17 Mei	
		elseif($mode==14) return $this->dateRange(1,$vardate); 										// -- 12 jam 59 menit lalu
		elseif($mode==15) return $dywk2.' ('.$dy2.'/'.$mth2.'/'.$yr.')'.$this->dateRange(0,$vardate,"",1); // -- Senin (17/05) | 12 jam 59 menit lalu 
		else return $yr.'-'.$mth.'-'.$dy.' '.$hr.':'.$mi.':'.$ss;   								// -- 2010-12-31 00:00:00 
	}  
	
	function dateRange($mode=0,$datePub="",$dateNow="",$timeMax=2){
		if(empty($datePub)) $datePub=date("Y-m-d H:i:s");	
		if(empty($dateNow)) $dateNow=date("Y-m-d H:i:s");
		$strText=$strText1=$strText2=$strText3=''; 	
		$foo1 = strtotime($dateNow);
		$yy11 = date("Y",$foo1);		$hh11 = date("H",$foo1);
		$mm11 = date("m",$foo1);		$ii11 = date("i",$foo1);
		$dd11 = date("d",$foo1);		$ss11 = date("s",$foo1); 
		$dyz1 = date("z",$foo1);
		$foo2 = strtotime($datePub);
		$yy21 = date("Y",$foo2);		$hh21 = date("H",$foo2);
		$mm21 = date("m",$foo2);		$ii21 = date("i",$foo2);
		$dd21 = date("d",$foo2);		$ss21 = date("s",$foo2); 
		$dyz2 = date("z",$foo1);
		$tttime1 = mktime($hh11,$ii11,$ss11,$mm11,$dd11,$yy11);
		$tttime2 = mktime($hh21,$ii21,$ss21,$mm21,$dd21,$yy21); 
		$hournya = ($tttime1-$tttime2)/60/60;
		$jamnya  = floor($hournya); 
		$minnya  = ($tttime1-$tttime2) - $jamnya*3600;
		$minnya  = floor($minnya/60);
		$secnya  = ($tttime1-$tttime2) ;
		if($jamnya<$timeMax){
			if($jamnya>0)  $strText1 .=  $jamnya.' jam '; 
			if($minnya>0)  $strText2 .=  $minnya.' menit ';  
			if($secnya<60 && $secnya>0) $strText3  =  $secnya.' detik '; 	 
			if(strlen($strText1)>0||strlen($strText2)>0||strlen($strText3)>0)
			$strText .= ' | '.$hh21.':'.$ii21.' WIB. <span class="nDate"> '.$strText1.$strText2.$strText3.' lalu.</span>'; 
			else 
			$strText .= ' | '.$hh21.':'.$ii21.' WIB.'; 
		}

		if($mode==1) return $strText = $strText1.$strText2.$strText3.' lalu.';
		else 		 return $strText; 
	} 
	//-- /functions date time
	
	 
	      
}
?>