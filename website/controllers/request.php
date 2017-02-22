<?php  
//session_start(); 
 
class Request extends Controller {  

	function Request()  
	{ 
		parent::Controller();   
		$this->load->helper('url');  		
		$this->load->model('allmodel'); 
		$this->load->library('allfunc');  
		$this->load->database();  
	} 
	
	function index(){  
	
	} 
	
	function submit($num,$type,$ip,$vm,$msg="",$trxid=0,$xdata=""){ 

		$data['dt'] 		= $dt = date("Y-m-d H:i:s"); 
		$data['d'] 			= $d  = date("Y-m-d");   
		$data['t'] 			= $t  = date("H:i"); 
		 
		$data['type'] 		= $type; 
		$data['ip'] 		= $ip; 
		$data['vm'] 		= $vm; 
		
		if($trxid==0){ //non trx 
		 	$data['trxid'] 		= 'Non Transaction'; 
			$txid = 0;
		}else{
		 	$data['trxid'] 		= $txid = $trxid; 
		}
		
		$data['msg'] 		= str_replace("%20"," ",$msg); 
		
		$data['xdata'] 		= str_replace("%20"," ",$xdata); 
		
		$data['pageTITLE'] 	= $data['msg'];
			
		if($num==1){
		    $data['response']	= "?dt=".$d."&time=".$t."&client_ip=".$ip."&vm_id=".$vm;
		}elseif($num<=6){  
		    $data['response']	= "?dt=".$d."&time=".$t."&vm_id=".$vm."&msg=".$data['msg'];
		}elseif($num<=12){ 
		    $data['response']	= "?dt=".$d."&time=".$t."&vm_id=".$vm."&txid=".$data['trxid']."&card=".$data['xdata'];
		}elseif($num<=14){   
		    $data['response']	= "?dt=".$d."&time=".$t."&vm_id=".$vm."&txid=".$data['trxid']."&msg=".$data['msg']."&payment=".$data['xdata'];
		}elseif($num<=16){ 
		    $data['response']	= "?dt=".$d."&time=".$t."&vm_id=".$vm."&txid=".$data['trxid']."&msg=".$data['msg']."&status=".$data['xdata'];
		}elseif($num=17){  
		    $data['response']	= "?dt=".$d."&time=".$t."&vm_id=".$vm."&txid=".$data['trxid']."&msg=".$data['msg']."&status=".$data['xdata'];
		}  
		
		
 
		 
		$data['error'] 		= "";  
		  
			$kirim = $this->allfunc->sendresponse($data['ip'],$data['vm'],$data['response']);
  
			if($kirim) $data['error'] = 1; 	// ok
			else $data['error'] = 0; 		// error
 			//echo 'error='.$data['error'];
			
		if($num<17){ 
		
			//-- store to database
			 
			$q = "INSERT INTO `cmd` (`id`, `datetime`, `ip`, `vm`, `type`, `refid`, `txid`, `msg`, `xdata`, `response_status`, `string_request`) 
			VALUES ('', '".$dt."', '".$ip."', '".$vm."', '".$type."', '".$num."', '".$txid."', '".$data['msg']."', '".$data['xdata']."', '".$data['error']."', '".str_replace("/index.php/request","",$_SERVER['PHP_SELF'])."');";
		
			$this->db->query($q);
		
			$this->load->view('pop_request',$data); 
			
		} else {
			$q = "select * from `cmd` Where txid = '".$txid."' Order By ID" ;
			$query = $this->db->query($q);
			 
			
			foreach($query->result_array() as $row){ 
			
				if($row['refid']==11||$row['refid']==12) $data['card'] 		= $row['xdata']; 
				if($row['refid']==13||$row['refid']==14) $data['payment'] 	= $row['xdata'];
				if($row['refid']==15) $data['payment_status']  = $row['xdata'];
				if($row['refid']==16) $data['delivery_status'] = $row['xdata'];
			
			} 
		
			$this->load->view('pop_txresult',$data); 
			
		}	
		 
	} 
	
	
	function pingIP($host){
		//$host = '25.59.210.284'; 
		$port = 555; 
		$waitTimeoutInSeconds = 1; 
		if($fp = fsockopen($host,$port,$errCode,$errStr,$waitTimeoutInSeconds)){   
		   return 1; 
		} else {
		   return 0; 
		} 
		fclose($fp);
	}
	
