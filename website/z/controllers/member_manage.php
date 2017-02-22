<?php  
//session_start();  
class Member_manage extends Controller { 
	function Member_manage(){   
		parent::Controller(); 
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		$this->load->library('allfunc');  
		$this->load->library('funcdbindex'); 
		$this->load->database(); 
		$this->load->library('session'); 
		//if(!$this->session->userdata('logged_in')) re_direct('login','refresh');
		if(!$this->session->userdata('logged_in')) 
		echo '<meta http-equiv="Refresh" content="0;URL=/login" />' ; 
		  
	} 
	function index(){  
 		//if(!$this->admindb->haveAccessPanel($this->session->userdata('GroupID'),7)){
			//re_direct('warning/alert/2');
		//}
 		echo "Hello U"; 
	}  
	
	function mainvars($ci_func='',$status_id=1,$limit=10){  
	
		$_ci_func	= $ci_func;
		$_status_id	= $status_id;
		$_limit		= $limit;
		
		$data = $this->allfunc->reflector(__CLASS__,$ci_func); 
 
		$data['navMenu']   	= $this->allfunc->navMenu(3);  
		$data['ci_menu'] 	= $this->allfunc->navMenu(3,1);
		$data['ci_ctrl'] 	= strtolower(__CLASS__);  
     	$data['ci_func']	= $_ci_func; 
		$data['TABLE'] 		= "user_group_table";   
		$strTable 			= ucwords(str_replace("_"," ",$data['TABLE'])); 
		
     	$data['status_id'] 	= $_status_id;  
     	$data['limit'] 		= $_limit;  
		
     	$data['pageTITLE']	= ucwords(str_replace("_"," ",$data['ci_ctrl'].' - '.str_replace("table","",$strTable)));  
     	$data['pageLABEL'] 	= ucwords(str_replace("_"," ",$data['ci_menu'].' > '.str_replace("table","",$strTable)));  
 
		return $data; 

	} 

	//--- index page 
	function indexpage($data=array()){  
		$data['ci_ctrl'] = strtolower($data['ci_ctrl']);  
		$data['indexData']  = $this->funcdbindex->indexDataTable($data['ci_ctrl'],$data['ci_func'],$data['TABLE'],$data['curpage'],$data['limit'],$data['status_id'],$data['sort'],$data['order'],$data['ci_changePage'],$data['result_id']); 
		$this->load->view('index/table_data_view',$data);
	}
	  
	function changepagegrp($curpage,$limit,$status_id,$sort,$order,$ci_changePage,$result_id,$ci_ctrl,$ci_func,$TABLE){  
		$ci_ctrl = strtolower($ci_ctrl); 
		$data['data'] = $this->funcdbindex->indexDataTable($ci_ctrl,$ci_func,$TABLE,$curpage,$limit,$status_id,$sort,$order,$ci_changePage,$result_id); 
		$this->load->view('data_view',$data);
	} 
 
