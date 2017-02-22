<?php  
//session_start();  
class Merchant_manage extends Controller { 
	function Merchant_manage(){   
		parent::Controller(); 
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		$this->load->library('allfunc');  
		$this->load->library('funcdbindex'); 
		$this->load->database(); 
		$this->load->library('session'); 
		if(!$this->session->userdata('logged_in')) 
		echo '<meta http-equiv="Refresh" content="0;URL=/login" />' ;
		//re_direct('login','refresh');
		  
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
 
		$data['navMenu']   	= $this->allfunc->navMenu(4);  
		$data['ci_menu'] 	= $this->allfunc->navMenu(4,1);
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
 
	function member_group		($curpage=1,$limit=10,$status_id=1,$sort="id",$order="asc",$ci_ctrl=__CLASS__,$ci_changePage="changepagegrp",$result_id="dspdata"){  
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit); 
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;  
		$data = $this->indexpage($data); 
	} 

	//-------------------------------------------------------------------------------------------------------------------
	
	
	function get_branch_dataxxx($GroupID){
			
		$groupname = $this->allmodel->getGroupbyID($GroupID)	;
		$groupdesc = $this->allmodel->getGroupbyID($GroupID,1)	;
		
		echo '
			<div class="size20 bold ">'.$groupname.'</div>
          	<div style="padding:3px 0; "></div>'.$groupdesc ; 
	}
	
	function edit_product($ID=0,$is_pop=1,$num=0){
		$data['ID'] = $ID;	
 		//$this->load->view('merchant/merchant_edit_product_pop',$data); 
		
		
		$n = $num+1;
		echo '<table width="100%" border="0" cellpadding="3" cellspacing="0"> 
			<tr>
              <td align="right" nowrap="nowrap">'.$n.'.</td>
              <td><input name="product_name['.$n.']" type="text" id="product_name['.$n.']" value="" size="19" maxlength="32"  autocomplete="off"/></td>
              <td></td>
              <td nowrap="nowrap">Value:</td>
              <td><input name="product_value['.$n.']" type="text" id="product_value['.$n.']" value="" size="1"  autocomplete="off"/></td>
              <td nowrap="nowrap">/</td>
              <td nowrap="nowrap"><select name="product_periode['.$n.']" id="product_periode['.$n.']">
                <option value="-1"></option>
                <option value="dy">day</option>
                <option value="mo">month</option>
                <option value="yr">year</option> 
              </select></td>
              <td nowrap="nowrap">=&gt;</td>
              <td nowrap="nowrap">Type</td>
			  <td>'; 
			  $tbl = "md_merchant_type"; 
			  $rowData = $this->allmodel->getTableWhere($tbl); 
			echo '<select name="merchant_type['.$n.']" id="merchant_type['.$n.']" >
                <option value="-1"></option>
				';
				foreach($rowData as $RowT){
                echo '<option value="'.$RowT['id'].'">'.$RowT['name'].'</option>
				';
                } 
             echo '</select >  
              </td>
              <td nowrap="nowrap">Amount-Value: Rp.<span class="red">*</span></td>
              <td><input name="product_credit['.$n.']" id="product_credit['.$n.']" value="" size="12" maxlength="12" autocomplete="off" type="text"></td> 
              <td>Term</td>
              <td><input name="product_term['.$n.']" type="text" id="product_term['.$n.']" value="" size="25"  autocomplete="off"/></td>
            </tr> 
			</table>  
			<div id="add_product_'.$n.'">    
			<table width="100%" border="0" cellpadding="4" cellspacing="0">
		     <tr>
              <td width="20"></td>
              <td colspan="7"><input class="bt_formreg" onclick="merchant_add_product('.$n.',\'add_product_'.$n.'\')" name="add_product" id="add_product" value="add" type="button" />                   </td>
            </tr> 
		   </div> 	
		   </table>
		';
		
	}

	function merchants($curpage=1,$limit=10,$statusid=1,$sort="ID",$order="desc",$group_id=0,$ci_ctrl="merchant_manage",$ci_changePage="changepage2",$result_id="dspdata"){  

		//--- default is login as USER
		$strAccount = "merchant";// $group_id = 1; $is_member = 0; $is_merchant = 1;
		
		//echo $this->session->userdata('is_merchant'); exit;
		
		if($this->session->userdata('is_member')) 	{ $strAccount = "member";   $is_member 	 = 1; } //-- login as MEMBER
		if($this->session->userdata('is_merchant'))	{ $strAccount = "merchant"; $is_merchant = 1; } //-- login as MERCHANT  

     	$data['pageTITLE'] 	= ucfirst($strAccount).' Management > '.ucfirst($strAccount).'s'; 
     	$data['pageLABEL'] 	= ucfirst($strAccount).' Management > '.ucfirst($strAccount).'s';
		$data['navMenu']   	= $this->allfunc->navMenu(4);  
		
		$data['limit'] 		= $limit;
		$data['statusid'] 	= $statusid;
		$data['sort'] 		= $sort;
		$data['order'] 		= $order;
		$data['ci_ctrl'] 	= $ci_ctrl;
		$data['ci_func'] 		= __FUNCTION__;
		$data['ci_changePage'] 	= $ci_changePage;
		$data['result_id'] 		= $result_id; 
 
		$data['group_id'] 		= $group_id;

		$data['rowgrp'] 		= $this->allmodel->getTableWhere('user_group_table','',0,1,'group_access_id');  
		
		$this->load->library('funcuser'); 
 		if( !$this->funcuser->chkFinanceAccess( $this->session->userdata('ID') ) )  $strAccessType = "Admin"; 
		else $strAccessType = "";
 		$data['strAccessType'] = $strAccessType;
		//$this->session->userdata('GroupID'); 
		//$data['indexData']  = $this->indexData($curpage,$limit,$statusid,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$group_id,$is_member,$is_merchant);
		//$this->load->view('merchant/merchants',$data); 
 
		$data['indexData']  = $this->indexData2($curpage,$limit,$statusid,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id);//,$group_id,$is_member,$is_merchant
		$this->load->view('merchant/merchants_list2.php',$data); 

	}