	function vmping($msg=""){ 
 
		$data['dt'] 		= $dt = date("Y-m-d H:i:s"); 
		$data['d'] 			= $d  = date("Y-m-d");   
		$data['t'] 			= $t  = date("H:i");  
		$data['type'] 		= ''; 
		$data['vm'] 		= '';  
		$data['trxid'] 		= '' ;  
		$data['msg'] 		= str_replace("%20"," ",$msg);  
		$data['xdata'] 		= '';  
		$data['ip'] 		= '';  
 
		$data['pageTITLE'] 	= $data['msg'];
			 
		$data['response']	= "0016000001RQ10010105"; 
 
		$qTerminal = $this->allmodel->getVendingTerminalAll(); 
		
		$str = '';
		 
        if($qTerminal->num_rows())   
		foreach($qTerminal->result_array() as $row){ 
			
			//echo "<br>sendping(".$row['IP'].",".$row['terminal_id'].",".$data['response']."<br>";
		
			$this->pingIP($row['IP']);
			
			$chkPing = $this->pingIP($row['IP']);
			if($chkPing){
 
			//	$kirim = $this->allfunc->sendping($row['IP'],$row['terminal_ID'],$data['response']);
			//	$data['error'] = $kirim;
				
				/*if(substr($kirim,20,2)=="00"){
					$vmid =  substr($kirim,22,strlen($kirim)); 
					*/
					$q    = "UPDATE vending_terminal SET online_status = 1 WHERE id = '".$row['id']."' LIMIT 1"; 
					$this->db->query($q);
					$str .= "Terminal-ID: ".$row['terminal_ID']." - IP: ".$row['IP']." --- Status: <strong>ONLINE</strong><br><br>"; 
					
					echo $qtchk = "INSERT INTO `lunari_mandiri`.`terminal_checking` (
					`ID`, `terminal_ip`, `terminal_id`, 
					`status_ping`, `status_printer`, `status_ba`, `status_cd1`, 
					`status_cd2`, `status_cd3`, `status_cd4`, `check_datetime`, `status_id`
					) VALUES (
					NULL, '".$row['IP']."', '".$row['terminal_ID']."', 
					'00', '', '', '', 
					'NA', 'NA', 'NA', '".date("Y-m-d H:i:s")."', '1')
					";
					//$this->db->query($qtchk);
					
		 		/*
				}else{
					$vmid =  substr($kirim,22,strlen($kirim)); 
					$q    = "UPDATE vending_terminal SET online_status = 0 WHERE terminal_id = '".$row['terminal_id']."' LIMIT 1"; 
					$this->db->query($q);
					$str .= "Terminal-ID: ".$row['terminal_id']." - IP: ".$row['IP']." --- Status: <strong>OFFLINE</strong><br>"; 
				}'*/
				
			}else{
				 
					$q    = "UPDATE vending_terminal SET online_status = 0 WHERE id = '".$row['id']."' LIMIT 1"; 
					$this->db->query($q);
					$str .= "Terminal-ID: ".$row['terminal_ID']." - IP: ".$row['IP']." --- Status: <strong>OFFLINE</strong><br>"; 	
   
   	
			}
		} 
 		$data['strChkVM'] = $str;
 
