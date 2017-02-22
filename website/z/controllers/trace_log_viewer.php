<?php  
//session_start();  
class Trace_log_viewer extends Controller { 
	function Trace_log_viewer(){   
		parent::Controller();  
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		$this->load->library('allfunc');  
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
 		//echo "Hello U"; 
		//re_direct('trace_log_viewer/card_transaction'); 
		echo '<meta http-equiv="Refresh" content="0;URL=/trace_log_viewer/card_transaction" />' ;  
	} 
	 
	function card_transaction($curpage=1,$limit=10,$statusid=1,$sort="id",$order="desc",$ci_ctrl="trace_log_viewer",$ci_changePage="changepage",$result_id="dspdata",$type=1){  
     	$data['pageTITLE'] = 'TFC Web Admin - Trace Log Viewer'; 
     	$data['pageLABEL'] 	= 'Trace Log Viewer > Card Transaction';
		$data['navMenu']   	= $this->allfunc->navMenu(5);   
		$data['limit'] 		= $limit;
		$data['statusid'] 	= $statusid;
		$data['sort'] 		= $sort;
		$data['order'] 		= $order;
		$data['ci_ctrl'] 	= $ci_ctrl;
		$data['ci_changePage'] = $ci_changePage;
		$data['result_id'] 	= $result_id; 
		$data['indexData']  = $this->indexDataLog($curpage,$limit,$statusid,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$type); 
		$this->load->view('log/trace_log_viewer',$data);  
	} 
	
	
 
	
	
