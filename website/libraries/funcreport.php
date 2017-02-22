<?php 
 if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Funcreport extends Allmodel{ 

  	function Allfunc(){    
    	parent::Allmodel();     
  	} 
    
	//----- index database table --------------------------------
		
	function hiddenfields($varKey){ 
		$arrhide = array('id','status_id','kdtrx','nourut','uangmasuk','uangkeluar','cashbox','lbrcashbox','payout','lbrpayout','sisakartu','string_request','edit');
		$res = 0;
		foreach($arrhide as $k => $v) if($v==$varKey)$res = 1;
		return $res; 
	}
	function hiddenfieldsedit($varKey){ 
		$arrhide = array('online_status');
		$res = 0;
		foreach($arrhide as $k => $v) if($v==$varKey)$res = 1;
		return $res; 
	}
 
	function indexDataTable($ci_ctrl='',$ci_func='',$TABLE='',$curpage=1,$limit=10,$status_id=1,$sort='id',
		$order='desc',$ci_changePage='changepage',$result_id='dspdata',$type=0,$vm_id=0,$dt1='',$dt2=''){ 
 
		if($order=="asc") 		$orderO="desc";
		elseif($order=="desc") 	$orderO="asc"; 
		$content=$disableAll=''; 
 
		$start=($curpage*$limit)-$limit; 
 
		//-- get table keys
		$arr_fields = $this->allmodel->getTableKeys($TABLE); 
		//foreach( $arr_fields as $key => $value){  echo "<br>$key ===> $value"; } 
		//$arr_fields = array('id','datetime','ip','vm','type','refid','txid','msg','xdata','response_status','string_request'); 
 
		$vmid = $this->allmodel->getVMByID($vm_id);
 		
		if(empty($vmid))
		$where = " dt >= '".$dt1."' and dt <= '".$dt2."'";
		else
		$where = " vmid = '".$vmid."' and dt >= '".$dt1."' and dt <= '".$dt2."'";
 
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
			foreach($arr_fields as $k => $varKey){
							
				$w100 = '';
				if($varKey=='string_request')
				$w100 = ' align="right" ';
							
				//if($varKey!='id' && $varKey!='location_id' ){
				if(!$this->hiddenfields($varKey)){
				
					$content .='<td'.$w100.'><a class="lightgrey" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$ci_func.'/1/'.$limit.'/'.$status_id.'/'.$varKey.'/'.$orderO.'\')">'.$varKey.'</a></td>';
					
				}
				
				
			}
			if(!$this->hiddenfields('edit')) 
			$content.=' <td align="center" class="lightgrey">Edit</td>';
			
			$content.='  
					  </tr>
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
					  	//if($varKey!='id' && $varKey!='location_id' ){
						
							if($varKey=='string_request'){
								$content.='
								<td width="100%" align="right"><input name="" type="button" value="View"  onclick="popupwindow(\'/trace_log_viewer/string_request/'.$row['id'].'/'.str_replace("/","---",$row['string_request']).'\', \'View String Request\', 320, 320)" /></td>';
							}else{  
								$content.='
								<td>'.$row[$varKey].'</td>'; 
							} 
						} 
					 } 
					  
 
					if(!$this->hiddenfields('edit')){
					$content.='<td>'; 
					$content.='<input '.$disable.' type="button" name="EDIT" value="EDIT" onclick="window.location.assign(\''.base_url().$ci_ctrl.'/edit_data/'.$row['id'].'/'.$ci_func.'\')"/>';
					$content.='</td>';
					}
					
					$content.='</tr>'; 
					$x++;
				}	
				 
			}
 
		$content.='</tbody>';
		$content.='</table>';		
		$content.='<div class="linebot"></div>';		 
		
		//$content .= $this->pagenave($curpage,$limit,$status_id,$sort,$order,$ci_changePage,$result_id,$ci_ctrl,$ci_func,$TABLE,$where);
		 
		return $content;
		
	} 
	
	function pagenave($curpage,$limit,$status_id,$sort,$order,$ci_changePage,$result_id,$ci_ctrl,$ci_func,$TABLE,$where){
   
		$cData=$this->allmodel->countTable($TABLE,$status_id,$where);  
		
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
	
}
