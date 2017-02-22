<?php  
//session_start();  
class Tools extends Controller { 
	function Tools(){   
		parent::Controller(); 
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		$this->load->library('allfunc');   
		$this->load->database();   
	} 
	function index(){  
  
     	$data['pageTITLE'] = 'Lunari Web Admin - Tools';
		
		$arr_vm[0]['val'] =  "25.196.36.42/VM000";
		$arr_vm[0]['txt'] =  "VM000 - BM-Notebook - 25.196.36.42";
		$arr_vm[0]['pathupload'] =  "d:\upload";
		
		$arr_vm[1]['val'] =  "25.197.173.93/VM001";
		$arr_vm[1]['txt'] =  "VM001 - BM-VM1 - 25.197.173.93";
		$arr_vm[1]['pathupload'] =  "o:";
		
		$arr_vm[2]['val'] =  "25.196.235.207/VM002";
		$arr_vm[2]['txt'] =  "VM002 - BM-PC-Office - 25.196.235.207";
		$arr_vm[2]['pathupload'] =  "p:";
		
		$arr_vm[3]['val'] =  "25.99.59.236/VM003";
		$arr_vm[3]['txt'] =  "VM003 - P-SIGIT - 25.99.59.236";
		$arr_vm[3]['pathupload'] =  "";
		
		$arr_vm[4]['val'] =  "25.100.127.173/VM004";
		$arr_vm[4]['txt'] =  "VM004 - PC-KIOSK1 - 25.100.127.173";
		$arr_vm[4]['pathupload'] =  "";
		
		$str_result = "";
		foreach($arr_vm as $key => $value){
		  $str_result .= '<option value="'.$arr_vm[$key]['val'].'"  >'.$arr_vm[$key]['txt'].'</option>
		  				 ';  
		}	
		$data['selectvm'] = $str_result ; 
		$this->load->view('tools',$data); 
 
   
	}  
	function upload(){  
  
     	$data['pageTITLE'] = 'Lunari Web Admin - Upload';
		
	$arr_vm[0]['val'] =  "25.196.36.42/VM000";
		$arr_vm[0]['txt'] =  "VM000 - BM-Notebook - 25.196.36.42";
		$arr_vm[0]['pathupload'] =  "d:\upload";
		
		$arr_vm[1]['val'] =  "25.197.173.93/VM001";
		$arr_vm[1]['txt'] =  "VM001 - BM-VM1 - 25.197.173.93";
		$arr_vm[1]['pathupload'] =  "o:";
		
		$arr_vm[2]['val'] =  "25.196.235.207/VM002";
		$arr_vm[2]['txt'] =  "VM002 - BM-PC-Office - 25.196.235.207";
		$arr_vm[2]['pathupload'] =  "p:";
		
		$arr_vm[3]['val'] =  "25.99.59.236/VM003";
		$arr_vm[3]['txt'] =  "VM003 - P-SIGIT - 25.99.59.236";
		$arr_vm[3]['pathupload'] =  "";
		
		$arr_vm[4]['val'] =  "25.100.127.173/VM004";
		$arr_vm[4]['txt'] =  "VM004 - PC-KIOSK1 - 25.100.127.173";
		$arr_vm[4]['pathupload'] =  "";
		
		foreach($_POST as $key => $value){ //echo "$key => $value<br>"; 
			if($value == "Upload") $field = $key; 
			if($key == "strvmslc") {
				$vmstring = $value;
				foreach($arr_vm as $k => $v)
				foreach($v as $kk => $vv){
				// echo "$kk => $vv<br>"; 

					 if($vmstring == $vv) $uploadpath = $arr_vm[$k]['pathupload'];
				}
			
			} 
		} 
		//echo $field;
		//echo "<br>".$uploadpath;
		//exit; 
		 
		$server_path = $_SERVER['DOCUMENT_ROOT']."/upload/".basename($_FILES[$field]['name']); 
		$client_path = $uploadpath."/".basename($_FILES[$field]['name']); 

 		if(move_uploaded_file($_FILES[$field]['tmp_name'], $server_path)) {
			 
			if (copy($server_path, $client_path)) {
    			echo "File ".basename( $_FILES[$field]['name'])." berhasil diupload.";
			} else echo "Failed to copy ".basename( $_FILES[$field]['name'])."...\n";
     		
			echo "<br><br><a href=tools/>Back</a>";
 		}
 
   
	}  
}
