<?php 
 if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Funcuser extends Allmodel{ 

  	function Funcuser(){    
    	parent::Allmodel();     
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
						<input name="Prev-'.$row['ID'].'" type="radio" value="'.$row['ID'].'" '.$checked1.$strDisable.'> Grand &nbsp; 
						<input name="Prev-'.$row['ID'].'" type="radio" value="0" '.$checked2.$strDisable.'> No &nbsp;
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
				  	<input name="Prev-'.$row['ID'].'" type="radio" value="'.$row['ID'].'" '.$checked1.$disabled.'> Yes &nbsp; 
					<input name="Prev-'.$row['ID'].'" type="radio" value="0" '.$checked2.$disabled.'> No &nbsp;
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
		
		$content = $checked1 = $checked2 = ''; 
 
		$rowgrpaccess = $this->allmodel->getTableByID('user_group_table',$GroupID); 
		$strgrpaccess = $rowgrpaccess['group_access_id']; 
		
		$arrAccess = array();
		if(!empty($strgrpaccess)) $arrAccess = explode(",",$strgrpaccess); 
		
		$arrUsrAccess = array();
		if(!empty($UserAcces)) $arrUsrAccess = explode(",",$UserAcces); 	
 
		$x=0;
		foreach($arrayMenu as $key => $row)
		if($arrAccess[$key]){ 
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
			$content .= '
				<tr bgcolor="'.$strClr.'">
				  <td nowrap="nowrap">'.$strSub.$strtPar.'</td>
				  <td nowrap="nowrap">
				  	<input name="Prev-'.$row['ID'].'" type="radio" value="'.$row['ID'].'" '.$checked1.$disabled.'> Yes &nbsp; 
					<input name="Prev-'.$row['ID'].'" type="radio" value="0" '.$checked2.$disabled.'> No &nbsp;
				</td>
				</tr>'; 
			$x++; 	 
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
				  	<input name="Prev-'.$row['ID'].'" type="radio" value="'.$row['ID'].'" '.$checked1.$disabled.'> Grand &nbsp; 
					<input name="Prev-'.$row['ID'].'" type="radio" value="0" '.$checked2.$disabled.'> No &nbsp;
				</td>
				</tr>'; 
				$x++;
			}
			return $content .= '';
		} 
	}
	
}