	function merchant_validation($curpage=1,$limit=10,$statusid=1,$sort="ID",$order="desc",$group_id=0,$ci_ctrl="merchant_manage",$ci_changePage="changepage",$result_id="dspdata"){  

		//--- default is login as USER
		$strAccount = "merchant"; //$group_id = 1; $is_member = 0; $is_merchant = 1;
		
		//echo $this->session->userdata('is_merchant'); exit;
		
		if($this->session->userdata('is_member')) 	{ $strAccount = "member";   $is_member 	 = 1; } //-- login as MEMBER
		if($this->session->userdata('is_merchant'))	{ $strAccount = "merchant"; $is_merchant = 1; } //-- login as MERCHANT  

     	$data['pageTITLE'] 	= ucfirst($strAccount).' Management > '.ucfirst($strAccount).' Validation'; 
     	$data['pageLABEL'] 	= ucfirst($strAccount).' Management > '.ucfirst($strAccount).' Validation';
		$data['navMenu']   	= $this->allfunc->navMenu(4);  
		
		$data['limit'] 		= $limit;
		$data['statusid'] 	= $statusid;
		$data['sort'] 		= $sort;
		$data['order'] 		= $order;
		$data['ci_ctrl'] 	= $ci_ctrl;
		$data['ci_changePage'] = $ci_changePage;
		$data['result_id'] 	= $result_id;

		//$data['indexData']  = $this->indexData($curpage,$limit,$statusid,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$group_id,$is_member,$is_merchant);
		//$this->load->view('merchant/merchants',$data); 
		
		
		$data['indexData']  = $this->indexDataval($curpage,$limit,$statusid,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id);//,$group_id,$is_member,$is_merchant
		$this->load->view('merchant/merchant_validation',$data); 

	}

	function merchant_edit($ID,$edit=0,$error=0,$is_ajax=0,$ajax_parentid=0,$cur_menu=0,$slcmenuid=0){  

   		//echo $ajax_parentid;

		//--- default is login as USER
		$strAccount = "merchant"; $group_id = 0; $is_member = 0; $is_merchant = 1; 
		if($this->session->userdata('is_merchant'))	{ $strAccount = "merchant"; $is_merchant = 1; } //-- login as MERCHANT  

     	$data['pageTITLE'] 	= ucfirst($strAccount).' Management > '.ucfirst($strAccount).'s'; 
     	$data['pageLABEL'] 	= ucfirst($strAccount).' Management > Edit '.ucfirst($strAccount).' Profile';
		$data['navMenu']   	= $this->allfunc->navMenu(4); 
		  
		$data['edit'] 		= $edit; 
		$data['ID'] 		= $ID; 
		
		if(empty($ID)) 
     	$data['pageLABEL'] 	= ucfirst($strAccount).' Management > Add '.ucfirst($strAccount).' '; 
		  
		$qData 				= $this->allmodel->getUserById($ID,'merchant_table');  
		$data['row'] 		= $qData->row_array();
		foreach($qData->row_array() as $key => $val) $$key = $val; 
 
		$data['isAdmin'] 	= 0;
		if($this->session->userdata('AccessType')=='admin') $data['isAdmin'] = 1;
		
		$data['rowgrp'] 	= $this->allmodel->getTableWhere('user_group_table');  
	  										// getTableWhere($tbl='',$key='',$val=0,$status_id=1,$orderby='',$result_key='') { 
 
		$data['StatusID'] = '';
		if(isset($data['row']['AccessID'])) $data['StatusID'] = $data['row']['StatusID'];
		


		//--- Product data
		$qData 		 = $this->allmodel->getMerchantProduct($ID);  
		$data['rowProduct'] = $qData->result_array(); 




		//---------------------------------------------------------------------------------- : LOCATION
		
		$data['TABLE'] 		= 'md_location'; 
		$tbl 				= $data['TABLE'];
		$data['ci_ctrl'] 	= 'merchant_manage';
 		$data['callfunc'] 	= 'merchant_edit'; 
		
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
		
		//exit;
		
		$gData = $this->allmodel->getTableByID($data['TABLE'],$TFCMerchantLocationID);
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
		
		//foreach($arr_loc as $k => $v) echo "$k => $v<br>"; exit;
		
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

		if($have_coun2) $data['coun_idx2'] = $this->getlist_locat_form3(0,$data,$arr_parent[0],$arr_id[0],1); 
		if($have_prov2) $data['prov_idx2'] = $this->getlist_locat_form3(1,$data,$arr_parent[1],$arr_id[1],1);  
		if($have_city2) $data['city_idx2'] = $this->getlist_locat_form3(2,$data,$arr_parent[2],$arr_id[2],1);
		if($have_area2) $data['area_idx2'] = $this->getlist_locat_form3(3,$data,$arr_parent[3],$arr_id[3],1); 
		if($have_venu2) $data['venu_idx2'] = $this->getlist_locat_form3(4,$data,$arr_parent[4],$arr_id[4],1);
 
		//-- add  
		if(!$cur_item_id){  
			$data['coun_idx2'] = $this->getlist_locat_form3(0,$data,$arr_parent[0],0,1); 
			$data['prov_idx2'] = '';	
			$data['city_idx2'] = '';	
			$data['area_idx2'] = '';	
			$data['venu_idx2'] = '';	 
		} 
 
		//---------------------------------------------------------------------------------------------		
		
		
		//--- ajax call output
 
		if($cur_menu && $ajax_parentid > -1){
			if($is_ajax=='1') 
			echo $this->getlist_locat_form($cur_menu,$data,$arr_parent[$cur_menu],$arr_id[$cur_menu],1); 
			elseif($is_ajax=='2') 
			echo $this->getlist_locat_form3($cur_menu,$data,$arr_parent[$cur_menu],$arr_id[$cur_menu],1); 
			
		}
 
		if(empty($is_ajax)) $this->load->view('merchant/merchant_edit',$data); 
 
	}  	
	
