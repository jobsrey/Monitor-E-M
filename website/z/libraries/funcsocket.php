<?php 
 if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Funcsocket extends Allmodel{ 

  	function Funcsocket(){    
    	parent::Allmodel();     
  	} 
	
	function sendmediabysocket($toip,$toid,$msg){ 
		//error_reporting(E_ALL); 
		
		$socket 	= socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
        $address 	= 'localhost'; 
        $port 		= 5555;
		
		$message    =  'mandiri.mp4';
		
		 try {
            socket_connect($socket, $address, $port);

            $status = socket_sendto($socket, $message, strlen($message), 0, $address, $port); 
			
            if ($status != false)  {
                //return true;
                socket_recvfrom($socket, $buf, 0, 0, $address, $port); 
				return strlen($buf);
            } 
            return false;
        } catch (Exception $e)  {
            return false;
        }
		
		/*
	    $query_vm 	= $vm;
        $address 	= $ip; 
        $port 		= 5555;
        $socket 	= socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
        $message 	= $response;
		exit;
		 
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
		

		//Report all errors
		//error_reporting(E_ALL);
		*/
    }
	
	 
	// --------------------------------------------------------------------
	
	
	
	
	
	
	
	
	
	
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
	function sendping($ip,$vm,$response)  { 
	    $query_vm 	= $vm;
        $address 	= $ip; 
        $port 		= 555;
        $socket 	= socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
        $message 	= $response;
		
 		error_reporting(0); 
		try {
            socket_connect($socket, $address, $port);

            $status = socket_sendto($socket, $message, strlen($message), 0, $address, $port); 
            if ($status != false)  {
                //return true;
                socket_recvfrom($socket, $buf, 38, 0, $address, $port); //22
				return $buf;
            } 
            return false;
        } catch (Exception $e)  {
            return false;
        } 
		

		//Report all errors 
    }
	function getLogs(){
 		$x=1;  
		$q = "Select * from request_table Order By datetime desc"; 
		$query = $this->db->query($q); 
		$result = ''; 
		foreach($query->result_array() as $row){  
			$clr = '#eee'; 
			if(fmod($x,2)) $clr = '#bbb';  
			$result .= ' 
		 <tr bgcolor="'.$clr.'">
          <td align="right" ><span sty="style8">'.$x.'.</span></td>
          <td nowrap="nowrap" bgcolor="'.$clr.'"><span class="style8">'.$row['datetime'].'</span></td>
          <td class="style8">'.$row['id'].'</td>
          <td nowrap="nowrap"><span class="style8">'.$row['ip'].'</span></td>
          <td nowrap="nowrap"><span class="style8">'.$row['vm'].'</span></td>
          <td nowrap="nowrap"><span class="style8">'.$row['type'].'</span></td>
          <td nowrap="nowrap"><span class="style8">'.$row['txid'].'</span></td>
          <td nowrap="nowrap"><span class="style8"><a href="#">'.$row['msg'].'</a> </span></td>
          <td><span class="style8">'.$row['response_status'].'</span></td>
          <td nowrap="nowrap" bgcolor="'.$clr.'"><span class="style8">'.$row['string_request'].'</span></td>
        </tr> 
			';
		 	$x++;
		 } 
   		return $result;  
	}  


 
	
}
