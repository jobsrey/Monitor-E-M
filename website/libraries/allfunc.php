<?php 
 if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Allfunc extends Allmodel{ 

  	function Allfunc(){    
    	parent::Allmodel();     
  	} 
  	function readimg($img){
    	return base_url().$img;
  	}  
 	function reflector($class,$func){ 
		$reflector = new ReflectionClass($class);
		$parameters = $reflector->getMethod($func)->getParameters();
		$dataArr1 = array(); 
		foreach($parameters as $parameter ) 
		$dataArr1[$parameter->name] = $parameter->getDefaultValue(); 
		return $dataArr1; 
	} 
 	function isAdmin($mode=0,$disabled=' disabled="disabled" '){  
		if( $this->session->userdata('ID')==1 ) 	 $disabled = '';
		if( $this->session->userdata('ID')==2 ) 	 $disabled = ''; 
		if( $this->session->userdata('AccessType')=='admin' && $this->session->userdata('GroupID')==1) $disabled = ''; 
		if(empty($disabled)) $return = 1; else $return = 0; 
		if($mode==1) return $return; else return $disabled;
	}
 	function isAdminGroup($mode=0,$disabled=' disabled="disabled" '){   
		if( $this->session->userdata('AccessType')=='admin') $disabled = '';
		if(empty($disabled)) $return = 1; else $return = 0; 
		if($mode==1) return $return; else return $disabled;
	}
	 

	function listmenuarray2($array=array(),$datalist,$str_onchange=''){ 
	
		foreach($array as $k => $v) $$k = $v;  //echo "<br>$k => $v"; exit; //
		 
 
 		//echo ' < -- select name="'.$select_name_id.'" id="'.$select_name_id.'" '.$str_onchange.' >'; 
 
 		$return = '<select name="'.$select_name_id.'" id="'.$select_name_id.'" '.$str_onchange.' >';
 		$x=0;  
		foreach($datalist as $row){   //foreach($row as $k => $v) echo "<br>$k => $v";  
		
			//echo $row['suplier_db']."<br>";
			
			if($row[$slc_key]==$selected) $strselected = 'selected="selected"'; 
			else $strselected = '';
			if(!$x)
			$return .= '<option value="'.$first_item_val.'" '.$strselected.' >'.$first_item_text.'</option>'; 
			$return .= '<option value="'.$row[$slc_key].'"  '.$strselected.' >'.$row[$show_key_name].'</option>';
			$x++;
		} 
		$return .= '</select>';
		return   $return; 
		
	}


 		
	function listmenuarray($ci_ctrl='',$callfunc='',$array1=array(),$array2=array()){ 
 		//$table='';$rowname='name';$status_id=1;$selected=0;$where_key='';$where_val=0;$listname='id';$result_id='listdata';$firstitem='all'; 
		$paramval = array('table'=>'','rowname'=>'name','status_id'=>1,'selected'=>0,'where_key'=>'','where_val'=>0,'selectname'=>'id','result_id'=>'listdata','firstitem'=>'');

		foreach($paramval as $k => $v){
			$strKey1 = $k."1";
			$strKey2 = $k."2";
			//if(empty($v))  $v = "'0'"; 
			$$strKey  = $v;
			$$strKey1 = $v;  
			$$strKey2 = $v;  
			//echo "<br>$strKey1 => $v";
			//echo "<br>$strKey2 => $v";
		}   
 		foreach($array1 as $k => $v){
			$strKey = $k."1"; 
			if(empty($v)) $v = "'0'";
			$$strKey = $v;
			//echo "<br>$strKey => $v";
		} 		
		foreach($array2 as $k => $v){
			$strKey = $k."2";
			if(empty($v)) $v = "'0'";
			$$strKey = $v;  
			//echo "<br>$strKey => $v";
		}   

		//-- using same table as table1
		if(empty($table2)) $table2 = $table1;
		if($table1 =="md_terminal_location"){

			$where_key1 = 'parent_id';
			$where_val1 = '0';  
		} 
		
		//====temp!!!
		$selected2 = str_replace("'0'","0",$selected2);
		if(empty($result_id1)) $result_id1 = 0;
		if(empty($where_key2)) $where_key2 = 0;  
 
		
		$dlist = $this->allmodel->getTableWhere($table1,$where_key1,$where_val1,$status_id1); 
 		//foreach($dlist as $k => $v) foreach($v as $k2 => $v2) echo "<br>$k => $k2 => $v2"; exit;
 
		//echo  '---select name="'.$selectname1.'" id="'.$selectname1.'"  onchange="loadcontent(\''.base_url().$ci_ctrl.'/'.$callfunc.'/'.$table2.'/'.$rowname2.'/'.$status_id2.'/'.$selected2.'/'.$where_key2.'/\'+$(\'select#'.$selectname1.'\').val()+\'/'.$selectname2.'/'.$result_id2.'/'.$firstitem1.'\',\''.$result_id2.'\')">';
 
 		$res .= '<select name="'.$selectname1.'" id="'.$selectname1.'"  onchange="loadcontent(\''.base_url().$ci_ctrl.'/'.$callfunc.'/'.$table2.'/'.$rowname2.'/'.$status_id2.'/'.$selected2.'/'.$where_key2.'/\'+$(\'select#'.$selectname1.'\').val()+\'/'.$selectname2.'/'.$result_id2.'/'.$firstitem1.'\',\''.$result_id2.'\')">';
 
 		$x=0; 
		//if(count($dlist)){  
			foreach($dlist as $kkk => $row){ //echo "<br>$kkk => $row"; 
				$strselected = '';
  				if($selected1==$row['id']) $strselected = 'selected="selected"';
				
				if(!$x)
				$res .= '  	<option value="0" '.$strselected.'>'.$firstitem1.'</option>'; 
 
				$res .= '	<option value="'.$row['id'].'" '.$strselected.' >'.$row[$rowname1].'</option>';
				$x++;
			}    
		//}		
		//else  
		//$res .= '  <option value="" selected="selected">none</option>';		
		 
		$res .= '</select>';
		return   $res; 
		
	}
 

	function listFormData($tbl='md_terminal_owner',$list_id='owner_id',$key_value='id',$key_list='name',$order='asc',$where=''){

		$qDataLoc=$this->allmodel->selectIndexTable(0,1000,1,$key_list,$order,$tbl,$where);   
		if($qDataLoc->num_rows()){ 
			$result .= '<select name="'.$list_id.'" id="'.$list_id.'">';
			$x=0;
			foreach($qDataLoc->result_array() as $row) {
				$selected = '';
				if($row[$key_value]==$$list_id) $selected = 'selected="selected"';  
				if(!$x)
				$result .= '<option value="0" '.$selected.' >none</option>'; 
				else
				$result .= '<option value="'.$row[$key_value].'" '.$selected.' >'.$row[$key_list].'</option>'; 
				$x++;
			}
			$result .= '</select>';
		}
	} 
	 
	function listmenucalljs($table='',$keyname='',$status_id=1,$selected=0,$where_key='',$where_val=0,$selectname='id',$result_id='listdata',$firstitem=''){

		$dlist = $this->allmodel->getTableWhere($table,$where_key,$where_val,$status_id);
		//foreach($dlist as $k => $v) foreach($v as $k2 => $v2) echo "<br>$k => $k2 => $v2"; exit; 
		
		//echo '< select name="'.$selectname.'" id="'.$selectname.'" onchange="getvalue(\''.$result_id.'\',$(\'select#'.$selectname.'\').val())" >';  
		
		$res .= '<select name="'.$selectname.'" id="'.$selectname.'" 
		onchange="getvalue(\''.$result_id.'\',$(\'select#'.$selectname.'\').val())">';   
		$x=0;  
		foreach($dlist as $k => $row){ 
				$strselected = '';
  				if($selected==$row['id']) $strselected = 'selected="selected"'; 
				if(!$x)
				$res .= '  	<option value="0" '.$strselected.'>'.$firstitem.'</option>';  
				$res .= '	<option value="'.$row['id'].'" '.$strselected.' >'.$row[$keyname].'</option>';
				$x++;
		}  
		$res .= '</select>';
		return  $res; 
	}
	function listmenu($table='',$rowname='',$status_id=1,$selected=0,$where_key='',$where_val=0,$listname='id',$result_id='listdata',$firstitem='all',$strOnchange=''){
 
		$dlist = $this->allmodel->getTableWhere($table,$where_key,$where_val,$status_id);
		//foreach($dlist as $k => $v) foreach($v as $k2 => $v2) echo "<br>$k => $k2 => $v2"; exit; 
 
		//echo ' < select name="'.$listname.'" id="'.$listname.'"  '.$strOnchange.'  >';
		 
		
		$res .= '<select name="'.$listname.'" id="'.$listname.'" '.$strOnchange.' '.$this->isAdmin().' >';   
 		$x=0;  
			foreach($dlist as $k => $row){ 
				
				$strselected = '';
  				if($selected==$row['id']) $strselected = 'selected="selected"'; 
 
				if(!$x)
				$res .= '  	<option value="0" '.$strselected.'>'.$firstitem.'</option>'; 
 
				$res .= '	<option value="'.$row['id'].'" '.$strselected.' >'.$row[$rowname].'</option>';
				$x++;
			}     	 
		
		$res .= '</select>';
		return  $res; 
	}
 
   	function createLog($type='',$par1='',$par2='',$par3='',$par4='',$par5='',$par6='',$par7='',$par8='',$par9='',$par10=''){
	
		$arrValue = array($par1,$par2,$par3,$par4,$par5,$par6,$par7,$par8,$par9,$par10);
 		
		if($type=='user'){  
			$tbl = 'log_user_action'; 
			$arrKey = array('user_id','activity','description');
			$arrVal = array();
			foreach($arrKey as $k => $key) 
				array_push($arrVal,$arrValue[$k]); 
			$sqlKey = "`".implode("`,`",$arrKey)."`";
			$sqlVal = "'".implode("','",$arrVal)."'"; 
			$q = "INSERT INTO `".$tbl."` (`ID`,`datetime`,".$sqlKey.") VALUES ('', NOW(), ".$sqlVal.")";						 
			$this->db->query($q);  
		}		 
	
	} 
 	function showmenu($chkid,$arrMenu){ 
		$arrMenuID = explode(",",$arrMenu); 
		$res = 0; 
		foreach($arrMenuID as $k => $v) if($v==$chkid) $res = 1;
		
		if($this->session->userdata('Username')=='admin'||$this->session->userdata('Username')=='su') $res = 1;
		
		return $res; 
	}
	function navMenu($slcid=-1,$mode=0){
		
		//$arrMenuID = explode(",",$this->session->userdata('AccessID'));
		
		//foreach($arrMenuID as $key => $value) echo "<br>$key => $value";
		
		
		$q = "Select * from menu_table Where StatusID = 1 and ParentID = 0 Order By id asc"; 
		$curMenu = $content = '';
		$qdata = $this->db->query($q);  
		if($qdata->num_rows()){
			$content = "
			<div id='cssmenu'>
				<ul>";
 			
			foreach($qdata->result_array() as $row){  
			
			if( $this->showmenu($row['ID'],$this->session->userdata('AccessID')) ){
					
				$strSlcID1 = "";
				if($slcid==$row['ID']){ 
					$strSlcID1 = ' class="active"';	
					$curMenu = $row['Name']; 
				} 
				$urlPar = $this->valurl($row['Name']);
				$content .= "<li".$strSlcID1."><a href='/".$urlPar."'><span>".$row['Name']."</span></a>"; 
				$q2 = "Select * from menu_table Where StatusID = 1 and ParentID = ".$row['ID']." Order By lineage asc"; 	  
				$qdata2 = $this->db->query($q2);  
				if($qdata2->num_rows()){
					$strSlcID2 = "";
					if($slcid==$row['ID']) $strSlcID2 = ' style="display:block"';
					$content .= "<ul".$strSlcID2.">"; 
					foreach($qdata2->result_array() as $row2){   
						if( $this->showmenu($row2['ID'],$this->session->userdata('AccessID')) ){
							$urlSub = $this->valurl($row2['Name']);
							$content .= "<li><a href='/".$urlPar."/".$urlSub."'><span>".$row2['Name']."</span></a></li>"; 
						}
					 }
					$content .= "</ul>";    
				}	 
				 
				$content .= "</li>"; 
			}
			}
			$content .= "
				</ul>
			</div>";
			
			if($mode==0) return $content;
			if($mode==1) return $curMenu;
			
		} 
	} 
	
	 
	
	
	function valurl($str){
		$str = str_replace("/","",$str);
		$str = str_replace("&","",$str);
		$str = str_replace("+","",$str);
		$str = str_replace("-","",$str);
		$str = str_replace(" ","_",$str);
		$str = str_replace("__","_",$str);
		$str = strtolower($str);
		return $str;
	}
	
	
	
	
	// --------------------------------------------------------------------
	function sendresponse($ip,$vm,$response)  { 
	    $query_vm 	= $vm;
        $address 	= $ip; 
        $port 		= 555;
        $socket 	= socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
        $message 	= $response;
 
        try {
            socket_connect($socket, $address, $port);

            $status = socket_sendto($socket, $message, strlen($message), 0, $address, $port);

            if ($status != false)  {
                //return true;
                socket_recvfrom($socket, $buf, 22, 0, $address, $port); //22
				return $buf;
            } 
            return false;
        } catch (Exception $e)  {
            return false;
        } 
    }
	function sendping($ip,$vm,$response)  { 
	    $query_vm 	= $vm;
        
		$address 	= $ip; 
        $port 		= 555;//server_port();
		
        $socket 	= socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
        $message 	= $response;
		
		//getVendingTerminal
		
 		error_reporting(0); 
		//error_reporting(E_ALL);
		try {
            socket_connect($socket, $address, $port);

            $status = socket_sendto($socket, $message, strlen($message), 0, $address, $port); 
            if ($status != false)  {
                //return true;
                socket_recvfrom($socket, $buf, 38, 0, $address, $port); //22
				return $buf;
            } 
            return false;
        } catch (Exception $e)  {
            return false;
        } 
		

		//Report all errors
		error_reporting(E_ALL);
    }
	function getLogs(){
 		$x=1;  
		$q = "Select * from request_table Order By datetime desc"; 
		$query = $this->db->query($q); 
		$result = ''; 
		foreach($query->result_array() as $row){  
			$clr = '#eee'; 
			if(fmod($x,2)) $clr = '#bbb';  
			$result .= ' 
		 <tr bgcolor="'.$clr.'">
          <td align="right" ><span sty="style8">'.$x.'.</span></td>
          <td nowrap="nowrap" bgcolor="'.$clr.'"><span class="style8">'.$row['datetime'].'</span></td>
          <td class="style8">'.$row['id'].'</td>
          <td nowrap="nowrap"><span class="style8">'.$row['ip'].'</span></td>
          <td nowrap="nowrap"><span class="style8">'.$row['vm'].'</span></td>
          <td nowrap="nowrap"><span class="style8">'.$row['type'].'</span></td>
          <td nowrap="nowrap"><span class="style8">'.$row['txid'].'</span></td>
          <td nowrap="nowrap"><span class="style8"><a href="#">'.$row['msg'].'</a> </span></td>
          <td><span class="style8">'.$row['response_status'].'</span></td>
          <td nowrap="nowrap" bgcolor="'.$clr.'"><span class="style8">'.$row['string_request'].'</span></td>
        </tr> 
			';
		 	$x++;
		 } 
   		return $result;  
	}  


 
	
}
