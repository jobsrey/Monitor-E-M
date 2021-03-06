<?php  
//session_start(); 
//error_reporting(E_ALL ^ E_NOTICE);
 
class Master_data extends Controller { 
	function Master_data(){   
		parent::Controller(); 
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		$this->load->library('allfunc'); 
		$this->load->library('funcdbindex');  
		$this->load->database(); 
		$this->load->library('session'); 
		if(!$this->session->userdata('logged_in')) redirect('login','refresh');
		  
	} 
	function index(){ 
 		echo "Hello U"; 
	} 
	
	function mainvars($ci_func='',$status_id=1,$limit=10){  
	
		$_ci_func	= $ci_func;
		$_status_id	= $status_id;
		$_limit		= $limit;
		
		$data = $this->allfunc->reflector(__CLASS__,$ci_func); 
 
		$data['navMenu']   	= $this->allfunc->navMenu(2);  
		$data['ci_menu'] 	= $this->allfunc->navMenu(2,1);
		$data['ci_ctrl'] 	= strtolower(__CLASS__);  
     	$data['ci_func']	= $_ci_func; 
		$data['TABLE'] 		= "md_".$_ci_func;   
		$strTable 			= ucwords(str_replace("_"," ",$data['TABLE'])); 
		
     	$data['status_id'] 	= $_status_id;  
     	$data['limit'] 		= $_limit;  
		
     	$data['pageTITLE']	= ucwords(str_replace("_"," ",$data['ci_ctrl'].' - '.str_replace("Md ","",$strTable)));  
     	$data['pageLABEL'] 	= ucwords(str_replace("_"," ",$data['ci_menu'].' > '.str_replace("Md ","",$strTable)));  
 
		return $data;
		  
		//echo __CLASS__;  
		//echo __FUNCTION__; 	exit;
		//echo __METHOD__; 		exit; //Dealer_terminal::mainvars

	} 
	
