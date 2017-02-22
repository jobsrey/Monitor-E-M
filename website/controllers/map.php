<?php  
error_reporting(E_ALL); 
//session_start();   
class Map extends Controller { 
	function Map(){   
		parent::Controller(); 
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		//$this->load->library('allfunc');  
		$this->load->database(); 
		$this->load->library('session'); 
		$this->load->library('func_v2');
		if(!$this->session->userdata('logged_in')) redirect('login','refresh');
		  
	} 

	
	function index(){  
		/*
		//-- chk new chk file : /upload/chk_terminal/*.txt
		$arrFileDBox = array();
		$pathSource  = $_SERVER['DOCUMENT_ROOT']."/upload/chk_terminal/";
		$arrFileSQL  = glob($pathSource."/*.txt"); 
		
		foreach ($arrFileSQL as $sqlfile) { 
			//echo "<br>-- source file : ".$val ;  
			//-- open file 
			$q = file_get_contents($sqlfile,true);
			$qData = $this->db->query($q); 
			
			//-- del file src
			unlink($sqlfile);
				
		}	
		exit;
		*/
  
     	$data['is_pop']    = 0;
     	$data['pageTITLE'] = 'Lunari Web Admin';
     	$data['pageLABEL'] = 'Welcome';
		$data['navMenu']   = '';//$this->allfunc->navMenu(0);   
		
		//-- get data vm
		$qTerminal = $this->getVendingTerminalInstalled();  
		//$data['qTerminal']   =  $qTerminal;
		
		$data['totTerminal'] =  $qTerminal->num_rows();
		 
		$cOnline = $cOffline = 0;
		$arrTerminal = array();		
		$arrStatus   = array();
		$arrStartCard= array();
		$arrTotCard  = array(); 
		$arrCardTrx	 = array();
		$arrTU10Tot	 = array(); 
		$arrTU20Tot	 = array();
		$arrTU50Tot	 = array();
		$arrTU100Tot = array();
		$arrTUAllTot = array();
		$arrTUPTrx	 = array();
		
		
		$arrTabelInfo = array();
		
		if($qTerminal->num_rows()){ 
			foreach($qTerminal->result_array() as $row){  
				
				//foreach ($row as $key => $value) echo "<br>$key => $value";
				
				//-- Checking Terminal Status and Device --------
				//-----------------------------------------------
				$tID = $row['id'];
				$ip  = $row['IP']; 
				$tid = $row['terminal_id'];
				$teminalStatus = $row['online_status'];
				
				$gmapcoord = $row['googlemapcoordinate'];
				$gmaplabel = $row['googlemappinlabel']; 
				$arrTerminal[$tID]['googlemapcoordinate'] = $gmapcoord; 
				$arrTerminal[$tID]['googlemappinlabel']   = $gmaplabel;  
				
				$arrTerminal[$tID]['ID']   = $tID; 
				
				$arrTabelInfo[$tid]['name'] = $gmaplabel; //--- 
				$arrTabelInfo[$tid]['TID']  = $row['TID'];
				
				
				//=====
				//$arrTabelInfo[$tid]['online_status'] = $row['online_status'];
				
				$qData = $this->getCheckingTerminalInstalled($ip,$tid);
				
				//echo "<br>$ip - $tid----".$qData->num_rows();
				
				if($qData->num_rows())  
				foreach($qData->result_array() as $kk => $row2){ 
					foreach ($row2 as $key => $val){  
						$arrStatus[$tID][$key] = $val; 
						//echo "<br>$kk => $key => $val";
						if($key=="status_ping"){ 
							if($val=='00'){ $cOnline++; }
							if($val=='FF'){ $cOffline++; }  
							
							$arrTabelInfo[$tid]['ping']  = $val;
							
						}
						//status_ping 	status_printer 	status_ba 	status_cd1
						if($key=="status_printer"){  
							$arrTabelInfo[$tid]['prn']  = $val; 
						}
						if($key=="status_ba"){  
							$arrTabelInfo[$tid]['ba']  = "00"; 
						}
						if($key=="status_cd1"){  
							$arrTabelInfo[$tid]['cd1']  = $val; 
						}
					} 
				} 
				
				 
				 
				
				//-----------------------------------------------
				
				//-- Get Terminal Card Transaction --------------
				//$tid = '210-00-000-0-DEV';
				$q = "Select dt,tm,vmid,cardfull,sisakartu,datetime From tbk Where 
					vmid = '".$tid."' And totaltrx = 0 And uangmasuk = 0 And kartukeluar = 0 And cardfull != 0  And sisakartu != 0 And
					dt <= '".date("Y-m-d")."'
					Order By id Desc Limit 1";
				
//---- edit: fix error if no-have-card/tdk jual kartu saat tutub buku	: 13-01-2016			
				$q = "Select dt,tm,vmid,cardfull,sisakartu,datetime From tbk Where 
					vmid = '".$tid."' And totaltrx = 0 And uangmasuk = 0 And kartukeluar = 0 And
					dt <= '".date("Y-m-d")."'
					Order By id Desc Limit 1";
				
				//echo "<br>$q";
					
				$qData2 = $this->db->query($q);  
				$result2 = $qData2->result_array();
				$result['cardfull']=0;
				$result['sisakartu']=0;
				$break = 0;
				
				if($qData2->num_rows()) 
				foreach($result2 as $kk => $row2) 
				if(is_array($row2)) 
				foreach ($row2 as $key => $val) {  
					if($key=='sisakartu'){
						//echo "<br>$kk => $key => $val"; 
						$arrTotalCard[$tid]=$val;   
					}  
					if($key=='dt'){ 
						$beginDate = $val;    
					}
					if($key=='tm'){
						$beginTime = $val;    
					}
				}
				
				//echo "<br> $beginDate $beginTime";
				
				//-----------------------------------------------
				///reporting/settlement_transaction/2015-10-26--00.00/2015-10-26--23.59/0/6/0/0/asc
				
				$beginDT = str_replace("-","",str_replace(":","",$beginDate.$beginTime));
				//$endDT   = date("Ymd")."235959";
				
				//----- CARD TRX
				$q3 = "Select id, kdtrx, 'crd' as kdprd, vmid, CONCAT(dt,' ',tm) as date, totalbayar, jmlbeli, nourut as trx_num, null as slot, null as totaltrx 
				From `trx` Where ( vmid = '".$tid."' ) and REPLACE(REPLACE(CONCAT(dt,'',tm),'-',''),':','') >= '".$beginDT."'";
				
				$qData3 = $this->db->query($q3);  
				$result3 = $qData3->result_array();  
				
				//totalbayar 	jmlbeli 
				$totalbayar=0;
				$jmlbeli=0;
				if($qData3->num_rows()) 
				foreach($result3 as $k3 => $row3){
					foreach ($row3 as $key => $val) { 
						//echo "<br>$k3 => $key => $val"; 
						if($key=='totalbayar'){ 
							$totalbayar += $val;    
						}
						if($key=='jmlbeli'){ 
							$jmlbeli += $val;    
						}
					}
				} 
				$arrCardTot[$tid]=$totalbayar;  //-- nilai transaksi 
				$arrCardTrx[$tid]=$jmlbeli;     //-- jumlah transaksi 
				//echo "<br> $tid totalbayar = ".$arrCardTot[$tid];
				//echo "<br> $tid jmlbeli = ".$arrCardTrx[$tid];
				
				//----- TOPUP TRX
				$beginDT = $beginDate." ".$beginTime;
				$q4 = " Select id, 'TOPUP' as kdtrx, 'tup' as kdprd, terminal_id as vmid, date, value as totalbayar, 1 as jmlbeli, trx_counter as trx_num, slot, null as totaltrx 
				From `topup_mandiri` 
				Where terminal_id = '".$tid."' and  `date` >= '".$beginDT."' ";
				
				$qData4 = $this->db->query($q4);  
				$result4 = $qData4->result_array(); 
				
				$totalbayar_10=0;
				$totalbayar_20=0;
				$totalbayar_50=0;
				$totalbayar_100=0;
				$jmlbeli=0;
				if($qData4->num_rows()) 
				foreach($result4 as $k4 => $row4){
					foreach ($row4 as $key => $val) { 
						//echo "<br>$k4 => $key => $val"; 
						if($key=='totalbayar'){ 
							//$totalbayar += $val;  
							if($val==10000)  $totalbayar_10  += $val; 
							if($val==20000)  $totalbayar_20  += $val; 
							if($val==50000)  $totalbayar_50  += $val; 
							if($val==100000) $totalbayar_100 += $val;  
						} 
						if($key=='jmlbeli'){ 
							$jmlbeli += $val;    
						}
					}
				}	
				$arrTU10Tot[$tid]=$totalbayar_10;  	
				$arrTU20Tot[$tid]=$totalbayar_20;  	
				$arrTU50Tot[$tid]=$totalbayar_50;  					//-- nilai transaksi TU 50
				$arrTU100Tot[$tid]=$totalbayar_100;  				//-- nilai transaksi TU 100
				$arrTUAllTot[$tid]=$totalbayar_10+$totalbayar_20+$totalbayar_50+$totalbayar_100;  //-- nilai transaksi all
				$arrTUPTrx[$tid]=$jmlbeli;     						//-- jumlah transaksi 
				//echo "<br> $tid totalbayar_50 = ".$arrTU50Tot[$tid];
				//echo "<br> $tid totalbayar_100 = ".$arrTU100Tot[$tid];	
				//echo "<br> $tid totalbayar_all = ".$arrTUAllTot[$tid];	
				//echo "<br> $tid jumlah transaksi = ".$arrTUPTrx[$tid];	
 		
				
 /*
				$q = "Select id, kdtrx, 'crd' as kdprd, vmid, CONCAT(dt,' ',tm) as date, totalbayar, jmlbeli, nourut as trx_num, null as slot, null as totaltrx 
				From `trx` 
				Where 
				( vmid = '210-00-000-0-DEV' ) and 
				REPLACE(REPLACE(CONCAT(dt,'',tm),'-',''),':','') >= 20151026000000 and 
				REPLACE(REPLACE(CONCAT(dt,'',tm),'-',''),':','') <= 20151026235900 
				
				UNION 
				
				Select id, 'TOPUP' as kdtrx, 'tup' as kdprd, terminal_id as vmid, date, value as totalbayar, 1 as jmlbeli, trx_counter as trx_num, slot, null as totaltrx 
				From `topup_mandiri` 
				Where (
				terminal_id = '210-00-000-0-DEV' ) and 
				( `date` >= '2015-10-26 00:00:00' and 
				`date` <= '2015-10-26 23:59:00' ) 
				
				UNION 
				
				Select id, kdtrx, 'tbk' as kdprd, vmid , CONCAT(dt,' ',tm) as date, uangmasuk as totalbayar, null as jmlbeli, null as trx_num, null as slot, totaltrx 
				From `tbk` 
				Where 
				( vmid = '210-00-000-0-DEV' ) and 
				REPLACE(REPLACE(CONCAT(dt,'',tm),'-',''),':','') >= 20151026000000 and 
				REPLACE(REPLACE(CONCAT(dt,'',tm),'-',''),':','') <= 20151026235900 and 
				uangmasuk != 0 
				
				ORDER BY date asc";
				*/
				  
				
			}
			
		}	
		
		 /*
		foreach($arrStatus as $k => $v)
		foreach($v as $key => $val)
		echo "<br> - $k => $key => $val";
		exit;
		*/
		
		//-- Checking Terminal Status and Device --------
		$data['totOnline']   =  $cOnline;
		$data['totOffline']  =  $cOffline;  
		$data['arrTerminal'] =  $arrTerminal;
		$data['arrStatus']   =  $arrStatus;
		
		//-----------------------------------------------
		 
		//foreach($arrTotCard as $k => $v) echo "<br> - $k => $v"; 
		
		$data['arrTotalCard'] =  $arrTotalCard;
		$data['arrCardTot']   =  $arrCardTot;
		$data['arrCardTrx']   =  $arrCardTrx; 
		
		$data['arrTU10Tot']   =  $arrTU10Tot;
		$data['arrTU20Tot']   =  $arrTU20Tot;
		$data['arrTU50Tot']   =  $arrTU50Tot;
		$data['arrTU100Tot']  =  $arrTU100Tot;
		$data['arrTUAllTot']  =  $arrTUAllTot;
		$data['arrTUPTrx']    =  $arrTUPTrx;
		 
		$data['TotarrTotalCard'] = $this->totArrValue($arrTotalCard);
		$data['TotarrCardTot']   = $this->totArrValue($arrCardTot);
		$data['TotarrCardTrx']   = $this->totArrValue($arrCardTrx); 
		
		$data['TotarrTU10Tot']   = $this->totArrValue($arrTU10Tot);
		$data['TotarrTU20Tot']   = $this->totArrValue($arrTU20Tot);
		$data['TotarrTU50Tot']   = $this->totArrValue($arrTU50Tot);
		$data['TotarrTU100Tot']  = $this->totArrValue($arrTU100Tot);
		$data['TotarrTUAllTot']  = $this->totArrValue($arrTUAllTot);
		$data['TotarrTUPTrx']    = $this->totArrValue($arrTUPTrx);
		
		$data['arrTabelInfo']    = $arrTabelInfo;
		
		  
		 
		  
		$this->load->view('map_view',$data);  ;
 
	} 
	