	function string_request($id,$str){
  
		$data['data']  = '<pre style="padding:0px 15px; font-size:13px;">'.str_replace("&&","<br>",str_replace("---","<br>",$str)).'</pre>'; 
		$this->load->view('pop_data',$data);  
		
	}

 
	function indexDataLog($curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$type){ 
 
		if($order=="asc") 		$orderO="desc";
		elseif($order=="desc") 	$orderO="asc"; 
		$content=$disableAll=''; 
		
		$w = 320;
		$h = 320;
		$start=($curpage*$limit)-$limit; 
		if($start >= 0){
		
			if($type==0){  
				//$arr_fields = array('id','datetime','ip','vm','type','refid','txid','msg','xdata','response_status','string_request'); 
				//$qData=$this->allmodel->selectLog($start,$limit,$status_id,$sort,$order,'cmd'); 
				//$logType = "server_command";
			} 			
			elseif($type==1){  
				$arr_fields = array('id','transaction_type','transaction_id','transaction_date','card_number','card_serialnumber','member_credit','merchant_id','merchant_product', 'string_request','edit'); 
				$qData=$this->allmodel->selectLog($start,$limit,$status_id,$sort,$order,'tfc_trx'); 
				$logType = "card_transaction";
			} 
			/*
			elseif($type==2){ 
				$arr_fields = array('id','kdtrx','dt','tm','vmid','totaltrx','uangmasuk','cardfull','kartukeluar','sisakartu','string_request');  
				$qData=$this->allmodel->selectLog($start,$limit,$status_id,$sort,$order,'tbk'); 
				$logType = "tutup_buku";
			}	
			elseif($type==3){ 
				$arr_fields = array('id','kdtrx','dt','tm','vmid','stprinter','stba','stcd','string_request');  
				$qData=$this->allmodel->selectLog($start,$limit,$status_id,$sort,$order,'ckd'); 
				$logType = "check_device";
			}				
			elseif($type==4){ 
				$arr_fields = array('id','terminal_id','datetime_settle','date','nik','terminal','institution','has_settle','type','value','samid','cardid',
					'kaid','sam','report_ka','has_push','ka_idx','ka_balance','ka_counter','sam_counter','trx_counter','kl_id','card_balance',
					'slot','another','uangmasuk','uangkeluar','string_request'); 
				$qData=$this->allmodel->selectLog($start,$limit,$status_id,$sort,$order,'topup_mandiri'); 
				$logType = "topup_mandiri";
				
				$h = 500;
			}  			
			elseif($type==5){ 
				$arr_fields = array('id','terminal_id','datetime_settle','date','tm_id','settfile','slot','counterbegin',
					'counterend','totaltrx','inst','shift','string_request'); 
				$qData=$this->allmodel->selectLog($start,$limit,$status_id,$sort,$order,'topup_settlement_mandiri'); 
				$logType = "topup_settlement";
				$w = 500;
				$h = 300;
			}
			*/

			if($qData->num_rows()){ 
				$col1 = "#ffffff";
				$col2 = "#f6f6f6";
				$col3 = "#FFDDFF";
				 
				//if($this->session->userdata('AccessType')=='admin') $disableAll = ''; 
				//if($this->session->userdata('AccessType')=='user')  $disableAll = ' disabled="disabled" '; 
 
				 $content.=
						'<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#bbbbbb">
						<thead>
							<tr bgcolor="#666666" class="style4 lightgrey">
							  <td align="center">No.</td>';
							  
						foreach($arr_fields as $k => $varKey){
							
							$w100 = '';
							if($varKey=='string_request')
							$w100 = ' align="right" ';
							
							if($varKey!='id')
							$content .='<td'.$w100.'><a class="lightgrey" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$logType.'/1/'.$limit.'/'.$status_id.'/'.$varKey.'/'.$orderO.'\')">'.$varKey.'</a></td>';
					
						}
						$content.='  
							</tr>
						</thead>
						<tbody>';
				  
				$x=$start+1;
				foreach($qData->result_array() as $row){
					$n = fmod($x,2); 
					if($n) $clr = $col1;
					else   $clr = $col2;
					 
					$content.='<tr bgcolor="'.$clr.'">';
					
					$content.='
					  <td align="right">'.$x.'.&nbsp;</td>';
					   
					foreach($arr_fields as $k => $varKey){ 
					  	if($varKey!='id'){
						
							if($varKey!='xstring_request'){
							$content.='
								<td>'.$row[$varKey].'</td>';
						 	}else{
							$content.='
								<td width="100%" align="right">'; 
								
							//if($varKey=='string_request')
							//$content.= "xxxx";//str_replace("/","---",$row['string_request']);
							//else	
							$content.='	
								<input name="" type="button" value="View"  onclick="popupwindow(\'/trace_log_viewer/string_request/'.$row['id'].'/'.str_replace("/","---",$row['string_request']).'\', \'View String Request\',\''.$w.'\', \''.$h.'\')" />';
							
							$content.='
								</td>';
							} 
						} 
					 } 
					  
 
					
					$content.='</tr>'; 
					$x++;
				}	
				 
			}
		}
		$content.='</tbody>';
		$content.='</table>';		
		
		$content.=$this->pagenav($curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$type);
		
		return $content;
	} 
	
	function pagenav($curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$type){
	
		if($type==1) $tbl='tfc_trx'; 
		
		$cData=$this->allmodel->countLog($tbl); 
		 
		
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
				$var.='<a href="javascript:void(0);loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/'.$prev.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'/'.$type.'\',\''.$result_id.'\')"><img src="/asset/icons/arrow_left.gif" width="16" height="16" />prev</a>';
				$var.='&nbsp; &nbsp;'; 
				$var.='<a href="javascript:void(0);loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/'.$next.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'/'.$type.'\',\''.$result_id.'\')">next<img src="/asset/icons/arrow_right.gif" width="16" height="16" /></a>';
				$var.='&nbsp; &nbsp;'; 
			
			$var.='		</td>';
				
			$var.='		<td width="100%" nowrap="nowrap" >';
							$var.='&nbsp; &nbsp;Page: <select name="page" id="page" onchange="loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/\'+$(this).val()+\'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'/'.$type.'\',\''.$result_id.'\')">'; 
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
				$var.='Show <select name="view" id="view" onchange="loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/1/\'+$(this).val()+\'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'/'.$type.'\',\''.$result_id.'\')" >';
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
	function changepage($curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$type){ 
		$data['data']=$this->indexDataLog($curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_changePage,$result_id,$type);
		$this->load->view('data_view',$data);
	} 
 	 
}
