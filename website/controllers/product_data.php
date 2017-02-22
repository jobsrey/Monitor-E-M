<?php  
//session_start(); 
//error_reporting(E_ALL ^ E_NOTICE);
 
class Product_data extends Controller { 
	function Product_data(){   
		parent::Controller(); 
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		$this->load->library('allfunc'); 
		$this->load->library('funcdbindex');  
		$this->load->database(); 
		$this->load->library('session'); 
		//if(!$this->session->userdata('logged_in')) redirect('login','refresh');
		  
	} 
	function index(){ 
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
		$data['TABLE'] 		= "pd_".$_ci_func;   
		$strTable 			= ucwords(str_replace("_"," ",$data['TABLE'])); 
		
     	$data['status_id'] 	= $_status_id;  
     	$data['limit'] 		= $_limit;  
		
     	$data['pageTITLE']	= ucwords(str_replace("_"," ",$data['ci_ctrl'].' - '.str_replace("Pd ","",$strTable)));  
     	$data['pageLABEL'] 	= ucwords(str_replace("_"," ",$data['ci_menu'].' > '.str_replace("Pd ","",$strTable)));  
 
		return $data;
		  
		//echo __CLASS__;  
		//echo __FUNCTION__; 	exit;
		//echo __METHOD__; 		exit; //Dealer_terminal::mainvars

	} 
	
