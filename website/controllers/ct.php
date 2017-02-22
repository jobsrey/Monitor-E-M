<?php  
//session_start(); 
 
class Ct extends Controller {  

	function Ct()   
	{ 
		parent::Controller();   
		$this->load->helper('url');  		
		//$this->load->model('allmodel'); 
		//$this->load->library('allfunc');  
		$this->load->database();  
	} 
	
	function index(){  
		$beta =  0;
		$port = 555;
		
		//-- get terminals
		$q = "
			Select a.online_status as status, a.id, a.IP, a.terminal_ID, g.name as terminal_owner, a.terminal_name, 
			a.terminal_address, h.tenant as terminal_tenant, a.location_id, 
			b.loc as venue, c.loc as area,  d.loc as city, e.loc as province, f.loc as country, 
			a.product_id, a.video_id, a.group_id, a.trx_code_id  
			From vending_terminal a
			Left join md_terminal_location b on b.id = a.location_id
			Left join md_terminal_location c on c.id = b.parent_id
			Left join md_terminal_location d on d.id = c.parent_id
			Left join md_terminal_location e on e.id = d.parent_id
			Left join md_terminal_location f on f.id = e.parent_id 
			Left join md_terminal_owner  g on g.id = a.owner_id  
			Left join md_terminal_tenant h on h.id = a.tenant_id   
			where a.status_id = 1 Order By terminal_ID " ;
		$qTerminal = $this->db->query($q); 
	  
		$update = 1; $passUpdate = 0;
		$str = '';
		 
		if($qTerminal->num_rows())   
		foreach($qTerminal->result_array() as $row){   
		 
			//echo "<br>".$row['IP']." : "; 
			//echo $chkPing = $this->VMpingIP($row['IP'],$port); 
			$chkPing = $this->VMpingIP($row['IP'],$port); 
			
			//$chkPing = 0;
			 
			if($chkPing){ 
 				//$q = "UPDATE vending_terminal SET online_status = 1 WHERE id = '".$row['id']."' LIMIT 1"; k
				//$this->db->query($q); 
				/*
				echo "<br>Chk PRN : ";
				echo $chkPRN = "0018000001RS0201010200 ";//
				//echo $chkPRN = $this->VMChkDevices($row['IP'],$row['terminal_ID'],"PRINTER"); 
				echo " -> ";
				echo $chkPRN = substr(trim($chkPRN),strlen(trim($chkPRN))-2,2);  
				echo "<br>Chk CD1 : ";
				echo $chkCD1 = "0018000001RS03010102B7  ";//
				//echo $chkCD1 = $this->VMChkDevices($row['IP'],$row['terminal_ID'],"CD1");
				echo " -> ";
				echo $chkCD1 = substr(trim($chkCD1),strlen(trim($chkCD1))-2,2);  
				echo "<br>Chk BA  : ";
				echo $chkBA  = "0018000001RS01010102FF  ";
				//echo $chkBA  = $this->VMChkDevices($row['IP'],$row['terminal_ID'],"BA");
				echo " -> ";
				echo $chkBA = substr(trim($chkBA),strlen(trim($chkBA))-2,2); 
				*/
				
				$chkIP 	= "00";
				
				$chkPRN = $this->VMChkDevices($row['IP'],$row['terminal_ID'],"PRINTER"); 
				$chkPRN = substr(trim($chkPRN),strlen(trim($chkPRN))-2,2);  
				
				$chkCD1 = $this->VMChkDevices($row['IP'],$row['terminal_ID'],"CD1");
				$chkCD1 = substr(trim($chkCD1),strlen(trim($chkCD1))-2,2); 
				
				//$chkBA  = $this->VMChkDevices($row['IP'],$row['terminal_ID'],"BA");
				//$chkBA  = substr(trim($chkBA),strlen(trim($chkBA))-2,2); 
				
 				$chkBA 	= "XX"; 
				/*
				25.100.127.173 : 1
				Chk PRN : 0018000001RS0201010200 -> 00
				Chk CD1 : 0018000001RS03010102B7 -> B7
				Chk BA : 0018000001RS01010102FF -> FF
				*/ 
			}else{
				//$q = "UPDATE vending_terminal SET online_status = 0 WHERE id = '".$row['id']."' LIMIT 1"; 
				//$this->db->query($q); 
				$chkIP 	= "FF"; 
				$chkPRN = "XX"; 
				$chkCD1 = "XX";  
				$chkBA 	= "XX";  
				
				//if($row['terminal_ID']=='210-00-000-0-DEV') $chkIP 	= "FF"; 
				 
				/*
				25.27.198.52 : 0 
				*/
			} 
			$arrChkTerminal[$row['terminal_ID']]['IP-Addr'] = $row['IP'];
			$arrChkTerminal[$row['terminal_ID']]['chkIP'] 	= $chkIP;
			$arrChkTerminal[$row['terminal_ID']]['chkPRN']  = $chkPRN;
			$arrChkTerminal[$row['terminal_ID']]['chkCD1']  = $chkCD1;
			$arrChkTerminal[$row['terminal_ID']]['chkBA'] 	= $chkBA;
 
 			//--- store database
			$chkCD2 = $chkCD3 = $chkCD4 = "NA"; 
			$status_id = 1;  
			 
			$q = "INSERT INTO `terminal_checking` (
				`ID`, `terminal_ip`, `terminal_id`, 
				`status_ping`, `status_printer`, `status_ba`, `status_cd1`, `status_cd2`, `status_cd3`, `status_cd4`, 
				`check_datetime`, `status_id`
				) VALUES (
				'', '".$row['IP']."', '".$row['terminal_ID']."', 
				'".$chkIP."', '".$chkPRN."', '".$chkBA."', '".$chkCD1."', '".$chkCD2."', '".$chkCD3."', '".$chkCD4."', 
				'".date("Y-m-d H:i:s")."', '".$status_id."' 
				)";
				
			$update = $this->db->query($q);
			
			//-- chk if last have same content no-create new file
			$pathData = $_SERVER['DOCUMENT_ROOT']."/chk_terminal/last/";
			$arrFiles = glob($pathData."*.txt"); 
			krsort($arrFiles);
			
			
			//echo $row['terminal_ID']; 
			foreach ($arrFiles as $filename) {
				//$file = $content = $file2 = $content2 = '';
				//echo "<br>$filename -- size : " . filesize($filename) . "\n";
				//echo "<br>$filename";
				//C:/xampp/htdocs/lunari/chk_terminal/done/ct_20151028-221238_210-00-000-0-DEV.txt
				//C:/xampp/htdocs/lunari/chk_terminal/done/ct_20151028-221237_210-00-000-0-111.txt
				$posL = strpos($filename,"ct_");
				$vmid = substr($filename,$posL+19,16); // -- 210-00-000-0-DEV : 16 chrs
				
				if($vmid==$row['terminal_ID']){
					$strCompare1 = trim(str_replace(" ","",file_get_contents($filename)));  
					$strCompare2 = trim(str_replace(" ","",$q)) ;  
					$strCompare1 = substr($strCompare1,0,strlen()-31);
					$strCompare2 = substr($strCompare2,0,strlen()-31); 
					//echo "<br>$strCompare1";
					//echo "<br>$strCompare2"; 
					if($strCompare1==$strCompare2) {
						$update = 0;
						//echo "<br>Status : ".$row['terminal_ID']." -> SAMA..."; 
						
						//--- create file
						$file = $_SERVER['DOCUMENT_ROOT']."/chk_terminal/done/ct_".date("Ymd-His")."_".$row['terminal_ID'].".txt"; 
						$content = file_get_contents($file); 
						$content .= $q; 
						file_put_contents($file, $content);
						
						$file = $_SERVER['DOCUMENT_ROOT']."/chk_terminal/log/sync_".date("Y-m-d_Hi")."_".$row['terminal_ID']."_no_sync.txt"; 
						$content = file_get_contents($file); 
						$content .= "Data sama dgn last-check..."; 
						//file_put_contents($file, $content); 
						
						unlink($_SERVER['DOCUMENT_ROOT']."/chk_terminal/chk.txt");
						
					} else { 
						$update = 1; 
						unlink($filename); 
						//echo "<br>Status : ".$row['terminal_ID']." -> BEDA...";
						
						//--- create file
						$file = $_SERVER['DOCUMENT_ROOT']."/chk_terminal/ct_".date("Ymd-His")."_".$row['terminal_ID'].".txt"; 
						$content = file_get_contents($file); 
						$content .= $q; 
						file_put_contents($file, $content);
						
						$file = $_SERVER['DOCUMENT_ROOT']."/chk_terminal/log/sync_".date("Y-m-d_Hi")."_".$row['terminal_ID']."_update.txt"; 
						$content = file_get_contents($file); 
						$content .= $q; 
						file_put_contents($file, $content); 
						
						
						$lastfile = $_SERVER['DOCUMENT_ROOT']."/chk_terminal/last/ct_".date("Ymd-His")."_".$row['terminal_ID'].".txt"; 
						copy($file,$lastfile);  
						
						$passUpdate = 1;
				
					} 
				} 
			}  
   			 
			if($update && !$passUpdate){
				//--- create file
				$file = $_SERVER['DOCUMENT_ROOT']."/chk_terminal/ct_".date("Ymd-His")."_".$row['terminal_ID'].".txt"; 
				$content = file_get_contents($file); 
				$content .= $q; 
				file_put_contents($file, $content);
				$lastfile = $_SERVER['DOCUMENT_ROOT']."/chk_terminal/last/ct_".date("Ymd-His")."_".$row['terminal_ID'].".txt"; 
				copy($file,$lastfile); 
				 
			}
			
			 
		} 
		