		$this->load->view('pop_vmtools_ping',$data);  
			
		 
		 
	} 
	 
	function vmtools($num,$type,$ip,$vm,$msg="",$trxid=0,$xdata=""){ 
	//http://25.59.210.248/request/vmtools/	0/vmtools/1/PRINTER/
	 	
 		//$ip = '25.100.127.173';
 //
		$data['dt'] 		= $dt = date("Y-m-d H:i:s"); 
		$data['d'] 			= $d  = date("Y-m-d");   
		$data['t'] 			= $t  = date("H:i"); 
		 
		$data['type'] 		= $type; 
		
		
		$data['ip'] 		=  $ip;  
		if(empty($ip)){
 
		}
		
 
		$data['vm'] 		= $vm; 
		
		if($trxid==0){ //non trx 
		 	$data['trxid'] 		= 'Non Transaction'; 
			$txid = 0;
		}else{
		 	$data['trxid'] 		= $txid = $trxid; 
		}
		
		$data['msg'] 		= str_replace("%20"," ",$msg); 
		
		$data['xdata'] 		= str_replace("%20"," ",$xdata); 
		
		$data['pageTITLE'] 	= $data['msg'];
			
 
		//$data['response']	= "?dt=".$d."&time=".$t."&vm_id=".$vm."&msg=".$data['msg'];
		//$data['response']	= "?dt=".$d."&time=".$t."&vm_id=".$vm."&msg=".$data['msg'];
		
		if($msg=="BLOCK")    $data['response']	= "0016000001RQ10010101";
		if($msg=="UNBLOCK")  $data['response']	= "0016000001RQ10010102";
		if($msg=="SHUTDOWN") $data['response']	= "0016000001RQ10010103";
		if($msg=="RESTART")  $data['response']	= "0016000001RQ10010104";
		
		if($msg=="PING")     $data['response']	= "0016000001RQ10010105";
		
		 
		if($msg=="BA")  	 $data['response']	= "0016000001RQ01010102";
		if($msg=="PRINTER")  $data['response']	= "0016000001RQ02010102";
		if($msg=="CD1")  	 $data['response']	= "0016000001RQ03010102";
		
		
		
		if($msg=="Video")  	 $data['response']	= "0016000001RQ16010101"; //-- respon : 0018000001RS1601010100
		if($msg=="patch")  	 $data['response']	= "0016000001RQ17010101";
		if($msg=="image")  	 $data['response']	= "0016000001RQ18010101";
		
		
		$chkStr = substr($msg,0,5);
		if($chkStr == "JCARD"){
			$num = substr($msg,5,4);  
			$str = "000001RQ12010101;id=1;full=".$num.";";  
			$strRes = "00".strlen($str).$str;
			$data['response']	= $strRes;
		} 
		$chkStr2 = substr($msg,0,5); //passw1=123456;passw2=asdfgh;
		if($chkStr2 == "passw"){
			$str2 = "000001RQ19010101;".$msg.";";   
			$strRes2 = "00".strlen($str2).$str2;
			$data['response']	= $strRes2; 
		}
		
		
		
		
		
		//if($msg="CHK_DEVICE_STATUS")  $data['response']	= "CHK_DEVICE_STATUS";
		
		/*   
			Block ====================================================
			
			000001RQ10010101 				block
			000001RQ10010102 				unblock
			000001RQ10010103 				shutdown
			000001RQ10010104 				restart
			
			000001RQ10010105 				vmid => respon : 000001RQ10010105 + 00 + vmid
			
			Update Database===========================================
			
			000001RQ11010101;id=1;nama=AS;harga=100000;  	Card_copy
			000001RQ12010101;id=1;full=60;  		card_dispenser1_inventory_copy
			
			000001RQ19010101;passw1=123abc;passw2=123abc;  	password
			
			Cek device================================================
			
			000001RQ01010102 				status BA
			000001RQ02010102 				status printer
			000001RQ03010102 				status CD1
		*/
 
		 
		$data['error'] 		= "";  
		
		 
		
		 
		//-- send to client get var error --- blm bisa 
		if($msg=="PING")
		$kirim = $this->allfunc->sendping($data['ip'],$data['vm'],$data['response']);
		else
		$kirim = $this->allfunc->sendresponse($data['ip'],$data['vm'],$data['response']);
 
		//if($kirim) $data['error'] = 1; 	// ok
		//else $data['error'] = 0; 		// error
 		//echo 'error='.$data['error'];
 		$data['error'] = $kirim;
		 
		//-- store to database
 
		$q = "INSERT INTO `cmd` (`id`, `datetime`, `ip`, `vm`, `type`, `refid`, `txid`, `msg`, `xdata`, `response_status`, `string_request`) 
			VALUES ('', '".$dt."', '".$ip."', '".$vm."', '".$type."', '".$num."', '".$txid."', '".$data['msg']."', '".$data['xdata']."', '".$data['error']."', '".str_replace("/index.php/request","",$_SERVER['PHP_SELF'])."');";
		
		$this->db->query($q);
		
		

		
		
		$vmid = 0;
		if($msg=="PING"){
			$vmid =  substr(($kirim,22,strlen($kirim));
			$q    = "UPDATE vending_terminal SET online_status = 1 WHERE vmid = '".$vmid."' LIMIT 1"; 
			$this->db->query($q);
			$popwin = 'pop_vmtools_ping';
		}else{ 
		
			//--- update manual check device --- IF NOT PING
			if($msg=="PRINTER")  $chkDevice = "status_printer";
			if($msg=="CD1")  	 $chkDevice = "status_cd1";
			if($data['error']=="1") $chkValue = "00";
			if($data['error']=="0") $chkValue = "FF";
			
			$qChkDev = "UPDATE `terminal_checking` SET `".$chkDevice."` = '".$chkValue."' WHERE 
			`terminal_ip` = '".$ip."' and `terminal_id` = '".$vm."' order by ID desc limit 1";
			
			$this->db->query($qChkDev);
		
		
		
			$popwin = 'pop_vmtools';
		}
		
		$this->load->view($popwin,$data);  
			
		 
		 
	} 
  

	 
} 