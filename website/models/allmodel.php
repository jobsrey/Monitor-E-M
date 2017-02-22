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
		if($TABLE=='vending_terminal'){ 
			
			//$strGroup = '';
			//if($this->session->userdata('GroupID')>1) $strGroup = '';
		
			$q = "
			Select a.online_status as status, a.id, 
			a.IP, 
			a.terminal_ID, 
			a.TID, 
			g.name as terminal_owner, 
			a.terminal_name, 
			a.terminal_address, h.tenant as terminal_tenant, a.location_id, 
			b.loc as venue, c.loc as area,  d.loc as city, e.loc as province, f.loc as country, 
			a.product_id, a.video_id, a.group_id, a.trx_code_id,  
			a.googlemapcoordinate,
			a.googlemappinlabel
			From vending_terminal a
			Left join md_terminal_location b on b.id = a.location_id
			Left join md_terminal_location c on c.id = b.parent_id
			Left join md_terminal_location d on d.id = c.parent_id
			Left join md_terminal_location e on e.id = d.parent_id
			Left join md_terminal_location f on f.id = e.parent_id 
			Left join md_terminal_owner  g on g.id = a.owner_id  
			Left join md_terminal_tenant h on h.id = a.tenant_id   
			";  
			 
		}
		if($TABLE=='md_terminal_location'){
			$q = "
			Select 
			a.id as id,
			a.loc as Venue, 
			b.loc as Area, 
			c.loc as City, 
			d.loc as Province, 
			e.loc as Country
			
			From md_terminal_location a 
			Left join md_terminal_location b on b.id = a.parent_id 
			Left join md_terminal_location c on c.id = b.parent_id 
			Left join md_terminal_location d on d.id = c.parent_id 
			Left join md_terminal_location e on e.id = d.parent_id  
			where 
			
			a.lineage = 'venue' and 
			b.lineage = 'area' and 
			c.lineage = 'city' and 
			d.lineage = 'province' and 
			e.lineage = 'country' 
			
			"; 
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
		$strSortBy = 'Order By '.$sort.' '.$order; 
				
		if($TABLE=="vending_terminal"){
			
			if($this->session->userdata('GroupID')>1) $where = " a.group_id = '".$this->session->userdata('GroupID')."' ";
			
			//echo $this->session->userdata('GroupID');
			
			$strWhere    = ' Where a.status_id='.$status_id.' ';
			
			if(!empty($where)) 
			$strWhere = ' Where a.status_id='.$status_id.' and '.$where;  
			
			//$strGroup = '';
			//if($this->session->userdata('GroupID')>1) $strGroup = '';
			//echo $this->session->userdata('GroupID');
			
			//echo $strWhere;
		}
		if($TABLE=="md_terminal_location"){ 
			$strWhere    = ' and a.status_id='.$status_id;
			if(!empty($where)) 
			$strWhere = ' and a.status_id='.$status_id.' and '.$where;  
		} 
		if($TABLE=="pd_product_price"&&!empty($where)){ 
			$strProductID = str_replace("where-"," and ",str_replace("--","=",$where));
			$strProductID = str_replace(" "," ",$strProductID); 
			if(preg_match("/product_id=0/i",$strProductID)) $strProductID = '';  
			$strWhere = ' Where status_id='.$status_id.' '. $strProductID  ;  
		}
 
		$strQ = $this->getQueryTable($TABLE);
		if(!empty($strQ)) $qstr = $this->getQueryTable($TABLE); 
		else $qstr = 'select * from '.$TABLE ; 
		
		$q = $qstr.' '.$strWhere.' '.$strSortBy.' limit '.$start.','.$limit ; 
 
		return $this->db->query($q);
	}
	function countTable($TABLE,$status_id=1){ 
 
   		if($TABLE=='md_terminal_location') $strwhere = " and lineage = 'venue' "; else $strwhere = ""; 
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
	
	function getTableWhere($tbl='',$key='',$val=0,$status_id=1,$orderby='',$result_key='') { 
 
		if(empty($orderby)) $order = "order by id desc";
		else				$order = "order by `".$orderby."` asc";
		
		
		if($tbl=='menu_table'||$tbl=='menu_table') $key_status_id = "StatusID"; else $key_status_id = "status_id";
		
		$strwhere = "where";
		//if(!empty($status_id)||!empty($val)) $strwhere .= " where";
		
		if(!empty($status_id)) 	$strwhere .= " and `".$key_status_id."` = '".$status_id."'";  
		
		if( ($tbl=='menu_table' && !empty($key)) || ($tbl!='menu_table' && !empty($val)) ) 
		
		$strwhere .= " and `".$key."` = '".$val."'";  
		$strwhere = str_replace("where and","where",$strwhere);
		if(str_replace(" ","",$strwhere)=="where") $strwhere=''; 
		
		
		
		$q = "select * from `".$tbl."` ".$strwhere." ".$order." ";
 		// echo $q;
  
		$gData = $this->db->query($q);
		$row = $gData->result_array();
		 
 		if($gData->num_rows()){
			if(!empty($result_key)) return $row[0][$result_key]; 
			else return $row; 
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
	
	/*
	function selectLog($start=0,$limit=10,$status_id=1,$sort="ID",$order="desc",$tbl="trx"){
  
		$strSortBy    = '';
		if(!empty($sort) && !empty($order) ) 
		$strSortBy = 'Order By '.$sort.' '.$order;

		$q = 'select * from `'.$tbl.'` '.$strSortBy.' limit '.$start.','.$limit ;

  		//echo $q; //exit;
		return $this->db->query($q);
	}
	*/ 
	function selectLog($start=0,$limit=10,$status_id=1,$sort="ID",$order="desc",$tbl="trx"){
  
		$strSortBy    = '';
		if(!empty($sort) && !empty($order) ){ 
			$strSortBy = 'Order By '.$sort.' '.$order; 
			if($tbl=="trx"){
				if($sort=="dt"||$sort=="tm") $sort = "date";  
				$strSortBy = 'Order By '.$sort.' '.$order; 
			} 
		} 
		if($tbl=="trx") 
			$q = 'select *, CONCAT(dt,\' \',tm) as date from `'.$tbl.'` '.$strSortBy.' limit '.$start.','.$limit ;
		else
			$q = 'select * from `'.$tbl.'` '.$strSortBy.' limit '.$start.','.$limit ;
  		//echo $q; exit;
		
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
	
	function selectUser($start=0,$limit=10,$status_id=1,$sort="ID",$order="desc"){
  
		$strStatusID = 'StatusID='.$status_id.'';  
		if($status_id==0) $strStatusID = '';  
		else 			 $strStatusID = ' and '.$strStatusID;   
		  
		$strSortBy    = '';
		if(!empty($sort) && !empty($order) ) 
		$strSortBy = 'Order By '.$sort.' '.$order;
		 
		if($this->session->userdata('GroupID')==1) $strGroup = '' ; //--- as Group Lunari
		else $strGroup = ' and GroupID = '.$this->session->userdata('GroupID');
		 
		$q = 'select * from user_table Where ( ID != 1 and ID != 2 '.$strGroup.') '.$strStatusID.' '.$strSortBy.' limit '.$start.','.$limit ;
		
  		// echo $q; 
		 
		 
		return $this->db->query($q);
	}
	function countUser($status_id=1){
		return $this->db->query('select count(ID) count from user_table Where ( ID != 1 and ID != 2 ) and StatusID='.$status_id);
	}
	function getUserById($id){
		return $this->db->query("select * from user_table where ID = ".$id." Limit  1"); 
	}	
	function getMenu($ParentID=0){ 
		return $this->db->query("Select * from menu_table Where StatusID = 1 and ParentID = ".$ParentID." Order By LineAge asc");  
	}
	
	function getMenuAllByParent($ParentID=0){ 
		return $this->db->query("Select * from menu_table Where ParentID = ".$ParentID." Order By LineAge asc");  
	}
	function editStatusIDUser($status_id,$id){
		return $this->db->query("update user_table set StatusID=".$status_id." Where ID=".$id);
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
	
	
	
	
	
	
	
	
	
	
	
	
	/*
	
	 
	 
	 
	function getSectionNavi($id) {
		$getSec = $this->allmodel->getSectionByID($id);  
		if(empty($getSec['ParentID'])){ 
			$urlChild = $this->allmodel->linkPathSection($getSec['SectionID']) ; 
			$sName = $this->allmodel->getSectionName($getSec['SectionID']); 
			$lblSection0 = '<a href="'.$this->allmodel->valPath($urlChild).'">'.$sName.'</a>';  
			$lblSection1 = '';
		}else{
			$getSec2 = $this->allmodel->getSectionName($getSec['ParentID']); 
			$lblSection0 = '<a href="/'.$this->allmodel->valPath($getSec2).'">'.$getSec2.'</a>';  
			$urlChild = $this->allmodel->linkPathSection($getSec['SectionID']) ; 
			$sName = $this->allmodel->getSectionName($getSec['SectionID']);  
			$lblSection1 = ' / <a href="'.$this->allmodel->valPath($urlChild).'">'.$sName.'</a>';  
		} 
		return $lblSection0.$lblSection1;
	} 

	function getUserNamebyID($id) {
		$return = '';
		$gData = $this->db->query("select FullName from usertable Where ID = '".$id."' Limit 1" );
		$row = $gData->row_array();
 		if($gData->num_rows()) $return = $row['FullName'];
		return $return; 
	} 
	function getParentByNewsID($newsid) {
		$SectionID = 0;
		$q = $this->db->query("select SectionID from newstable where ID = ".$newsid." limit 1 "); 
		if($q->num_rows()){
			$row = $q->row_array();
			$SectionID = $row['SectionID'] ; 
		} 
		$getParent = $this->getParentName($SectionID); 
		return array($getParent['ID'],$getParent['Name']); 
	} 
	function getParentName($sectionid) {
		$q = $this->db->query("select ID,Name from sectiontable a 
			where (a.ID = ".$sectionid." AND a.ParentID = 0) OR ( a.ID in (select ParentID from sectiontable where ID = ".$sectionid.") )
			limit 1 "); 
		return $q->row_array();
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
 
	function valPath($str=""){ 
		$str = str_replace(" ","_",$str);
		$str = str_replace("-","_",$str);
		$str = str_replace("&","n",$str);
		return strtolower($str); 
	} 
	*/
  
	//--------------------------------------------
	      
}
?>