	function member_group ($curpage=1,$limit=10,$status_id=1,$sort="id",$order="asc",$ci_ctrl=__CLASS__,$ci_changePage="changepagegrp",$result_id="dspdata"){  
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit); 
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;  
		$data = $this->indexpage($data); 
	} 

	//-------------------------------------------------------------------------------------------------------------------
	
	function member_edit_paid($ID,$curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_changePage,$result_id){  
	
		$strAccount = "member";
      	$data['pageTITLE'] 	= ucfirst($strAccount).' Management > '.ucfirst($strAccount).' Payment Confirmation'; 
     	$data['pageLABEL'] 	= ucfirst($strAccount).' Management > '.ucfirst($strAccount).' Payment Confirmation';
		$data['navMenu']   	= $this->allfunc->navMenu(3); 
		
		
		$data['ID'] 		= $ID; 
		
		if(empty($ID)) 
     	$data['pageLABEL'] 	= ucfirst($strAccount).' Management > Add '.ucfirst($strAccount).' '; 
		  
		$qData 				= $this->allmodel->getUserById($ID,'member_table');  
		
		$data['row'] 		= $qData->row_array();
		foreach($qData->row_array() as $key => $val) $$key = $val; 
		
		//$this->allmodel->editStatusMemberPAID('PAID',$member_id,'member_table');
 
 
		$data['rowgrp'] 	= $this->allmodel->getTableWhere('user_group_table');  
 
		//--create log
		//$this->allfunc->createLog('member',$this->session->userdata('ID'),'member paid', 'member_id: '.$member_id);
				 
 
		//$data['data']=$this->indexDatapaid($curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_changePage,$result_id);
		//$this->load->view('data_view',$data);
		 $this->load->view('member/member_edit_paid',$data); 
		
	}
	
	
	
	function edit_product($ID=0,$is_pop=1,$num=0){
		$data['ID'] = $ID;	
 		//$this->load->view('merchant/merchant_edit_product_pop',$data);  
		$n = $num+1;
		echo '<table> 
				<tr>
                <td>
				<input name="HobbyID['.$n.']" type="checkbox" id="HobbyID['.$n.']" value="1" /> 
				<input name="HobbyIDNew['.$n.']" type="text" id="HobbyIDNew['.$n.']" size="12" autocomplete="off" /></td>
                <td></td>
              </tr> 
			</table>  
            <div id="add_hobby_'.$n.'"> 
              <table width="100%" border="0" cellpadding="3" cellspacing="0">
                <tr>
                  <td width="20"></td>
                  <td colspan="7"><input class="bt_formreg" onclick="member_add_hobby('.$n.',\'add_hobby_'.$n.'\')" name="add_hobby" id="add_hobby" value="add" type="button" />                   </td>
                </tr>
              </table>   
            </div>
		';
		
	}
	
	function edit_product2($ID=0,$is_pop=1,$num=0){
		$data['ID'] = $ID;	
 		//$this->load->view('merchant/merchant_edit_product_pop',$data);  
		$n = $num+1;
		echo '<table> 
				<tr>
                <td>
				<input name="RubricFavoriteID['.$n.']" type="checkbox" id="RubricFavoriteID['.$n.']" value="1" /> 
				<input name="RubricFavoriteIDNew['.$n.']" type="text" id="RubricFavoriteIDNew['.$n.']" size="12" autocomplete="off" /></td>
              </tr> 
			</table>  
            <div id="add_rubric_favorite_'.$n.'"> 
              <table width="100%" border="0" cellpadding="3" cellspacing="0">
                <tr>
                  <td width="20"></td>
                  <td colspan="7"><input class="bt_formreg" onclick="member_add_rubric_favorite('.$n.',\'add_rubric_favorite_'.$n.'\')" name="add_rubric_favorite" id="add_rubric_favorite" value="add" type="button" /></td>
                </tr>
              </table>   
            </div>
		';
		
	}

	
	
	
	
	
	function member_edit_validation($ID,$edit=0,$error=0,$is_ajax=0,$ajax_parentid=0,$cur_menu=0,$slcmenuid=0){  
 
   		//echo $ajax_parentid;

		//--- default is login as  
		$strAccount = "member"; $group_id = 0; $is_member = 1; $is_merchant = 0;
		//if($this->session->userdata('is_member')) 	{ $strAccount = "member";   $is_member 	 = 1; } //-- login as MEMBER
		//if($this->session->userdata('is_merchant'))	{ $strAccount = "merchant"; $is_merchant = 1; } //-- login as MERCHANT  

     	$data['pageTITLE'] 	= ucfirst($strAccount).' Management > '.ucfirst($strAccount).' Validation'; 
     	$data['pageLABEL'] 	= ucfirst($strAccount).' Management > '.ucfirst($strAccount).' Validation';
		$data['navMenu']   	= $this->allfunc->navMenu(3); 
		  
		$data['edit'] 		= $edit; 
		$data['ID'] 		= $ID; 
		
		if(empty($ID)) 
     	$data['pageLABEL'] 	= ucfirst($strAccount).' Management > Add '.ucfirst($strAccount).' '; 
		  
		$qData 				= $this->allmodel->getUserById($ID,'member_table');  
		
		$data['row'] 		= $qData->row_array();
		foreach($qData->row_array() as $key => $val) $$key = $val; 
 
 
		$data['isAdmin'] 	= 0;
		if($this->session->userdata('AccessType')=='admin') $data['isAdmin'] = 1;
		
		$data['rowgrp'] 	= $this->allmodel->getTableWhere('user_group_table');  
	  										// getTableWhere($tbl='',$key='',$val=0,$status_id=1,$orderby='',$result_key='') { 
 
		$data['StatusID'] = '';
		if(isset($data['row']['AccessID'])) $data['StatusID'] = $data['row']['StatusID'];
		

		//---------------------------------------------------------------------------------- : location
		
		$data['TABLE'] 		= 'md_location'; 
		$tbl 				= $data['TABLE'];
		$data['ci_ctrl'] 	= 'member_manage';
 		$data['callfunc'] 	= 'member_edit'; 
		
		//---- HOME ADDRESS ------------------- 
		$gData = $this->allmodel->getTableByID($data['TABLE'],$LocationID);
		if(count($gData))
		foreach($gData as $key => $val){   //echo "<br>$key => $val";
			$data[$key] = $val;  
		}
		if($is_ajax=='1'){  
			$data['parent_id'] = $ajax_parentid; 
		}	
		$cur_item_id   		= $data['id'];
		$cur_item_parent_id = $data['parent_id'];
		$cur_item_loc_id 	= $data['loc'];

		//-- get parent loop to top 
		$arr_id = $arr_parent = $arr_loc = array(); 
 
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
		
		//foreach($arr_loc as $k => $v) echo "$k => $v<br>";  
		
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

		if($have_coun) $data['coun_idx'] = $this->getlist_locat_form(0,$data,$arr_parent[0],$arr_id[0],1); 
		if($have_prov) $data['prov_idx'] = $this->getlist_locat_form(1,$data,$arr_parent[1],$arr_id[1],1);  
		if($have_city) $data['city_idx'] = $this->getlist_locat_form(2,$data,$arr_parent[2],$arr_id[2],1);
		if($have_area) $data['area_idx'] = $this->getlist_locat_form(3,$data,$arr_parent[3],$arr_id[3],1); 
		if($have_venu) $data['venu_idx'] = $this->getlist_locat_form(4,$data,$arr_parent[4],$arr_id[4],1);
 
		//-- add  
		if(!$cur_item_id){  
			$data['coun_idx'] = $this->getlist_locat_form(0,$data,$arr_parent[0],0,1); 
			$data['prov_idx'] = '';	
			$data['city_idx'] = '';	
			$data['area_idx'] = '';	
			$data['venu_idx'] = '';	 
		}
		//------------------------------------- 
		
		
		
		//---- WORK ADDRESS ------------------- 
		
		//echo "WorkLocationID = ".$WorkLocationID;  
		
		$gData = $this->allmodel->getTableByID($data['TABLE'],$WorkLocationID);
		if(count($gData))
		foreach($gData as $key => $val){   //echo "<br>$key => $val";
			$data[$key] = $val;  
		}
		if($is_ajax=='2'){  
			$data['parent_id'] = $ajax_parentid; 
		}	
		$cur_item_id   		= $data['id'];
		$cur_item_parent_id = $data['parent_id'];
		$cur_item_loc_id 	= $data['loc'];
		
		
		
		//-- get parent loop to top 
		$arr_id = $arr_parent = $arr_loc = array(); 
 
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
		
		//foreach($arr_loc as $k => $v) echo "$k => $v<br>";  
		
		$data['coun_idx2'] = $data['prov_idx2'] = $data['city_idx2'] = $data['area_idx2'] = $data['venu_idx2'] = ''; 
				
		$have_venu2 = $have_area2 = $have_city2 = $have_prov2 = $have_coun2 = 0; 
				
		if(count($arr_parent)==1){ //echo "is_coun<br>"; 
			$have_coun2 = $have_prov2 = 1; 
			$arr_parent[1] = $cur_item_id;
			$arr_id[1] = 0;  
		}
		elseif(count($arr_parent)==2){ //echo "is_prov<br>"; 
			$have_coun2 = $have_prov2 = $have_city2 = 1;
			$arr_parent[2] = $cur_item_id;
			$arr_id[2] = 0; 
		}
		elseif(count($arr_parent)==3){ //echo "is_city<br>"; 
			$have_coun2 = $have_prov2 = $have_city2 = $have_area2 = 1; 
			$arr_parent[3] = $cur_item_id;
			$arr_id[3] = 0; 
		}
		elseif(count($arr_parent)==4){ //echo "is_area<br>"; 
			$have_coun2 = $have_prov2 = $have_city2 = $have_area2 = $have_venu2 = 1;  
			$arr_parent[4] = $cur_item_id;
			$arr_id[4] = 0;  
		}
		elseif(count($arr_parent)==5){ //echo "is_venu<br>"; 
			$have_coun2 = $have_prov2 = $have_city2 = $have_area2 = $have_venu2 = 1; 
		}  

		if($have_coun2) $data['coun_idx2'] = $this->getlist_locat_form2(0,$data,$arr_parent[0],$arr_id[0],1); 
		if($have_prov2) $data['prov_idx2'] = $this->getlist_locat_form2(1,$data,$arr_parent[1],$arr_id[1],1);  
		if($have_city2) $data['city_idx2'] = $this->getlist_locat_form2(2,$data,$arr_parent[2],$arr_id[2],1);
		if($have_area2) $data['area_idx2'] = $this->getlist_locat_form2(3,$data,$arr_parent[3],$arr_id[3],1); 
		if($have_venu2) $data['venu_idx2'] = $this->getlist_locat_form2(4,$data,$arr_parent[4],$arr_id[4],1);
 
		//-- add  new
		if(!$cur_item_id){  
			$data['coun_idx2'] = $this->getlist_locat_form2(0,$data,$arr_parent[0],0,1); 
			$data['prov_idx2'] = '';	
			$data['city_idx2'] = '';	
			$data['area_idx2'] = '';	
			$data['venu_idx2'] = '';	 
		}
 
		//---------------------------------------------------------------------------------------------		
		
		
		//--- ajax call output
		
		//echo $is_ajax; 
 
		if($cur_menu && $ajax_parentid > -1){
			if($is_ajax=='1') 
			echo $this->getlist_locat_form($cur_menu,$data,$arr_parent[$cur_menu],$arr_id[$cur_menu],1); 
			elseif($is_ajax=='2') 
			echo $this->getlist_locat_form2($cur_menu,$data,$arr_parent[$cur_menu],$arr_id[$cur_menu],1); 
			
		}
 
		
 
		if(empty($is_ajax)) $this->load->view('member/member_edit_validation',$data); 
 
   
	} 
	
	function xxxxmember_edit_validationxxxxx($ID,$edit=0,$error=0,$is_ajax=0,$ajax_parentid=0,$cur_menu=0,$slcmenuid=0){  
 
   		//echo $ajax_parentid;

		//--- default is login as  
		$strAccount = "member"; $group_id = 0; $is_member = 1; $is_merchant = 0;
		//if($this->session->userdata('is_member')) 	{ $strAccount = "member";   $is_member 	 = 1; } //-- login as MEMBER
		//if($this->session->userdata('is_merchant'))	{ $strAccount = "merchant"; $is_merchant = 1; } //-- login as MERCHANT  

     	$data['pageTITLE'] 	= ucfirst($strAccount).' Management > '.ucfirst($strAccount).' Validation'; 
     	$data['pageLABEL'] 	= ucfirst($strAccount).' Management > '.ucfirst($strAccount).' Validation';
		$data['navMenu']   	= $this->allfunc->navMenu(3); 
		  
		$data['edit'] 		= $edit; 
		$data['ID'] 		= $ID; 
		
		if(empty($ID)) 
     	$data['pageLABEL'] 	= ucfirst($strAccount).' Management > Add '.ucfirst($strAccount).' '; 
		  
		$qData 				= $this->allmodel->getUserById($ID,'member_table');  
		
		$data['row'] 		= $qData->row_array();
		foreach($qData->row_array() as $key => $val) $$key = $val; 
		
		


		$data['isAdmin'] 	= 0;
		if($this->session->userdata('AccessType')=='admin') $data['isAdmin'] = 1;
		
		$data['rowgrp'] 	= $this->allmodel->getTableWhere('user_group_table');  
	  										// getTableWhere($tbl='',$key='',$val=0,$status_id=1,$orderby='',$result_key='') { 
 
		$data['StatusID'] = '';
		if(isset($data['row']['AccessID'])) $data['StatusID'] = $data['row']['StatusID'];
		

		//---------------------------------------------------------------------------------- : location
		
		$data['TABLE'] 		= 'md_location'; 
		$tbl 				= $data['TABLE'];
		$data['ci_ctrl'] 	= 'member_manage';
 		$data['callfunc'] 	= 'member_edit'; 
		
		//---- HOME ADDRESS ------------------- 
		$gData = $this->allmodel->getTableByID($data['TABLE'],$LocationID);
		if(count($gData))
		foreach($gData as $key => $val){   //echo "<br>$key => $val";
			$data[$key] = $val;  
		}
		if($is_ajax=='1'){  
			$data['parent_id'] = $ajax_parentid; 
		}	
		$cur_item_id   		= $data['id'];
		$cur_item_parent_id = $data['parent_id'];
		$cur_item_loc_id 	= $data['loc'];

		//-- get parent loop to top 
		$arr_id = $arr_parent = $arr_loc = array(); 
 
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
		
		//foreach($arr_loc as $k => $v) echo "$k => $v<br>";  
		
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

		if($have_coun) $data['coun_idx'] = $this->getlist_locat_form(0,$data,$arr_parent[0],$arr_id[0],1); 
		if($have_prov) $data['prov_idx'] = $this->getlist_locat_form(1,$data,$arr_parent[1],$arr_id[1],1);  
		if($have_city) $data['city_idx'] = $this->getlist_locat_form(2,$data,$arr_parent[2],$arr_id[2],1);
		if($have_area) $data['area_idx'] = $this->getlist_locat_form(3,$data,$arr_parent[3],$arr_id[3],1); 
		if($have_venu) $data['venu_idx'] = $this->getlist_locat_form(4,$data,$arr_parent[4],$arr_id[4],1);
 
		//-- add  
		if(!$cur_item_id){  
			$data['coun_idx'] = $this->getlist_locat_form(0,$data,$arr_parent[0],0,1); 
			$data['prov_idx'] = '';	
			$data['city_idx'] = '';	
			$data['area_idx'] = '';	
			$data['venu_idx'] = '';	 
		}
		//------------------------------------- 
		
		
		
		//---- WORK ADDRESS ------------------- 
		
		//echo "WorkLocationID = ".$WorkLocationID;  
		
		$gData = $this->allmodel->getTableByID($data['TABLE'],$WorkLocationID);
		if(count($gData))
		foreach($gData as $key => $val){   //echo "<br>$key => $val";
			$data[$key] = $val;  
		}
		if($is_ajax=='2'){  
			$data['parent_id'] = $ajax_parentid; 
		}	
		$cur_item_id   		= $data['id'];
		$cur_item_parent_id = $data['parent_id'];
		$cur_item_loc_id 	= $data['loc'];
		
		
		
		//-- get parent loop to top 
		$arr_id = $arr_parent = $arr_loc = array(); 
 
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
		
		//foreach($arr_loc as $k => $v) echo "$k => $v<br>";  
		
		$data['coun_idx2'] = $data['prov_idx2'] = $data['city_idx2'] = $data['area_idx2'] = $data['venu_idx2'] = ''; 
				
		$have_venu2 = $have_area2 = $have_city2 = $have_prov2 = $have_coun2 = 0; 
				
		if(count($arr_parent)==1){ //echo "is_coun<br>"; 
			$have_coun2 = $have_prov2 = 1; 
			$arr_parent[1] = $cur_item_id;
			$arr_id[1] = 0;  
		}
		elseif(count($arr_parent)==2){ //echo "is_prov<br>"; 
			$have_coun2 = $have_prov2 = $have_city2 = 1;
			$arr_parent[2] = $cur_item_id;
			$arr_id[2] = 0; 
		}
		elseif(count($arr_parent)==3){ //echo "is_city<br>"; 
			$have_coun2 = $have_prov2 = $have_city2 = $have_area2 = 1; 
			$arr_parent[3] = $cur_item_id;
			$arr_id[3] = 0; 
		}
		elseif(count($arr_parent)==4){ //echo "is_area<br>"; 
			$have_coun2 = $have_prov2 = $have_city2 = $have_area2 = $have_venu2 = 1;  
			$arr_parent[4] = $cur_item_id;
			$arr_id[4] = 0;  
		}
		elseif(count($arr_parent)==5){ //echo "is_venu<br>"; 
			$have_coun2 = $have_prov2 = $have_city2 = $have_area2 = $have_venu2 = 1; 
		}  

		if($have_coun2) $data['coun_idx2'] = $this->getlist_locat_form2(0,$data,$arr_parent[0],$arr_id[0],1); 
		if($have_prov2) $data['prov_idx2'] = $this->getlist_locat_form2(1,$data,$arr_parent[1],$arr_id[1],1);  
		if($have_city2) $data['city_idx2'] = $this->getlist_locat_form2(2,$data,$arr_parent[2],$arr_id[2],1);
		if($have_area2) $data['area_idx2'] = $this->getlist_locat_form2(3,$data,$arr_parent[3],$arr_id[3],1); 
		if($have_venu2) $data['venu_idx2'] = $this->getlist_locat_form2(4,$data,$arr_parent[4],$arr_id[4],1);
 
		//-- add  new
		if(!$cur_item_id){  
			$data['coun_idx2'] = $this->getlist_locat_form2(0,$data,$arr_parent[0],0,1); 
			$data['prov_idx2'] = '';	
			$data['city_idx2'] = '';	
			$data['area_idx2'] = '';	
			$data['venu_idx2'] = '';	 
		}
 
		//---------------------------------------------------------------------------------------------		
		
		
		//--- ajax call output
		
		//echo $is_ajax; 
 
		if($cur_menu && $ajax_parentid > -1){
			if($is_ajax=='1') 
			echo $this->getlist_locat_form($cur_menu,$data,$arr_parent[$cur_menu],$arr_id[$cur_menu],1); 
			elseif($is_ajax=='2') 
			echo $this->getlist_locat_form2($cur_menu,$data,$arr_parent[$cur_menu],$arr_id[$cur_menu],1); 
			
		}
 
		
 
		if(empty($is_ajax)) $this->load->view('member/member_edit_validation',$data); 
 
   
	} 
	
	function member_edit($ID,$edit=0,$error=0,$is_ajax=0,$ajax_parentid=0,$cur_menu=0,$slcmenuid=0){  
 
   		//echo $ajax_parentid;

		//--- default is login as  
		$strAccount = "member"; $group_id = 0; $is_member = 1; $is_merchant = 0;
		//if($this->session->userdata('is_member')) 	{ $strAccount = "member";   $is_member 	 = 1; } //-- login as MEMBER
		//if($this->session->userdata('is_merchant'))	{ $strAccount = "merchant"; $is_merchant = 1; } //-- login as MERCHANT  

     	$data['pageTITLE'] 	= ucfirst($strAccount).' Management > '.ucfirst($strAccount).'s'; 
     	$data['pageLABEL'] 	= ucfirst($strAccount).' Management > Edit '.ucfirst($strAccount).' Profile';
		$data['navMenu']   	= $this->allfunc->navMenu(3); 
		  
		$data['edit'] 		= $edit; 
		$data['ID'] 		= $ID; 
		
		if(empty($ID)) 
     	$data['pageLABEL'] 	= ucfirst($strAccount).' Management > Add '.ucfirst($strAccount).' '; 
		  
		$qData 				= $this->allmodel->getUserById($ID,'member_table');  
		
		$data['row'] 		= $qData->row_array();
		foreach($qData->row_array() as $key => $val) $$key = $val; 
		
		


		$data['isAdmin'] 	= 0;
		if($this->session->userdata('AccessType')=='admin') $data['isAdmin'] = 1;
		
		$data['rowgrp'] 	= $this->allmodel->getTableWhere('user_group_table');  
	  										// getTableWhere($tbl='',$key='',$val=0,$status_id=1,$orderby='',$result_key='') { 
 
		$data['StatusID'] = '';
		if(isset($data['row']['AccessID'])) $data['StatusID'] = $data['row']['StatusID'];
		

		//---------------------------------------------------------------------------------- : location
		
		$data['TABLE'] 		= 'md_location'; 
		$tbl 				= $data['TABLE'];
		$data['ci_ctrl'] 	= 'member_manage';
 		$data['callfunc'] 	= 'member_edit'; 
		
		//---- HOME ADDRESS ------------------- 
		$gData = $this->allmodel->getTableByID($data['TABLE'],$LocationID);
		if(count($gData))
		foreach($gData as $key => $val){   //echo "<br>$key => $val";
			$data[$key] = $val;  
		}
		if($is_ajax=='1'){  
			$data['parent_id'] = $ajax_parentid; 
		}	
		$cur_item_id   		= $data['id'];
		$cur_item_parent_id = $data['parent_id'];
		$cur_item_loc_id 	= $data['loc'];

		//-- get parent loop to top 
		$arr_id = $arr_parent = $arr_loc = array(); 
 
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
		
		//foreach($arr_loc as $k => $v) echo "$k => $v<br>";  
		
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

		if($have_coun) $data['coun_idx'] = $this->getlist_locat_form(0,$data,$arr_parent[0],$arr_id[0],1); 
		if($have_prov) $data['prov_idx'] = $this->getlist_locat_form(1,$data,$arr_parent[1],$arr_id[1],1);  
		if($have_city) $data['city_idx'] = $this->getlist_locat_form(2,$data,$arr_parent[2],$arr_id[2],1);
		if($have_area) $data['area_idx'] = $this->getlist_locat_form(3,$data,$arr_parent[3],$arr_id[3],1); 
		if($have_venu) $data['venu_idx'] = $this->getlist_locat_form(4,$data,$arr_parent[4],$arr_id[4],1);
 
		//-- add  
		if(!$cur_item_id){  
			$data['coun_idx'] = $this->getlist_locat_form(0,$data,$arr_parent[0],0,1); 
			$data['prov_idx'] = '';	
			$data['city_idx'] = '';	
			$data['area_idx'] = '';	
			$data['venu_idx'] = '';	 
		}
		//------------------------------------- 
		
		
		
		//---- WORK ADDRESS ------------------- 
		
		//echo "WorkLocationID = ".$WorkLocationID;  
		
		$gData = $this->allmodel->getTableByID($data['TABLE'],$WorkLocationID);
		if(count($gData))
		foreach($gData as $key => $val){   //echo "<br>$key => $val";
			$data[$key] = $val;  
		}
		if($is_ajax=='2'){  
			$data['parent_id'] = $ajax_parentid; 
		}	
		$cur_item_id   		= $data['id'];
		$cur_item_parent_id = $data['parent_id'];
		$cur_item_loc_id 	= $data['loc'];
		
		
		
		//-- get parent loop to top 
		$arr_id = $arr_parent = $arr_loc = array(); 
 
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
		
		//foreach($arr_loc as $k => $v) echo "$k => $v<br>";  
		
		$data['coun_idx2'] = $data['prov_idx2'] = $data['city_idx2'] = $data['area_idx2'] = $data['venu_idx2'] = ''; 
				
		$have_venu2 = $have_area2 = $have_city2 = $have_prov2 = $have_coun2 = 0; 
				
		if(count($arr_parent)==1){ //echo "is_coun<br>"; 
			$have_coun2 = $have_prov2 = 1; 
			$arr_parent[1] = $cur_item_id;
			$arr_id[1] = 0;  
		}
		elseif(count($arr_parent)==2){ //echo "is_prov<br>"; 
			$have_coun2 = $have_prov2 = $have_city2 = 1;
			$arr_parent[2] = $cur_item_id;
			$arr_id[2] = 0; 
		}
		elseif(count($arr_parent)==3){ //echo "is_city<br>"; 
			$have_coun2 = $have_prov2 = $have_city2 = $have_area2 = 1; 
			$arr_parent[3] = $cur_item_id;
			$arr_id[3] = 0; 
		}
		elseif(count($arr_parent)==4){ //echo "is_area<br>"; 
			$have_coun2 = $have_prov2 = $have_city2 = $have_area2 = $have_venu2 = 1;  
			$arr_parent[4] = $cur_item_id;
			$arr_id[4] = 0;  
		}
		elseif(count($arr_parent)==5){ //echo "is_venu<br>"; 
			$have_coun2 = $have_prov2 = $have_city2 = $have_area2 = $have_venu2 = 1; 
		}  

		if($have_coun2) $data['coun_idx2'] = $this->getlist_locat_form2(0,$data,$arr_parent[0],$arr_id[0],1); 
		if($have_prov2) $data['prov_idx2'] = $this->getlist_locat_form2(1,$data,$arr_parent[1],$arr_id[1],1);  
		if($have_city2) $data['city_idx2'] = $this->getlist_locat_form2(2,$data,$arr_parent[2],$arr_id[2],1);
		if($have_area2) $data['area_idx2'] = $this->getlist_locat_form2(3,$data,$arr_parent[3],$arr_id[3],1); 
		if($have_venu2) $data['venu_idx2'] = $this->getlist_locat_form2(4,$data,$arr_parent[4],$arr_id[4],1);
 
		//-- add  new
		if(!$cur_item_id){  
			$data['coun_idx2'] = $this->getlist_locat_form2(0,$data,$arr_parent[0],0,1); 
			$data['prov_idx2'] = '';	
			$data['city_idx2'] = '';	
			$data['area_idx2'] = '';	
			$data['venu_idx2'] = '';	 
		}
 
		//---------------------------------------------------------------------------------------------		
		
		
		//--- ajax call output
		
		//echo $is_ajax; 
 
		if($cur_menu && $ajax_parentid > -1){
			if($is_ajax=='1') 
			echo $this->getlist_locat_form($cur_menu,$data,$arr_parent[$cur_menu],$arr_id[$cur_menu],1); 
			elseif($is_ajax=='2') 
			echo $this->getlist_locat_form2($cur_menu,$data,$arr_parent[$cur_menu],$arr_id[$cur_menu],1); 
			
		}
 
		
 
		if(empty($is_ajax)) $this->load->view('member/member_edit',$data); 
 
   
	}  	
	
	function getlist_locat_form($iCurMenu,$array,$parentid,$selectid,$edit=0){ 
 
		$table = $array['TABLE'];
		$where_key = 'parent_id';
		$where_val = $parentid;
		$status_id = 1;
		$key_show  = 'loc';
		 
		$dlist = $this->allmodel->getTableWhere($table,$where_key,$where_val,$status_id,$key_show,$key_show,$edit); 
 		
		
		//foreach($dlist as $k => $v) foreach($v as $k2 => $v2) echo "<br>$k => $k2 => $v2";  exit;
 
 		$ci_ctrl  	= $array['ci_ctrl'];
 		$callfunc 	= $array['callfunc'];
		$id			= $array['id'];
 		$ci_func	= $array['ci_func'];
		
		if(empty($selectid)) $selectid = "0";
 
 		if($iCurMenu==0){ $selectname = "coun_id"; $resultid = "listloc1"; }
 		if($iCurMenu==1){ $selectname = "prov_id"; $resultid = "listloc2"; }
 		if($iCurMenu==2){ $selectname = "city_id"; $resultid = "listloc3"; }
 		if($iCurMenu==3){ $selectname = "area_id"; $resultid = "listloc4"; }
 		if($iCurMenu==4){ $selectname = "venu_id"; $resultid = "listloc5"; } 
 		//if($iCurMenu==4){ $selectname = "venu_id"; $is_ajax	= 5; $resultid = "listloc5"; } 
 		
		//http://localhost/member_manage/member_edit/39/0/0/1/52/2

		$res .= '<div style="display:block">';
//		$res .= 'loadcontent(\''.base_url().$ci_ctrl.'/'.$callfunc.'/39/0/0/1/\'+$(\'select#'.$selectname.'\').val()+\'/'.($iCurMenu+1).'\',\''.$resultid.'\')<br>';
		$res .= '<select name="'.$selectname.'" id="'.$selectname.'"  onchange="loadcontent_loc(\''.
		base_url().$ci_ctrl.'/'.$callfunc.'/'.$selectid.'/0/0/1/\'+$(\'select#'.$selectname.'\').val()+\'/'.($iCurMenu+1).'\',\''.$resultid.'\',\''.$iCurMenu.'\',$(\'select#'.$selectname.'\').val())">';
 
 		$x=0;    
		foreach($dlist as $kkk => $row){    
			$strselected = ''; 
  			if($selectid==$row['id']) $strselected = 'selected="selected"'; 
			if(!$x)
			$res .= '  	<option value="-1" '.$strselected.'> </option>';  
			$res .= '	<option value="'.$row['id'].'" '.$strselected.' >'.$row['loc'].'</option>'; 
			$x++;
		}  
		
		$res .= '</select>'; 
		//$res .= '</div>';
        //$res .= '<div style="float:right;" > &nbsp; &nbsp; ';
		if($iCurMenu)
		$res .= '&nbsp; <input class="bt_formreg"  onclick="popupwindow(\'/master_data/locat_edit/add/'.$selectname.'/'.$parentid.'/'.$selectid.'/member_1\',\'Add Location\',240,185)" type="button" name="add_'.$selectname.'" id="add_'.$selectname.'" value="add" />';
		//$res .= '&nbsp; <input onclick="popupwindow(\'/'.$ci_ctrl.'/locat_edit/del/'.$row['id'].'/'.$parentid.'/\'+$(\'select#'.$selectname.'\').val(),\'Del Location\',240,185)" type="button" name="del_'.$selectname.'" id="del_'.$selectname.'" value="del" style="font:normal 10px arial"/>';
		//$res .= '&nbsp; <input onclick="popupwindow(\'/'.$ci_ctrl.'/locat_edit/ren/'.$row['id'].'/'.$parentid.'/\'+$(\'select#'.$selectname.'\').val(),\'Rename Location\',240,185)" type="button" name="ren_'.$selectname.'" id="ren_'.$selectname.'" value="rename" style="font:normal 10px arial"/>';
		//if($parentid)
		//$res .= '&nbsp; <input onclick="popupwindow(\'/'.$ci_ctrl.'/locat_edit/chgpar/'.$row['id'].'/'.$parentid.'/\'+$(\'select#'.$selectname.'\').val(),\'Change Parent Location\',240,185)" type="button" name="chgpar_'.$selectname.'" id="chgpar_'.$selectname.'" value="Change Parent" style="font:normal 10px arial"/>';
		$res .= '</div>';

		return $res; 
	} 
	
	
	function getlist_locat_form2($iCurMenu,$array,$parentid,$selectid,$edit=0){ 
	
		$table = $array['TABLE'];
		$where_key = 'parent_id';
		$where_val = $parentid;
		$status_id = 1;
		$key_show  = 'loc';
		 
		$dlist = $this->allmodel->getTableWhere($table,$where_key,$where_val,$status_id,$key_show,$key_show,$edit); 
 		//foreach($dlist as $k => $v) foreach($v as $k2 => $v2) echo "<br>$k => $k2 => $v2";  exit;
 
 		$ci_ctrl  	= $array['ci_ctrl'];
 		$callfunc 	= $array['callfunc'];
		$id			= $array['id'];
 		$ci_func	= $array['ci_func'];
		
		if(empty($selectid)) $selectid = "0";
 
 		if($iCurMenu==0){ $selectname = "coun_id2"; $resultid = "listloc12"; }
 		if($iCurMenu==1){ $selectname = "prov_id2"; $resultid = "listloc22"; }
 		if($iCurMenu==2){ $selectname = "city_id2"; $resultid = "listloc32"; }
 		if($iCurMenu==3){ $selectname = "area_id2"; $resultid = "listloc42"; }
 		if($iCurMenu==4){ $selectname = "venu_id2"; $resultid = "listloc52"; } 
 		 
		$res .= '<div style="display:block">';
		$res .= '<select name="'.$selectname.'" id="'.$selectname.'"  onchange="loadcontent_loc2(\''.
		base_url().$ci_ctrl.'/'.$callfunc.'/'.$selectid.'/0/0/2/\'+$(\'select#'.$selectname.'\').val()+\'/'.($iCurMenu+1).'\',\''.$resultid.'\',\''.$iCurMenu.'\',$(\'select#'.$selectname.'\').val())">';
 
 		$x=0;    
		foreach($dlist as $kkk => $row){     
			$strselected = ''; 
  			if($selectid==$row['id']) $strselected = 'selected="selected"'; 
			if(!$x)
			$res .= '  	<option value="-1" '.$strselected.'> </option>';  
			$res .= '	<option value="'.$row['id'].'" '.$strselected.' >'.$row['loc'].'</option>'; 
			$x++;
		}  
		
		$res .= '</select>'; 
		if($iCurMenu)
		$res .= '&nbsp; <input class="bt_formreg"  onclick="popupwindow(\'/master_data/locat_edit/add/'.$selectname.'/'.$parentid.'/'.$selectid.'/member_2\',\'Add Location\',240,185)" type="button" name="add_'.$selectname.'" id="add_'.$selectname.'" value="add" />';
		$res .= '</div>';

		return $res; 
	 
	
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
 
		//--get data db -> for non $data['TABLE']=="md_location"
		if($data['id']){
			$gData = $this->allmodel->getTableByID($data['TABLE'],$data['id']); 
			if(!empty($gData))
			foreach($gData as $key => $val){  //echo "<br>$key => $val";
			 	$data[$key] = $val; 
			} 
		}  
		
		
		
		//foreach($data as $key => $val) echo "<br>data[$key] = $val"; exit;
		if(empty($data['group_access_id'])) $data['group_access_id'] = 1;
 
		$this->load->library('funcmember');  
 		
		$data['menuAccessGrp'] = $this->funcmember->mainMenuAccessGrp($data['group_access_id']); 
		
		$data['editFormTable'] = $this->funcdbindex->editFormTable($data);
 
		$this->load->view('index/edit_data_view',$data);   
	} 
 
	function qedit(){ 
		//foreach($_POST as $k => $v) echo "<br>$k => $v";  exit; 
 		
		//-- delete items
		if(isset($_POST['bdel'])) if($_POST['bdel']=="DELETE"){		 
			$q = "UPDATE `".$_POST['TABLE']."` SET `status_id` = 0 WHERE `id` = '".$_POST['id']."' LIMIT 1"; 
			$this->db->query($q);
			//--create log
			$this->allfunc->createLog('member',$this->session->userdata('ID'),strtolower(__CLASS__),$_POST['TABLE'].' - DEL id: '.$_POST['id']);
		    echo '<meta http-equiv="Refresh" content="0;URL=/'.strtolower(__CLASS__).'/'.$_POST['ci_func'].'/" />' ; 
			//re_direct('/'.strtolower(__CLASS__).'/'.$_POST['ci_func'].'/','refresh');  
			exit;
		}
 			
		$arrAccess = array();
		$str_group_access_id = $qstr1 = $qstr2 = $qstr3 = ''; 
		foreach($_POST as $k => $v){ //echo "<br>$k => $v"; 
				//$$k = $v; 
				
			if(substr($k,0,4)=="Prev"){  
				if($v) array_push($arrAccess,$v);  
			}else{
				$$k = $v; 
				if( 
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
		} 
		
		$str_group_access_id = $arrAccess = implode(",",$arrAccess);
	 
	 	if(!empty($str_group_access_id)){ 
			$qstr1 .= "`group_access_id`,";
			$qstr2 .= "'".$str_group_access_id."',"; 
			$qstr3 .= "`group_access_id`='".$str_group_access_id."',";;
		}

		if(empty($id)){ //-- add new data 
			$qstr1 = substr($qstr1,0,strlen($qstr1)-1);
			$qstr2 = substr($qstr2,0,strlen($qstr2)-1); 
			$q = "INSERT INTO `".$TABLE."` (".$qstr1.")VALUES(".$qstr2.")";
			$this->db->query($q); 
			$cid = mysql_insert_id();  
			
			//--create log
			$this->allfunc->createLog('member',$this->session->userdata('ID'),strtolower(__CLASS__),$_POST['TABLE'].' - ADD id : '.$cid);
			
		 }else{ //-- edit data
			$qstr3 = substr($qstr3,0,strlen($qstr3)-1); 
			
			$stractive = '';
			if($_POST['button']=="ACTIVATE") $stractive = ', `status_id`=1 ';
			
			$q = "UPDATE `".$TABLE."` SET ". $qstr3.$stractive. " WHERE `id` = ".$id." LIMIT 1"; 

				
			$this->db->query($q); 
			 
			$cid = $id; 
 
			//--create log
			$this->allfunc->createLog('member',$this->session->userdata('ID'),strtolower(__CLASS__),$_POST['TABLE'].' - UPDATE id: '.$_POST['id']); 
		} 
		 
		echo '<meta http-equiv="Refresh" content="0;URL=/'.strtolower(__CLASS__).'/edit_data/'.$cid.'/'.$ci_func.'/" />' ; 
		//re_direct('/'.strtolower(__CLASS__).'/edit_data/'.$cid.'/'.$ci_func.'/','refresh');
 
	}
	//------------------------------------------------------------------------------------------------------------------------------------------ 

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//------ MEMBER MANAGEMENT
	
	

	

 	function chgpwd($StatusID=0,$ID=0){  
	
		if($_POST){ 
			$ID = $_POST['ID'];
			$PassCur = $_POST['Password'];
			$PassNew = $_POST['PasswordNew1'];
			$PassNew2 = $_POST['PasswordNew2'];
			
			//-- chk current password
			$row['Password'] = '';
			$qData = $this->allmodel->getUserById($ID);
			$row = $qData->row_array(); 
			if(md5($PassCur)!=$row['Password']) $err = "Wrong Enter Current Password";
			else $err = 0; 
			
			//echo md5($PassCur);
			//echo "<br>";
			//echo $row['Password'];
			//echo "<br>";
			//echo $err;  
			
			if(empty($err)){
				$q = "Update user_table Set Password = '".md5($PassNew2)."' Where `ID`= '".$ID."' Limit 1";	 
		    	$this->db->query($q); 
				
				//--create log
				 $this->allfunc->createLog('user',$this->session->userdata('ID'),'change password', 'user_id: '.$ID);
 
			} 
			$data['err'] 		= $err; 
			$data['isPOST'] 	= true;  
			
		} else {   
		 
			$data['StatusID']	= $StatusID;    
			$data['ID'] 		= $ID;    
			$data['isPOST'] 	= false;  
		
		} 
     	$data['pageTITLE'] 	= 'Change User Password'; 
     	$data['pageLABEL'] 	= 'Change User Password';  
		 
		$this->load->view('user/user_pass_pop',$data);
   
	} 
	
	function user_delete($del_id,$curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_changePage,$result_id){  
 
		$this->allmodel->editStatusIDUser(2,$del_id,'member_table');
		
		
		//--create log
		$this->allfunc->createLog('user',$this->session->userdata('ID'),'delete user', 'user_id: '.$del_id);
				 
 
		$data['data']=$this->indexData($curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_changePage,$result_id);
		$this->load->view('data_view',$data);
		
	}
	
	
 
	function qedit_usr(){  
   		$arrAccess = array();
		foreach($_POST as $key => $value){    
			//if(is_array($value)) echo "<br>$key => $value";
			/* 
			ContactMediaData => Array
			SocialMediaData => Array
			HobbyID => Array
			HobbyIDNew => Array
			RubricFavoriteID => Array
			RubricFavoriteIDNew => Array
			*/ 
			if(substr($key,0,4)=="Prev"){  //echo "<br>$key => $value"; 
				if($value) array_push($arrAccess,$value) ;
			}else{
				//if(is_array($value)) $$key = implode(",",$value);
				//else 
				$$key = $value;
			} 
		}
	
		//-- HOBBY add From REGIS-FORM 
		$arrHobby = $HobbyID;  
		if(isset($HobbyIDNew)) {   
			foreach($HobbyIDNew as $key => $value){   
				$val = trim($value);   
				if(!empty($val) && $HobbyID[$key]=='1'){ 
					//--check duplicate
					$q = "Select 1 From md_hobby Where `name` = '".$value."' Limit 1";  
					$dat = $this->db->query($q);
					$chk = $dat->num_rows();  
					if(!$chk){ //echo "<br>$key => $val"; 
						//-- INSERT 
						$q = " INSERT INTO `md_hobby` ( `id`, `name`, `description`, `status_id`) VALUES ( NULL, '".$value."', 'add', '1') ";  
						$this->db->query($q); 
						$add_id = mysql_insert_id(); 
						$arrHobby[$add_id] = 1;  
						//--remove id-temp and add new id $key 
						unset($arrHobby[$key]);  
					}
				} 
			}   
		} 
		//foreach($arrHobby as $key => $value) echo "<br>$key => $value";  
		$HobbyID = trim(implode(",",array_keys($arrHobby))); 
		//echo $HobbyID; exit;
		
		//-- RubricFavorite add From REGIS-FORM 
		$arrRubricFavorite = $RubricFavoriteID;  
		if(isset($RubricFavoriteIDNew)) {   
			foreach($RubricFavoriteIDNew as $key => $value){   
				$val = trim($value);   
				if(!empty($val) && $RubricFavoriteID[$key]=='1'){ 
					//--check duplicate
					$q = "Select 1 From md_rubric_favorite Where `name` = '".$value."' Limit 1";  
					$dat = $this->db->query($q);
					$chk = $dat->num_rows();  
					if(!$chk){ //echo "<br>$key => $val"; 
						//-- INSERT 
						$q = " INSERT INTO `md_rubric_favorite` ( `id`, `name`, `description`, `status_id`) VALUES ( NULL, '".$value."', 'add', '1') ";  
						$this->db->query($q); 
						$add_id = mysql_insert_id(); 
						$arrRubricFavorite[$add_id] = 1;  
						//--remove id-temp and add new id $key 
						unset($arrRubricFavorite[$key]);  
					}
				} 
			}   
		} 
		//foreach($arrHobby as $key => $value) echo "<br>$key => $value";  
		$RubricFavoriteID = trim(implode(",",array_keys($arrRubricFavorite))); 
		//echo $RubricFavoriteID; exit;
 
 
 
 
 
 
		$arrID = array();
		$arrDT = array();
		foreach($ContactMediaID as $key => $value){ 
			 array_push($arrID,$key);  
			 array_push($arrDT,$ContactMediaData[$key]);  
		} 
		//foreach($arrID as $key => $value) echo "<br>$key => $value"; 
		$ContactMediaID 	= implode(",",$arrID); 
		$ContactMediaData 	= trim(implode(",",$arrDT));
		
		$arrID = array();
		$arrDT = array();
		foreach($SocialMediaID as $key => $value){ 
			 array_push($arrID,$key);  
			 array_push($arrDT,$SocialMediaData[$key]);  
		}  
		$SocialMediaID 		= implode(",",$arrID); 
		$SocialMediaData 	= trim(implode(",",$arrDT));
		
 
		
		
 
 /*		
		//-- RubricFavorite
		$arrRubricFavoriteID = array(); 
		foreach($RubricFavoriteID as $key => $value){ 
			 array_push($arrRubricFavoriteID,$key);   
		} 
		//foreach($arrRubricFavoriteID as $key => $value) echo "<br>$key => $value";   exit;
		$RubricFavoriteID 	= implode(",",$arrRubricFavoriteID);  
 
	 

 
		//-- add RUBRIC FAVORITE from member form reg
		foreach($_POST['RubricFavoriteIDNew'] as $key => $value){   
			//echo "<br> key => $key => $value ----- ".$_POST['HobbyID'] ; 
			foreach($_POST['RubricFavoriteID'] as $key2 => $value2){  
				if($key==$key2){ 
					//echo "<br> key => $key => $value"; 
					 //-- INSERT
					if(!empty($value)){  
		//chk if duplicate exist 
					$q = " INSERT INTO `md_rubric_Favorite` ( 
						`id`, `name`, `description`, `status_id`) 
						VALUES (
						NULL, '".$value."', 'add', '1') "; 
 						$this->db->query($q); 
				 	}
				} 
			} 
		} 
 
 */
 
 
 
 
 


		//--- Submit Privileges
		if(isset($_POST['SubmitAccess'])){
			/*
			ID => 15
			curGroupID => 4
			chgGroupID => 4
			Prev-1 => 0
			Prev-12 => 0
			Prev-13 => 0
			SubmitAccess => Update Privileges
			*/	 
			$AccessID = implode(",",$arrAccess);
			//foreach($arrAccess as $key => $value)  echo "<br>$key => $value";
			
			$q = "Update user_table Set   
			`AccessID` = '".$AccessID."',
			ModifiedDate = '".date('Y-m-d H:i:s')."',
			ModifiedBy = '".$this->session->userdata('ID')."'  
			Where `ID`= '".$ID."' Limit 1";	 
			
			$this->db->query($q);
			
			//--create log
			//$this->allfunc->createLog('user',$this->session->userdata('ID'),'edit user privileges', 'user_id: '.$ID);
			 
			echo '<meta http-equiv="Refresh" content="0;URL=/member_manage/user_edit" />' ; 
			//re_direct('/member_manage/user_edit/'.$ID,'refresh');
			
			exit;  
			
		}
 
 
 
		//-- chg Status ID from deleted item
		$StatusIDChg = $StatusID;
		$strPasswordUpdate = '';
		if(isset($_POST['StatusIDChg'])) if($_POST['StatusIDChg']==1||$_POST['StatusIDChg']==2) { 
			$StatusID = $_POST['StatusIDChg'];
		 	$strPasswordUpdate = " Password = '".md5($Password)."', "; 
		}	 
			$AccessID = 0;
			if(count($arrAccess)>0)
			$AccessID = implode(",",$arrAccess);
		
			if(isset($GroupID)) 
				 $strGroupID = "GroupID = '".$GroupID."',"; 
			else $strGroupID = '';
			
			if(isset($AccessType)) 
				 $strAccessType = "AccessType = '".$AccessType."',";
			else $strAccessType = '';
			
		//foreach($arrAccess as $key => $value)  echo "<br>$key => $value";
		
		//-- default groupID is same admin group / not SU
		if(empty($GroupID)) $GroupID = $this->session->userdata('GroupID');
			
 
		if(empty($_POST['ID'])){

 			$Password 		= '1234'; //-- first time password
			$StatusID 		= 1;
			$TFCStatus 		= "REGISTER";
			$CreatedDate 	= date('Y-m-d H:i:s');
			$CreatedBy 	 	= $this->session->userdata('ID');
 
			$q = " INSERT INTO `member_table` 
				(
				`ID`, `Username`, `Password`, `TitleName`, `FullName`, `GenderID`, `BirthPlace`, `BirthDate`, 
				`ReligionID`, `IncomeID`, `MaritalStatusID`, 
				`ContactMediaID`, `ContactMediaData`, `SocialMediaID`, `SocialMediaData`, `SigninLog`, 
				`Email`, `CreatedDate`, `CreatedBy`, `ModifiedDate`, `ModifiedBy`, `StatusID`, `GroupID`,  
				`AccessID`, `AccessType`, `Address`, `LocationID`, `PostCode`, `Phone`, `Mobile`,  
				`WorkAddress`, `WorkLocationID`, `WorkPostCode`, `OccupationID`, `PositionID`, `EducationID`, `HobbyID`, `RubricFavoriteID`, 
				`TFCAgentID`, `TFCOfficerName`, `TFCNumber`, `TFCSerialNumber`, `TFCStatus`, `TFCNoPolisi`, `TFCMemberTypeID`, `TFCRegisterDate`, 
				`TFCValidDateBegin`, `TFCValidDateEnd`, `TFCSurveyID`, `CommentText`
				) VALUES (
				NULL, '".$TFCNumber."', '".md5($Password)."', '".$TitleName."', '".$FullName."', '".$GenderID."', '".$BirthPlace."', '".$BirthDate."', 
				'".$ReligionID."', '".$IncomeID."', '".$MaritalStatusID."',
				'".$ContactMediaID."', '".$ContactMediaData."', '".$SocialMediaID."', '".$SocialMediaData."', '".$SigninLog."', 
				'".$Email."', '".$CreatedDate."', '".$CreatedBy."', '".$ModifiedDate."', '".$ModifiedBy."', '".$StatusID."', '".$GroupID."', 
				'".$AccessID."', '".$AccessType."', '".$Address."', '".$LocationID."', '".$PostCode."', '".$Phone."',  '".$Mobile."',
				'".$WorkAddress."', '".$WorkLocationID."', '".$WorkPostCode."', '".$OccupationID."', '".$PositionID."', '".$EducationID."', '".$HobbyID."', '".$RubricFavoriteID."', 
				'".$TFCAgentID."', '".$TFCOfficerName."', '".$TFCNumber."', '".$TFCSerialNumber."', '".$TFCStatus."', '".$TFCNoPolisi."', '".$TFCMemberTypeID."', '".$TFCRegisterDate."', 
				'".$TFCValidDateBegin."', '".$TFCValidDateEnd."', '".$TFCSurveyID."', '".$CommentText."');
 
			";
 
			$this->db->query($q);
			$uid = mysql_insert_id();
			
			//--create log
			$this->allfunc->createLog('member',$this->session->userdata('ID'),'create member', 'member_id: '.$uid);
		
 
		}else{

			$q = "Update member_table Set 
			 
			`Username`			= '".$TFCNumber."',
			`TitleName`			= '".$TitleName."',
			`FullName`			= '".$FullName."',
			`GenderID`			= '".$GenderID."',
			`BirthPlace`		= '".$BirthPlace."',
			`BirthDate`			= '".$BirthDate."',
			`ReligionID`		= '".$ReligionID."',
			`IncomeID`			= '".$IncomeID."',
			`MaritalStatusID` 	= '".$MaritalStatusID."',
			`ContactMediaID`	= '".$ContactMediaID."', 
			`ContactMediaData`	= '".$ContactMediaData."',
			`SocialMediaID`		= '".$SocialMediaID."',
			`SocialMediaData`	= '".$SocialMediaData."',
			`Email`				= '".$Email."', 
			`ModifiedDate` 		= '".date('Y-m-d H:i:s')."', 
			`ModifiedBy`		= '".$this->session->userdata('ID')."',   
			`StatusID`			= '".$StatusID."', 
			`GroupID`			= '".$GroupID."',  
			`AccessID`			= '".$AccessID."',
			`AccessType`		= '".$AccessType."', 
			`Address`			= '".$Address."',
			`LocationID`		= '".$LocationID."', 
			`PostCode`			= '".$PostCode."', 
			`Phone`				= '".$Phone."', 
			`Mobile`			= '".$ID."',  
			`WorkAddress`		= '".$WorkAddress."', 
			`WorkLocationID`	= '".$WorkLocationID."', 
			`WorkPostCode`		= '".$WorkPostCode."', 
			`OccupationID`		= '".$OccupationID."', 
			`PositionID`		= '".$PositionID."', 
			`EducationID`		= '".$EducationID."', 
			`HobbyID`			= '".$HobbyID."',  
			`RubricFavoriteID`	= '".$RubricFavoriteID."', 
			`TFCAgentID`		= '".$TFCAgentID."', 
			`TFCOfficerName`	= '".$TFCOfficerName."',
			`TFCNoPolisi`		= '".$TFCNoPolisi."', 
			`TFCMemberTypeID`	= '".$TFCMemberTypeID."', ";
			
			//`TFCStatus`			= '".$TFCStatus."', 

		
		//if(isset($_POST['TFCValidDateBegin'])) echo  "TFCValidDateBegin - isset";
		//else echo  "TFCValidDateBegin -  not set";
		
		 
		if(isset($_POST['TFCValidDateBegin']))
		$q .= "		
			`TFCValidDateBegin`	= '".$TFCValidDateBegin."', 
			`TFCValidDateEnd`	= '".$TFCValidDateEnd."', "; 
			
/*			
			`TFCNumber`			= '".$TFCNumber."',
			`TFCSerialNumber`	= '".$TFCSerialNumber."', 
			`TFCSurveyID`		= '".$TFCSurveyID."', "; 
			`TFCRegisterDate`	= '".$TFCRegisterDate."', 
*/			
 
		$q .= "			
			`CommentText`		= '".$CommentText."' 
			Where `ID`= '".$ID."' Limit 1";	 

			$this->db->query($q);
			
			//echo str_replace("',","',<br>",$q); exit;
			
			//--create log
			$this->allfunc->createLog('member',$this->session->userdata('ID'),'edit profile', 'member_id: '.$ID);
		}
		
		

		
		
		 /*
		if(is_array($_POST['HobbyID'])){ 
			//echo $_POST['HobbyIDNew'];
			
			foreach($_POST['HobbyID'] as $key => $value){ 
			
				//echo "<br>$key => $value"; 
 
				if(!empty($value))){
 
		 
					 //-- INSERT
					 
					$q = " INSERT INTO `md_hobby` ( 
						`id`, `name`, `description`, `status_id`) 
						VALUES (
						NULL, '".trim($_POST['HobbyIDNew'])."', 'add', '1') ";
					 
 						$this->db->query($q); 

				}

			}

		}
		*/
		
 
		
		
		
		
		
		
		
		
		
		
		
		
		if(empty($_POST['ID'])) $ID = mysql_insert_id()."/add";
		if(isset($uid)) $ID = $uid."/add";
		
 		//re_direct('/member_manage/member_edit/'.$ID,'refresh');
 		echo '<meta http-equiv="Refresh" content="0;URL=/member_manage/members" />' ; 
		//re_direct('/member_manage/members/','refresh');
   
	}  
 
	  
	function qedit_usrpaid(){  
 
		if( $_POST['ID'] ){
			foreach($_POST as $key => $value){ 
				//echo "<br>$key => $value";
				/*
				ID => 11
				TFCNumber => 0210000003
				TFCValidDateBegin => 2016-03-25
				TFCValidDateEnd => 2017-03-25
				TFCSerialNumber => 100003
				TFCStatus => REGISTER
				Submit => Submit
				*/
				$$key = $value; 
			} 
 //exit;
			$q = "Update member_table Set `TFCStatus` = 'PAID' Where `ID`= '".$ID."' Limit 1";	 
			 
			$this->db->query($q);
			
			//echo str_replace("',","',<br>",$q); exit;
			
			//--create log
			$this->allfunc->createLog('member',$this->session->userdata('ID'),'validate member', 'member_id: '.$ID);
		}
  
		
 		echo '<meta http-equiv="Refresh" content="0;URL=/member_manage/member_paid" />' ; 
		//re_direct('/member_manage/member_validation/','refresh');
   
	}  
	  function qedit_usrval(){  
 
		if( $_POST['ID'] ){
			foreach($_POST as $key => $value){ 
				//echo "<br>$key => $value";
				/*
				ID => 11
				TFCNumber => 0210000003
				TFCValidDateBegin => 2016-03-25
				TFCValidDateEnd => 2017-03-25
				TFCSerialNumber => 100003
				TFCStatus => REGISTER
				Submit => Submit
				*/
				$$key = $value; 
			} 
 
			$q = "Update member_table Set    
			`Username`			= '".$TFCNumber."', 
			`TFCNumber`			= '".$TFCNumber."',
			`TFCSerialNumber`	= '".$TFCSerialNumber."',
			`TFCStatus`			= '".$TFCStatus."',    
			`TFCValidDateBegin`	= '".$TFCValidDateBegin."', 
			`TFCValidDateEnd`	= '".$TFCValidDateEnd."' 
			Where `ID`= '".$ID."' Limit 1";	 
			 
			$this->db->query($q);
			
			//echo str_replace("',","',<br>",$q); exit;
			
			//--create log
			$this->allfunc->createLog('member',$this->session->userdata('ID'),'validate member', 'member_id: '.$ID);
		}
  
		
 		echo '<meta http-equiv="Refresh" content="0;URL=/member_manage/member_validation" />' ; 
		//re_direct('/member_manage/member_validation/','refresh');
   
	}  
	  
	  
	  
	  
	  
 	
	  
	  
	  
	  
	  
	  
	  
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//----- MEMBERSs
	
	function members($curpage=1,$limit=10,$statusid=1,$sort="ID",$order="desc",$group_id=0,$ci_ctrl="member_manage",$ci_changePage="changepage",$result_id="dspdata"){  
 
		$strAccount = "member"; // $is_member = 1; $is_merchant = 0; 

     	$data['pageTITLE'] 		= ucfirst($strAccount).' Management > '.ucfirst($strAccount).'s'; 
     	$data['pageLABEL'] 		= ucfirst($strAccount).' Management > '.ucfirst($strAccount).'s';
		$data['navMenu']   		= $this->allfunc->navMenu(3);  
		
		$data['limit'] 			= $limit;
		$data['statusid'] 		= $statusid;
		$data['sort'] 			= $sort;
		$data['order'] 			= $order;
		$data['ci_ctrl'] 		= $ci_ctrl;
		$data['ci_func'] 		= __FUNCTION__;
		$data['ci_changePage']	= $ci_changePage;
		$data['result_id'] 		= $result_id;

		$data['group_id'] 		= $group_id;

		$data['rowgrp'] 		= $this->allmodel->getTableWhere('user_group_table','',0,1,'group_access_id');  
		
		
						
		$this->load->library('funcuser'); 
 		if( !$this->funcuser->chkFinanceAccess( $this->session->userdata('ID') ) )  $strAccessType = "Admin"; 
		else $strAccessType = "";
 		$data['strAccessType'] = $strAccessType;
		//$this->session->userdata('GroupID'); 
  
		$data['indexData']  = $this->indexData($curpage,$limit,$statusid,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id); //,$is_member,$is_merchant

		$this->load->view('member/members',$data); 

	}
	
	function member_validation($curpage=1,$limit=10,$statusid=1,$sort="ID",$order="desc",$group_id=0,$ci_ctrl="member_manage",$ci_changePage="changepageval",$result_id="dspdata"){  

		$strAccount = "member"; // $is_member = 1; $is_merchant = 0; 

     	$data['pageTITLE'] 		= ucfirst($strAccount).' Management > '.ucfirst($strAccount).' Validation'; 
     	$data['pageLABEL'] 		= ucfirst($strAccount).' Management > '.ucfirst($strAccount).' Validation'; 
		$data['navMenu']   		= $this->allfunc->navMenu(3);  
		
		$data['limit'] 			= $limit;
		$data['statusid'] 		= $statusid;
		$data['sort'] 			= $sort;
		$data['order'] 			= $order;
		$data['ci_ctrl'] 		= $ci_ctrl;
		$data['ci_func'] 		= __FUNCTION__;
		$data['ci_changePage']	= $ci_changePage;
		$data['result_id'] 		= $result_id;

		$data['group_id'] 		= $group_id;

		$data['rowgrp'] 		= $this->allmodel->getTableWhere('user_group_table','',0,1,'group_access_id');  

		//$this->session->userdata('GroupID'); 

		$data['indexData']  = $this->indexDataVal($curpage,$limit,$statusid,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id);//,$is_member,$is_merchant
		//$data['indexData']  = $this->indexData($curpage,$limit,$statusid,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id); //,$is_member,$is_merchant

		$this->load->view('member/members',$data); 

	}
	
	function member_paid($curpage=1,$limit=10,$statusid=1,$sort="ID",$order="desc",$group_id=0,$ci_ctrl="member_manage",$ci_changePage="changepagepaid",$result_id="dspdata"){

		//--- default is login as USER
		$strAccount = "member"; //$group_id = 0; $is_member = 1; $is_merchant = 0; 

     	$data['pageTITLE'] 		= ucfirst($strAccount).' Management > '.ucfirst($strAccount).' Paid Status'; 
     	$data['pageLABEL'] 		= ucfirst($strAccount).' Management > '.ucfirst($strAccount).' Paid Status';
		$data['navMenu']   		= $this->allfunc->navMenu(3);  
		
		$data['limit'] 			= $limit;
		$data['statusid'] 		= $statusid;
		$data['sort'] 			= $sort;
		$data['order'] 			= $order;
		$data['ci_ctrl'] 		= $ci_ctrl;
		$data['ci_func'] 		= __FUNCTION__;
		$data['ci_changePage']	= $ci_changePage;
		$data['result_id'] 		= $result_id;
 
		$data['group_id'] 		= $group_id;

		$data['rowgrp'] 		= $this->allmodel->getTableWhere('user_group_table','',0,1,'group_access_id');  

		//$this->session->userdata('GroupID'); 
		
		$data['indexData']  = $this->indexDatapaid($curpage,$limit,$statusid,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id);//,$group_id,$is_member,$is_merchant

		//$data['indexData']  =  $this->indexDataVal($curpage,$limit,$statusid,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id);//,$is_member,$is_merchant
		//$data['indexData']  = $this->indexData($curpage,$limit,$statusid,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id); //,$is_member,$is_merchant

		$this->load->view('member/members',$data); 

	}
	
	
	
 	function indexData($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id){ //,$is_member=0,$is_merchant=0
 
		//$part_url = "users";
		//if($is_member) 	 
		$part_url = "members"; 
 
		if($order=="asc") $orderO="desc";
		elseif($order=="desc") $orderO="asc";
		 
		$content=$disableAll='';
		
		$start=($curpage*$limit)-$limit;
  
		if($start >= 0){
 
			//$qData=$this->allmodel->selectUser($start,$limit,$status_id,$sort,$order); 
			$qData=$this->allmodel->selectUser($start,$limit,$status_id,$sort,$order,$group_id,"member_table"); 
 
			if($qData->num_rows()){ 
				$col1 = "#ffffff";
				$col2 = "#f6f6f6";
				$col3 = "#FFDDFF";
				
				//$this->allfunc->isAdmin();
				 
				if($this->session->userdata('AccessType')=='admin') $disableAll = ''; 
				if($this->session->userdata('AccessType')=='user')  $disableAll = ' disabled="disabled" '; 
				 
				 $content.=
						'<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#bbbbbb">
						<thead>
							<tr bgcolor="#666666" class="">
							  <td align="center" class="lightgrey" >No.</td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/GroupID/'.$orderO.'/'.$group_id.'\')">Branch</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/Fullname/'.$orderO.'/'.$group_id.'\')">Name</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCNumber/'.$orderO.'/'.$group_id.'\')">Card-Number</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCSerialNumber/'.$orderO.'/'.$group_id.'\')">Serial-Number</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCValidDateBegin/'.$orderO.'/'.$group_id.'\')">Valid Date</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCValidDateEnd/'.$orderO.'/'.$group_id.'\')">Valid Thru</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCStatus/'.$orderO.'/'.$group_id.'\')">Status</a></td>
							  <td align="center" class="lightgrey" >Edit</td> 
							  <td align="center" class="lightgrey" >Delete</td>  
							</tr>
						</thead>
						<tbody>';
						
						//	  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/SigninLog/'.$orderO.'/'.$group_id.'\')">Last-Login</a></td>
						// <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/AccessType/'.$orderO.'\')">Access</a></td>
 
				$x=$start+1;
				foreach($qData->result_array() as $row){
 
					$n = fmod($x,2);
 
 					//-- format time las login
					if(!empty($row['SigninLog'])){
						$dt = substr($row['SigninLog'],13,10); 
						$tm = substr($row['SigninLog'],24,5);  
						$fdatetime = $this->allfunc->formatDateTime($dt." ".$tm,4);
					}else $fdatetime = '';
					
					if($n) $clr = $col1;
					else  $clr = $col2;
					
					$disable  = $disableAll;
					$disable2 = $disableAll; 
					
					if($row['Username']==$this->session->userdata('Username')){
						$clr = $col3; 
						$disable = ''; 
						$disable2 = ''; 
					} 
					if( $row['AccessType']=='user' && $this->session->userdata('AccessType')=='user')  $disable2 = ' disabled="disabled" '; 
					
					if( $row['AccessType']=='user') 	 $strAccessType =  "Member";
					elseif( $row['AccessType']=='admin') $strAccessType =  "Administrator";
					
					$getGroup = $this->allmodel->getTableByID('user_group_table',$row['GroupID']);
					
					//echo $getGroup['group'];
					
					if(empty($getGroup['group']))  $strGroupID =  "";
					else $strGroupID = $getGroup['group'];
					
					if($row['TFCStatus']=="REGISTER") 
					$strTFCStatus = "REGISTER"." : ".$row['TFCRegisterDate'];
					else 
					$strTFCStatus = $row['TFCStatus'];
 
					$content.='<tr bgcolor="'.$clr.'">
					  <td align="right">'.$x.'.&nbsp;</td>
					  <td>'.$strGroupID.'</td>
					  <td>'.$row['FullName'].'</td>
					  <td>'.$row['TFCNumber'].'</td>
					  <td>'.$row['TFCSerialNumber'].'</td>
					  <td>'.$row['TFCValidDateBegin'].'</td>
					  <td>'.$row['TFCValidDateEnd'].'</td> 
					  <td>'.$strTFCStatus.'</td>
					  <td align="center">';
					  //<td nowrap="nowrap">'.$fdatetime.'</td>
					  //<td>'.$strAccessType.'</td>
					  
					//if($this->session->userdata('ID')==1 || $this->session->userdata('ID')==2 || $this->session->userdata('ID')==$row['ID'] || $this->session->userdata('AccessType')=='admin')  
					$show_edit = 0;
					//if($this->session->userdata('ID')==1 || $this->session->userdata('ID')==2 || $this->session->userdata('AccessType')=='admin' || $this->session->userdata('AccessType')=='manager_admin') $show_edit = 1;   
					if($strTFCStatus!="VALID"&&$strTFCStatus!="PRINTCARD") $show_edit = 1;
					if($this->session->userdata('ID')==1 || $this->session->userdata('ID')==2) $show_edit = 1;
					 
					
					
					if($show_edit)
					$content.='<input  type="button" name="EDIT" value="EDIT" onclick="window.location.assign(\''.base_url().$ci_ctrl.'/member_edit/'.$row['ID'].'\')"/>';
					
					$content.='</td>';
					$content.='<td align="center">';
					
					if( $status_id!=2 && ($this->session->userdata('ID')==1 || $this->session->userdata('ID')==2 || 
					
						($this->session->userdata('AccessType')=='manager_admin' && ($strTFCStatus!="VALID"&&$strTFCStatus!="PRINTCARD") )
						||
						($this->session->userdata('AccessType')=='admin' && ($strTFCStatus!="VALID"&&$strTFCStatus!="PRINTCARD") )
					
					)){   
					 
						$content.='<input  type="submit" name="DEL" value="DEL" onclick="confirmdelete(\''.base_url().$ci_ctrl.'/user_delete/'.$row['ID'].'/'.$curpage.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$group_id.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'\',\''.$result_id.'\')"/>';
					//} else{
						//$content.='<span class="size10"mgr admin only</span>';
						
					}
					
					
					$content.='</td>'; 
					$content.='</tr>'; 
					$x++;
				}	
			}
		}
		$content.='</tbody>';
		$content.='</table>';		
		
		$content.=$this->pagenav($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id);
		
		return $content;
	} 
	
 	//function indexData($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id){ //,$is_member=0,$is_merchant=0
	function indexDataVal($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id){ //,$is_member=0,$is_merchant=0
 
		//$part_url = "users";
		//if($is_member) 	 
		$part_url = "member_validation"; 
 
		if($order=="asc") $orderO="desc";
		elseif($order=="desc") $orderO="asc";
		 
		$content=$disableAll='';
		
		$start=($curpage*$limit)-$limit;
  
		if($start >= 0){
  
			$qData=$this->allmodel->selectUser($start,$limit,$status_id,$sort,$order,$group_id,"member_table");  
 
			if($qData->num_rows()){ 
				$col1 = "#ffffff";
				$col2 = "#f6f6f6";
				$col3 = "#FFDDFF";
				
				//$this->allfunc->isAdmin();
				 
				if($this->session->userdata('AccessType')=='admin') $disableAll = ''; 
				if($this->session->userdata('AccessType')=='user')  $disableAll = ' disabled="disabled" '; 
				 
				 $content.=
						'<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#bbbbbb">
						<thead>
							<tr bgcolor="#666666" class="">
							  <td align="center" class="lightgrey" >No.</td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/GroupID/'.$orderO.'/'.$group_id.'\')">Branch</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/Fullname/'.$orderO.'/'.$group_id.'\')">Name</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCNumber/'.$orderO.'/'.$group_id.'\')">Card-Number</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCSerialNumber/'.$orderO.'/'.$group_id.'\')">Serial-Number</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCRegisterDate/'.$orderO.'/'.$group_id.'\')">RegisterDate</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCValidDateBegin/'.$orderO.'/'.$group_id.'\')">ValidDateBegin</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCValidDateEnd/'.$orderO.'/'.$group_id.'\')">ValidDateEnd</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCStatus/'.$orderO.'/'.$group_id.'\')">Status</a></td>
							  <td align="center" class="lightgrey" >Action</td> 
							</tr>
						</thead>
						<tbody>';
						// <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/AccessType/'.$orderO.'\')">Access</a></td>
 
				$x=$start+1;
				foreach($qData->result_array() as $row){
 
					$n = fmod($x,2);
 
 					//-- format time las login
					if(!empty($row['SigninLog'])){
						$dt = substr($row['SigninLog'],13,10); 
						$tm = substr($row['SigninLog'],24,5);  
						$fdatetime = $this->allfunc->formatDateTime($dt." ".$tm,4);
					}else $fdatetime = '';
					
					if($n) $clr = $col1;
					else  $clr = $col2;
					
					$disable  = $disableAll;
					$disable2 = $disableAll; 
					
					if($row['Username']==$this->session->userdata('Username')){
						$clr = $col3; 
						$disable = ''; 
						$disable2 = ''; 
					} 
					if( $row['AccessType']=='user' && $this->session->userdata('AccessType')=='user')  $disable2 = ' disabled="disabled" '; 
					
					if( $row['AccessType']=='user') 	 $strAccessType =  "Member";
					elseif( $row['AccessType']=='admin') $strAccessType =  "Administrator";
					
					$getGroup = $this->allmodel->getTableByID('user_group_table',$row['GroupID']);
					
					//echo $getGroup['group'];
					
					if(empty($getGroup['group']))  $strGroupID =  "";
					else $strGroupID = $getGroup['group'];
					
					if($row['TFCStatus']=="REGISTER") 
					$strTFCStatus = "REGISTER"." : ".$row['TFCRegisterDate'];
					else 
					$strTFCStatus = $row['TFCStatus'];
 
					$content.='<tr bgcolor="'.$clr.'">
					  <td align="right">'.$x.'.&nbsp;</td>
					  <td>'.$strGroupID.'</td>
					  <td>'.$row['FullName'].'</td>
					  <td>'.$row['TFCNumber'].'</td>
					  <td>'.$row['TFCSerialNumber'].'</td>
					  <td nowrap="nowrap">'.$row['TFCRegisterDate'].'</td>
					  <td nowrap="nowrap">'.$row['TFCValidDateBegin'].'</td>
					  <td nowrap="nowrap">'.$row['TFCValidDateEnd'].'</td>
					  <td>'.$row['TFCStatus'].'</td>
					  <td align="center">'; 
					  
					
					if($this->session->userdata('ID')==1 || $this->session->userdata('AccessType')=='admin'){   
					
						if($row['TFCStatus']=="VALID"||$row['TFCStatus']=="EXPIRED") 
						$content.='<a href="#" onclick="window.location.assign(\''.base_url().$ci_ctrl.'/member_edit_validation/'.$row['ID'].'\')" ><u>edit</u></a>';
 											
						if($row['TFCStatus']=="PAID") 
						$content.='<input '.$disable.' type="button" name="VALIDATE" value="VALIDATE" onclick="window.location.assign(\''.base_url().$ci_ctrl.'/member_edit_validation/'.$row['ID'].'\')"/>';
 					
						if($row['TFCStatus']=="PRINTCARD") 
						//$content.='<span class="red">CREATE CARD NOW!</span>';
 						$content.='<a href="#" onclick="window.location.assign(\''.base_url().$ci_ctrl.'/member_edit_validation/'.$row['ID'].'\')" ><span class="red">CREATE-CARD!</span></a>';
 						
 					
					
					}	
					$content.='</td>'; 
					$content.='</tr>'; 
					$x++;
				}	
			}
		}
		$content.='</tbody>';
		$content.='</table>';		
		
		$content.=$this->pagenav($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id);
		
		return $content;
	} 
	
	function indexDatapaid($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id){ //,$group_id=0,$is_member=0,$is_merchant=0 
 		
		//$part_url = "users";
		//if($is_member) 	 
		$part_url = "member_paid"; 
 
		if($order=="asc") $orderO="desc";
		elseif($order=="desc") $orderO="asc";
		 
		$content=$disableAll='';
		
		$start=($curpage*$limit)-$limit;
  
		if($start >= 0){
   
			$qData=$this->allmodel->selectUser($start,$limit,$status_id,$sort,$order,$group_id,"member_table"); 
			  
			if($qData->num_rows()){ 
				$col1 = "#ffffff";
				$col2 = "#f6f6f6";
				$col3 = "#FFDDFF";
				
				//$this->allfunc->isAdmin();
				 
				if($this->session->userdata('AccessType')=='admin') $disableAll = ''; 
				if($this->session->userdata('AccessType')=='user')  $disableAll = ' disabled="disabled" '; 
				 
				 $content.=
						'<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#bbbbbb">
						<thead>
							<tr bgcolor="#666666" class="">
							  <td align="center" class="lightgrey" >No.</td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/GroupID/'.$orderO.'/'.$group_id.'\')">Branch</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/Fullname/'.$orderO.'/'.$group_id.'\')">Name</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCNumber/'.$orderO.'/'.$group_id.'\')">Card-Number</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCSerialNumber/'.$orderO.'/'.$group_id.'\')">Serial-Number</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCRegisterDate/'.$orderO.'/'.$group_id.'\')">RegisterDate</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCValidDateBegin/'.$orderO.'/'.$group_id.'\')">ValidDateBegin</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCValidDateEnd/'.$orderO.'/'.$group_id.'\')">ValidDateEnd</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCStatus/'.$orderO.'/'.$group_id.'\')">Status</a></td>
							  <td align="center" class="lightgrey" >Action</td> 
							</tr>
						</thead>
						<tbody>';
						// <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/AccessType/'.$orderO.'\')">Access</a></td>
 
				$x=$start+1;
				foreach($qData->result_array() as $row){
 
					$n = fmod($x,2);
 
 					//-- format time las login
					if(!empty($row['SigninLog'])){
						$dt = substr($row['SigninLog'],13,10); 
						$tm = substr($row['SigninLog'],24,5);  
						$fdatetime = $this->allfunc->formatDateTime($dt." ".$tm,4);
					}else $fdatetime = '';
					
					if($n) $clr = $col1;
					else  $clr = $col2;
					
					$disable  = $disableAll;
					$disable2 = $disableAll; 
					
					if($row['Username']==$this->session->userdata('Username')){
						$clr = $col3; 
						$disable = ''; 
						$disable2 = ''; 
					} 
					if( $row['AccessType']=='user' && $this->session->userdata('AccessType')=='user')  $disable2 = ' disabled="disabled" '; 
					
					if( $row['AccessType']=='user') 	 $strAccessType =  "Member";
					elseif( $row['AccessType']=='admin') $strAccessType =  "Administrator";
					
					$getGroup = $this->allmodel->getTableByID('user_group_table',$row['GroupID']);
					
					//echo $getGroup['group'];
					
					if(empty($getGroup['group']))  $strGroupID =  "";
					else $strGroupID = $getGroup['group'];
					
					if($row['TFCStatus']=="REGISTER") 
					$strTFCStatus = "REGISTER"." : ".$row['TFCRegisterDate'];
					else 
					$strTFCStatus = $row['TFCStatus'];
 
					$content.='<tr bgcolor="'.$clr.'">
					  <td align="right">'.$x.'.&nbsp;</td>
					  <td>'.$strGroupID.'</td>
					  <td>'.$row['FullName'].'</td>
					  <td>'.$row['TFCNumber'].'</td>
					  <td>'.$row['TFCSerialNumber'].'</td>
					  <td nowrap="nowrap">'.$row['TFCRegisterDate'].'</td>
					  <td nowrap="nowrap">'.$row['TFCValidDateBegin'].'</td>
					  <td nowrap="nowrap">'.$row['TFCValidDateEnd'].'</td>
					  <td>'.$row['TFCStatus'].'</td>
					  <td align="center">'; 
					  
					
					//if($this->session->userdata('ID')==1 || $this->session->userdata('AccessType')=='admin'){   
					
						//if($row['TFCStatus']=="VALID"||$row['TFCStatus']=="EXPIRED") 
						//$content.='<a href="#" onclick="window.location.assign(\''.base_url().$ci_ctrl.'/member_edit_validation/'.$row['ID'].'\')" ><u>edit</u></a>';
 											
						//if($row['TFCStatus']=="PAID") 
						//$content.='<input '.$disable.' type="button" name="VALIDATE" value="VALIDATE" onclick="window.location.assign(\''.base_url().$ci_ctrl.'/member_edit_validation/'.$row['ID'].'\')"/>';
 					
						if($row['TFCStatus']=="REGISTER")  
  						//$content.='<input type="button" name="PAID" value="PAID" onclick="loadcontent(\''.base_url().$ci_ctrl.'/member_edit_paid/'.$row['ID'].'/'.$curpage.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'\',\''.$result_id.'\')"/>';
						$content.='<input type="button" name="PAID" value="PAID" onclick="window.location.assign(\''.base_url().$ci_ctrl.'/member_edit_paid/'.$row['ID'].'\')"/>';
 					
 					
					//$content.='<input '.$disable2.' type="submit" name="DEL" value="DEL" onclick="confirmdelete(\''.base_url().$ci_ctrl.'/user_delete/'.$row['ID'].'/'.$curpage.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'\',\''.$result_id.'\')"/>';
					
					 
					$content.='</td>'; 
					$content.='</tr>'; 
					$x++;
				}	
			}
		}
		$content.='</tbody>';
		$content.='</table>';		
		
		$content.=$this->pagenav($curpage,$limit,$status_id,$sort,$order,group_id,$ci_ctrl,$ci_changePage,$result_id);
		
		return $content;
	} 
	
	
	function pagenav($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id){
 
		//$cData=$this->allmodel->countUser($status_id,'user_table',$group_id); 
		$cData=$this->allmodel->countUser($status_id,'member_table',$group_id); 
 
		$tempData=$cData->result_array();
		$totalData=$tempData[0]['count'];		
		
		$var='<div class="pagenave">';
		
		if($cData->num_rows()){
			$totalPage=ceil($totalData/$limit);
			
			if(($curpage-1)>0){
				$prev=($curpage-1);
			}else{
				$prev=$curpage;
			}
			if(($curpage+1) < $totalPage){
				$next=($curpage+1);
			}else{
				$next=$totalPage;
			} 
	 		$var.='<table width="100%" cellpadding="0" cellspacing="5" border="0">
			  		<tr>';
					
			$var.='		<td nowrap="nowrap" style="border-right:1px dotted grey">';
				$var.='<a href="javascript:void(0);loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/'.$prev.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$group_id.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'\',\''.$result_id.'\')"><img src="/asset/icons/arrow_left.gif" width="16" height="16" />prev</a>';
				$var.='&nbsp; &nbsp;'; 
				$var.='<a href="javascript:void(0);loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/'.$next.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$group_id.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'\',\''.$result_id.'\')">next<img src="/asset/icons/arrow_right.gif" width="16" height="16" /></a>';
				$var.='&nbsp; &nbsp;'; 
			
			$var.='		</td>';
				
			$var.='		<td width="100%" nowrap="nowrap" >';
							$var.='&nbsp; &nbsp;Page: <select name="page" id="page" onchange="loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/\'+$(this).val()+\'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$group_id.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'\',\''.$result_id.'\')">'; 
				for($i=1;$i<=$totalPage;$i++){
					$var.='<option value="'.$i.'"';
					if($curpage==$i){
						$var.=' selected'; 
					}
					$var.='>'.$i.'</option>'; 
				}
				$var.='</select>';
				$var.=' of <b>'.$totalPage.'</b> pages &nbsp;-&nbsp; ';			
				$var.='Total <strong>'.$totalData.'</strong> records found.';
			$var.='		</td>';  
			$var.='		<td align="right" nowrap="nowrap" >';
				$var.='Show <select name="view" id="view" onchange="loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/1/\'+$(this).val()+\'/'.$status_id.'/'.$sort.'/'.$order.'/'.$group_id.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'\',\''.$result_id.'\')" >';
				$arrView=array(10,20,50,100);
				foreach($arrView as $val){
					$var.= '<option value="'.$val.'"';  
					if($limit==$val){
						$var.=' selected'; 
					}
					$var.='>'.$val.'</option>';  
				}
				$var.='</select> item/page';
			$var.='		</td>'; 
			$var.='	</tr> 
				   </table>'; 
		}
		$var.='</div>';
		return $var;
	}  
	
	
	function     changepage($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id){	 
		$data['data']=    $this->indexData($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id);
		$this->load->view('data_view',$data);
	} 
	function  changepageval($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id){	 
		$data['data']= $this->indexDataval($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id);
		$this->load->view('data_view',$data); 
	} 
	
	function changepagepaid($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id){	 
		$data['data']=$this->indexDatapaid($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id);
		$this->load->view('data_view',$data); 
	} 
}