	function respons_code		($curpage=1,$limit=10,$status_id=1,$sort="id",$order="asc",$ci_ctrl=__CLASS__,$ci_changePage="changepage",$result_id="dspdata"){  
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit); 
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;  
		$data = $this->indexpage($data); 
	}  
	function transaction_code	($curpage=1,$limit=10,$status_id=1,$sort="id",$order="asc",$ci_ctrl=__CLASS__,$ci_changePage="changepage",$result_id="dspdata"){  
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit);
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;  
		$data = $this->indexpage($data);  
	} 
	function transaction_type	($curpage=1,$limit=10,$status_id=1,$sort="id",$order="asc",$ci_ctrl=__CLASS__,$ci_changePage="changepage",$result_id="dspdata"){  
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit);
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;  
		$data = $this->indexpage($data); 
	}
  
	function terminal_owner		($curpage=1,$limit=10,$status_id=1,$sort="id",$order="asc",$ci_ctrl=__CLASS__,$ci_changePage="changepage",$result_id="dspdata"){  
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit);
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;  
		$data = $this->indexpage($data); 
	}
	function terminal_tenant     ($curpage=1,$limit=10,$status_id=1,$sort="id",$order="asc",$ci_ctrl=__CLASS__,$ci_changePage="changepage",$result_id="dspdata"){  
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit);
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;  
		$data = $this->indexpage($data); 
	} 
	function terminal_location($curpage=1,$limit=10,$status_id=1,$sort="id",$order="asc",$ci_ctrl=__CLASS__,$ci_changePage="changepage",$result_id="dspdata"){   
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit); 
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;   
		$data = $this->indexpage($data); 
	} 
	function delivery_methods	($curpage=1,$limit=10,$status_id=1,$sort="id",$order="asc",$ci_ctrl=__CLASS__,$ci_changePage="changepage",$result_id="dspdata"){  
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit);
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;  
		$data = $this->indexpage($data); 
	}
	function card_vendor			($curpage=1,$limit=10,$status_id=1,$sort="id",$order="asc",$ci_ctrl=__CLASS__,$ci_changePage="changepage",$result_id="dspdata"){  
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit);
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;  
		$data = $this->indexpage($data); 
	}  
 
	//--- index page 
	function indexpage($data=array()){  
		$data['ci_ctrl'] = strtolower($data['ci_ctrl']);  
		$data['indexData']  = $this->funcdbindex->indexDataTable($data['ci_ctrl'],$data['ci_func'],$data['TABLE'],$data['curpage'],$data['limit'],$data['status_id'],$data['sort'],$data['order'],$data['ci_changePage'],$data['result_id']); 
		$this->load->view('index/table_data_view',$data);
	}  
	function changepage($curpage,$limit,$status_id,$sort,$order,$ci_changePage,$result_id,$ci_ctrl,$ci_func,$TABLE){  
		$ci_ctrl = strtolower($ci_ctrl); 
		$data['data'] = $this->funcdbindex->indexDataTable($ci_ctrl,$ci_func,$TABLE,$curpage,$limit,$status_id,$sort,$order,$ci_changePage,$result_id); 
		$this->load->view('data_view',$data);
	} 
 
	//--- edit data 
	function edit_data($id,$ci_func,$is_ajax=0,$is_pop=0){  
 
		$data 				= $this->mainvars($ci_func);   
		$strTable 			= ucwords(str_replace("_"," ",$ci_func)); 
 
	 	$mode = "Edit";
		if(empty($id))$mode = "Add New"; 
     	$data['pageLABEL'] 	= $data['pageLABEL']." > $mode Data";   
 
		$data['id'] 		= $id; 
		$data['tablemod']  	= $mode; 
		$data['tablelbl']  	= $strTable; 
		$data['is_ajax']  	= $is_ajax; 
		$data['is_pop']  	= 0;//$is_pop; 
		//echo $data['TABLE']; exit; 
 
		//--get data db -> for non ($data['TABLE']=="md_terminal_locationx"
		if($data['id']){
			$gData = $this->allmodel->getTableByID($data['TABLE'],$data['id']);
			 
			if(!empty($gData))
			foreach($gData as $key => $val){ //echo "<br>$key => $val";
			 	$data[$key] = $val;
				/*
				id => 13
				loc => Gd. Kompas Gramedia
				parent_id => 12
				lineage =>
				link =>
				status_id => 1
				*/
			}
			
		} 
 
		if($data['TABLE']=="md_terminal_location"){  
			$data['callfunc'] = __FUNCTION__;  
			/*
			id => 13
			loc => Gd. Kompas Gramedia
			parent_id => 12
			*/
			$tbl 				= $data['TABLE'];
			$cur_item_id   		= $data['id'];
			$cur_item_parent_id = $data['parent_id'];
			$cur_item_loc_id 	= $data['loc'];
			
			//-- get parent loop to top
 
			$arr_id = $arr_parent = $arr_loc = array(); 
			
			if($cur_item_id){ 
				if(empty($cur_item_parent_id)){ 
					array_unshift($arr_id,$cur_item_id);
					array_unshift($arr_loc,$cur_item_loc_id);
					array_unshift($arr_parent,$cur_item_parent_id); 
				}else{ 
					$getloc = $this->allmodel->getLocationByID($tbl,$cur_item_parent_id);  
					$up1_id 	   = $getloc['id']; 
					$up1_parent_id = $getloc['parent_id']; 
					$up1_loc_name  = $getloc['loc']; 
					if($up1_id){ 
						array_unshift($arr_id,$up1_id);  
						array_unshift($arr_parent,$up1_parent_id);  
						array_unshift($arr_loc,$up1_loc_name);
					}  
					if($up1_parent_id){
						$getloc = $this->allmodel->getLocationByID($tbl,$up1_parent_id); 
						$up2_id 	   = $getloc['id']; 
						$up2_parent_id = $getloc['parent_id'];  
						$up2_loc_name  = $getloc['loc']; 
						if($up2_id){
							array_unshift($arr_id,$up2_id); 
							array_unshift($arr_parent,$up2_parent_id); 
							array_unshift($arr_loc,$up2_loc_name); 
						} 					
						if($up2_parent_id){
							$getloc = $this->allmodel->getLocationByID($tbl,$up2_parent_id); 
							$up3_id 	   = $getloc['id']; 
							$up3_parent_id = $getloc['parent_id'];  
							$up3_loc_name  = $getloc['loc'];   
							if($up3_id){
								array_unshift($arr_id,$up3_id); 
								array_unshift($arr_parent,$up3_parent_id); 
								array_unshift($arr_loc,$up3_loc_name); 
							}
							if($up3_parent_id){
								$getloc = $this->allmodel->getLocationByID($tbl,$up3_parent_id); 
								$up4_id 	   = $getloc['id']; 
								$up4_parent_id = $getloc['parent_id'];  
								$up4_loc_name  = $getloc['loc'];   
								if($up4_id){
									array_unshift($arr_id,$up4_id); 
									array_unshift($arr_parent,$up4_parent_id); 
									array_unshift($arr_loc,$up4_loc_name); 
								} 
							} 
						}  
					} 
					array_push($arr_id,$cur_item_id);
					array_push($arr_loc,$cur_item_loc_id);
					array_push($arr_parent,$cur_item_parent_id); 
				}
				/*
				foreach($arr_loc as $k => $v) echo "$k => $v<br>";  
				if(count($arr_parent)==5) echo "is_venu<br>"; 
				if(count($arr_parent)==4) echo "is_area<br>"; 
				if(count($arr_parent)==3) echo "is_city<br>"; 
				if(count($arr_parent)==2) echo "is_prov<br>";
				if(count($arr_parent)==1) echo "is_coun<br>";
				if(count($arr_parent)==0) echo "is_add_new<br>";
				*/
				
				$data['coun_idx'] = $data['prov_idx'] = $data['city_idx'] = $data['area_idx'] = $data['venu_idx'] = ''; 
				
				$have_venu = $have_area = $have_city = $have_prov = $have_coun = 0; 
				if(count($arr_parent)==1){ //echo "is_coun<br>"; 
					$have_coun = $have_prov = 1; 
					$arr_parent[1] = $cur_item_id;
					$arr_id[1] = 0;  
				}
				elseif(count($arr_parent)==2){ //echo "is_prov<br>"; 
					$have_coun = $have_prov = $have_city = 1;
					$arr_parent[2] = $cur_item_id;
					$arr_id[2] = 0; 
				}
				elseif(count($arr_parent)==3){ //echo "is_city<br>"; 
					$have_coun = $have_prov = $have_city = $have_area = 1; 
					$arr_parent[3] = $cur_item_id;
					$arr_id[3] = 0; 
				}
				elseif(count($arr_parent)==4){ //echo "is_area<br>"; 
					$have_coun = $have_prov = $have_city = $have_area = $have_venu = 1;  
					$arr_parent[4] = $cur_item_id;
					$arr_id[4] = 0;  
				}
				elseif(count($arr_parent)==5){ //echo "is_venu<br>"; 
					$have_coun = $have_prov = $have_city = $have_area = $have_venu = 1; 
				}  
				if($have_coun) $data['coun_idx'] = $this->getlist_locat(0,$data,$arr_parent[0],$arr_id[0]);
				if($have_prov) $data['prov_idx'] = $this->getlist_locat(1,$data,$arr_parent[1],$arr_id[1]);  
				if($have_city) $data['city_idx'] = $this->getlist_locat(2,$data,$arr_parent[2],$arr_id[2]);
				if($have_area) $data['area_idx'] = $this->getlist_locat(3,$data,$arr_parent[3],$arr_id[3]); 
				if($have_venu) $data['venu_idx'] = $this->getlist_locat(4,$data,$arr_parent[4],$arr_id[4]);
			}else{
				$data['coun_idx'] = $this->getlist_locat(0,$data,0,0);
			} 
			if($is_ajax){    
	 
				if($is_ajax==1){
					if($cur_item_id) $data['prov_idx'] = $this->getlist_locat(1,$data,$cur_item_id,0); 
					else $data['prov_idx'] = '';
					echo $data['prov_idx'];	
					echo '<script>'; 
					echo ' document.getElementById("listloc2").innerHTML = ""; ';
					echo ' document.getElementById("listloc3").innerHTML = ""; ';
					echo ' document.getElementById("listloc4").innerHTML = ""; ';
					echo '</script>'; 
				}
				if($is_ajax==2){
					if($cur_item_id) $data['city_idx'] = $this->getlist_locat(2,$data,$cur_item_id,0);  
					else $data['city_idx'] = '';
					echo $data['city_idx'];	
					echo '<script>';  
					echo ' document.getElementById("listloc3").innerHTML = ""; ';
					echo ' document.getElementById("listloc4").innerHTML = ""; ';
					echo '</script>'; 
				}
				if($is_ajax==3){
					if($cur_item_id) $data['area_idx'] = $this->getlist_locat(3,$data,$cur_item_id,0);  
					else $data['area_idx'] = '';
					echo $data['area_idx'];	  
					echo '<script>';   
					echo ' document.getElementById("listloc4").innerHTML = ""; ';
					echo '</script>'; 
				}
				if($is_ajax==4){
					if($cur_item_id) $data['venu_idx'] = $this->getlist_locat(4,$data,$cur_item_id,0);  
					else $data['venu_idx'] = '';
					echo $data['venu_idx'];	 
				} 
				exit;	
			}
				
 
		} //-- end : if($data['TABLE']=="md_terminal_location") 
		else 
		$data['editFormTable']	 = $this->funcdbindex->editFormTable($data);
		
		//foreach($data as $key => $val) echo "<br>$key => $val"; exit; 
		//error_reporting(E_ALL); 
		//error_reporting(E_ALL ^ E_NOTICE);
		
		$this->load->view('index/edit_data_view',$data);   
	} 
 
	
	
	
	function getlist_locat($iCurMenu,$array,$parentid,$selectid){
 
		$table = $array['TABLE'];
		$where_key = 'parent_id';
		$where_val = $parentid;
		$status_id = 1;
		$key_show  = 'loc';
		 
		$dlist = $this->allmodel->getTableWhere($table,$where_key,$where_val,$status_id,$key_show); 
 		//foreach($dlist as $k => $v) foreach($v as $k2 => $v2) echo "<br>$k => $k2 => $v2";  exit;
 
 		$ci_ctrl  	= $array['ci_ctrl'];
 		$callfunc 	= $array['callfunc'];
		$id			= $array['id'];
 		$ci_func	= $array['ci_func'];
 
 		if($iCurMenu==0){ $selectname = "coun_id"; $is_ajax	= 1; $resultid = "listloc1"; }
 		if($iCurMenu==1){ $selectname = "prov_id"; $is_ajax	= 2; $resultid = "listloc2"; }
 		if($iCurMenu==2){ $selectname = "city_id"; $is_ajax	= 3; $resultid = "listloc3"; }
 		if($iCurMenu==3){ $selectname = "area_id"; $is_ajax	= 4; $resultid = "listloc4"; }
 		if($iCurMenu==4){ $selectname = "venu_id"; $is_ajax	= 5; $resultid = ""; } 
 		
		$res .= '
			<div style="float:left" >';
		$res .= '<select name="'.$selectname.'" id="'.$selectname.'"  onchange="loadcontent(\''.base_url().$ci_ctrl.'/'.
		$callfunc.'/\'+$(\'select#'.$selectname.'\').val()+\'/'.$ci_func.'/'.$is_ajax.'\',\''.$resultid.'\')">';
 
 		$x=0;   
		foreach($dlist as $kkk => $row){   
			$strselected = '';
  			if($selectid==$row['id']) $strselected = 'selected="selected"'; 
			if(!$x)
			$res .= '  	<option value="0" '.$strselected.'></option>'; 
			$res .= '	<option value="'.$row['id'].'" '.$strselected.' >'.$row['loc'].'</option>';
			$x++;
		} 
		$res .= '</select>'; 
		$res .= '</div>';
        $res .= '<div style="float:right" > &nbsp; &nbsp; ';
		$res .= '&nbsp; <input onclick="popupwindow(\'/'.$ci_ctrl.'/locat_edit/add/'.$selectname.'/'.$parentid.'/'.$selectid.'\',\'Add Location\',240,185)" type="button" name="add_'.$selectname.'" id="add_'.$selectname.'" value="add" style="font:normal 10px arial"/>';
		$res .= '&nbsp; <input onclick="popupwindow(\'/'.$ci_ctrl.'/locat_edit/del/'.$row['id'].'/'.$parentid.'/\'+$(\'select#'.$selectname.'\').val(),\'Del Location\',240,185)" type="button" name="del_'.$selectname.'" id="del_'.$selectname.'" value="del" style="font:normal 10px arial"/>';
		$res .= '&nbsp; <input onclick="popupwindow(\'/'.$ci_ctrl.'/locat_edit/ren/'.$row['id'].'/'.$parentid.'/\'+$(\'select#'.$selectname.'\').val(),\'Rename Location\',240,185)" type="button" name="ren_'.$selectname.'" id="ren_'.$selectname.'" value="rename" style="font:normal 10px arial"/>';
		if($parentid)
		$res .= '&nbsp; <input onclick="popupwindow(\'/'.$ci_ctrl.'/locat_edit/chgpar/'.$row['id'].'/'.$parentid.'/\'+$(\'select#'.$selectname.'\').val(),\'Change Parent Location\',240,185)" type="button" name="chgpar_'.$selectname.'" id="chgpar_'.$selectname.'" value="Change Parent" style="font:normal 10px arial"/>';
		$res .= '</div>';

		return $res; 
	} 
	
	
	function locat_edit($type='',$selectname='',$parentid='',$selectid=-1){
		//echo " selectname = $selectname<br>";
		//echo " parentid  = $parentid<br>";  
		$error_pop = 0;
		if($_POST){ 
			//foreach($_POST as $k => $v) echo "<br>$k => $v"; exit;
			$data['isPOST'] = 1;
			//foreach($_POST as $k => $v) echo "<br>$k => $v";
			/*parent_id => 5
			add_location => keca
			Submit => Add 
			
			parent_id => 4
			del_location => 7
			Submit => Delete
			
			*/ 
			if($_POST['Submit']=="Add"){ 
				$data['strPop'] = $_POST['Submit'];    
				
				if($_POST['selectname']=='coun_id') $lineage = 'country'; 
				elseif($_POST['selectname']=='prov_id') $lineage = 'province'; 
				elseif($_POST['selectname']=='city_id') $lineage = 'city';
				elseif($_POST['selectname']=='area_id') $lineage = 'area';
				elseif($_POST['selectname']=='venu_id') $lineage = 'venue'; 
				else $lineage = ''; 
				
				if(!empty($_POST['add_location'])){ 
					
					$q = "INSERT INTO `md_terminal_location` (
						`id` , `loc` , `parent_id` , `lineage` , `link` , `status_id`
						) VALUES ( 
						NULL , '".$_POST['add_location']."', '".$_POST['parent_id']."' , '".$lineage."', '', '1' )";						 
					$this->db->query($q); 
 
					$data['editID'] = mysql_insert_id();
				} else {
					$data['editID'] = 'error_add';
				}
			} 
			if($_POST['Submit']=="Delete"){							
				$getloc = $this->allmodel->getLocationByID('md_terminal_location',$_POST['del_location']); 
				$parent_id = $getloc['parent_id']; 
				$data['parent_id']   = $parent_id;
			
				$q = "delete from md_terminal_location where id = ".$_POST['del_location'];								 
				$this->db->query($q);  
				$data['strPop'] = $_POST['Submit'];  
				$data['editID'] = 'del_done'; 
				 
			}
			 
			if($_POST['Submit']=="Rename"){					
				//foreach($_POST as $k => $v) echo "<br>$k => $v"; exit;
				//parent_id => 2
				//ren_id => 5
				//ren_location => Jakarta Pusat
				//Submit => Rename 
				$data['id'] = $_POST['ren_id']; 
				$q = "update md_terminal_location set `loc` = '".$_POST['ren_location']."' where id = ".$_POST['ren_id'];								 
				$this->db->query($q);  
				$data['strPop'] = $_POST['Submit'];  
				$data['editID'] = 'ren_done';  
			}
			 
			if($_POST['Submit']=="Change Parent"){					
				//foreach($_POST as $k => $v) echo "<br>$k => $v"; exit;
				//parent_id => 12
				//chgpar_id => 13
				//chgpar_location => 14
				//Submit => Change Parent
				$data['id'] = $_POST['chgpar_id']; 
				$q = "update md_terminal_location set `parent_id` = '".$_POST['chgpar_location']."' where id = ".$_POST['chgpar_id'];								 
				$this->db->query($q);  
				$data['strPop'] = $_POST['Submit'];  
				$data['editID'] = 'chgpar_done';  
			} 
			
		}else{
		
			if($type=='add'){
				$data['strPop'] 	 = "Add";
				$getloc = $this->allmodel->getLocationByID('md_terminal_location',$parentid); 
				$parent_name = $getloc['loc']; 
									
				if($selectname=="coun_id") $strloc = "Country/Negara";
				if($selectname=="prov_id") $strloc = "Province/Propinsi";
				if($selectname=="city_id") $strloc = "City/Kota/Kabupaten";
				if($selectname=="area_id") $strloc = "Area/Kecamatan";
				if($selectname=="venu_id") $strloc = "Venue/Spot/Gedung/Mall";
				
				$data['strloc']	     = $strloc;
				$data['parent_id']   = $parentid;
				$data['parent_name'] = $parent_name;
				$data['selectname']  = $selectname;
				
			} 
			if($type=='del'){
				$data['strPop'] 	 = "Delete";
				$data['selectid'] 	 = $selectid;
	 
				$getloc = $this->allmodel->getLocationByID('md_terminal_location',$parentid); 
				$parent_name = $getloc['loc']; 
				$data['parent_id']   = $parentid;
				$data['parent_name'] = $parent_name;
						
				//-- check if have child 
				if($selectid!=-1){ 
					
					if($selectid){
						
						$getloc = $this->allmodel->getLocationByID('md_terminal_location',$selectid); 
						$loc_name = $getloc['loc'];
				
						$getchild = $this->allmodel->getChildByID('md_terminal_location',$selectid);  
						//echo count($getchild);
						
						if(count($getchild)==0){
							//-- go del
							$del_id =  $selectid;	
							$data['del_id']   = $del_id;
							$data['loc_name']  = $loc_name; 
						}else{
							$data['$pageTITLE'] = "Error";
							$data['data'] = '<div style="display:block;padding:30px 0;color:red;font-size:18px;" align="center">error...<br> only item have no child can be delete</div>';
							$error_pop = 1; 
						} 
					}else{
						$data['$pageTITLE'] = "Error";
						$data['data'] = '<div style="display:block;padding:30px 0;color:red;font-size:18px;" align="center">error...<br> first empty data can\'t be delete</div>';
						$error_pop = 1;
					}
				
				}else{ 
					$data['$pageTITLE'] = "Error";
					$data['data'] = '<div style="display:block;padding:30px 0;color:red;font-size:18px;" align="center">error...<br> empty data can\'t be delete</div>';
					$error_pop = 1; 
				} 
			 
			}
			if($type=='ren'){
				$data['strPop'] 	 = "Rename";
				$data['selectid'] 	 = $selectid; 
				$getloc = $this->allmodel->getLocationByID('md_terminal_location',$parentid);  
				$parent_name = $getloc['loc']; 
				$data['parent_id']   = $parentid;
				$data['parent_name'] = $parent_name; 
				//-- check if have child 
				if($selectid!=-1){ 
					if($selectid){ 
						$getloc = $this->allmodel->getLocationByID('md_terminal_location',$selectid); 
						$loc_name = $getloc['loc']; 
						//-- go rename
						$ren_id 			= $selectid;	
						$data['ren_id']     = $ren_id;
						$data['loc_name']   = $loc_name; 
						 
					}else{
						$data['$pageTITLE'] = "Error";
						$data['data'] = '<div style="display:block;padding:30px 0;color:red;font-size:18px;" align="center">error...<br> first empty data can\'t be rename</div>';
						$error_pop = 1;
					} 
				}else{ 
					$data['$pageTITLE'] = "Error";
					$data['data'] = '<div style="display:block;padding:30px 0;color:red;font-size:18px;" align="center">error...<br> empty data can\'t be rename</div>';
					$error_pop = 1; 
				} 
			 
			}
			if($type=='chgpar'){
				$data['strPop'] 	 = "Change Parent";
				$data['selectid'] 	 = $selectid; 
				$getloc = $this->allmodel->getLocationByID('md_terminal_location',$parentid);  
				$parent_name = $getloc['loc']; 
				$data['parent_id']   = $parentid;
				$data['parent_name'] = $parent_name; 
				//-- check if have child 
				if($selectid!=-1){ 
					if($selectid){ 
						$getloc = $this->allmodel->getLocationByID('md_terminal_location',$selectid); 
						$loc_name = $getloc['loc']; 
						//-- go chgpar
						$chgpar_id 			= $selectid;	
						$data['chgpar_id']  = $chgpar_id;
						$data['loc_name']   = '';// array locations 
						
						$data['cur_cat']    = $this->funcdbindex->listmenu2table('md_terminal_location',1,2,$selectid);
						$data['locData']    = $this->funcdbindex->listmenu2table('md_terminal_location');
  
					}else{
						$data['$pageTITLE'] = "Error";
						$data['data'] = '<div style="display:block;padding:30px 0;color:red;font-size:18px;" align="center">error...<br> first empty data can\'t be edit</div>';
						$error_pop = 1;
					} 
				}else{ 
					$data['$pageTITLE'] = "Error";
					$data['data'] = '<div style="display:block;padding:30px 0;color:red;font-size:18px;" align="center">error...<br> empty data can\'t be edit</div>';
					$error_pop = 1; 
				} 
			 
			}
		
		}
		if($error_pop) 
		$this->load->view('pop_data',$data); 
		else
		$this->load->view('pop_edit_loc',$data);  
		
	} 
 
	//------------------------------------------------------------------------------------------------------------------------------------------
	function qedit(){ 
 
		//foreach($_POST as $k => $v) echo "<br>$k => $v";  exit; 
 		
		//-- delete items
		if(isset($_POST['bdel'])) if($_POST['bdel']=="DELETE"){		 
			$q = "UPDATE `".$_POST['TABLE']."` SET `status_id` = 0 WHERE `id` = '".$_POST['id']."' LIMIT 1"; 
			$this->db->query($q);
			//--create log
			$this->allfunc->createLog('user',$this->session->userdata('ID'),strtolower(__CLASS__),$_POST['TABLE'].' - DEL id: '.$_POST['id']);
		    redirect('/'.strtolower(__CLASS__).'/'.$_POST['ci_func'].'/','refresh');  
			exit;
		}
		 /* 
			TABLE => md_terminal_owner
			ci_func => owner
			id => 1
			name => Bank Mandiri Tbk.
			description => Divisi Penjualan Prepaid111 
		 	button => Submit  
		 	button => ACTIVATE 
		 	bdel => DELETE

		 */ 
		 			
		$qstr1 = $qstr2 = $qstr3 = ''; 
		foreach($_POST as $k => $v){ //echo "<br>$k => $v"; 
				$$k = $v; 
				if(  
					//( $TABLE=="authorize_dealer" && $k!="TABLE" && $k!="ci_func" && $k!="button" && $k!="status_id" && $v!="Submit" ) 
					//||
					//( $TABLE=="vending_terminal" && $k!="TABLE" && $k!="ci_func" && $k!="button" && $k!="status_id" && $v!="Submit" )  
					//||
					($k!="TABLE" && $k!="ci_func" && $k!="button" && $k!="status_id" && $v!="Submit")
				){ 
					$qstr1 .= "`".$k."`,";  
					if($k=="id") 
					$qstr2 .= "'',";
					else
					$qstr2 .= "'".$v."',";  
					
					if($k!="id")
					$qstr3 .= "`".$k."` = '".$v."',";  
				} 
		}
		
		if(empty($id)){ //-- add new data 
			$qstr1 = substr($qstr1,0,strlen($qstr1)-1);
			$qstr2 = substr($qstr2,0,strlen($qstr2)-1); 
			$q = "INSERT INTO `".$TABLE."` (".$qstr1.")VALUES(".$qstr2.")";
			$this->db->query($q); 
			$cid = mysql_insert_id();  
			
			//--create log
			$this->allfunc->createLog('user',$this->session->userdata('ID'),strtolower(__CLASS__),$_POST['TABLE'].' - ADD id : '.$cid);
			
		 }else{ //-- edit data
			$qstr3 = substr($qstr3,0,strlen($qstr3)-1); 
			
			$stractive = '';
			if($_POST['button']=="ACTIVATE") $stractive = ', `status_id`=1 ';
			
			$q = "UPDATE `".$TABLE."` SET ". $qstr3.$stractive. " WHERE `id` = ".$id." LIMIT 1"; 
		 		
			$this->db->query($q); 
			 
			$cid = $id; 
 
			//--create log
			$this->allfunc->createLog('user',$this->session->userdata('ID'),strtolower(__CLASS__),$_POST['TABLE'].' - UPDATE id: '.$_POST['id']); 
		} 
		redirect('/'.strtolower(__CLASS__).'/edit_data/'.$cid.'/'.$ci_func.'/','refresh');
 
	}
	//------------------------------------------------------------------------------------------------------------------------------------------ 
}