	function totArrValue($arr){
		$tot = 0;
		foreach ($arr as $key => $value ){
			$tot += $value;
		}
		return $tot;
	}
	
	function getVendingTerminalInstalled(){
		$q = "Select * from vending_terminal where status_id = 1 " ;
		return $this->db->query($q); 
	}
	
	function getTerminalIDbyID($id){
		$q = "Select * from vending_terminal where id = ".$id ;
		return $this->db->query($q); 
	}
	
	function getCheckingTerminalInstalled($ip,$tid){
		$q = "Select * from terminal_checking where terminal_ip = '".$ip."' And  terminal_id = '".$tid."' And status_id = '1' Order By check_datetime Desc Limit 1" ;
		return $this->db->query($q); 
	}
	
	function boxinfo($id){

		//-- get data vm
		$qTerminal = $this->getTerminalIDbyID($id);  
		if($qTerminal->num_rows()){ 
			foreach($qTerminal->result_array() as $row) 
			foreach ($row as $key => $value){ 
				//echo "<br>$key => $value";
				/*
				id => 1
				IP => 25.100.127.173
				terminal_id => 210-00-000-0-111
				terminal_name => E-Money ATM
				terminal_address => Plaza Mandiri
				location_id => 45
				owner_id => 3
				tenant_id => 0
				status_id => 1
				product_id => 1
				product_delivery_id => 1
				product_vendor_id => 1
				alert_id =>
				trx_code_id => 1
				group_id => 1
				video_id => 12
				online_status => 1
				googlemapcoordinate => -6.2244983,106.8140951
				googlemappinlabel => PLAZA MANDIRI
				*/
				$arrTerminal[$key]=$value;  
			}
		} 
		
		$qData = $this->getCheckingTerminalInstalled($arrTerminal['IP'],$arrTerminal['terminal_id']);
		
		$terminalStatus = "NA";
		if($qData->num_rows()){   
			foreach($qData->result_array() as $row) { 
				foreach ($row as $key => $val) {  
					 //echo "<br> $key => $val"; 
					 if($key=="status_ping"){
					 	if($val=='00'){ $terminalStatus = 1; }
						if($val=='FF'){ $terminalStatus = 2; }   
					 }
				}	  
			}	 
		} 
			
		 
		
		
				//-- Get Terminal Card Transaction --------------
				$tid = $arrTerminal['terminal_id'];
				$q = "Select dt,tm,vmid,cardfull,sisakartu,datetime From tbk Where 
					vmid = '".$tid."' And totaltrx = 0 And uangmasuk = 0 And kartukeluar = 0 And cardfull != 0  And sisakartu != 0 And
					dt <= '".date("Y-m-d")."'
					Order By id Desc Limit 1";
				
				//echo "<br>$q";
					
				$qData2 = $this->db->query($q);  
				$result2 = $qData2->result_array();
				$result['cardfull']=0;
				$result['sisakartu']=0;
				$break = 0;
				
				 
				
				if($qData2->num_rows()) 
				foreach($result2 as $kk => $row2) 
				if(is_array($row2)) 
				foreach ($row2 as $key => $val) {  
					if($key=='sisakartu'){
						//echo "<br>$kk => $key => $val"; 
						$arrTotalCard[$tid]=$val; 
						  
					}  
					if($key=='dt'){ 
						$beginDate = $val;    
					}
					if($key=='tm'){
						$beginTime = $val;    
					}
				}
				
		//echo "<br> $beginDate $beginTime";
		$lastTBKdatetime = "$beginDate $beginTime";
		//$lastTBKdatetime = substr($lastTBKdatetime,0,strlen($lastTBKdatetime)-3);
		
				//-----------------------------------------------
				///reporting/settlement_transaction/2015-10-26--00.00/2015-10-26--23.59/0/6/0/0/asc
				
				$beginDT = str_replace("-","",str_replace(":","",$beginDate.$beginTime));
				//$endDT   = date("Ymd")."235959";
				
				//----- CARD TRX
				$q3 = "Select id, kdtrx, 'crd' as kdprd, vmid, CONCAT(dt,' ',tm) as date, totalbayar, jmlbeli, nourut as trx_num, null as slot, null as totaltrx 
				From `trx` Where ( vmid = '".$tid."' ) and REPLACE(REPLACE(CONCAT(dt,'',tm),'-',''),':','') >= '".$beginDT."'";
				
				$qData3 = $this->db->query($q3);  
				$result3 = $qData3->result_array();  
				
				//totalbayar 	jmlbeli 
				$totalbayar=0;
				$jmlbeli=0;
				if($qData3->num_rows()) 
				foreach($result3 as $k3 => $row3){
					foreach ($row3 as $key => $val) { 
						//echo "<br>$k3 => $key => $val"; 
						if($key=='totalbayar'){ 
							$totalbayar += $val;    
						}
						if($key=='jmlbeli'){ 
							$jmlbeli += $val;    
						}
					}
				} 
		$arrCardTot[$tid]=$totalbayar;  //-- nilai transaksi 
		$arrCardTrx[$tid]=$jmlbeli;     //-- jumlah transaksi 
				//echo "<br> $tid totalbayar = ".$arrCardTot[$tid];
				//echo "<br> $tid jmlbeli = ".$arrCardTrx[$tid];
				
				
				
				//----- TOPUP TRX
				$beginDT = $beginDate." ".$beginTime;
				$q4 = " Select id, 'TOPUP' as kdtrx, 'tup' as kdprd, terminal_id as vmid, date, value as totalbayar, 1 as jmlbeli, trx_counter as trx_num, slot, null as totaltrx 
				From `topup_mandiri` 
				Where terminal_id = '".$tid."' and  `date` >= '".$beginDT."' ";
				
				$qData4 = $this->db->query($q4);  
				$result4 = $qData4->result_array(); 
				
				$totalbayar_50=0;
				$totalbayar_100=0;
				$jmlbeli=0;
				if($qData4->num_rows()) 
				foreach($result4 as $k4 => $row4){
					foreach ($row4 as $key => $val) { 
						//echo "<br>$k4 => $key => $val"; 
						if($key=='totalbayar'){ 
							//$totalbayar += $val;  
							if($val==50000)  $totalbayar_50  += $val; 
							if($val==100000) $totalbayar_100 += $val;  
						} 
						if($key=='jmlbeli'){ 
							$jmlbeli += $val;    
						}
					}
				}	
				$arrTU50Tot[$tid]=$totalbayar_50;  					//-- nilai transaksi TU 50
				$arrTU100Tot[$tid]=$totalbayar_100;  				//-- nilai transaksi TU 100
				$arrTUAllTot[$tid]=$totalbayar_50+$totalbayar_100;  //-- nilai transaksi all
				$arrTUPTrx[$tid]=$jmlbeli;     						//-- jumlah transaksi 
				
				
	
	 			 
	
		echo ' 
				<table id="infotable" width="220" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
                  <tr>
                    <td colspan="2" bgcolor="#009966"><span style="float:left"><strong>'.$arrTerminal['googlemappinlabel'].'</strong></span><span style="float:right"><a href="javascript:void(0);javascript:infoclose()"><img src="/close.gif" alt="close" border="0" /></a></span></td>
                   </tr>
                  <tr>
                    <td width="80" valign="top" bgcolor="#B3FFB3">Status</td>
                    <td width="120" bgcolor="#B3FFB3">
                    <strong>';
					if($terminalStatus==1)
                    echo '<span style="color:green">ONLINE</span>'; 
					if($terminalStatus==0)
                    echo '<span style="color:red">OFFLINE</span>';  
					
 		echo '   </strong></td>
                   </tr>
                  <tr>
                    <td bgcolor="#EEFFB3">Terminal-ID</td>
                    <td bgcolor="#EEFFB3">'.$arrTerminal['terminal_id'].'</td>
                   </tr>
                  <tr>
                    <td width="80" valign="top" bgcolor="#EEFFB3">Terminal-IP</td>
                    <td width="120" bgcolor="#EEFFB3">'.$arrTerminal['IP'].'</td>
                   </tr>
                  <tr>
                    <td colspan="2" bgcolor="#999999">Last TBK : '.$lastTBKdatetime.'</td>
                   </tr>
                  <tr>
                    <td colspan="2" bgcolor="#CC9900">Prepaid Card eMoney</td>
                   </tr>
                  <tr>
                    <td bgcolor="#eee">Nilai Trx</td>
                    <td bgcolor="#eee">Rp. '.number_format($arrCardTot[$tid],0,",",".").',-</td>
                  </tr>
                  <tr>
                    <td bgcolor="#ccc">Kartu-Keluar</td>
                    <td bgcolor="#ccc">'.$arrCardTrx[$tid].'</td>
                  </tr>
                  <tr>
                    <td bgcolor="#ccc">Sisa-Kartu</td>
                    <td bgcolor="#ccc">'.($arrTotalCard[$tid]-$arrCardTrx[$tid]).'</td>
                  </tr>
                  <tr>
                    <td colspan="2" bgcolor="#CC9900">Topup eMoney</td>
                   </tr>
                  <tr>
                    <td bgcolor="#eee">Nilai Trx</td>
                    <td bgcolor="#eee">Rp. '.number_format($arrTUAllTot[$tid],0,",",".").',-</td>
                  </tr>
                  <tr>
                    <td bgcolor="#eee">Jumlah Trx</td>
                    <td bgcolor="#eee">'.$arrTUPTrx[$tid].'</td>
                  </tr>
                  <tr>
                    <td bgcolor="#eee">Trx-TU-50</td>
                    <td bgcolor="#eee">'.($arrTU50Tot[$tid]/50000).'</td>
                  </tr>
                  <tr>
                    <td bgcolor="#ccc">Trx-TU-100</td>
                    <td bgcolor="#ccc">'.($arrTU100Tot[$tid]/100000).'</td>
                  </tr>
                </table> 
				';
	
	} 
}