	function merchant_edit_validation($ID,$edit=0,$error=0,$is_ajax=0,$ajax_parentid=0,$cur_menu=0,$slcmenuid=0){  

   		//echo $ajax_parentid;

		//--- default is login as USER
		$strAccount = "merchant"; $group_id = 0; $is_member = 0; $is_merchant = 1; 
		if($this->session->userdata('is_merchant'))	{ $strAccount = "merchant"; $is_merchant = 1; } //-- login as MERCHANT  

     	$data['pageTITLE'] 	= ucfirst($strAccount).' Management > '.ucfirst($strAccount).' Validation';
     	$data['pageLABEL'] 	= ucfirst($strAccount).' Management > '.ucfirst($strAccount).' Validation';
		$data['navMenu']   	= $this->allfunc->navMenu(4); 
		  
		$data['edit'] 		= $edit; 
		$data['ID'] 		= $ID; 
		
		if(empty($ID)) 
     	$data['pageLABEL'] 	= ucfirst($strAccount).' Management > Add '.ucfirst($strAccount).' '; 
		  
		$qData 				= $this->allmodel->getUserById($ID,'merchant_table');  
		$data['row'] 		= $qData->row_array();
		foreach($qData->row_array() as $key => $val) $$key = $val; 
 
		$data['isAdmin'] 	= 0;
		if($this->session->userdata('AccessType')=='admin') $data['isAdmin'] = 1;
		
		$data['rowgrp'] 	= $this->allmodel->getTableWhere('user_group_table');  
	  										// getTableWhere($tbl='',$key='',$val=0,$status_id=1,$orderby='',$result_key='') { 
 
		$data['StatusID'] = '';
		if(isset($data['row']['AccessID'])) $data['StatusID'] = $data['row']['StatusID'];
		


		//--- Product data
		$qData 		 = $this->allmodel->getMerchantProduct($ID);  
		$data['rowProduct'] = $qData->result_array(); 




		//---------------------------------------------------------------------------------- : LOCATION
		
		$data['TABLE'] 		= 'md_location'; 
		$tbl 				= $data['TABLE'];
		$data['ci_ctrl'] 	= 'merchant_manage';
 		$data['callfunc'] 	= 'merchant_edit'; 
		
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
		
		//exit;
		
		$gData = $this->allmodel->getTableByID($data['TABLE'],$TFCMerchantLocationID);
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
		
		//foreach($arr_loc as $k => $v) echo "$k => $v<br>"; exit;
		
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

		if($have_coun2) $data['coun_idx2'] = $this->getlist_locat_form3(0,$data,$arr_parent[0],$arr_id[0],1); 
		if($have_prov2) $data['prov_idx2'] = $this->getlist_locat_form3(1,$data,$arr_parent[1],$arr_id[1],1);  
		if($have_city2) $data['city_idx2'] = $this->getlist_locat_form3(2,$data,$arr_parent[2],$arr_id[2],1);
		if($have_area2) $data['area_idx2'] = $this->getlist_locat_form3(3,$data,$arr_parent[3],$arr_id[3],1); 
		if($have_venu2) $data['venu_idx2'] = $this->getlist_locat_form3(4,$data,$arr_parent[4],$arr_id[4],1);
 
		//-- add  
		if(!$cur_item_id){  
			$data['coun_idx2'] = $this->getlist_locat_form3(0,$data,$arr_parent[0],0,1); 
			$data['prov_idx2'] = '';	
			$data['city_idx2'] = '';	
			$data['area_idx2'] = '';	
			$data['venu_idx2'] = '';	 
		} 
 
		//---------------------------------------------------------------------------------------------		
		
		
		//--- ajax call output
 
		if($cur_menu && $ajax_parentid > -1){
			if($is_ajax=='1') 
			echo $this->getlist_locat_form($cur_menu,$data,$arr_parent[$cur_menu],$arr_id[$cur_menu],1); 
			elseif($is_ajax=='2') 
			echo $this->getlist_locat_form3($cur_menu,$data,$arr_parent[$cur_menu],$arr_id[$cur_menu],1); 
			
		}
 
		if(empty($is_ajax)) 
		$this->load->view('merchant/merchant_edit_validation',$data);  
 
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
 
 		if($iCurMenu==0){ $selectname = "coun_id"; $is_ajax	= 1; $resultid = "listloc1"; }
 		if($iCurMenu==1){ $selectname = "prov_id"; $is_ajax	= 2; $resultid = "listloc2"; }
 		if($iCurMenu==2){ $selectname = "city_id"; $is_ajax	= 3; $resultid = "listloc3"; }
 		if($iCurMenu==3){ $selectname = "area_id"; $is_ajax	= 4; $resultid = "listloc4"; }
 		if($iCurMenu==4){ $selectname = "venu_id"; $is_ajax	= 5; $resultid = "listloc5"; } 
 		
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
	
	
	function getlist_locat_form3($iCurMenu,$array,$parentid,$selectid,$edit=0){ 
	
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
 
 		if($iCurMenu==0){ $selectname = "coun_id2"; $is_ajax	= 1; $resultid = "listloc12"; }
 		if($iCurMenu==1){ $selectname = "prov_id2"; $is_ajax	= 2; $resultid = "listloc22"; }
 		if($iCurMenu==2){ $selectname = "city_id2"; $is_ajax	= 3; $resultid = "listloc32"; }
 		if($iCurMenu==3){ $selectname = "area_id2"; $is_ajax	= 4; $resultid = "listloc42"; }
 		if($iCurMenu==4){ $selectname = "venu_id2"; $is_ajax	= 5; $resultid = "listloc52"; } 
 		 
		$res .= '<div style="display:block">';
		$res .= '<select name="'.$selectname.'" id="'.$selectname.'"  onchange="loadcontent_loc3(\''.
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
		$res .= '&nbsp; <input class="bt_formreg"  onclick="popupwindow(\'/master_data/locat_edit/add/'.$selectname.'/'.$parentid.'/'.$selectid.'/member_3\',\'Add Location\',240,185)" type="button" name="add_'.$selectname.'" id="add_'.$selectname.'" value="add" />';
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
 
		$this->allmodel->editStatusIDUser(2,$del_id,'merchant_table');
		
		
		//--create log
		$this->allfunc->createLog('user',$this->session->userdata('ID'),'delete user', 'user_id: '.$del_id);
				 
 
		$data['data']=$this->indexData2($curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_changePage,$result_id);
		$this->load->view('data_view',$data);
		
	}
	
	
	function qedit_usrval(){ 
	
 		if( $_POST['ID'] ){
			foreach($_POST as $key => $value){ 
				/* echo "<br>$key => $value";
				
				ID => 7
				TFCMerchantID => 0210001
				TFCMerchantRegisterDate => 2016-03-24
				TFCMerchantName => m3
				TFCMerchantValidDateBegin => 2016-03-25
				TFCMerchantValidDateEnd => 2017-03-25
				TFCMerchantStatus => VALID
				Submit => Submit
				*/
				$$key = $value; 
			} 
 
			$q = "Update merchant_table Set    
			`Username`			= '".$TFCMerchantID."', 
			`TFCMerchantID`				= '".$TFCMerchantID."', 
			`TFCMerchantValidDateBegin`	= '".$TFCMerchantValidDateBegin."', 
			`TFCMerchantValidDateEnd`	= '".$TFCMerchantValidDateEnd."', 
			`TFCMerchantStatus`			= '".$TFCMerchantStatus."' 
			Where `ID`= '".$ID."' Limit 1";	 
			 
			$this->db->query($q);
			
			//echo str_replace("',","',<br>",$q); exit;
			
			//--create log
			$this->allfunc->createLog('merchant',$this->session->userdata('ID'),'validate merchant', 'merchant_id: '.$ID);
		}
  
		
 		
		echo '<meta http-equiv="Refresh" content="0;URL=/merchant_manage/merchant_validation/" />' ;
		//re_direct('/merchant_manage/merchant_validation/','refresh');
	}  
	
 
	function qedit_usr(){ 
 
		//-- UPLOAD IMGs
		$uFile1 = $uFile2 = $uFile3 = 0;
		$TFCMerchantLogo = $TFCMerchantPhoto = $TFCMerchantMapPhoto = "";
		$c = 0;
		foreach($_FILES as $key => $rowUL){ 
			//echo "<br>$key => $rowUL";
			/*
			uploadMerchantLogo => Array
			uploadMerchantPhoto => Array
			uploadMapPhoto => Array
			*/
 
			if(!empty($rowUL['name'])){ //-- only upload not empty fileform
 
				//foreach($rowUL as $key2 => $value){ //echo "<br>$key => $key2 => $value"; 	
				//}
 
				//---- upload
				$config['upload_path'] 	 = './upload/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']      = '1000';
				$config['max_width'] 	 = '1024';
				$config['max_height'] 	 = '768';
						
				$this->load->library('upload',$config);
		 
				if ( ! $this->upload->do_upload($key))
				{
					$error = array('error' => $this->upload->display_errors());
					foreach($error as $k => $v) echo "<br>$k => $v";
 
					exit;
					//$this->load->view('upload_form', $error);
				} else {
					$data = array('upload_data' => $this->upload->data());
								
					//echo $ccc."<br>";
								
					//foreach($data as $k => $v) 
					//	foreach($v as $k2 => $vv) echo "<br>$k => $k2 => $vv";
									
					/*
					upload_data => file_name => ico-tools6.jpg
					upload_data => file_type => image/jpeg
					upload_data => file_path => D:/_SERVER-TFC/UniServerZ/www/upload/
					upload_data => full_path => D:/_SERVER-TFC/UniServerZ/www/upload/ico-tools6.jpg
					upload_data => raw_name => ico-tools6
					upload_data => orig_name => ico-tools.jpg
					upload_data => file_ext => .jpg
					upload_data => file_size => 6.91
					upload_data => is_image => 1
					upload_data => image_width => 225
					upload_data => image_height => 225
					upload_data => image_type => jpeg
					upload_data => image_size_str => width="225" height="225"
					*/	
								
					//$this->load->view('upload_success', $data);
				} 
			
				if($key=="uploadMerchantLogo") 	{ $uFile1 = 1; $TFCMerchantLogo 	= $config['upload_path'].$data['upload_data']['file_name'];}
				if($key=="uploadMerchantPhoto") { $uFile2 = 1; $TFCMerchantPhoto 	= $config['upload_path'].$data['upload_data']['file_name'];}
				if($key=="uploadMapPhoto")  	{ $uFile3 = 1; $TFCMerchantMapPhoto = $config['upload_path'].$data['upload_data']['file_name'];}
 			
			}
 
 			//$c++:
			
		}
 
/* 
		echo "<br>TFCMerchantLogo: ".$TFCMerchantLogo;
		echo "<br>TFCMerchantPhoto: ".$TFCMerchantPhoto;
		echo "<br>TFCMerchantMapPhoto: ".$TFCMerchantMapPhoto; 
 		exit;
*/
   		$arrAccess = array();
		foreach($_POST as $key => $value){	//echo "<br>$key => $value";
			
			/*
			ContactMediaID => Array
			ContactMediaData => Array
			SocialMediaData => Array
			SocialMediaID => Array
			*/
			
			if(substr($key,0,4)=="Prev"){  //echo "<br>$key => $value"; 
				if($value) array_push($arrAccess,$value) ;
			}else{
				//if(is_array($value)) $$key = implode(",",$value); 
				
				//-- if value is array
				if(is_array($value)){
				
					if(
					$key=="ContactMediaID"||$key=="ContactMediaData"||$key=="SocialMediaData"||$key=="SocialMediaID"||
					$key=="TFCMerchantContactMediaID"||$key=="TFCMerchantContactMediaData"||$key=="TFCMerchantSocialMediaData"||$key=="TFCMerchantSocialMediaID"
					){
						$$key = $value;
						//echo "<br>$key => $value"; 
					}
 
				} elseif($key=="TFCMerchantOpen"){ 
					//$$key = nl2br($value);
					$$key = $value;
					//echo "<br>$key => ".nl2br($value);
				} else {
					$$key = $value;
					//echo "<br>$key => $value"; 
				}
				
			} 
		}
 
		//if($key=="ContactMediaID"||$key=="ContactMediaData"||$key=="SocialMediaData"||$key=="SocialMediaID"){
		
		//-- count md_data
		 
		//$qetMDContactMedia = $this->allmodel->getMDdata('md_contact_media');
		//echo count($qetMDContactMedia);
		
		//foreach($qetMDContactMedia  as $key => $row) { 
			//foreach($row  as $key2 => $value) { //echo "<br>$key => $key2 => $value";
				/*
				1 => id => 3
				1 => name => WA
				1 => description =>
				1 => status_id => 1
				2 => id => 4
				*/
			//}
			
			//$chkID = '';
			//$chkDt = '']; 
		//} 
		//exit;
 
		//-- SOCIAL MEDIA
		
		//`SocialMediaID`		= '".$SocialMediaID."',
		//`SocialMediaData`	= '".$SocialMediaData."',
 
		$arrID = array();
		$arrDT = array(); 
		foreach($ContactMediaID as $key => $value){ 
			 array_push($arrID,$key);  
			 array_push($arrDT,$ContactMediaData[$key]);  
		}  
		//foreach($ContactMediaID as $key => $value) echo "<br>$key => $value";  
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
 
 		//`TFCMerchantContactMediaID`	= '".$ID."',
 		//`TFCMerchantContactMediaData`	= '".$ID."',
			
		$arrID2 = array();
		$arrDT2 = array(); 
		foreach($TFCMerchantContactMediaID as $key => $value){ 
			 array_push($arrID2,$key);  
			 array_push($arrDT2,$TFCMerchantContactMediaData[$key]);  
		}   
		$TFCMerchantContactMediaID 	= implode(",",$arrID2); 
		$TFCMerchantContactMediaData 	= trim(implode(",",$arrDT2));
		
		$arrID2 = array();
		$arrDT2 = array();
		foreach($TFCMerchantSocialMediaID as $key => $value){ 
			 array_push($arrID2,$key);  
			 array_push($arrDT2,$TFCMerchantSocialMediaData[$key]);  
		}  
		$TFCMerchantSocialMediaID 		= implode(",",$arrID2); 
		$TFCMerchantSocialMediaData 	= trim(implode(",",$arrDT2)); 	
 
		//-- GenderID 
/*		//--- Submit Privileges
		if(isset($_POST['SubmitAccess'])){
			 
			//ID => 15
			//curGroupID => 4
			//chgGroupID => 4
			//Prev-1 => 0
			//Prev-12 => 0
			//Prev-13 => 0
			//SubmitAccess => Update Privileges
				 
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
			 
//			redirect('/member_manage/user_edit/'.$ID,'refresh');
			
			exit;  
			
		}
*/		
 
 
 
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

		//$TFCMerchantRegisterDate   = $datepicker;
//		$TFCMerchantValidDateBegin = $datepicker2;
//		$TFCMerchantValidDateEnd   = $datepicker3;
			
 
		if(empty($_POST['ID'])){
		
			//foreach($_POST as $key => $value)  echo "<br>$key => $value"; exit;

 			$Password 	 = '1234'; //-- first time password 
			$CreatedDate = date('Y-m-d H:i:s');
			$CreatedBy 	 = $this->session->userdata('ID'); 
 			$StatusID 	 = 1;
			$TFCMerchantStatus = "REGISTER";
			
			/*
			ID =>
			TFCMerchantAE => ae3
			TFCMerchantRegisterDate => 2016-03-24
			TFCMerchantName => m3
			TFCMerchantCategoryID => 2
			TFCMerchantStatus => REGISTER
			TFCMerchantTypeID => 2
			TFCMerchantAcceptCardID => 2
			Submit => Submit
			*/
 
			 $q = " INSERT INTO `merchant_table` 
				(
				`ID`, `Password`, `CreatedDate`, `CreatedBy`, `StatusID`, `GroupID`,  
				`TFCMerchantName`, `TFCMerchantStatus`, `TFCMerchantAE`, 
				`TFCMerchantCategoryID`, `TFCMerchantAcceptCardID`, `TFCMerchantRegisterDate` 
				) 
				VALUES 
				(
				NULL, '".md5($Password)."','".$CreatedDate."','".$CreatedBy."', '".$StatusID."', '".$GroupID."', 
				'".$TFCMerchantName."', '".$TFCMerchantStatus."', '".$TFCMerchantAE."', 
				'".$TFCMerchantCategoryID."', '".$TFCMerchantAcceptCardID."', '".$TFCMerchantRegisterDate."' 
				)
				";
 
			$this->db->query($q);
			$uid = mysql_insert_id();
 
			//--create log
			$this->allfunc->createLog('merchant',$this->session->userdata('ID'),'create merchant', 'merchant_id: '.$uid);
 
		}else{
 
			//-- delete image
			
			//foreach($_POST as $key => $val){ 
				//echo "<br>$key => $val";
				//delimage => DELETE-LOGO
				//delimage => DELETE-PHOTO
				//delimage => DELETE-MAPPHOTO 
			//}
 			if(isset($_POST['delimage'])){
				if($_POST['delimage']=="DELETE-LOGO"){
					//-- del img:
					$fndel = $_SERVER['DOCUMENT_ROOT'].substr($_POST['img_logo'],1,strlen($_POST['img_logo']));
					if(!unlink($fndel)) echo "delete file : ".$_POST['img_logo']." Failed."; 
					$uFile1 = 1; $TFCMerchantLogo = ''; 
				} 
				if($_POST['delimage']=="DELETE-PHOTO"){
					//-- del img:
					$fndel = $_SERVER['DOCUMENT_ROOT'].substr($_POST['img_photo'],1,strlen($_POST['img_photo']));
					if(!unlink($fndel)) echo "delete file : ".$_POST['img_photo']." Failed."; 
					$uFile2 = 1; $TFCMerchantPhoto = ''; 
				} 
				if($_POST['delimage']=="DELETE-MAPPHOTO"){
					//-- del img:
					$fndel = $_SERVER['DOCUMENT_ROOT'].substr($_POST['img_mapphoto'],1,strlen($_POST['img_mapphoto']));
					if(!unlink($fndel)) echo "delete file : ".$_POST['img_mapphoto']." Failed."; 
					$uFile3 = 1; $TFCMerchantMapPhoto = ''; 
				} 
				 
			 }


			$q = "Update merchant_table Set 
 
			`TitleName`			= '".$TitleName."',
			`FullName`			= '".$FullName."', 
			`BirthPlace`		= '".$BirthPlace."',
			`BirthDate`			= '".$BirthDate."',  
			`ReligionID`		= '".$ReligionID."',  
			`MaritalStatusID`	= '".$MaritalStatusID."', 
			
			
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
			`Address`			= '".$Address."', "; 
			
			if($LocationID!=-1)
			$q .= "
			`LocationID`		= '".$LocationID."',";  
			
			$q .= " 
			`PostCode`			= '".$PostCode."', 
			`Phone`				= '".$Phone."', 
			`Mobile`			= '".$ID."',  
			`CommentText`		= '".$CommentText."',
 
			`TFCMerchantPIC`			= '".$TFCMerchantPIC."', 
			`TFCMerchantAE`				= '".$TFCMerchantAE."',  
			`TFCMerchantName`			= '".$TFCMerchantName."', 
			";
			
			if($uFile1) $q .= "
			`TFCMerchantLogo`			= '".$TFCMerchantLogo."', "; 
			
			if($uFile2) $q .= "
			`TFCMerchantPhoto`			= '".$TFCMerchantPhoto."', ";
			
			if($uFile3) $q .= "
			`TFCMerchantMapPhoto`		= '".$TFCMerchantMapPhoto."', ";    

			
			
			//`TFCMerchantStatus`			= '".$TFCMerchantStatus."',
			$q .= "
			
			`TFCMerchantAcceptCardID`	= '".$TFCMerchantAcceptCardID."', 

			`TFCMerchantCategoryID`		= '".$TFCMerchantCategoryID."', 
			`TFCMerchantTypeID`			= '".$TFCMerchantTypeID."', 
			
			`TFCMerchantOpen`			= '".$TFCMerchantOpen."',
			`TFCMerchantAddress`		= '".$TFCMerchantAddress."', "; 
			
			if($TFCMerchantLocationID!=-1)
			$q .= "
			`TFCMerchantLocationID`		= '".$TFCMerchantLocationID."',";  
			
			$q .= "
			`TFCMerchantPostCode`		= '".$TFCMerchantPostCode."',
			`TFCMerchantPhone`			= '".$TFCMerchantPhone."',
			`TFCMerchantEmail`			= '".$TFCMerchantEmail."',
			`TFCMerchantFax`			= '".$TFCMerchantFax."',
			`TFCMerchantWebsite`		= '".$TFCMerchantWebsite."',
			 
 			`TFCMerchantContactMediaID`		= '".$TFCMerchantContactMediaID."',
 			`TFCMerchantContactMediaData`	= '".$TFCMerchantContactMediaData."',
 			`TFCMerchantSocialMediaID`		= '".$TFCMerchantSocialMediaID."',  
 			`TFCMerchantSocialMediaData`	= '".$TFCMerchantSocialMediaData."', "; 
			
			if(isset($_POST['TFCMerchantValidDateBegin']))
			$q .= " 
			`TFCMerchantValidDateBegin`	= '".$TFCMerchantValidDateBegin."', 
			`TFCMerchantValidDateEnd`	= '".$TFCMerchantValidDateEnd."', ";
			
			$q .= " 
			`TFCMerchantMapGeo`		= '".$TFCMerchantMapGeo."',  
			`TFCMerchantMapLabel`	= '".$TFCMerchantMapLabel."',   
			`TFCMerchantMapDesc`	= '".$TFCMerchantMapDesc."'  
 
			Where `ID`= '".$ID."' Limit 1";	 
			/*
			`TFCMerchantID`				= '".$TFCMerchantID."', 
			`TFCMerchantRegisterDate`	= '".$TFCMerchantRegisterDate."', 
			`TFCMerchantValidDateBegin`	= '".$TFCMerchantValidDateBegin."', 
			`TFCMerchantValidDateEnd`	= '".$TFCMerchantValidDateEnd."', 
			*/
			
			//echo "<br><hr><br>".str_replace(",","<br>",$q); exit;
			
			$this->db->query($q);
//			exit;
			//echo str_replace("',","',<br>",$q); exit;
			
			//--create log
//			$this->allfunc->createLog('mnerchant',$this->session->userdata('ID'),'edit merchant', 'mnerchant_id: '.$ID);
		}
		
		
		//-- add PRODUCT 
		
		if(is_array($_POST['product_name'])){
			//product_name => Array
			//product_value => Array
			//product_term => Array
			
			foreach($_POST['product_name'] as $key => $value){ 
			
				//echo "<br>$key => $value";
				//echo "<br>$key => ".$_POST['product_value'][$key];
				//echo "<br>$key => ".$_POST['product_term'][$key];
				
				//--- if $value = empty -> delete
 
				if(empty($value)){
				
					$this->db->query("DELETE from db_merchant_product Where id = '".$key."' Limit 1");
 
					
				} else {
					
					$q = "Select 1 from db_merchant_product Where id = '".$key."' Limit 1";
					
					$qdata = $this->db->query($q);
					
					$chk = $qdata->num_rows(); 
		 
					if(empty($chk)){ //-- INSERT
					
						$this->db->query(" INSERT INTO `db_merchant_product` (
						`id`, `merchant_id`, `merchant_category`, `merchant_type`, `product_name`, `product_value`, `product_periode`, `product_credit`, `product_term`, 
						`modified_date`, `modified_by`, `status_id`) 
						VALUES (
						NULL, '".$ID."', '".$_POST['TFCMerchantCategoryID']."', '".$_POST['merchant_type'][$key]."', '".$value."', '".$_POST['product_value'][$key]."', '".$_POST['product_periode'][$key]."', '".$_POST['product_credit'][$key]."', '".$_POST['product_term'][$key]."', 
						'".date('Y-m-d H:i:s')."', '".$this->session->userdata('ID')."', '1')  
						");
					
					} else { //-- UPDATE
						$this->db->query(" UPDATE  `db_merchant_product` SET 
						`merchant_id` 		= '".$ID."' , 
						`merchant_category` = '".$_POST['TFCMerchantCategoryID']."' , 
						`merchant_type`		= '".$_POST['merchant_type'][$key]."' ,
						`product_name` 		= '".$value."' , 
						`product_value` 	= '".$_POST['product_value'][$key]."' , 
						`product_periode` 	= '".$_POST['product_periode'][$key]."' , 
						`product_credit` 	= '".$_POST['product_credit'][$key]."' , 
						`product_term` 		= '".$_POST['product_term'][$key]."' , 
						`modified_date` 	= '".date('Y-m-d H:i:s')."' , 
						`modified_by` 		= '".$this->session->userdata('ID')."' 
						WHERE  `id` = '".$key."' "); 
					
					}

				}

			}

		}


		if(empty($_POST['ID'])) $ID = mysql_insert_id()."/add";
		if(isset($uid)) $ID = $uid."/add";

 		
		echo '<meta http-equiv="Refresh" content="0;URL=/merchant_manage/merchant_edit/'.$ID.'" />' ;
		//re_direct('/merchant_manage/merchant_edit/'.$ID,'refresh');

	}  
 
	  
	  
	function indexData2($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id){ 
 
		//---
		$part_url = "merchants"; //$tbl = "merchant_table"; 

		//echo $part_url; exit;
		
		if($order=="asc") $orderO="desc";
		elseif($order=="desc") $orderO="asc";
		 
		$content=$disableAll='';
		
		$start=($curpage*$limit)-$limit;
  
		if($start >= 0){
  
			$qData=$this->allmodel->selectUser($start,$limit,$status_id,$sort,$order,$group_id,"merchant_table"); 
 
			//foreach($qData->result_array() as $k => $v) echo "<br>$k => $v"; exit;
 
			if($qData->num_rows()){ 
				$col1 = "#ffffff";
				$col2 = "#f6f6f6";
				$col3 = "#FFDDFF";
				
				//$this->allfunc->isAdmin();
				 
				if($this->session->userdata('AccessType')=='admin') $disableAll = ''; 
				if($this->session->userdata('AccessType')=='user')  $disableAll = ' disabled="disabled" '; 
				 
				 $content.=
						'<table  border="0" cellpadding="5" cellspacing="1" bgcolor="#bbbbbb">
						<thead>
							<tr bgcolor="#666666" class="">
							  <td align="center" class="lightgrey">No.</td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/GroupID/'.$orderO.'/'.$group_id.'\')">Branch</a></td>
							  <td colspan="2" >
							  	Order By: 
								<a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCMerchantID/'.$orderO.'/'.$group_id.'\')">Merchant ID</a> | 
							  	<a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCMerchantName/'.$orderO.'/'.$group_id.'\')">Merchant Name</a> | 
							  	<a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCMerchantValidDateBegin/'.$orderO.'/'.$group_id.'\')">ValidDateBegin</a> |  
							  	<a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCMerchantValidDateEnd/'.$orderO.'/'.$group_id.'\')">ValidDateEnd</a> | 
							  	<a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCMerchantStatus/'.$orderO.'/'.$group_id.'\')">Status</a>
							  </td>   
							  <td align="center" class="lightgrey">Edit</td>
							</tr>
						</thead>
						<tbody>';
 
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
					
					if( $row['AccessType']=='user') 	 $strAccessType =  "User";
					elseif( $row['AccessType']=='admin') $strAccessType =  "Administrator";
					
					$getGroup = $this->allmodel->getTableByID('user_group_table',$row['GroupID']);
					
					//echo $getGroup['group'];
					
					if(empty($getGroup['group']))  $strGroupID =  "";
					else $strGroupID = $getGroup['group'];
					
					$content.='<tr bgcolor="'.$clr.'">
					  <td align="right" valign="top" style="padding-top:14px;">'.$x.'.&nbsp;</td>
					  <td align="left"  valign="top" style="padding-top:14px;">'.$strGroupID.'</td>
					  <td valign="top">
						<table border="0" cellpadding="4" cellspacing="0">
							<tr>
							  <td colspan="4"><span class="size20">'.$row['TFCMerchantName'].'</span></td> 
							</tr> 
							<tr>
							  <td rowspan="4" valign="top"><img src="'.substr($row['TFCMerchantLogo'],1,strlen($row['TFCMerchantLogo'])).'" width="100"  /></td>
							  <td>Merchant ID</td>
							  <td>:</td>
							  <td width="100%" ><strong>'.$row['TFCMerchantID'].'</strong></td>
							</tr> 
							<tr>
							  <td>Valid Date</td>
							  <td>:</td>
							  <td>'.$row['TFCMerchantValidDateBegin'].'</td>
							</tr>
							<tr>
							  <td>Valid Thru</td>
							  <td>:</td>
							  <td>'.$row['TFCMerchantValidDateEnd'].'</td>
							</tr>
							<tr>
							  <td>STATUS</td>
							  <td>:</td>
							  <td><span class="size18 red">'.$row['TFCMerchantStatus'].'</span></td>
							</tr>
							<tr> 
							  <td colspan="4"><div class="merchant_address">'.$row['TFCMerchantAddress'].'</div></td>
							</tr>
                      	</table>';
					  
					$content.='
					<td valign="top">';
					
					
					$content .=' Products/Services: 	
						<table border="0" cellpadding="4" cellspacing="0">';
						
					
					$qPrd =  "Select * from db_merchant_product Where merchant_id = '".$row['ID']."' And status_id = 1"; 
					$qPrddata = $this->db->query($qPrd); 
					$chk = $qPrddata->num_rows();  
					
					$p=1;
					if(!empty($chk))
					foreach($qPrddata->result_array() as $rowPrd){  
					
						if($rowPrd['product_periode']=="dy") $strPeriode = "day";
						if($rowPrd['product_periode']=="mo") $strPeriode = "month";
						if($rowPrd['product_periode']=="yr") $strPeriode = "year";
						
						if(strlen(trim($rowPrd['product_term']))>0) $strTerm = " Term : ".$rowPrd['product_term']; 
						else $strTerm = "";
						
						$content .=' 
								  <tr>
									<td bgcolor="#BEDCF1" nowrap="nowrap" align="right">'.$p.'.</td>
									<td bgcolor="#BEDCF1" nowrap="nowrap" colspan="2"  width="100%">'.$rowPrd['product_name'].'</td>  
								  </tr> 
								  
								  <tr bgcolor="#eeeeee">
									<td rowspan="" align="right"></td>
									<td> -> Valid : '.$rowPrd['product_value'].' / '.$strPeriode.' </td> 
									<td> '.$strTerm.'</td>
								  </tr>  
								 ';
						$p++;			
					}				
						
					$content .=' 
						</table>';
					
					
					
					$content.='</td>';
					
					$content.='
					<td align="center">';
					  
					//if($this->session->userdata('ID')==1 || $this->session->userdata('ID')==2 || $this->session->userdata('ID')==$row['ID'] || $this->session->userdata('AccessType')=='admin' || $strAccessType=="Admin")   
					
					$disable = '';
					$content.='<input '.$disable.' type="button" name="EDIT" value="EDIT" onclick="window.location.assign(\''.base_url().$ci_ctrl.'/merchant_edit/'.$row['ID'].'\')"/>';
					
					$content.='<br><br>';
					
					//if($this->session->userdata('ID')==1 || $this->session->userdata('AccessType')=='admin'){  
						$content.='<input type="submit" name="DEL" value="DEL" onclick="confirmdelete(\''.base_url().$ci_ctrl.'/user_delete/'.$row['ID'].'/'.$curpage.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$group_id.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'\',\''.$result_id.'\')"/>';
					//}  
					$content.='</td>'; 
					$content.='</tr>'; 
					$x++;
				}	
			}
		}
		$content.='</tbody>';
		$content.='</table>';		
		
		$content.=$this->pagenav2($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id);
		
		return $content;
	}	  
	  
	  
	function indexDataval($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id,$group_id=0,$is_member=0,$is_merchant=0){ 
 
		$part_url = "merchant_validation"; $tbl = "merchant_table"; 
 
		//echo $part_url; exit;
		
		if($order=="asc") $orderO="desc";
		elseif($order=="desc") $orderO="asc";
		 
		$content=$disableAll='';
		
		$start=($curpage*$limit)-$limit;
  
		if($start >= 0){

			$qData=$this->allmodel->selectUser($start,$limit,$status_id,$sort,$order,$group_id,$tbl); 
 
			//foreach($qData->result_array() as $k => $v) echo "<br>$k => $v"; exit;
 
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
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/GroupID/'.$orderO.'\')">Branch</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCMerchantID/'.$orderO.'\')">Merchant ID</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCMerchantName/'.$orderO.'\')">Merchant Name</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCMerchantRegisterDate/'.$orderO.'\')">RegisterDate</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCMerchantValidDateBegin/'.$orderO.'\')">ValidDateBegin</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCMerchantValidDateEnd/'.$orderO.'\')">ValidDateEnd</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCMerchantStatus/'.$orderO.'\')">Status</a></td>
							  <td align="" class="lightgrey" >Validate</td> 
							</tr> 
						</thead>
						<tbody>';
 
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
					
					if( $row['AccessType']=='user') 	 $strAccessType =  "User";
					elseif( $row['AccessType']=='admin') $strAccessType =  "Administrator";
					
					$getGroup = $this->allmodel->getTableByID('user_group_table',$row['GroupID']);
					
					//echo $getGroup['group'];
					
					if(empty($getGroup['group']))  $strGroupID =  "";
					else $strGroupID = $getGroup['group'];
					
					$content.='<tr bgcolor="'.$clr.'">
					  <td align="right">'.$x.'.&nbsp;</td>
					  <td>'.$strGroupID.'</td> 
					  <td>'.$row['TFCMerchantID'].'</td>
					  <td>'.$row['TFCMerchantName'].'</td>
					  <td>'.$row['TFCMerchantRegisterDate'].'</td>
					  <td>'.$row['TFCMerchantValidDateBegin'].'</td>
					  <td>'.$row['TFCMerchantValidDateEnd'].'</td>
					  <td>'.$row['TFCMerchantStatus'].'</td>
					  <td>';
					  
					//if($this->session->userdata('ID')==1 || $this->session->userdata('ID')==2 || $this->session->userdata('ID')==$row['ID'] || $this->session->userdata('AccessType')=='admin')   
					//if($this->session->userdata('ID')==1 || $this->session->userdata('AccessType')=='admin')   
					$shoButVal = 0;
					if($row['TFCMerchantStatus']=="VALID"&&($this->session->userdata('ID')==1||$this->session->userdata('AccessType')=='admin')) $shoButVal = 1;
					if($row['TFCMerchantStatus']=="REGISTER"||$this->session->userdata('ID')==1||$this->session->userdata('AccessType')=='admin') $shoButVal = 1;
					if($row['TFCMerchantStatus']=="EXPIRED"||$this->session->userdata('ID')==1||$this->session->userdata('AccessType')=='admin') $shoButVal = 1;
					
					if($shoButVal)
					$content.='<input type="button" name="VALIDATE" value="VALIDATE" onclick="window.location.assign(\''.base_url().$ci_ctrl.'/merchant_edit_validation/'.$row['ID'].'\')"/>';
  
					$content.='</td>'; 
					$content.='</tr>'; 
					$x++;
				}	
			}
		}
		$content.='</tbody>';
		$content.='</table>';		
		
		$content.=$this->pagenav($curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_changePage,$result_id);
		
		return $content;
	} 	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	
	//function indexData($curpage,$limit,$status_id,$sort="CreatedDate",$order="desc",$ci_ctrl="member_manage",$ci_changePage="changepage",$result_id="dspdata"){ 
	function indexData($curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$group_id=0,$is_member=0,$is_merchant=0){ 
 
		//---
		$part_url = "merchant"; $tbl = "merchant_table";
		//if($is_member) { $part_url = "members";  $tbl = "member_table";}
		//if($is_merchant) { $part_url = "merchant"; $tbl = "merchant_table";}
		
 
		//echo $part_url; exit;
		
		if($order=="asc") $orderO="desc";
		elseif($order=="desc") $orderO="asc";
		 
		$content=$disableAll='';
		
		$start=($curpage*$limit)-$limit;
  
		if($start >= 0){

			$qData=$this->allmodel->selectUser($start,$limit,$status_id,$sort,$order,$tbl); 
 
			//foreach($qData->result_array() as $k => $v) echo "<br>$k => $v"; exit;
 
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
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/GroupID/'.$orderO.'\')">Branch</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCMerchantID/'.$orderO.'\')">Merchant ID</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCMerchantName/'.$orderO.'\')">Merchant Name</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/Email/'.$orderO.'\')">Email</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/AccessType/'.$orderO.'\')">Access</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/SigninLog/'.$orderO.'\')">Last-Login</a></td>
							  <td><a class="lightgrey underline" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$part_url.'/1/'.$limit.'/'.$status_id.'/TFCStatus/'.$orderO.'\')">Status</a></td>
							  <td align="" class="lightgrey" >Edit</td> 
							  <td align="" class="lightgrey" >Delete</td>  
							</tr>
						</thead>
						<tbody>';
 
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
					
					if( $row['AccessType']=='user') 	 $strAccessType =  "User";
					elseif( $row['AccessType']=='admin') $strAccessType =  "Administrator";
					
					$getGroup = $this->allmodel->getTableByID('user_group_table',$row['GroupID']);
					
					//echo $getGroup['group'];
					
					if(empty($getGroup['group']))  $strGroupID =  "";
					else $strGroupID = $getGroup['group'];
					
					$content.='<tr bgcolor="'.$clr.'">
					  <td align="right">'.$x.'.&nbsp;</td>
					  <td>'.$strGroupID.'</td>
					  <td>'.$row['TFCMerchantID'].'</td>
					  <td>'.$row['TFCMerchantName'].'</td>
					  <td>'.$row['Email'].'</td>
					  <td>'.$strAccessType.'</td>
					  <td nowrap="nowrap">'.$fdatetime.'</td>
					  <td>'.$row['TFCMerchantStatus'].'</td>
					  <td>';
					  
					if($this->session->userdata('ID')==1 || $this->session->userdata('ID')==2 || $this->session->userdata('ID')==$row['ID'] || $this->session->userdata('AccessType')=='admin')   
					$content.='<input '.$disable.' type="button" name="EDIT" value="EDIT" onclick="window.location.assign(\''.base_url().$ci_ctrl.'/merchant_edit/'.$row['ID'].'\')"/>';
					
					$content.='</td>';
					$content.='<td>';
					
					if($this->session->userdata('ID')==1 || $this->session->userdata('ID')==2 || $this->session->userdata('AccessType')=='admin'){   
					
						if($status_id!=2) 
						$content.='<input '.$disable2.' type="submit" name="DEL" value="DEL" onclick="confirmdelete(\''.base_url().$ci_ctrl.'/user_delete/'.$row['ID'].'/'.$curpage.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'\',\''.$result_id.'\')"/>';
					}
					
					
					$content.='</td>'; 
					$content.='</tr>'; 
					$x++;
				}	
			}
		}
		$content.='</tbody>';
		$content.='</table>';		
		
		//$content.=$this->pagenav($curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_changePage,$result_id);
		
		return $content;
	} 
	
	function pagenav($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id){
	
		//$cData=$this->allmodel->countUser($status_id); 
		$cData=$this->allmodel->countUser($status_id,'merchant_table',$group_id); 
		
		$var='<div class="pagenave">';
		if($cData->num_rows()){
			$tempData=$cData->result_array();
			$totalData=$tempData[0]['count'];
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
				$var.='<a href="javascript:void(0);loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/'.$prev.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'\',\''.$result_id.'\')"><img src="/asset/icons/arrow_left.gif" width="16" height="16" />prev</a>';
				$var.='&nbsp; &nbsp;'; 
				$var.='<a href="javascript:void(0);loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/'.$next.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'\',\''.$result_id.'\')">next<img src="/asset/icons/arrow_right.gif" width="16" height="16" /></a>';
				$var.='&nbsp; &nbsp;'; 
			
			$var.='		</td>';
				
			$var.='		<td width="100%" nowrap="nowrap" >';
							$var.='&nbsp; &nbsp;Page: <select name="page" id="page" onchange="loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/\'+$(this).val()+\'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'\',\''.$result_id.'\')">'; 
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
				$var.='Show <select name="view" id="view" onchange="loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/1/\'+$(this).val()+\'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'\',\''.$result_id.'\')" >';
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
	
	function pagenav2($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id){
	
		//$cData=$this->allmodel->countUser($status_id); 
		$cData=$this->allmodel->countUser($status_id,'merchant_table',$group_id); 
		
		$var='<div class="pagenave">';
		if($cData->num_rows()){
			$tempData=$cData->result_array();
			$totalData=$tempData[0]['count'];
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
	
	function changepage($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id){	 
		$data['data']=$this->indexData2($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id);
		$this->load->view('data_view',$data);
	} 
	
	function changepage2($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id){	 
		$data['data']=$this->indexData2($curpage,$limit,$status_id,$sort,$order,$group_id,$ci_ctrl,$ci_changePage,$result_id);
		$this->load->view('data_view',$data);
	} 
}
