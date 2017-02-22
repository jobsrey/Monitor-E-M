<?php 
 if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Funcuser extends Allmodel{ 

  	function Funcuser(){    
    	parent::Allmodel();     
  	} 
	
	function chkFinanceAccess($userID=''){ 
		$financeMenuAccessID='44'; //== id menu Member Paid
		$return = 0;
		$q = "Select AccessID From user_table Where ID = '".$userID."' Limit 1";
		$qdata = $this->db->query($q);
		$return = '';
		if($qdata->num_rows()){  
			$row = $qdata->result_array(); 
			$strAccessID = $row[0]['AccessID']; 
		} 
		$arrAccessID = explode(",",$strAccessID);
		foreach ($arrAccessID as $key => $value){
			//echo "<br>$key => $value";
			if($value==$financeMenuAccessID) $return = 1;
		} 
		return $return;
	}
	
	function mainMenuAccess($grpAccessID='',$userAccessID=''){ 

		$arrayMenu = array();
		$qdata = $this->allmodel->getTableWhere('menu_table','ParentID','0',1,'LineAge'); 
		//getTableWhere($tbl='',$key='',$val=0,$status_id=1,$orderby='')
		$x=0;
		 
		foreach($qdata as $row){   
			$arrayMenu[$x]['ID']   = $row['ID'];
			$arrayMenu[$x]['Name'] = $row['Name'];
			$arrayMenu[$x]['Sub'] = 0;
			$qdatasub = $this->allmodel->getTableWhere('menu_table','ParentID',$row['ID'],1,'LineAge');  
			$x++;
			foreach($qdatasub as $row2){ 
			 
				$arrayMenu[$x]['ID']   = $row2['ID'];
				$arrayMenu[$x]['Name'] = $row2['Name']; 
				$arrayMenu[$x]['Sub'] = 1;
				$x++;
			}
		}
		
		$content = ''; 
		$checked1 = $checked2 = ''; 
 
		$arrGrpAccess = explode(",",$grpAccessID);
		$arrUsrAccess = explode(",",$userAccessID); 
		
		$x=0;
		foreach($arrayMenu as $key => $row){ 
			foreach($arrGrpAccess as $kkk => $grpAccess)  
			if($row['ID']==$grpAccess){
				    
				//echo "<br>$key => ".$row['ID']." => ".$row['Name']." => ".$row['Sub'];
 
				//-- checked 
				$checked1 = '';
				$checked2 = 'checked';
				foreach($arrUsrAccess as $k => $accss)  
				if($row['ID']==$accss){  
					$checked1 = 'checked'; $checked2 = ''; 
				}
				   
				if(fmod($x,2)) $strClr = '#efefef';
				else  $strClr = '#ffffff'; 
				
				if($row['Sub']) { 
					$strSub = " &nbsp; - "; 
					$strtPar = $row['Name']; 
				}else{
					$strSub = "";
					$strtPar = "<strong>".$row['Name']."</strong>"; 
				}
				
				$strDisable = ' disabled="disabled" ';
				if($this->allfunc->isAdmin(1)) $strDisable = '';
				if($this->allfunc->isAdminGroup(1)) $strDisable = '';
				 
				 
				
				$content .= '
					<tr bgcolor="'.$strClr.'">
					
					  <td>'.$strSub.$strtPar.'</td>
					  
					  <td width="100%">
						<input id="Prev-'.$row['ID'].'" name="Prev-'.$row['ID'].'" type="radio" value="'.$row['ID'].'" '.$checked1.$strDisable.'> Grand &nbsp; 
						<input id="Prev-'.$row['ID'].'" name="Prev-'.$row['ID'].'" type="radio" value="0" '.$checked2.$strDisable.'> No &nbsp;
					  </td>
					  
					</tr>'; 
				
				$x++;	
			}
			 
		}  
		return $content .= '';
 
	}
	
	function mainMenuAccessGrp($userAccessID){ 

		$arrayMenu = array();
		$qdata = $this->allmodel->getTableWhere('menu_table','ParentID','0',0,'LineAge'); 
		//getTableWhere($tbl='',$key='',$val=0,$status_id=1,$orderby='')
		
		$x=0;
		 
		foreach($qdata as $row){   
			$arrayMenu[$x]['ID']   = $row['ID'];
			$arrayMenu[$x]['Name'] = $row['Name'];
			$arrayMenu[$x]['ParentID'] = $row['ParentID'];
			$qdatasub = $this->allmodel->getTableWhere('menu_table','ParentID',$row['ID'],1,'LineAge');  
			$x++;
			foreach($qdatasub as $row2){ 
			 
				$arrayMenu[$x]['ID']   = $row2['ID'];
				$arrayMenu[$x]['Name'] = $row2['Name']; 
				$arrayMenu[$x]['ParentID'] = $row['ID'];
				$x++;
			}
		}
		
		$content = ''; 
		$checked1 = $checked2 = ''; 
 		
		$arrAccess = array();
		if(!empty($userAccessID)) $arrAccess = explode(",",$userAccessID); 
 
		$x=0;
		foreach($arrayMenu as $key => $row){     
			
			//-- checked 
			$checked1 = '';
			$checked2 = 'checked';
 
			if($this->allfunc->isAdmin(1)){
				
				//echo "<br>$key => ".$row['ID']." => ".$row['Name']." => ".$row['ParentID']; 
				
				//-- checked 
				$checked1 = '';
				$checked2 = 'checked';
				foreach($arrAccess as $k => $value){ 
					if($row['ID']==$value){ 
						$checked1 = 'checked';
						$checked2 = '';
					}
					if(empty($row['ParentID'])) {  
						$strSub = "";
						$strtPar = "<b>".$row['Name']."</b>";
					}elseif($row['ParentID']){
						$strSub = " &nbsp; - "; 
						$strtPar = $row['Name'];  
					} 
				}  
				if(fmod($x,2)) $strClr = '#efefef';
				else  $strClr = '#ffffff'; 
				
				$content .= '
				<tr bgcolor="'.$strClr.'">
				  <td nowrap="nowrap">'.$strSub.$strtPar.'</td>
				  <td nowrap="nowrap">
				  	<input id="Prev-'.$row['ID'].'" name="Prev-'.$row['ID'].'" type="radio" value="'.$row['ID'].'" '.$checked1.$disabled.'> Yes &nbsp; 
					<input id="Prev-'.$row['ID'].'" name="Prev-'.$row['ID'].'" type="radio" value="0" '.$checked2.$disabled.'> No &nbsp;
				</td>
				</tr>'; 
				$x++;
				
				
				
			}else{
			
				//-- if as Group admin :
				foreach($arrAccess as $k => $accss)  
				if($row['ID']==$accss){ 
					//echo "<br>$key => ".$row['ID']." => ".$row['Name']." => ".$row['ParentID'];  
					if(fmod($x,2)) $strClr = '#efefef';
					else  $strClr = '#ffffff'; 
	 
					if(empty($row['ParentID'])) { 
						$arrLastParent=$row['ID'];  
						$strSub = "";
						$strtPar = $row['Name'];
						$strIco = '<img src="/asset/icons/status_on.png" width="16" height="16" />Yes';  
					}elseif($row['ParentID']){
						$strSub = " &nbsp; - "; 
						$strtPar = $row['Name']; 
						$strIco = '<img src="/asset/icons/status_on.png" width="16" height="16" />Yes';
					} 
					$content .= '
					<tr bgcolor="'.$strClr.'"> 
					  <td>'.$strSub.$strtPar.'</td> 
					  <td>'.$strIco.'</td> 
					</tr>';  
					$x++; 
				}
				
			}
			
			
			 
		}  
		return $content .= '';
 
	}
	
	function accessUserByGroup($GroupID,$UserAcces){ 
 

		//echo $GroupID."---".$UserAcces; exit;
 
		$arrayMenu = array();
		$qdata = $this->allmodel->getTableWhere('menu_table','ParentID','0',0,'LineAge'); 
		//getTableWhere($tbl='',$key='',$val=0,$status_id=1,$orderby='')
		
		
 
		
		$x=0;
		 
		foreach($qdata as $row){  

			$arrayMenu[$x]['ID']   = $row['ID'];
			$arrayMenu[$x]['Name'] = $row['Name'];
			$arrayMenu[$x]['ParentID'] = $row['ParentID'];
			$qdatasub = $this->allmodel->getTableWhere('menu_table','ParentID',$row['ID'],1,'LineAge');  
			$x++;

			foreach($qdatasub as $row2){  
				$arrayMenu[$x]['ID']   = $row2['ID'];
				$arrayMenu[$x]['Name'] = $row2['Name']; 
				$arrayMenu[$x]['ParentID'] = $row['ID'];
				$x++;
			}
		}
		
		//foreach($arrayMenu as $key => $row)  
		//foreach($row as $key2 => $val) if($key2=="Name") 
		//echo "<br>$key => $key2 => $val"; exit;
 
		
		$content = $checked1 = $checked2 = ''; 
 
		$rowgrpaccess = $this->allmodel->getTableByID('user_group_table',$GroupID); 
		
		$strgrpaccess = $rowgrpaccess['group_access_id']; 
		
		//foreach($rowgrpaccess as $key => $row)   
		//echo "<br>$key => $key2 => $row"; 
		//exit;
		
		
		
		
		
		$arrAccess = array();
		if(!empty($strgrpaccess)) $arrAccess = explode(",",$strgrpaccess); 
		
		$arrUsrAccess = array();
		if(!empty($UserAcces)) $arrUsrAccess = explode(",",$UserAcces); 	
 

 		 
		
		//foreach($arrAccess as $key => $val)   echo "<br>$key =>  $val"; exit;
		
		
		
		$x=0;
		foreach($arrayMenu as $key => $row) {  
		
		 	$showAccess = 0;
			foreach($arrAccess as $k => $v){  
				if($row['ID']==$v) {
					//echo "<br>$x => $k => $v";
					$showAccess = 1;	
				}	
				if($row['ID']==10){ //---- GROUP ID 
 					//--- group setting only for admin HQ 
					//echo $rowGrp = $this->allmodel->getGroupbyID($GroupID,0);  
				
					if($GroupID=='1') $showAccess = 1;
					else $showAccess = 0;
				
				}
				if($row['ID']==9){ //---- User
 					//--- group setting only for admin HQ 
					//echo $rowGrp = $this->allmodel->getGroupbyID($GroupID,0);  
				
					if($GroupID=='1') $showAccess = 1;
					else $showAccess = 0;
				
				}
				if($row['ID']==1){ //---- menu manage user
 					//--- group setting only for admin HQ 
					//echo $rowGrp = $this->allmodel->getGroupbyID($GroupID,0);  
				
					if($GroupID=='1') $showAccess = 1;
					else $showAccess = 0;
				
				}
				if($this->session->userdata('ID')==1 || $this->session->userdata('ID')==2) $showAccess = 1;
				
			} 
			if($showAccess){ 
 
				//echo "<br>$key => ".$row['ID']." => ".$row['Name']." => ".$row['ParentID']; 
	  
				//-- checked 
				$checked1 = '';
				$checked2 = 'checked';
				foreach($arrUsrAccess as $k => $value){  
					if($row['ID']==$value){ 
						//echo "<br> $k => $value";
						$checked1 = 'checked';
						$checked2 = '';
					} 
				}  
				 
				if(fmod($x,2)) $strClr = '#efefef';
				else  $strClr = '#ffffff'; 
				if(empty($row['ParentID'])) {  
					$strSub = "";
					$strtPar = "<b>".$row['Name']."</b>";
				}elseif($row['ParentID']){
					$strSub = " &nbsp; - "; 
					$strtPar = $row['Name'];  
				}  
				
				if($strtPar=="Member Paid") 			$mval = " &nbsp; ----- &nbsp; <span class=\"red\">*konfirmasi pembayaran member status => PAID<span>"; 
				elseif($strtPar=="Merchant Validation") $mval = " &nbsp; ----- &nbsp; <span class=\"red\">*mengaktifkan merchant status => VALID<span>"; 
				else $mval = "";
				
				$content .= '
					<tr bgcolor="'.$strClr.'">
					  <td nowrap="nowrap">'.$strSub.$strtPar.'</td>
					  <td nowrap="nowrap">
						<input id="Prev-'.$row['ID'].'" name="Prev-'.$row['ID'].'" type="radio" value="'.$row['ID'].'" '.$checked1.$disabled.'> Yes &nbsp; 
						<input id="Prev-'.$row['ID'].'N" name="Prev-'.$row['ID'].'" type="radio" value="0" '.$checked2.$disabled.'> No &nbsp;
						'.$mval.'
					</td> 
					</tr>'; 
	 			
				$x++; 	 
			}
		} 
		 
		return $content .= '';
 
	}
 
	function mainMenuTablexxxx($ID,$userAccessID){ 
		$content = ''; 
		$qdata = $this->allmodel->getMenu(0);
		if($qdata->num_rows()){
			$content = ''; 
			$checked1 = $checked2 = $disabled = ' '; 
			
			if($this->session->userdata('ID')!=1 && $this->session->userdata('ID')!=2 && $this->session->userdata('AccessType')!='admin') $disabled = 'disabled';  
			$arrAccess = explode(",",$userAccessID); 
			$x=0;
			foreach($qdata->result_array() as $row){  
				//-- checked 
				$checked1 = '';
				$checked2 = 'checked';
				foreach($arrAccess as $k => $value){ 
					if($row['ID']==$value){ 
						$checked1 = 'checked';
						$checked2 = '';
					}
				}  
				if(fmod($x,2)) $strClr = '#efefef';
				else  $strClr = '#ffffff'; 
				
				$content .= '
				<tr bgcolor="'.$strClr.'">
				  <td>'.$row['Name'].'</td>
				  <td width="100%">
				  	<input id="Prev-'.$row['ID'].'" name="Prev-'.$row['ID'].'" type="radio" value="'.$row['ID'].'" '.$checked1.$disabled.'> Grand &nbsp; 
					<input id="Prev-'.$row['ID'].'" name="Prev-'.$row['ID'].'" type="radio" value="0" '.$checked2.$disabled.'> No &nbsp;
				</td>
				</tr>'; 
				$x++;
			}
			return $content .= '';
		} 
	}
	
}
