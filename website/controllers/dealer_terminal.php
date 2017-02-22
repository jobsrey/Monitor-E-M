<?php  
//session_start(); 
//error_reporting(E_ALL ^ E_NOTICE);
 
class Dealer_terminal extends Controller { 
	function Dealer_terminal(){   
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
 
		$data['navMenu']   	= $this->allfunc->navMenu(3);  
		$data['ci_menu'] 	= $this->allfunc->navMenu(3,1);
		$data['ci_ctrl'] 	= strtolower(__CLASS__);  
     	$data['ci_func']	= $_ci_func; 
		$data['TABLE'] 		= $_ci_func;   
		$strTable 			= ucwords(str_replace("_"," ",$data['TABLE'])); 
		
     	$data['status_id'] 	= $_status_id;  
     	$data['limit'] 		= $_limit;  
		
     	$data['pageTITLE']	= ucwords(str_replace("_"," ",$data['ci_ctrl'].' - '.str_replace("Md ","",$strTable)));  
     	$data['pageLABEL'] 	= ucwords(str_replace("_"," ",$data['ci_menu'].' > '.str_replace("Md ","",$strTable)));  
 
		return $data;

	} 
	
	function authorize_dealer($curpage=1,$limit=10,$status_id=1,$sort="id",$order="asc",$ci_ctrl=__CLASS__,$ci_changePage="changepage",$result_id="dspdata"){   
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit); 
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;   
		$data = $this->indexpage($data); 
	} 
	 
	function vending_terminal($curpage=1,$limit=10,$status_id=1,$sort="id",$order="asc",$ci_ctrl=__CLASS__,$ci_changePage="changepage",$result_id="dspdata"){   
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
	
	
	function listgevalue($table,$rowname2,$status_id2,$selected2,$where_key2,$selectid,$selectname2,$result_id2,$firstitem1=''){
		//$table2,$rowname2,$status_id2,$where_key2,$result_id2 
		$gData = $this->allmodel->getTableByID($table,$selectid);
		//foreach($gData as $key => $val) echo "<br>$key => $val";
		echo $gData['vendor'];
		 
	}
		
	function getvendorname($table,$rowname2,$status_id2,$selected2,$where_key2,$selectid,$selectname2,$result_id2,$firstitem1=''){
		//$table2,$rowname2,$status_id2,$where_key2,$result_id2 
		$gData = $this->allmodel->getTableByID($table,$selectid);
		// foreach($gData as $key => $val) echo "<br>$key => $val";
		
		 
		/* 
		id => 5
		product => Flazz
		description => Prepaid BCA
		suplier_db => md_product_vendor
		suplier_id => 2
		status_id => 1
		*/
		$tbl = $gData['suplier_db'];
		$sid = $gData['suplier_id'];
		 
		$pkey = str_replace("vendordata",'',$result_id2);
			
		if(!empty($tbl)){
			$vData = $this->allmodel->getTableByID($tbl,$sid);
			//foreach($vData as $key => $val) echo "<br>$key => $val"; 
			//id => 3
			//dealer_name => Telesindo 
			
			if($tbl=='md_product_vendor') echo $vData['vendor'];
			if($tbl=='authorize_dealer')  echo $vData['dealer_name'];
		
		}
		
		 
	}
	
	function product_price ($tid,$id){
	
	    //$curpage=1;$limit=100;$status_id=1;$sort="id";$order="asc";
		//$ci_ctrl=__CLASS__;$ci_changePage="changepage";$result_id="dspdata";
		//$where="";$is_pop=0; 

		if($_POST){ 
			// foreach($_POST as $key => $value) echo "<br>$key => $value";	exit;
			/*			 
			terminal_price_xxx0 => 20000
			price_id_0 => 5
			terminal_price_xxx1 => 40000
			price_id_1 => 6
			terminal_price_xxx2 => 100000
			price_id_2 => 7
			terminal_price_xxx3 => 200000
			price_id_3 => 8
			
			tid => 3
			pid => 3
			redir => /dealer_terminal/product_price/3/3
			submit => Update Price
			*/
			$x=0;
			foreach($_POST as $key => $val){ 
				if(substr($key,0,15)=='terminal_price_'){
					
					$prc_id = "price_id_".$x; 
					$price_id = $_POST[$prc_id]; 
					//echo "<br>product_price_id = ".$price_id;
					
					$terminal_price_id='';
					if(substr($key,0,18)=='terminal_price_xxx') $terminal_price_id = '';  
					else {
						$tp_id = substr($key,15,strlen($key)); 
					 	$terminal_price_id = $tp_id; 
					}  
					//echo "<br>terminal_price_id = ".$terminal_price_id; 
					
					$terminal_price = $val;  
					//echo "<br>terminal_price = ".$terminal_price;
					
					//product_price_id = 5
					//terminal_price_id =
					//terminal_price = 20000
					
					if($terminal_price_id){
						$q = "UPDATE `terminal_price` SET  
						`terminal_price` = '".$terminal_price."'  
						WHERE `id` = '".$terminal_price_id."' LIMIT 1"; 
						$this->db->query($q);
						//--create log
						//$this->allfunc->createLog('user',$this->session->userdata('ID'),strtolower(__CLASS__),$_POST['TABLE'].' - DEL id: '.$_POST['id']);
					}else{
						$q = "INSERT INTO `terminal_price` (
						`id` ,
						`product_price_id` ,
						`terminal_id` ,
						`terminal_price` ,
						`modified_date` ,
						`modified_by` ,
						`status_id`
						) VALUES (
						NULL , 
						'".$price_id."',
						'".$_POST['tid']."', 
						'".$terminal_price."', 
						'".date('Y-m-d H:i:s')."' , 
						'".$this->session->userdata('ID')."', 
						'1'
						)"; 
						$this->db->query($q);
						//--create log
						//$this->allfunc->createLog('user',$this->session->userdata('ID'),strtolower(__CLASS__),$_POST['TABLE'].' - DEL id: '.$_POST['id']);
 
					}  
					$x++;
				}  
			}
			 
		 	redirect($_POST['redir'],'refresh');  
			exit;
 		 
			 
			 
		
		}
 
		$data['TABLE']   = 'pd_product_price';   
		 
		$data['indexData']  = $this->indexDataPrice($tid,$id); 
 
		$strProduct = '';
		$gProduct = $this->allfunc->getTableWhere('pd_product','id',$id); 
		
		if(isset($gProduct[0]['product'])) if(!empty($gProduct[0]['product'])) 
		$strProduct = ' : '.$gProduct[0]['product'].' - '.$gProduct[0]['description'];
		$data['pageTITLE']	= 'Terminal Product Price'.$strProduct;  
		$data['pageLABEL'] 	= 'Terminal Product Price'.$strProduct;  
		$data['is_pop'] 	= 2; 
		$this->load->view('index/table_only_data_view',$data); 
 
	}  
	
	function indexDataPrice($tid,$pid){ 
	
									//	$rowProduct 	= $this->allmodel->getTableByID('pd_product',$arrProduct_id[$pkey]);
									//$rowVendor 		= $this->allmodel->getTableByID('md_product_vendor',$arrVendor[$pkey]);
									//$rowDelivery 	= $this->allmodel->getTableByID('md_product_delivery',$arrDelivery[$pkey]);
									//$rowAlert 		= $this->allmodel->getTableByID('md_respons_code',$arrAlert[$pkey]);
									
		
		$ci_ctrl = ''; 
 
		if($order=="asc") 		$orderO="desc";
		elseif($order=="desc") 	$orderO="asc"; 
		
		$content = '';   
 
		$q = "select   
				a.id, a.product as product_name, b.id as price_id, b.item_name, b.item_price, b.modified_date , 
				c.terminal_price, c.id as terminal_price_id  
				from pd_product a  
				Left join pd_product_price b on b.product_id = a.id   
				Left join terminal_price c on c.product_price_id = b.id  
				Where a.id = ".$pid." Order By product_name asc 
				limit 0,100 " ; //
 
		$qData = $this->db->query($q);
		
		 
		if($qData->num_rows()){ 
			$col1 = "#ffffff"; $col2 = "#f6f6f6"; $disable= '';  
 
			$content.='
				<table id="tableindex" width="" border="0" cellpadding="5" cellspacing="1" bgcolor="#bbbbbb">
				    <form action="/dealer_terminal/product_price" method="post"> 
					  ';
				 
			$content.='
				   <thead>
					  <tr bgcolor="#666666"> 
						  <td class="lightgrey">No.</td>
						  <td class="lightgrey">Product</td>
						  <td class="lightgrey">Item Name</td>
						  <td class="lightgrey">Price</td>
						  <td class="lightgrey">Terminal Price</td> 
						</tr>
					</thead>'; 
			 	
			$content.='
					<tbody>';
					
				  
			$x=0;
			foreach($qData->result_array() as $row){
				
					$n = fmod($x,2); 
					if($n) $clr = $col1;
					else   $clr = $col2;
					 
					$content.='
					<tr bgcolor="'.$clr.'"> 
					
					  <td align="right">'.($x+1).'.&nbsp;</td>'; 
					 
					$tpid = $row['terminal_price_id'];
					if(empty($tpid)){
						
						$tpid = "xxx". $x;
						
					}
					
					$content.=' 
					  <td>'.$row['product_name'].'</td>
					  <td>'.$row['item_name'].'</td>
					  <td align="right">'.$row['item_price'].'</td>
					  <td align="right"> 
					  <input type="text" name="terminal_price_'.$tpid.'" id="terminal_price_'.$tpid.'" value="'.$row['terminal_price'].'" />
					  
					  <input name="price_id_'.$x.'" type="hidden" value="'.$row['price_id'].'" />
					  
					  </td>
					  
					  
					  ';  
					$content.='</tr>'; 
					$x++;
					
				}	
				 
			}
 
		$content.='</tbody>';
		$phpself = str_replace("index.php/","",$_SERVER['PHP_SELF']);
		
		//   /index.php/dealer_terminal/product_price/1/100/1/product_id/asc/dealer_terminal/changepage/dspdata/where-product_id--3/2 
		$content.='<tr>';
		$content.='	<td colspan="5" align="right">
		<input name="tid" type="hidden" value="'.$tid.'" />
		<input name="pid" type="hidden" value="'.$pid.'" />
		<input name="redir" type="hidden" value="'.$phpself.'" />
		<input type="submit" name="submit" value="Update Price" >
		</td>';
		$content.='</tr>';
		$content.='</form>';
		$content.='</table>';		
		$content.='<div class="linebot"></div>';
		 	 
 
		return $content;
		
	}
	//------------------------------------------------------------------------------------------------------------------------------------------
		
	//--- edit data
	
	function edit_data($id,$TABLE,$product_id='',$product_vendor_id='',$product_delivery_id='',$trx_code_id='',$add=0){  
		
		$data 				= $this->mainvars($TABLE); 
		 
		$strTable 			= ucwords(str_replace("_"," ",$TABLE));
	 	$mode = "Edit";
		if(empty($id))$mode = "Add New"; 
     	$data['pageLABEL'] 	= $data['pageLABEL']." > $mode Data";   
		
		$data['id'] 		= $id;  
		$data['TABLE']     	= $TABLE;  
		$data['tablemod']  	= $mode; 
		$data['tablelbl']  	= $strTable;  
 
		$data['product_id']			 = $product_id; 
		$data['product_vendor_id']   = $product_vendor_id;  
		$data['product_delivery_id'] = $product_delivery_id; 
		$data['trx_code_id'] 		 = $trx_code_id; 
		
		$data['cur_product_id']			 = $product_id; 
		$data['cur_product_vendor_id']   = $product_vendor_id;  
		$data['cur_product_delivery_id'] = $product_delivery_id; 
		$data['cur_trx_code_id'] 		 = $trx_code_id; 
 
		if($add=='add')
		$data['add'] = $add; 
		elseif($add=='done')
		$data['done'] = $add; 
		 
		//--get data db
		if($id){
			$gData = $this->allmodel->getTableByID($TABLE,$id);
			foreach($gData as $key => $val){ //echo "<br>$key => $val";
			 	$data[$key] = $val;
			}
		}else{ 
			
			//$arr_fields_type = $this->allmodel->getTableKeysType($TABLE,'all');  
			//$x=0;
			//foreach($arr_fields_type as $key => $val){ 
				//$data[$x] = $key; $x++;
			//}
		}
 
		$data['is_pop'] = $is_poduct = 0; 
		if( strlen($product_id)==1 && strlen($product_vendor_id)==1 && strlen($product_delivery_id)==1 ) {
			$data['is_pop'] = 1;  
     		$data['pageLABEL'] 	= $data['pageLABEL']." > Product"; 
			$is_poduct = 1;
		}

		
		//foreach($data as $key => $val) echo "<br>$key => $val"; exit;	 
		
		if($is_poduct)
		$data['editFormTable']	 = $this->funcdbindex->editFormProductVT($data);
		else
		$data['editFormTable']	 = $this->funcdbindex->editFormTable($data);
 
		$this->load->view('index/edit_data_view',$data);  
		//error_reporting(E_ALL);
	}  
	
	function qedit(){ 
 
		//foreach($_POST as $k => $v) echo "<br>$k => $v";  exit; 
 
		if(isset($_POST['bdel'])) if($_POST['bdel']=="DELETE"){		 
			$q = "UPDATE `".$_POST['TABLE']."` SET `status_id` = 0 WHERE `id` = '".$_POST['id']."' LIMIT 1"; 
			$this->db->query($q); 
			//--create log
			$this->allfunc->createLog('user',$this->session->userdata('ID'),strtolower(__CLASS__),$_POST['TABLE'].' - DEL id: '.$_POST['id']);
		    redirect('/'.strtolower(__CLASS__).'/'.$_POST['ci_func'].'/','refresh');  
			exit;
		}
 		
		$qstr1 = $qstr2 = $qstr3 = ''; 
		foreach($_POST as $k => $v){ //echo "<br>$k => $v"; 
			$$k = $v; 
			if( 
				($k!="TABLE" && $k!="ci_func" && $k!="button" && $k!="status_id" && $v!="Submit" && $k!='redir') 
				&&
				( substr($k,0,10)!='product_id' && 	substr($k,0,13)!='delivery_type' && substr($k,0,8)!='trx_code')	
			){ 
				$qstr1 .= "`".$k."`,";  
				if($k=="id")    $qstr2 .= "'',"; 
				else 			{$qstr2 .= "'".$v."',";  
				
				$qstr3 .= "`".$k."` = '".$v."',";}  
			}  
			if( substr($k,0,10)=='product_id' ){
				$p_key = substr($k,10,strlen($k));
				$p_val = $v; 
				$product_ids[$p_key] = $p_val; 
				$vendor_ids[$p_key] = $this->allmodel->getTableWhere('pd_product','id',$p_val,1,'id','suplier_id'); 
				
			} 
			if( substr($k,0,13)=='delivery_type' ){
				$d_key = substr($k,13,strlen($k));
				$d_val = $v; 
				$delivery_types[$d_key] = $d_val;
			} 
			if( substr($k,0,8)=='trx_code' ){
				$t_key = substr($k,8,strlen($k));
				$t_val = $v; 
				$trx_codes[$t_key] = $t_val;
			} 
			
		}
		//$product_ids
		if(isset($product_ids)){
			$im_product_id = implode(",",$product_ids); 
			$qstr3 .= " `product_id`= '".$im_product_id."',";
			
			$im_vendor_id = implode(",",$vendor_ids); 
			$qstr3 .= " `product_vendor_id`= '".$im_vendor_id."',";
			
			$im_delivery_type = implode(",",$delivery_types); 
			$qstr3 .= " `product_delivery_id`= '".$im_delivery_type."',";
			
			$im_trx_code = implode(",",$trx_codes); 
			$qstr3 .= " `trx_code_id`= '".$im_trx_code."',";
			
			//-- get vendor id from product id
			
			
			
		}
 
		//foreach($product_ids as $k => $v) echo "<br>$k => $v";   
		
		
///------------------  product_delivery_id 	product_vendor_id 	product_alert_id 	trx_code_id
///---- VENDOR IDS!!!!
		
		
		/* 
		TABLE => vending_terminal
		ci_func => vending_terminal
		id => 3
		redir => http://lunari/dealer_terminal/edit_data/3/vending_terminal/1/1/1/1
		
		product_id0 => 1
		delivery_type0 => 1
		trx_code0 => 1
		
		product_id1 => 2
		delivery_type1 => 7
		trx_code1 => 10
		
		product_id2 => 3
		delivery_type2 => 5
		trx_code2 => 9
		
		button => Submit
		*/
		
		
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
 
 
 
		if(isset($product_ids)){
			redirect(str_replace("http://25.59.210.248/","/",$redir."/done"),'refresh'); 
			 
		}
		else
		redirect('/'.strtolower(__CLASS__).'/edit_data/'.$cid.'/'.$ci_func.'/','refresh'); 
	}
	
	//------------------------------------------------------------------------------------------------------------------------------------------ 
	
	 
	
	//------------------------------------------------------------------------------------------------------------------------------------------ 
}