	function product ($curpage=1,$limit=10,$status_id=1,$sort="id",$order="asc",$ci_ctrl=__CLASS__,$ci_changePage="changepage",$result_id="dspdata"){  
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit); 
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;  
		$data = $this->indexpage($data); 
	}  
	function product_price ($curpage=1,$limit=10,$status_id=1,$sort="id",$order="asc",$ci_ctrl=__CLASS__,$ci_changePage="changepage",$result_id="dspdata",$where="",$is_pop=0){  
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit); 
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;  

		$product_id_list = 0;
		if(!empty($where)) $product_id_list = str_replace("where-product_id--","",$where);

		$content ='';
 		$strOnChange = " onchange=\"loadcontent('".base_url().$ci_ctrl."/product_price_ajax/".$curpage."/".$limit.
				"/$status_id/item_name/$order/$ci_ctrl/$ci_changePage/$result_id/where-product_id--'+$('select#selProduct').val()+' ','$result_id')\" ";	
		$content .= '<div style="padding:0 0 8px;border-bottom:0px solid grey;margin-bottom:8px;display:block;"> Select Product: ';  
		$content .= $this->allfunc->listmenu('pd_product','product',1,$product_id_list,'',0,'selProduct','','All',$strOnChange);  
		$content .= '</div>'; 

		$data['ci_ctrl'] = strtolower($data['ci_ctrl']);  
		$data['headerData'] = $content;
		$data['indexData']  = $this->funcdbindex->indexDataTable($data['ci_ctrl'],$data['ci_func'],$data['TABLE'],$data['curpage'],$data['limit'],$data['status_id'],$data['sort'],$data['order'],$data['ci_changePage'],$data['result_id'],0,"where-product_id--".$product_id_list,$is_pop); 
		
		if($is_pop==2){ 
			$gProduct = '';
			$gProduct = $this->allfunc->getTableWhere('pd_product','id',$product_id_list);
			if(isset($gProduct[0]['product'])) if(!empty($gProduct[0]['product'])) $gProduct = ' : '.$gProduct[0]['product'].' - '.$gProduct[0]['description'];
			 
			$data['pageTITLE']	= 'Product Price'.$gProduct;  
			$data['pageLABEL'] 	= 'Product Price'.$gProduct;  
			$this->load->view('index/table_only_data_view',$data); 
		}
		else
		$this->load->view('index/table_data_view',$data);
		
		
		
	}  
	function product_price_ajax ($curpage=1,$limit=10,$status_id=1,$sort="id",$order="asc",$ci_ctrl=__CLASS__,$ci_changePage="changepage",$result_id="dspdata",$where="",$is_pop=0){  
		$data = $this->mainvars(__FUNCTION__,$status_id,$limit); 
		foreach($data as $key => $val) if(isset($$key)){
			 $data[$key] = $$key;   
		} 
		$TABLE = "pd_product_price";   
		$data['data'] = $this->funcdbindex->indexDataTable($ci_ctrl,$ci_func,$TABLE,$curpage,$limit,$status_id,$sort,$order,$ci_changePage,$result_id,0,$where,$is_pop); 
		$this->load->view('data_view',$data);
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
	
	function select_db($useTable=''){
 
		if($useTable=='md_product_vendor') 	  { $useKey = 'vendor';		 $listname = 'vendor_id'; }
		elseif($useTable=='authorize_dealer') { $useKey = 'dealer_name'; $listname = 'dealer_id'; }	
 
		if($useTable) 
		echo $this->allfunc->listmenucalljs($useTable,$useKey,1,0,'',0,'suplier_id','suplier_idx','');
		//echo '<input type=" " name="suplier_db" id="suplier_db" value="'.$useTable.'" />'; 
		 
	}
 
	//--- edit data 
	function edit_data($id,$ci_func,$is_ajax=0){  
	
	    //$ci_func = 'product_price';
	 
	
		$data 				= $this->mainvars($ci_func);   
		$strTable 			= ucwords(str_replace("_"," ",$ci_func)); 
 
	 	$mode = "Edit";
		if(empty($id))$mode = "Add New"; 
     	$data['pageLABEL'] 	= $data['pageLABEL']." > $mode Data";   
 
		$data['id'] 		= $id; 
		$data['tablemod']  	= $mode; 
		$data['tablelbl']  	= $strTable; 
		//echo $data['TABLE']; exit; 
 
		//--get data db -> for non ($data['TABLE']=="md_terminal_locationx"
		if($data['id']){
			$gData = $this->allmodel->getTableByID($data['TABLE'],$data['id']);
			 
			if(!empty($gData))
			foreach($gData as $key => $val){ // echo "<br>$key => $val";
			 	$data[$key] = $val;
 
			} 
		}  
		 
		 
		//$data['editFormTable']	 = $this->funcdbindex->editFormTable($data);
		$data['editFormTable']	 = $this->funcdbindex->editFormProduct($data);
 
		
		$this->load->view('index/edit_data_view',$data);   
	} 
 
	//------------------------------------------------------------------------------------------------------------------------------------------
	function qedit(){ 
 
		//foreach($_POST as $k => $v) echo "<br>$k => $v"; // exit; 
 		
		//-- delete items
		if(isset($_POST['bdel'])) if($_POST['bdel']=="DELETE"){		 
			$q = "UPDATE `".$_POST['TABLE']."` SET `status_id` = 0 WHERE `id` = '".$_POST['id']."' LIMIT 1"; 
			$this->db->query($q);
			//--create log
			$this->allfunc->createLog('user',$this->session->userdata('ID'),strtolower(__CLASS__),$_POST['TABLE'].' - DEL id: '.$_POST['id']);
		    redirect('/'.strtolower(__CLASS__).'/'.$_POST['ci_func'].'/','refresh');  
			exit;
		}
 		
		$qstr1 = $qstr2 = $qstr3 = ''; 
		$suplier_idx = $suplier_id = '';
		foreach($_POST as $k => $v){  //echo "<br>$k => $v"; 
			/*
			TABLE => pd_product
			ci_func => product
			id => 1
			product => eMoney
			description => Prepaid Card Bank Mandiri
			suplier_db => authorize_dealer
			suplier_idx => 3
			button => Submit 
			*/
			$$k = $v; 
				//if($TABLE=='pd_product')
 
				if(   
					($k!="TABLE" && $k!="ci_func" && $k!="button" && $k!="status_id" && $v!="Submit" && $k!="suplier_idx" && $k!="suplier_id")
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
 		
		//-- for product suplier db
		if(isset($suplier_db)){
			if(empty($suplier_id) && $suplier_idx ) $suplier_id = $suplier_idx;  
			if(empty($suplier_db)) $suplier_id = '';  
			$qstr1 .= "`suplier_id`,";
			$qstr2 .= "'".$suplier_id."',"; 
			$qstr3 .= " `suplier_id` = '".$suplier_id."',";
		}
		//echo "<br>";
		
		if(empty($id)){ //-- add new data 
			if($TABLE=='pd_product_price'){
				$qstr1 .= "`modified_date`,`modified_by`,";
				$qstr2 .= "'".date("Y-m-d H:i:s")."',".$this->session->userdata('ID').","; 
			} 
			$qstr1 = substr($qstr1,0,strlen($qstr1)-1);
			$qstr2 = substr($qstr2,0,strlen($qstr2)-1); 
			$q = "INSERT INTO `".$TABLE."` (".$qstr1.")VALUES(".$qstr2.")";
			$this->db->query($q); 
			$cid = mysql_insert_id();  
			
			//--create log
			$this->allfunc->createLog('user',$this->session->userdata('ID'),strtolower(__CLASS__),$_POST['TABLE'].' - ADD id : '.$cid);
			
		 }else{ //-- edit data
		 	// echo $modified_by; exit;
			
			if($TABLE=='pd_product_price'){ 
		 	$qstr3 .= "`modified_date`= '".date("Y-m-d H:i:s")."',`modified_by`=".$this->session->userdata('ID').","; 
			}
			$qstr3 = substr($qstr3,0,strlen($qstr3)-1); 
			//if(isset($modified_by)){
				
			//} 
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
