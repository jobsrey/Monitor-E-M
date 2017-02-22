<?
 /* CLIENT */ 
 
$address = "localhost";
$port = 5555;
$message =  'mandiri.mp4';

$filename =  $_SERVER['DOCUMENT_ROOT']."/mandiri.mp4";
//$handle = fopen($filename, "rb");
//$file   = fread($handle, filesize($filename));
//fclose($handle);
$file = file_get_contents($filename); 
$lenfile = strlen($file);
 

		$socket = socket_create(AF_INET, SOCK_STREAM,SOL_TCP);//getprotobyname('tcp')
				
		 try {
            socket_connect($socket, $address, $port);

            $status = socket_sendto($socket, $message, strlen($message), 0, $address, $port); 
			
            if ($status != false)  {
                $response =  true;
                //socket_recvfrom($socket, $buf, 0, 0, $address, $port); 
				//return strlen($buf);/	
  
 
	$sendfile = socket_write($socket,$file,$lenfile); 
 


 
            } else $response =  false;
            //return false;
        } catch (Exception $e) {
            //return false;
        }
		
if($response){
	
	/* 
$socket = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));

if ($socket === false) {
    echo "<br>socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
} else {
    echo "<br>socket successfully created.\n";
}

echo "<br>Attempting to connect to '$address' on port '$port'...";
$result = socket_connect($socket, $address, $port);
if ($result === false) {
    echo "<br>socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
} else {
    echo "<br>successfully connected to $address.\n";
}
*/ 

 
//http://localhost/lunari/


 


/*
if ($sendfile === false) {
    echo "<br>socket_write() failed.\nReason: ($sendfile) " . socket_strerror(socket_last_error($socket)) . "\n";
} else {
    echo "<br>successfully socket_write to $address.\n";
}
*/
}

echo "Closing socket...";
socket_close($socket);
exit; 
/*
 
 
 
		error_reporting(E_ALL); 
		
        $address 	= "localhost"; 
        $port 		= 5555;
        $message 	= "0016000001RQ16010101";
		
        $socket 	= socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
		 
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
		
*/
		//Report all errors
 
?>