		//foreach($arrChkTerminal as $k => $v)
		//foreach($v as $key => $val)
		//echo "<br> - $k => $key => $val";
		 
		//--- creat chk.txt : 1 if neet to sync. 0 : no data change
		$file = $_SERVER['DOCUMENT_ROOT']."/chk_terminal/chk.txt"; 
		unlink($file);
		
		$content = file_get_contents($file); 
		$content .= $update; 
		file_put_contents($file, $content); 
		
		//echo "<br>";
		//echo "update : $update "; //--> for triger starting loop checking
		
		echo $update;
		
	} 
	
	function VMpingIP($host,$port){
		//$host = '25.59.210.284'; 
		//$port = 555; 
		$waitTimeoutInSeconds = 1; 
		if($fp = fsockopen($host,$port,$errCode,$errStr,$waitTimeoutInSeconds)){   
		   return 1; 
		} else {
		   return 0; 
		} 
		fclose($fp);
	}
	
	function VMChkDevices($ip,$vm,$msg=""){ 
		//http://25.59.210.248/request/vmtools/	0/vmtools/1/PRINTER/ 
		//$data['dt'] 		= $dt = date("Y-m-d H:i:s"); 
		//$data['d'] 			= $d  = date("Y-m-d");   
		//$data['t'] 			= $t  = date("H:i");   
		$data['ip'] 		= $ip;  
		$data['vm'] 		= $vm;
		 
		if($msg=="PRINTER")  
		$data['response']	= "0016000001RQ02010102";
		if($msg=="CD1")  	
		$data['response']	= "0016000001RQ03010102"; 
		if($msg=="BA")  	 
		$data['response']	= "0016000001RQ01010102";
		$data['msg'] 		= str_replace("%20"," ",$msg);   
 
		$kirim = $this->sendresponse($data['ip'],$data['vm'],$data['response']);
 
 		$data['error'] = $kirim; 
 
		return $data['error']; 
	} 
	
	function sendresponse($ip,$vm,$response)  { 
	    $query_vm 	= $vm;
        $address 	= $ip; 
        $port 		= 555;
        $socket 	= socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
        $message 	= $response;
 
        try {
            socket_connect($socket, $address, $port);

            $status = socket_sendto($socket, $message, strlen($message), 0, $address, $port);

            if ($status != false)  {
                //return true;
                socket_recvfrom($socket, $buf, 22, 0, $address, $port); //22
				return $buf;
            } 
            return false;
        } catch (Exception $e)  {
            return false;
        } 
    }
	   
} 