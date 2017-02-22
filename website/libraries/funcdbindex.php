<?php 
 if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Funcdbindex extends Allmodel{ 

  	function Allfunc(){    
    	parent::Allmodel();     
  	} 
    
	//----- index database table --------------------------------
	
	function listmenu2table($tbl,$status_id=1,$mode=0,$slcid=0){ 
		
		$qData = $this->allmodel->getListLocDesc($tbl,$status_id,$mode,$slcid);
		 
		$arr = $arr_ids = array(); 
		if($qData->num_rows()){  
 
			$arrResult = $qData->result_array() ;
			foreach($arrResult as $k => $row){
 
				$cur_item_id 		= $arrResult[$k]['id'];	
				$cur_item_loc_id 	= $arrResult[$k]['loc'];
				$cur_item_parent_id = $arrResult[$k]['parent_id'];	 
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
						if(count($arr_parent)==5) $cur_item_cat = 'venue'; //echo "is_venue<br>"; 
						if(count($arr_parent)==4) $cur_item_cat = 'area'; //echo "is_area<br>"; 
						if(count($arr_parent)==3) $cur_item_cat = 'city'; //echo "is_city<br>"; 
						if(count($arr_parent)==2) $cur_item_cat = 'province'; // echo "is_province<br>";
						if(count($arr_parent)==1) $cur_item_cat = 'country'; //echo "is_country<br>";
 
						//if(count($arr_parent)==0) echo "is_add_new<br>";
						  
				$cur_item_id 		= $arrResult[$k]['id'];	
				$cur_item_loc_id 	= $arrResult[$k]['loc'];
				$cur_item_parent_id = $arrResult[$k]['parent_id'];	
 
				$arr[$k]['id'] 		  = $cur_item_id;
				$arr[$k]['loc_name']  = $cur_item_loc_id; 
				$arr[$k]['loc_cat']   = $cur_item_cat;
				
				//-- mode 1
				if(count($arr_parent)==5) array_push($arr_ids,$cur_item_id);
						 
			}
		}
		
		if($mode==0) return $arr;
		elseif($mode==1) return $arr_ids;
		elseif($mode==2) return $cur_item_cat;

		exit;
		
	}
		
	function hiddenfields($varKey){ 
		$arrhide = array(
		'id','status_id','location_id','owner_id','parent_id',
		'lineage','link','note','status','area','province','country','video_id',
		'suplier_db','trx_code_id' 
		);
		$res = 0;
		foreach($arrhide as $k => $v) if($v==$varKey)$res = 1;
		return $res; 
	} 
	function hiddenfieldsedit($varKey){
		$arrhide = array('online_status','area','city','province','country','modified_date','modified_by');
		$res = 0;
		foreach($arrhide as $k => $v) if($v==$varKey)$res = 1;
		return $res; 
	} 
	function showfieldseditproduct($varKey){
		$arrhide = array('IP','terminal_ID','product_id','group_access_id');
		$res = 0;
		foreach($arrhide as $k => $v) if($v==$varKey)$res = 1;
		return $res; 
	}
	function str_changetext($strTxt){
		$strTxt = str_replace("IP","terminal-IP",$strTxt);
		$strTxt = str_replace("suplier_id","Suplier",$strTxt);
		$strTxt = str_replace("terminal_id","terminal_ID",$strTxt);
		$strTxt = str_replace("terminal_ID","terminal-ID",$strTxt);
		//$strTxt = str_replace("terminal_","",$strTxt);
		$strTxt = str_replace("product_id","product",$strTxt);
		$strTxt = str_replace("group_access_id","group access",$strTxt);
		$strTxt = str_replace("group_id","group access",$strTxt);
		$strTxt = str_replace("_"," ",$strTxt);
		$strTxt = ucwords($strTxt); 
		return $strTxt;
	} 
 
	function indexDataTable($ci_ctrl='',$ci_func='',$TABLE='',$curpage=1,$limit=10,$status_id=1,$sort='id',
		$order='desc',$ci_changePage='changepage',$result_id='dspdata',$type=0,$where='',$is_pop=''){ 
		
		$ci_ctrl = strtolower($ci_ctrl); 
 
		if($order=="asc") 		$orderO="desc";
		elseif($order=="desc") 	$orderO="asc"; 
		
		$content=$disableAll=''; 
		$start=($curpage*$limit)-$limit; 

		//-- get table keys
 
		$arr_fields = $this->allmodel->getTableKeys($TABLE); 
		//foreach( $arr_fields as $key => $value){  echo "<br>$key ===> $value"; } exit;
		//$arr_fields = array('id','datetime','ip','vm','type','refid','txid','msg','xdata','response_status','string_request'); 
 
 		
 
		$qData=$this->allmodel->selectIndexTable($start,$limit,$status_id,$sort,$order,$TABLE,$where);
 
		if($qData->num_rows()){ 
			$col1 = "#ffffff";
			$col2 = "#f6f6f6";
			//$col3 = "#FFDDFF"; 
			//if($this->session->userdata('AccessType')=='admin') $disableAll = ''; 
			//if($this->session->userdata('AccessType')=='user')  $disableAll = ' disabled="disabled" '; 
			$disable= ''; 
 
			$content.=
				'<table id="tableindex" width="" border="0" cellpadding="5" cellspacing="1" bgcolor="#bbbbbb">
				   <thead>
					  <tr bgcolor="#666666">
					    <td align="center" class="lightgrey">No.</td>';

			foreach($arr_fields as $k => $varKey){ //echo "<br>$k => $varKey";
							
				$alignr = '';
				if($varKey=='string_request')
				$alignr = ' align="right" '; 
				
				$varKeyLbl = $this->str_changetext($varKey);  

				if(!$this->hiddenfields($varKey)){
			
					$ico_arrow=""; 
					if($order=="asc"&&$varKey==$sort)  		$ico_arrow = "s_asc";
					elseif($order=="desc"&&$varKey==$sort) 	$ico_arrow = "s_desc";

			 		//echo $sort_arrow; 
					if($is_pop!=2)
					$content .='<td'.$alignr.' nowrap="nowrap"><span class="tblhead"><a class="lightgrey" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$ci_func.'/1/'.$limit.'/'.$status_id.'/'.$varKey.'/'.$orderO.'\')">'.$varKeyLbl.'</a></span><span class="'.$ico_arrow.'"></span></td>';
					else
					$content .='<td'.$alignr.' class="lightgrey">'.$varKeyLbl.'</td>';
 
				}	
			}
			
 			if($is_pop!=2)
			$content.=' <td align="center" class="lightgrey">Edit</td>';
			
			$content.='</tr>
					</thead>'; 
			$content.='
					<tbody>';
				  
			$x=$start+1;
			foreach($qData->result_array() as $row){
					$n = fmod($x,2); 
					if($n) $clr = $col1;
					else   $clr = $col2;
					 
					$content.='
					<tr bgcolor="'.$clr.'"> 
					  <td align="right">'.$x.'.&nbsp;<input name="id" type="hidden" value="'.$row['id'].'" /></td>';
					   
					foreach($arr_fields as $k => $varKey){ 
					 
					  	if(!$this->hiddenfields($varKey)){
					 
							if($varKey=='string_request'){
								$content.='
								<td width="100%" align="right"><input name="" type="button" value="View"  onclick="popupwindow(\'/trace_log_viewer/string_request/'.$row['id'].'/'.str_replace("/","---",$row['string_request']).'\', \'View String Request\', 320, 320)" /></td>';
							}
							elseif($varKey=='product_id'){
								$content.='<td nowrap="nowrap">'; 
								$arrProduct_id = explode(",",$row['product_id']); 
								$strProduct = array();
								if(count($arrProduct_id)&&!empty($arrProduct_id[0])) 
								foreach($arrProduct_id as $pkey => $pid){// echo "<br>$pkey => $pid";
									$rowProduct = $this->allmodel->getTableByID('pd_product',$arrProduct_id[$pkey]);	
									array_push($strProduct,$rowProduct['product']); 
								}
								$content.= implode(",",$strProduct); 
								$content.= '</td>'; 
							}
							elseif($varKey=='suplier_id'){
								$content.='<td nowrap="nowrap">';  
								$useTable  = $row['suplier_db'];
								if($useTable){
									$rowVendor = $this->allmodel->getTableByID($useTable, $row['suplier_id']);  
									if($useTable=='md_product_vendor') $useKey = 'vendor';
									elseif($useTable=='authorize_dealer')  $useKey = 'dealer_name';
									$content.= $rowVendor[$useKey]; 
								} 
								$content.= '</td>'; 
							} 
							elseif($varKey=='group_access_id'){
								$content.='<td>'; 
						 		if($row['id']==1) $content.= 'All Privileges'; 
								else $content.= 'Group Privileges'; 
								$content.= '</td>'; 
							}  
							elseif($varKey=='group_id'){
								$content.='<td>'; 
								$group_id = $row['group_id'];
								if($group_id){
									$rowGrp = $this->allmodel->getTableByID('user_group_table', $group_id);  
									$content.= $rowGrp['group']; 
								} 
								
								$content.= '</td>'; 
							} 
							elseif($varKey=="modified_by"){ 
								$content .= '  <td>';  
								if($row[$varKey]){
									$qdata = $this->allfunc->getUserByID($row[$varKey]);
									$getUser = $qdata->result_array();
									if(isset($getUser[0]['Username'])) 
									$content .= $getUser[0]['Username']; 
								}
								$content .= '  </td>'; 
							} 
							else{  
								$content.='
								<td>'.$row[$varKey].'</td>'; 
								
							} 
						} 
					} 
 					
					if($is_pop!=2)
					$content.='<td>';
					 
					if($is_pop!=2)
					$content.='		   <input '.$disable.' type="button" name="EDIT" value="EDIT" onclick="window.location.assign(\''.base_url().$ci_ctrl.'/edit_data/'.$row['id'].'/'.$ci_func.'\')"/>';
					
					if($ci_func=="product")
					$content .='&nbsp; <input '.$disable.' type="button" name="PRICELIST" value="Price List" onclick="window.open(\''.base_url().$ci_ctrl.'/product_price/'.
								$curpage.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'/where-product_id--'.$row['id'].'/2\',\'view_price_list\',\'height=600,width=640\')" />';
 					
					if($is_pop!=2)
					$content.='</td>';
					
					$content.='</tr>'; 
					$x++;
				}	
				 
			}
 
		$content.='</tbody>';
		$content.='</table>';		
		$content.='<div class="linebot"></div>';		 
		
		if($is_pop!=2)
		$content .= $this->pagenave($curpage,$limit,$status_id,$sort,$order,$ci_changePage,$result_id,$ci_ctrl,$ci_func,$TABLE);
		 
		return $content;
		
	} 
	
	function pagenave($curpage,$limit,$status_id,$sort,$order,$ci_changePage,$result_id,$ci_ctrl,$ci_func,$TABLE){
   
		$cData=$this->allmodel->countTable($TABLE,$status_id);  
		
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
				$var.='<a href="javascript:void(0);loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/'.$prev.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_changePage.'/'.$result_id.'/'.$ci_ctrl.'/'.$ci_func.'/'.$TABLE.'\',\''.$result_id.'\')"><img src="/asset/icons/arrow_left.gif" width="16" height="16" />prev</a>';
				$var.='&nbsp; &nbsp;'; 
				$var.='<a href="javascript:void(0);loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/'.$next.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_changePage.'/'.$result_id.'/'.$ci_ctrl.'/'.$ci_func.'/'.$TABLE.'\',\''.$result_id.'\')">next<img src="/asset/icons/arrow_right.gif" width="16" height="16" /></a>';
				$var.='&nbsp; &nbsp;'; 
			
			$var.='		</td>';
				
			$var.='		<td width="100%" nowrap="nowrap" >';
							$var.='&nbsp; &nbsp;Page: <select name="page" id="page" onchange="loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/\'+$(this).val()+\'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_changePage.'/'.$result_id.'/'.$ci_ctrl.'/'.$ci_func.'/'.$TABLE.'\',\''.$result_id.'\')">'; 
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
				$var.='Show <select name="view" id="view" onchange="loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/1/\'+$(this).val()+\'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_changePage.'/'.$result_id.'/'.$ci_ctrl.'/'.$ci_func.'/'.$TABLE.'\',\''.$result_id.'\')" >';
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
	
	//---------------------------------------------------------------
 
 	 
	function editFormProductVT($data){  //--   edit product vending terminal 
	
		foreach( $data as $key => $val){    //echo "<br>$key => $val"; //exit; 
			//$none = '0';
			//if(empty($val)) $val = $none;
			$$key = $val; 
		} 
		 
		//http://lunari/dealer_terminal/edit_data/3/vending_terminal/1/1/1/1
		if(isset($cur_product_id))
		$str_redir = base_url().$ci_ctrl."/edit_data/".$id."/vending_terminal/".$cur_product_id."/".$cur_product_vendor_id."/".$cur_product_delivery_id."/".$cur_trx_code_id;
 
		//-- get table keys
		$arr_fields      = $this->allmodel->getTableKeys($TABLE,'key');  
		
		
		$arr_fields_type = $this->allmodel->getTableKeysType($TABLE,'all'); 
		//foreach( $arr_fields_type as $k => $varKey) echo "<br>$k ===> $varKey"; exit;   
  	 
		 
 
		$result = '';
		$col1 = "#ffffff";
		$col2 = "#f6f6f6";
		$x=0;
		
		foreach( $arr_fields as $key => $varKey){ //echo "<br>$key ===> $varKey"; 
			$n = fmod($x,2); 
			if($n) $clr = $col1; else $clr = $col2;
 		
			if(!$this->hiddenfields($varKey)){ 
				//echo "<br>$k => $varKey"; 
				$inputsize = 'width:120px';
				if	  ($arr_fields_type[$varKey]=="varchar(255)") $inputsize = 'width:220px';
				elseif($arr_fields_type[$varKey]=="varchar(120)") $inputsize = 'width:160px'; 
 				
				//,'venue','area','city','province','country'
				if( $this->showfieldseditproduct($varKey) ){  // echo "<br>$key ===> $varKey"; 
					
					$varKeyLbl = $this->str_changetext($varKey);
					
					$result .= '<tr valign="top" bgcolor="'.$clr.'">'; 
 
					$result .= '  <td>'.$varKeyLbl.'</td>'; 
					 
					if($varKey=="product_id"){ 
						$result .= '  <td>';
						 
						$result .= '    <div class="bgtable">';  
							
						$arrProduct_id  = explode(",",$product_id);
						$arrDelivery    = explode(",",$product_delivery_id);
						$arrVendor      = explode(",",$product_vendor_id);
						$arrAlert       = explode(",",$product_alert_id);
						$arrTrx_code 	= explode(",",$trx_code_id);
						
						//-- redir data
						if(isset($str_redir))
						$result .= '    <input type="hidden" name="redir" id="redir" value="'.$str_redir.'" />';  
						
						
 						$n=0;
						
						
							$result .= '<table border="0" cellpadding="3" cellspacing="1">'; 
                            $result .= '  <tr bgcolor="#cccccc">
                                                <td align="right" width="15">No.</td>
                                                <td>Product</td> 
                                                <td>Vendor</td>
                                                <td>Delivery</td>  
                                                <td>TRX-CODE</td>  
                                              </tr>  '; 
											  
						if(count($arrProduct_id)&&!empty($arrProduct_id[0])){					  
							foreach($arrProduct_id as $pkey => $pid){ //echo "<br>$pid"; 
								if(fmod($n,2)) 	$strClr = '#ffffff';
								else 			$strClr = '#eeeeee';
 
								//$rowProduct 	= $this->allmodel->getTableByID('pd_product',$arrProduct_id[$pkey]);
								$rowVendor 		= $this->allmodel->getTableByID('md_product_vendor',$arrVendor[$pkey]);
								//$rowDelivery 	= $this->allmodel->getTableByID('md_product_delivery',$arrDelivery[$pkey]);
								//$rowAlert 	= $this->allmodel->getTableByID('md_respons_code',$arrAlert[$pkey]);
								//$rowTrxCode		= $this->allmodel->getTableByID('md_transaction_code',$arrTrx_code[$pkey]); 
								//$rowProduct 	= $this->allmodel->getTableWhere($tbl='pd_product',$key='',$val=0,$status_id=1,$orderby='product');
								//$rowProduct 	= $this->allfunc->listmenu('pd_product','product',1,$arrProduct_id[$pkey],'',0,'product_id','','');
								
								//$rowProduct 	= $this->allfunc->listmenugetvalue('dealer_terminal','listgevalue','pd_product','product',1,$arrProduct_id[$pkey],$where_key='',$where_val=0,$listname='id','vendordata','');
								//function listmenuchild($ci_ctrl='',$callfunc='',$table='',$rowname='',$status_id=1,$selected=0,$where_key='',$where_val=0,$listname='id',$result_id='listdata',$firstitem='all'){
								
								/*
								$array1 = array(
									'table'		=> 'pd_product',
									'rowname'	=> 'product', 
									'selected'	=> $arrProduct_id[$pkey], 
									'selectname'=> 'id', 
									'result_id'	=> '' 
									); 
								$array2 = array(
									'table'		=> 'md_product_vendor',
									'rowname'	=> 'vendor', 
									'result_id'	=> 'vendordata'.$n 
									);

								$rowProduct 	= $this->allfunc->listmenuarray3('dealer_terminal','listgevalue',$array1,$array2); 
								
								*/
								
								//echo $data['product_id'];
								
								$lmenu['select_name_id'] 	= 'product_id'.$pkey;
								$lmenu['slc_key']			= 'id';
								$lmenu['selected']			= $arrProduct_id[$pkey];
								$lmenu['show_key_name']		= 'product'; 
								$lmenu['first_item_val'] 	= 0;
								$lmenu['first_item_text']	= '';
								
								$ltable = '';
								
								$datalist = $this->allmodel->getTableWhere('pd_product','id',0,1); 
								//foreach($datalist as $k => $v) foreach($v as $k2 => $v2) echo "<br>$k => $k2 => $v2"; 
								
								//foreach($datalist as $row)   foreach($row as $k => $v) echo "<br>$k => $v";   
								//echo $row['suplier_db']."<br>";
 
								//$str_onchange =  ' onchange="loadcontent(\''.base_url().$ci_ctrl.
							 	//'/list_data_child_2/0/\'+$(\'select#owner_id\').val()+\'/'.$listval2.'/'.$listval3.'\',\'vendordata'.$n.'\')" ';
								
								//echo "<br>";
								//echo 
								$str_onchange =  ' onchange="loadcontent(\''.base_url().$ci_ctrl.'/getvendorname/pd_product/vendor/1/0/0/\'+$(\'select#product_id'.$pkey.'\').val()+\'/product_id/vendordata'.$pkey.'/\',\'vendordata'.$pkey.'\')" ';
								
								// listgevalue($table,$rowname2,$status_id2,$selected2,$where_key2,$selectid,$selectname2,$result_id2,$firstitem1=''){
						 
								$rowProduct 	= $this->allfunc->listmenuarray2($lmenu,$datalist,$str_onchange); 
								$rowDelivery 	= $this->allfunc->listmenu('md_product_delivery','delivery_type',1,$arrDelivery[$pkey],'',0,'delivery_type'.$pkey,'','');
								$rowTrxCode 	= $this->allfunc->listmenu('md_transaction_code','trx_code',1,$arrTrx_code[$pkey],'',0,'trx_code'.$pkey,'','');

								$result .= '  <tr bgcolor="'.$strClr.'">
												<td align="right" width="15">'.($n+1).'.</td>
												<td>'.$rowProduct.'</td> 
                                                <td><div id="vendordata'.$pkey.'">'.$rowVendor['vendor'].'</div></td>
												<td>'.$rowDelivery.'</td> 
												<td>'.$rowTrxCode.'</td> 
											  </tr>  ';  
	  
												//
											  //<td>'.$rowDelivery['delivery_type'].'</td> 
											  		  
								$n++;
							}
						}		
							if($add){	
								$add_id = $n+1;	
								$lmenu['select_name_id'] 	= 'product_id'.$add_id;
								$lmenu['slc_key']			= 'id';
								$lmenu['selected']			= 0;
								$lmenu['show_key_name']		= 'product'; 
								$lmenu['first_item_val'] 	= 0;
								$lmenu['first_item_text']	= '';  
								
								$datalist = $this->allmodel->getTableWhere('pd_product','id',0,1); 
								$str_onchange =  ' onchange="loadcontent(\''.base_url().$ci_ctrl.'/getvendorname/pd_product/vendor/1/0/0/\'+$(\'select#product_id'.$add_id.'\').val()+\'/product_id/vendordata'.$add_id.'/\',\'vendordata'.$add_id.'\')" ';
								
								
								$rowProduct 	= $this->allfunc->listmenuarray2($lmenu,$datalist,$str_onchange); 
								$rowDelivery 	= $this->allfunc->listmenu('md_product_delivery','delivery_type',1,0,'',0,'delivery_type'.$add_id,'','');
								$rowTrxCode 	= $this->allfunc->listmenu('md_transaction_code','trx_code',1,0,'',0,'trx_code'.$add_id,'','');

								$result .= '  <tr bgcolor="'.$strClr.'">
												<td align="right" width="15">'.($n+1).'.</td>
												<td>'.$rowProduct.'</td> 
                                                <td><div id="vendordata'.$add_id.'">'.$rowVendor['vendor'].'</div></td>
												<td>'.$rowDelivery.'</td> 
												<td>'.$rowTrxCode.'</td> 
											  </tr>  ';
							}				  
											  
											  
							$result .= '    </table>'; 
										
												
						$result .= '    </div>'; 
						 
						$result .= '  	</td>';
							
					} 
					elseif($product_id&&$product_vendor_id&&$product_delivery_id){  
							
							if($varKey=='terminal_ID') $varKey = strtolower($varKey);
							 
							$result .= '  <td>'.$data[$varKey].'</td>';  //$data[$varKey]
					 
					}
					
					$result .= '</tr>';
				} 
		 
				$x++;
							
			}	 
		}
 		
		return $result;			
					
	}
	
	function editFormProduct($data){    
	
		foreach( $data as $key => $val){    //echo "<br>$key => $val"; //exit;
 
			$$key = $val; 
		}
		
 
		//-- get table keys
		$arr_fields      = $this->allmodel->getTableKeys($TABLE,'key');  
		$arr_fields_type = $this->allmodel->getTableKeysType($TABLE,'all');  
 
		$result = '';
		$col1 = "#ffffff";
		$col2 = "#f6f6f6";
		$x=0;
		
		foreach( $arr_fields as $key => $varKey){ //echo "<br>$key => $varKey"; 
			$n = fmod($x,2); 
			if($n) $clr = $col1; else $clr = $col2;
 		
			if(!$this->hiddenfields($varKey)){
				
				//echo "<br>$k => $varKey"; 	 
				
				$inputsize = 'width:120px';
				if	  ($arr_fields_type[$varKey]=="varchar(255)") $inputsize = 'width:220px';
				elseif($arr_fields_type[$varKey]=="varchar(120)") $inputsize = 'width:160px'; 
 				
				//,'venue','area','city','province','country'
				if(!$this->hiddenfieldsedit($varKey)){
					
					$varKeyLbl = $this->str_changetext($varKey);
					
					$result .= '<tr valign="top" bgcolor="'.$clr.'">';  
					$result .= '  <td>'.$varKeyLbl.'</td>';  
					
					 if($varKey=="product_id"){ 
						$result .= '  <td>';  
						$result .= $this->allfunc->listmenu('pd_product','product',1,$product_id,'',0,'product_id','',''); 
						$result .= '  </td>';
					} 
					elseif($varKey=="product_vendor_id"){ 
						$result .= '  <td>';  
						$result .= $this->allfunc->listmenu('md_product_vendor','vendor',1,$product_id,'',0,'vendor_id','','none Vendor'); 
						$result .= '  </td>';  
					} 
					elseif($varKey=="authorize_dealer_id"){ 
						$result .= '  <td>';  
						$result .= $this->allfunc->listmenu('authorize_dealer','dealer_name',1,$authorize_dealer_id,'',0,'dealer_id','','none AD'); 
						$result .= '  </td>'; 
					} 
					elseif($varKey=="suplier_id"){  
						$result .= '  <td>';  
						
						
						$useTable  		 = $data['suplier_db'];
						$useSuplier_id   = $data['suplier_id'];
						
						$selected1 = $selected2 = '';
						if($useTable=='md_product_vendor') 	 { $useKey = 'vendor';		$selected1 = ' selected="selected" ';} 
						elseif($useTable=='authorize_dealer'){ $useKey = 'dealer_name'; $selected2 = ' selected="selected" ';}	
						

						$result .= '  <div style="padding:0 0 5px 0">'; 
						$result .= '    <select name="suplier_db" id="suplier_db"  onchange="loadcontent(\''.base_url().$ci_ctrl.
							'/select_db/\'+$(\'select#suplier_db\').val(),\'listdata0\')">'; 
						$result .= '	<option value="" ></option>';
						$result .= '	<option value="md_product_vendor" '.$selected1.' >Product Vendor</option>';
						$result .= '	<option value="authorize_dealer"  '.$selected2.' >Authorize Dealer</option>';
									  		 
						$result .= '	</select>'; 
						$result .= '	<input type="hidden" name="suplier_idx" id="suplier_idx"/>';
						$result .= '  </div>'; 
						$result .= '  <div style="padding:0 0 0 0" id="listdata0">';  
						if($useSuplier_id) $result .= $this->allfunc->listmenu($useTable,$useKey,1,$useSuplier_id,'',0,'suplier_id','','');  
						$result .= '  </div>';
						
						$result .= '  </td>';   
						//$result .= $this->allfunc->listmenu('authorize_dealer','dealer_name',1,$authorize_dealer_id,'',0,'dealer_id','','none AD'); 



					}  
					else {  
						
						if($arr_fields_type[$varKey]=="text")
						$result .= '  <td><textarea rows="2" name="'.$varKey.'" id="'.$varKey.'" style="width:220px">'.$data[$varKey].'</textarea></td>';
						else 
						$result .= '  <td><input type="text" style="'.$inputsize.'" name="'.$varKey.'" id="'.$varKey.'" value="'.$data[$varKey].'" /></td>';
 						 
					}
					
					$result .= '</tr>';
				} 
		 
				$x++;
							
			}	 
		}
 		
		return $result;			
					
	}
	
	function editFormTable($data=array()){  
	  
		foreach( $data as $key => $val){   //echo "<br>$key => $val"; exit; 
			$$key = $val; 
		} 
		$cur_id 				 = $id; 
 		$cur_product_id			 = $product_id; 
		$cur_product_vendor_id   = $product_vendor_id;  
		$cur_product_delivery_id = $product_delivery_id; 
		$cur_trx_code_id 		 = $trx_code_id; 
 
		//-- get table keys
		$arr_fields      = $this->allmodel->getTableKeys($TABLE,'key'); 
		// foreach( $arr_fields as $k => $varKey) echo "<br>$k ===> $varKey"; exit; 
		
		//echo "<br><br>";
		$arr_fields_type = $this->allmodel->getTableKeysType($TABLE,'all'); 
		// foreach( $arr_fields_type as $k => $varKey) echo "<br>$k ===> $varKey"; 
 
		/*
		id ===> int(11)
		IP ===> varchar(255)
		terminal_ID ===> varchar(255)
		*/
		
		$result = '';
		$col1 = "#ffffff";
		$col2 = "#f6f6f6";
		$x=0;
		
		if(!$cur_id){
			 
			foreach($arr_fields_type as $k => $varKey) $arr_fields[0] = 'status_id';	 
		}
		 
		
		foreach( $arr_fields as $key => $varKey){// echo "<br>$key ===> $varKey"; 
			$n = fmod($x,2); 
			if($n) $clr = $col1; else $clr = $col2;
			 
			if(!$this->hiddenfields($varKey)){
					 
 		
				
				$inputsize = 'width:120px';
				if	  ($arr_fields_type[$varKey]=="varchar(255)") $inputsize = 'width:220px';
				elseif($arr_fields_type[$varKey]=="varchar(120)") $inputsize = 'width:120px'; 
 				
				//,'venue','area','city','province','country'
				if(!$this->hiddenfieldsedit($varKey)){
 
					$varKeyLbl = $this->str_changetext($varKey);
					
					$result .= '<tr valign="top" bgcolor="'.$clr.'">'; 

					//if($varKey=="venue")
					//$result .= '  <td>Location</td>';
					//else 
					//$result .= '  <td>'.$varKey.'</td>';
 
					 
					$result .= '  <td>'.$varKeyLbl.'</td>'; 
					
					if($varKey=="venue"){ 
							$result .= '  <td>'; 
							
							$qDataLoc=$this->allmodel->selectIndexTable(0,1000,1,'venue','asc','md_terminal_location');  
							if($qDataLoc->num_rows()){ 
								$result .= '<select name="location_id" id="location_id">';  
								$result .= '	<option value="0" selected="selected">Select location:</option>';  
								foreach($qDataLoc->result_array() as $row) { 
									 $selected = '';
									 if($row['id']==$location_id) $selected = 'selected="selected"';
									 $result .= '<option value="'.$row['id'].'" '.$selected.' >'.$row['Venue'].' -> '.$row['Area'].', '.$row['City'].', '.$row['Province'].', '.$row['Country'].'</option>'; 
								}
								$result .= '</select>';
							} 
							$result .= '<br><div style="padding:5px 0 0;">
										<input type="button" name="button1" id="button1" value="Edit Location" onclick="window.open(\'/master_data/edit_data/\'+$(\'select#location_id\').val()+\'/terminal_location/0/1\',\'edit_location\',\'height=1024,width=800\')" />
								   		</div>'; 
							$result .= '  </td>';
									
					}
					elseif($varKey=="terminal_owner"){ 
							$result .= '  <td>'; 
							//$result .= $this->allfunc->listmenu($table='md_terminal_owner',$rowname='name',$status_id=1,$selected=0,$where_key='',$where_val=0,$listname='owner_id',$result_id='',$firstitem='select owner:');
							//if($product_id&&$product_vendor_id&&$product_delivery_id)
							//$result .= $this->allmodel->getTableByID('md_terminal_owner',$owner_id);  
							//else
							$result .= $this->allfunc->listmenu('md_terminal_owner','name',1,$owner_id,'',0,'owner_id','','');
							
							$result .= '  </td>'; 
					}
					elseif($varKey=="terminal_tenant"){  
						 
							$result .= '  <td>'; 
							$result .= $this->allfunc->listmenu('md_terminal_tenant','tenant',1,$tenant_id,'',0,'tenant_id','','');
							
							$result .= '  </td>'; 
					} 
					elseif($varKey=="product_id"){ 
							$result .= '  <td>';
							$result .= '    <div class="bgtable">';  
							
							$arrProduct_id = explode(",",$product_id);
							$arrDelivery   = explode(",",$product_delivery_id);
							$arrVendor     = explode(",",$product_vendor_id);
							$arrAlert      = explode(",",$product_alert_id);
							$arrTrx_code   = explode(",",$trx_code_id);
							
							//trx_code_id
							
 
							$n=0;
							if(count($arrProduct_id)&&!empty($arrProduct_id[0])){
								$result .= '<table border="0" cellpadding="3" cellspacing="1">'; 
                            	$result .= '  <tr bgcolor="#cccccc">
                                                <td align="right" width="15">No.</td>
                                                <td>Product</td> 
                                                <td>Vendor</td>
                                                <td>Delivery</td>
                                                
                                                <td align="center">Pricing</td>
                                                <td align="center">Edit</td>
                                              </tr>  '; //<td align="center">Alert</td>
								foreach($arrProduct_id as $pkey => $pid){ //echo "<br>$pid"; 
									if(fmod($n,2)) 	$strClr = '#ffffff';
									else 			$strClr = '#eeeeee';
									
									$rowProduct 	= $this->allmodel->getTableByID('pd_product',$arrProduct_id[$pkey]);
									$rowVendor 		= $this->allmodel->getTableByID('md_product_vendor',$arrVendor[$pkey]);
									$rowDelivery 	= $this->allmodel->getTableByID('md_product_delivery',$arrDelivery[$pkey]);
									$rowAlert 		= $this->allmodel->getTableByID('md_respons_code',$arrAlert[$pkey]);
									$rowTrxcode		= $this->allmodel->getTableByID('md_transaction_code',$arrTrx_code[$pkey]);
 
									$result .= '  <tr bgcolor="'.$strClr.'">
													<td align="right" width="15">'.($n+1).'.</td>
													<td>'.$rowProduct['product'].'</td> 
													<td>'.$rowVendor['vendor'].'</td>
													<td>'.$rowDelivery['delivery_type'].'</td>
													
													<td><input type="button" name="PRICELIST" value="Price List" 
													onclick="window.open(\''.base_url().'dealer_terminal/product_price/'.$id.'/'.$rowProduct['id'].
													'\',\'terminal_price_list\',\'height=600,width=640\')" /></td>
													<td><input type="button" name="edit_data_product" id="edit_data_product" value="edit" 
													onclick="window.open(\'/dealer_terminal/edit_data/'.$id.'/'.$TABLE.'/'.$rowProduct['id'].'/'.$rowVendor['id'].'/'.$rowDelivery['id'].'/'.$rowTrxcode['id'].
													'\',\'terminal_product_edit\',\'height=480,width=720\')" /></td>
												  </tr>  '; //<td class="red">'.$rowAlert["description"].'</td>
												  //http://lunari/product_data/product_price/1/10/1/id/asc/product_data/changepage/dspdata/where-product_id--1/2
												  
								//$content .='&nbsp; <input '.$disable.' type="button" name="PRICELIST" value="Price List" onclick="window.open(\''.base_url().$ci_ctrl.'/product_price/'.
								//$curpage.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'/where-product_id--'.$row['id'].'/2\',\'view_price_list\',\'height=600,width=640\')" />';
 				
				 
									$n++;
								}
								$result .= '    </table>'; 
							}					
												
							$result .= '    </div>';
							$result .= '    <div style="padding:5px 0 0;">
											<input type="button" name="button1" id="button1" value="Add Product" 
											onclick="window.open(\'/dealer_terminal/edit_data/'.$id.'/vending_terminal/0/0/0/0/add\',\'add_product\',\'height=480,width=720\')" />
											 
											</div>';
							$result .= '  	</td>';
							
					}
					elseif($varKey=="video_id"){
							
							if($id){ 
							$result .= '  <td>'; 
							//$result .= $this->allfunc->listmenu($table='md_terminal_owner',$rowname='name',$status_id=1,$selected=0,$where_key='',$where_val=0,$listname='owner_id',$result_id='',$firstitem='select owner:');
							$result .= '<div style="padding:2px 0;">Screen Video: '. $this->allfunc->listmenu('media_database','title',1,$video_id,'type','video','video_id','','select video:').' &nbsp; <input style=" font-size:10px;" type="button" name="button1" id="button1" value="Upload New Video" onclick="window.open(\'/master_data/edit_data/'.$arr_fields['location_id'].'/terminal_location\',\'edit_location\',\'height=1024,width=800\')" /></div>';
							$result .= '<div style="padding:2px 0;font:normal 11px arial;color:green">&nbsp;- Last Upload Video, date: <strong>2014-10-10 13:00:00</strong>, by: <strong>admin</strong>, file:<strong>mandiri.mp4</strong></div>';
							//$result .= '<div style="padding:2px 0">&nbsp;- Last Upload Patch, date: <strong>2014-10-10 13:00:00</strong>, by: <strong>admin</strong>, file:<strong>filename.class</strong></div>';
							$result .= '  </td>';
							}
					 
					}
					elseif($varKey=="product_vendor_id"){
							
						$result .= '  <td>'; 
						
						$result .= $this->allfunc->listmenu('md_terminal_tenant','tenant',1,$tenant_id,'',0,'tenant_id','','');
						
						$result .= '  </td>'; 
 
					}					
					elseif($varKey=="group_access_id"){
 
						$result .= '  <td>';
 
						$result .= '    <div style="border:1px solid #cccccc">
										  <table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF">  
											'.$menuAccessGrp.'
										  </table>
										</div>'; 
						$result .= '  </td>'; 
						
					}					
					elseif($varKey=="group_id"){
 
						$result .= '  <td>'; 
						
						$result .= $this->allfunc->listmenu('user_group_table','group',1,$group_id,'',0,'group_id','','');
						
						$result .= '  </td>'; 
						
					}				
					elseif($varKey=="group" && $data[$varKey]=='Lunari' && $cur_id==1){ 
					//-- As default item, can't change this key & value. 
						$result .= '  <td><strong>'.$data[$varKey].'</strong></td>';
					}
					else { 
						
						if($varKey=="terminal_ID") $data[$varKey] = $data['terminal_id']; 
						
						if($arr_fields_type[$varKey]=="text")
						$result .= '  <td><textarea rows="2" name="'.$varKey.'" id="'.$varKey.'" style="width:220px">'.$data[$varKey].'</textarea></td>';
						else 
						$result .= '  <td><input type="text" style="'.$inputsize.'" name="'.$varKey.'" id="'.$varKey.'" value="'.$data[$varKey].'" /></td>';
 						 
					}
					 
					
					
					$result .= '</tr>';
				} 
		 
				$x++;
							
			}	 
		}
 		
		return $result;			
					
	}
	
	/*
		
old
	function editFormTable($data){ 
	
		foreach( $data as $key => $val) $$key = $val; //echo "<br>$key => $val"; exit;
	
		//-- get table keys
		$arr_fields      = $this->allmodel->getTableKeys($TABLE,'key'); 
		//foreach( $arr_fields as $k => $varKey) echo "<br>$k ===> $varKey"; exit; 
		
		//echo "<br><br>";
		$arr_fields_type = $this->allmodel->getTableKeysType($TABLE,'all'); 
		//foreach( $arr_fields_type as $k => $varKey) echo "<br>$k ===> $varKey"; 
		//
		
		 
		//id ===> int(11)
		//IP ===> varchar(255)
		//terminal_ID ===> varchar(255)
		 
 		
		$result = '';
		$col1 = "#ffffff";
		$col2 = "#f6f6f6";
		$x=0;
		
		foreach( $arr_fields as $key => $varKey){ //echo "<br>$key ===> $value"; 
			$n = fmod($x,2); 
			if($n) $clr = $col1; else $clr = $col2;
 		
			if(!$this->hiddenfields($varKey)){
				
				//echo "<br>$k => $varKey"; 	 
				
				$inputsize = 'width:120px';
				if	  ($arr_fields_type[$varKey]=="varchar(255)") $inputsize = 'width:220px';
				elseif($arr_fields_type[$varKey]=="varchar(120)") $inputsize = 'width:160px'; 
 				
				//,'venue','area','city','province','country'
				if(!$this->hiddenfieldsedit($varKey)){
					
					$result .= '<tr valign="top" bgcolor="'.$clr.'">'; 

					//if($varKey=="venue")
					//$result .= '  <td>Location</td>';
					//else 
					//$result .= '  <td>'.$varKey.'</td>';
 
					
					if($varKey=="venue"||$varKey=="terminal_owner"||$varKey=="products"){
						  
						if($varKey=="venue"){
							$result .= '  <td>Location</td>';  
						 
							$result .= '  <td>';
 
							$qDataLoc=$this->allmodel->selectIndexTable(0,1000,1,'venue','asc','md_terminal_location'); 

							if($qDataLoc->num_rows()){ 
								$result .= '<select name="location_id" id="location_id">';  
								foreach($qDataLoc->result_array() as $row) {
									 $selected = '';
									 if($row['id']==$arr_fields['location_id']) $selected = 'selected="selected"';
									 $result .= '<option value="'.$row['id'].'" '.$selected.' >'.$row['Venue'].' -> '.$row['Area'].', '.$row['City'].', '.$row['Province'].', '.$row['Country'].'</option>'; 
								}
								$result .= '</select>';
							} 
							$result .= '<br><div style="padding:5px 0 0;">
										<input type="button" name="button1" id="button1" value="Edit Location" onclick="window.open(\'/master_data/edit_data/'.$arr_fields['location_id'].'/terminal_location\',\'edit_location\',\'height=1024,width=800\')" />
								   		</div>
								    </td>'; 
						}
						elseif($varKey=="terminal_owner"){
							$result .= '  <td>'.$varKey.'</td>';
							$result .= '  <td>'.$varKey.'</td>';
							
						}
						elseif($varKey=="products"){
							$result .= '  <td>'.$varKey.'</td>';
							$result .= '  <td>'.$varKey.'</td>';
							
						}
						
					} else {
						
						$result .= '  <td>'.$varKey.'</td>';
						 
						if($arr_fields_type[$varKey]=="text")
						$result .= '  <td><textarea rows="2" name="'.$varKey.'" id="'.$varKey.'" style="width:220px">'.$data[$varKey].'</textarea></td>';
						else 
						$result .= '  <td><input type="text" style="'.$inputsize.'" name="'.$varKey.'" id="'.$varKey.'" value="'.$data[$varKey].'" /></td>';
 						 
					}
					
					$result .= '</tr>';
				} 
		 
				$x++;
							
			}	 
		}
		 
					
		return $result;			
					
	}
	
	
	
	function editDataTable($ci_ctrl='',$ci_func='',$id=0){ 
 
		//-- get table keys
		$arr_fields = $this->allmodel->getTableKeys($TABLE); 
		//foreach( $arr_fields as $key => $value){  echo "<br>$key ===> $value"; }  
		 
		$qData=$this->allmodel->selectItemTableById($TABLE,$id);
		
		$content = ''; 

		if($qData->num_rows()){ 
			$col1 = "#ffffff";
			$col2 = "#f6f6f6";
 
		  
		}
		  
		return $content;
		
	} 
	*/
}

