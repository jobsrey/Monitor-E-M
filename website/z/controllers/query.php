<?php  
//session_start(); 
error_reporting(E_ALL); 
 
class Query extends Controller { 
	function Query(){ 
		parent::Controller();   
		$this->load->helper('url'); 
		$this->load->model('allmodel');
		$this->load->database();   
		  
	} 
	
	function index(){  
 		echo "Hello U";  
	} 
	
	//--- edit function val() {}
	//--- trx-id digenerate di server dgn datetime server
	
	function tap() { 
 
 		$hostname = "http://admin.tribunfamilycard.com"; 
		//$hostname = "http://localhost"; 
 
		echo '<pre>';
		
		$qstr = '';
		
		if($_POST){
		
			$curDate = date("Y-m-d H:i:s");
			echo "<br>curDate => $curDate";
			
			//-- save htmlpost to db 
			$strRequest = base_url()."query/tap/";
			
			foreach($_POST as $key => $value) {
				
				if($key!=="button"){
					echo "<br>$key => $value"; 
					$strRequest .= $key."=".$value."---";
					$$key = $value;
				}
				/*
				card_number => 11-0000$key-1111
				card_serialnum => 87654321
				merchant_id => 01-56789 
				*/ 
			} 
			
			// -- generate trx-id
			$transaction_id = substr($merchant_id,0,3)."-".date('ymd-His');
			
			echo "<br>transaction_id => $transaction_id";
			
            //Set transaction_id  
			//$this->load->library('session'); 
           //$this->CI->session->set_userdata(array('transaction_id' => $transaction_id)); 			
			//echo "<br>transaction_id => ".$this->session->userdata('transaction_id');;
			
			
			//--- INSERT TO DB TRX #1 : Send to Validation 
			
			$transaction_type = "VAL"; 
			$string_request = $strRequest."isPOST";
 
			//-- INSERT  
			$q = " INSERT INTO `tfc_trx` (
				`id`, `transaction_type`, `transaction_id`, `transaction_date`, 
				`card_number`, `card_serialnumber`, `member_credit`, 
				`merchant_id`, `merchant_product`, `string_request`, `status_id`) 
				VALUES (
				NULL, '".$transaction_type."', '".$transaction_id."', '".date('Y-m-d H:i:s')."', 
				'".$card_number."', '".$card_serialnum."', '', 
				'".$merchant_id."', '', '".$string_request."', '1')"; 
				
			$this->db->query($q); 
 
			//----------------------------------------------------------------------------- 
			echo "<br>";
			
			//-- VALIDATE MEMBER -> get Member Data
			//echo '<br>VALIDATE MEMBER:';
			
			$TFCStatus = 'NOTVALID';
			
			$q1 = "SELECT ID as MemberID, FullName, TFCNumber, TFCSerialNumber, TFCStatus, TFCNoPolisi, TFCValidDateBegin, TFCValidDateEnd 
				  FROM member_table Where TFCNumber = '".$card_number."' and TFCSerialNumber = '".$card_serialnum."' limit 1";
 
			$qData1 =  $this->db->query($q1);
 
			if($qData1->num_rows()){  
				foreach($qData1->result_array() as $row1){   
					foreach($row1 as $key => $value1) {
						echo "<br>$key => $value1";
						$$key = $value1;
						$data[$key] = $value1;
						/* 
						FullName => Agung Siagunggung  
						TFCNumber => 11-0000-1111
						TFCSerialNumber => 87654321
						TFCStatus => REGISTER
						TFCNoPolisi => AA 2222 XX 
						TFCValidDateBegin => 2016-02-01
						TFCValidDateEnd => 2017-02-01  
						*/
					}
				} 
				$member_exist = 1;
			} else { $member_exist = 0; $member_expired = '';}
			
			if($member_exist){
				$row = $qData1->result_array();
				
				$dtbegin = $row[0]['TFCValidDateBegin']; 
				$dtend   = $row[0]['TFCValidDateEnd']; 
				//echo "<br>dtbegin = $dtbegin";
				//echo "<br>dtend   = $dtend";
				//echo "<br>"; 
				//-- CHECK EXPIRE  
				$member_expired = $this->allmodel->dateIsExpire($curDate,$TFCValidDateBegin,$TFCValidDateEnd);
				
				//---if member expired => change TFCStatus to EXPIRED 
				if( $TFCStatus=="VALID" && $member_expired){
					$q = "Update member_table Set `TFCStatus` = 'EXPIRED' Where `ID`= '".$MemberID."' Limit 1"; 
					$this->db->query($q);
					$TFCStatus="EXPIRED";
					echo "<br>TFCStatus => $TFCStatus";
				}
 			}
			//-- MEMBER STATUS 
			echo "<br>";
			echo "member_exist => $member_exist";
			echo "<br>";
			echo "member_expired => $member_expired" ;


			//--- RESPONSE => if member not valid
			
			if( $TFCStatus != "VALID" ) {
			
				 $res['VALIDATE_RESULT'] = "TRANSACTION DENIED";
				 $res['VALIDATE_TEXT']   = "SORRY, YOUR CARD IS NOT-VALID OR EXPIRED";
				 $res['VALIDATE_ERROR']  = "MEMBER-STATUS : ".$TFCStatus.". ";
				 
				 echo "<br>";
				 $this->response_result($res);
				 exit;
			}
 			//exit;
			//----------------------------------------------------------------------------- 
			echo "<br>";
			
			
			//-- VALIDATE MERCHANT
			//echo '<br>VALIDATE MERCHANT:';
			
			$q2 = "SELECT ID as MerchantID, TFCMerchantID, TFCMerchantName, TFCMerchantStatus, TFCMerchantValidDateBegin, TFCMerchantValidDateEnd 
				   FROM merchant_table Where TFCMerchantID = '".$merchant_id."' limit 1";
			
			$qData2 =  $this->db->query($q2);
			 		
			if($qData2->num_rows()){  
				foreach($qData2->result_array() as $row2){   
					foreach($row2 as $key2 => $value2) {
						echo "<br>$key2 => $value2";
						/* 
						TFCMerchantID => 01-56789
						TFCMerchantName => Salon Uhuyi
						TFCMerchantStatus => VALID    
						TFCValidDateBegin => 2016-02-01
						TFCValidDateEnd => 2017-02-01 
						*/ 
						if($key2=="ID"){ 
							$data['Mid'] = $Mid = $value2;
						}					
						if($key2=="TFCValidDateBegin"){
	// 						echo "<br>TFCMerchantValidDateBegin => $value2";
							$data['TFCMerchantValidDateBegin'] = $TFCMerchantValidDateBegin = $value2;
						}
						elseif($key2=="TFCValidDateEnd"){
	// 						echo "<br>TFCMerchantValidDateEnd => $value2";
							$data['TFCMerchantValidDateEnd'] = $TFCMerchantValidDateEnd = $value2;
						}
						else{
	// 						echo "<br>$key2 => $value2";
							$$key2 = $value2;
							$data[$key2] = $value2; 
						}
					}
				} 
				$merchant_exist = 1;
			} else $merchant_exist = 0;
			
 
			//$row2 = $qData2->result_array();
			//$dtbegin2 = $row2[0]['TFCMerchantValidDateBegin']; 
			//$dtend2   = $row2[0]['TFCMerchantValidDateEnd'];
//			echo "<br>dtbegin2 = $dtbegin2";
//			echo "<br>dtend2   = $dtend2";

			//-- CHECK EXPIRE  
			if(!isset($TFCMerchantValidDateBegin)) $TFCMerchantValidDateBegin = '';
			if(!isset($TFCMerchantValidDateEnd)) $TFCMerchantValidDateEnd = '';
			$merchant_expired = $this->allmodel->dateIsExpire($curDate,$TFCMerchantValidDateBegin,$TFCMerchantValidDateEnd);
 			
			
			if(!isset($TFCMerchantStatus)) $TFCMerchantStatus = '';
			//---if member expired => change TFCStatus to EXPIRED 
			if( $TFCMerchantStatus=="VALID" && $merchant_expired){
				$q = "Update merchant_table Set `TFCMerchantStatus` = 'EXPIRED' Where `ID`= '".$MerchantID."' Limit 1"; 
				$this->db->query($q);
				$TFCMerchantStatus="EXPIRED";
				echo "<br>TFCMerchantStatus => $TFCMerchantStatus";
			}
 
			//-- MERCHANT STATUS 
			echo "<br>";
			echo "merchant_exist => $merchant_exist";
			echo "<br>";
			echo "merchant_expired => $merchant_expired" ;


			//--- RESPONSE => if member/merchant not valid
 
			if( $TFCMerchantStatus != "VALID" ) {
				 $res['VALIDATE_RESULT'] = "TRANSACTION DENIED";
				 $res['VALIDATE_TEXT']   = "SORRY, MERCHANT IS NOT-VALID OR EXPIRED";
				 $res['VALIDATE_ERROR']  = "MERCHANT-STATUS : ".$TFCMerchantStatus.". ";
				 
				 echo "<br>";
				 $this->response_result($res);
				 exit;
			} else {
			
				 $res['VALIDATE_RESULT'] = "VALIDATION SUCCESS";
				 $res['VALIDATE_TEXT']   = "MERCHANT-STATUS : VALID , MERCHANT-STATUS : VALID";
				 $res['VALIDATE_ERROR']  = "NONE";
				 
				 echo "<br>";
				 $this->response_result($res);
			
			}
 

 			//exit;
			//----------------------------------------------------------------------------- 
			echo "<br>";
			
			
			
			
			
			
			//-- PRODUCT MERCHANT
//			echo '<br>PRODUCTs MERCHANT:';
			 
			
			//$q3 = "SELECT * FROM db_merchant_product Where merchant_id = '".$MerchantID."' and status_id = 1 Order By product_name";
			$q3 = "SELECT id,merchant_id,merchant_category,merchant_type,product_name,product_value,product_periode,product_credit,product_term FROM db_merchant_product Where merchant_id = '".$MerchantID."' and status_id = 1 Order By product_name";
			$qData3 =  $this->db->query($q3);
			
			foreach($qData3->result_array() as $kkk => $row3){   
				foreach($row3 as $key3 => $value3) {
 					//echo "<br>products - $kkk => $key3 => $value3";
					$products[$kkk][$key3] = $value3;
					$data[$kkk][$key3] = $value3; 
				}
			} 
			foreach($products as $k10 => $row10){  
				$mp_id = $products[$k10]['id'];
				$merchant_product[$mp_id] = $row10; 
			}
 
 			//---- VALIDATE PRODUCTS
			foreach($merchant_product as $kkk => $row3){   
				foreach($row3 as $key3 => $value3) {
					echo "<br>item_$key3 => $value3";  
					$item[$kkk][$key3] = $value3;
				} 
 				//echo "<br>".$item[$kkk]['merchant_type'];
				
				
				//--- CHECK CREDIT FOR THIS PRODUCT
				/*
				item_id => 17
				item_merchant_id => 7
				item_product_name => Car Wash
				item_product_value => 4
				item_product_periode => dy
				item_product_credit => 356
 				*/
 				$merchant_product = $kkk; 
				
				$maxValue = $item[$kkk]['product_value']; 
 				
				$trxdate1 = date("Y-m-d 00:00:00");
				$trxdate2 = date("Y-m-d 23:59:59");
 				$strPeriode = '';
				
				if($item[$kkk]['product_periode']=="dy"){ 
					$trxdate1 = date("Y-m-d 00:00:00");
					$trxdate2 = date("Y-m-d 23:59:59");
					$strPeriode = "day";
				} 
 
				if($item[$kkk]['product_periode']=="mo"){ 
					$trxdate1 = date("Y-m")."-01 00:00:00";
					$a_date = date("Y-m-d");
					$ldate = date("t", strtotime($a_date));
					$trxdate2 = date("Y-m")."-".$ldate." 23:59:59";
					$strPeriode = "month";
				}
				if($item[$kkk]['product_periode']=="yr"){ 
					$trxdate1 = $TFCValidDateBegin." 00:00:00";
					$trxdate2 = $TFCValidDateEnd." 23:59:59"; 
					$strPeriode = "year";
				} 
				
 
				$transaction_type = "TRX"; 
				$q4 = "SELECT transaction_date 
						FROM tfc_trx 
						Where 
						transaction_type 	= '".$transaction_type."' and
						card_number 		= '".$card_number."' and 
						card_serialnumber 	= '".$card_serialnum."' and 
						merchant_id 		= '".$merchant_id."' and 
						merchant_product	= '".$merchant_product."' and 
						status_id 			= 1 and 
						transaction_date >= '".$trxdate1."' And transaction_date <= '".$trxdate2."' 
						Order By transaction_date Desc";
 
				$qData4 =  $this->db->query($q4); 
					
				$usedValue = $qData4->num_rows();	
 
				echo "<br>item_trx_value_max => ".$maxValue;
				echo "<br>item_trx_value_used => ".$usedValue; 
				
				$trxNow = $usedValue+1;
				if($trxNow>$maxValue) $trxNow = 0;
				$trxAccept = "OK";
				if(empty( $trxNow)) $trxAccept = "DENIED";
				
				$last_trx=""; 
				foreach($qData4->result_array() as $kkkk => $row4){   
					foreach($row4 as $key4 => $value4) { 
						$last_trx = $value4; 
						$break=1;
						break;
					} 
					if($break) break;
				}  
				echo "<br>item_trx_last_date => $last_trx";
 				
				echo "<br>";
				echo "<br>item_trx_allowed => ".$trxAccept;  
				echo "<br>item_trx_value_credit => ".( $maxValue - $usedValue); 
				echo "<br>item_trx_value_now => ".$trxNow; 
				
				if($item[$kkk]['merchant_type']==2) 
				echo "<br>item_trx_is_diskon => 1"; 
				
				
				
				
 
 
 				$message = "Sorry, Your credit is 0 for this $strPeriode. Available credit is $maxValue"."/".$strPeriode.". Please use your card next $strPeriode for available new credit(s)";
				
				if($trxAccept=="OK")
 				$message = "You are using $trxNow of $maxValue credit for this item / ".$strPeriode;
				echo "<br>item_trx_message => ".$message; 
 
				//-- URL TRX for this item
				/*
				`transaction_type`, 
				`transaction_id`, 
				`transaction_date`, 
				`card_number`, 
				`card_serialnumber`, 
				`member_credit`, 
				`merchant_id`, 
				`merchant_product`, 
				`product_group`, 
				`string_request`, 
				`status_id`
				*/
				$url_trx ="";
				if($trxAccept=="OK"){
					$url_trx =  $hostname."/query/trx/". 
							"transaction_id=$transaction_id---".
							"card_number=$card_number---".
							"card_serialnumber=$TFCSerialNumber---".
							"member_credit=$trxNow---".
							"merchant_id=$merchant_id---".
							"merchant_product=$merchant_product";
							
					if($item[$kkk]['merchant_type']==2) {
						$url_trx .=  "---is_diskon=1";	
						$isdiskon = 1;
					} else $isdiskon = 0;
				}	
				echo "<br>item_trx_url => $url_trx";	
				
				/*
				if(isset($isdiskon))if($isdiskon){
				
				 
				echo ' 
				<form id="form1" name="form1" method="post" action="">
item_diskon_from Rp. <input type="text" name="diskon_from" id="diskon_from"  size="6" /> -> <input type="submit" name="button" id="button" value="Submit" />
				</form>';	
					 
				}
				*/
				
				if($trxAccept=="OK")
				echo '<br><a href="'.$url_trx.'" target="_blank">SUBMIT THIS ITEM</a>';  
				
				 
				 		
				echo "<br>";
					
				 
				
			} 
 
		 
			echo "<br>";
			echo "----------------------------------------------------------------------------------";
			echo "<br>";
/* 
 			$ALLOW_TRX = false;
			
 		
			
			// -- val status 
 
			$VALIDATE_ERROR = '';
			if(!$valDTMember){
				if(date("Y-m-d H:i:s") > $TFCValidDateEnd) 
				$VALIDATE_ERROR .= "<br>MEMBER-DATE-STATUS : EXPIRE";
				else
				$VALIDATE_ERROR .= "<br>MEMBER-DATE-STATUS : NOT-VALID"; 
			}
			if(!$valDTMerchant){
				if(date("Y-m-d H:i:s") > $TFCMerchantValidDateEnd) 
				$VALIDATE_ERROR .= "<br>MERCHANT-VALID-DATE : EXPIRE";
				else
				$VALIDATE_ERROR .= "<br>MERCHANT-VALID-DATE : NOT-VALID"; 
			} 
			if(!$valSTMember){ 
				$VALIDATE_ERROR .= "<br>MEMBER-STATUS : ".$TFCStatus;  
			} 
			if(!$valSTMerchant){ 
				$VALIDATE_ERROR .= "<br>MERCHANT-STATUS : ".$TFCMerchantStatus;  
			}
			$VALIDATE_RESULT 	= "TRANSACTION DENIED";
			$VALIDATE_TEXT   	= "SORRY, YOUR CARD IS NOT-VALID OR EXPIRE"; 			
 
			if(empty($VALIDATE_ERROR)){
				$ALLOW_TRX = true; 
				$VALIDATE_RESULT 	= "TRANSACTION ALLOW";
				$VALIDATE_TEXT   	= "VALIDATE OK";  
			}
			else $ALLOW_TRX = false;
 
			echo "<br>";
			echo "<br>VALIDATE RESULT => $VALIDATE_RESULT ";
			echo "<br>VALIDATE TEXT 	=> $VALIDATE_TEXT ";
			echo "<br>VALIDATE ERROR  => $VALIDATE_ERROR ";
			echo "<br>";
			
			//----- MEMBER - MERCHAN - PRODUCT
 
 			if($ALLOW_TRX==true)
				
			foreach($merchant_product as $key => $value){
 
				$id = $merchant_product[$key]['id'];
				$tmember_credit[$key] = $member_credits[$id]['member_credit']; 
				
				if($tmember_credit[$key]=="") 
				$tmember_credit[$key] = $merchant_product[$key]['product_value']; 
 
				//--test
				//if($key=='1') $tmember_credit = 0;
				 
				
				$p_period = $merchant_product[$key]['product_periode'];
				if($p_period=="dy") $str_period = "/ Day";
				elseif($p_period=="mo") $str_period = "/ Month";
				elseif($p_period=="yr") $str_period = "/ Year";
				else $str_period = "";
				 
				
 
				echo "<br>";
				
				echo "<br>merchant_product[".$key."]['id'] = ".$merchant_product[$key]['id'] ; 
				echo "<br>merchant_product[".$key."]['name'] = ".$merchant_product[$key]['product_name'] ; 
				echo "<br>merchant_product[".$key."]['value'] = ".$merchant_product[$key]['product_value']." credit ".$str_period;  //-- harian/bulanan/tahunan
				echo "<br>merchant_product[".$key."]['member_credit'] = ".$tmember_credit[$key] ;  
				
				echo "<br>";
				 
				
				if($tmember_credit[$key]>0){ //-- saldo credit masih ada
				
					echo "<br> -- merchant_product[".$key."]['trx_allow'] = TRUE => SHOW BUTTON TO SELECT THIS PRODUCT"; 
					echo "<br> -- merchant_product[".$key."]['trx_error'] = You have ".$tmember_credit." credits lefts to select this product this month."; 
					echo "<br> -- merchant_product[".$key."]['trx_last']  = ".$products[$key]['product_transaction_last'] ; 
				
				} else {
				 
					echo "<br> -- merchant_product[".$key."]['trx_allow'] = FALSE => DISABLE BUTTON OF THIS PRODUCT";  
					echo "<br> -- merchant_product[".$key."]['trx_error'] = Sorry, you have using all credit this month for this product. Try next month...";  
					echo "<br> -- merchant_product[".$key."]['trx_last']  = ".$products[$key]['product_transaction_last'] ;  
 	
				}
				
				//if(empty($credits[$key]['member_credit'])) $valProduct = false;
			
			}
			
			
			if( $member_status=="VALID" && $meerchant_status=="VALID" && $valProduct ) $VALIDATE_TRANSACTION = "OK";
			else {
				
				 $VALIDATE_RESULT = "TRANSACTION DENIED";
				 $VALIDATE_TEXT   = "SORRY, YOUR CARD IS NOT-VALID OR EXPIRE";
				 $VALIDATE_ERROR  = "MERCHANT-STATUS : ".$TFCMerchantStatus." | MEMBER-STATUS : ".$TFCStatus.". ";
			
			
			}
 */			


		
		
		}
		
 
		
		
		echo '</pre>';
	
		
		//-- belum kelarrrrr....
		//echo "/query/val/<br>".str_replace("---","<br>",$qstr) ;
		
		//re_direct($str, 'refresh'); 
	
	}
	
	
 
	function val_result($str_request='') { 
 
		//$this->load->view('sim2_view',$data); 
	
	}
	
	function printed_card($card_number=0,$card_serial=0,$status="",$dt=""){
		//http://admin.tribunfamilycard.com/query/printed_card/XXXXXXXXXX/YYYYYY/PRINTSTATUS/DATETIME
		if($status=="OK"){
		
			//-- change member data
 
			$q = "Update member_table Set 
			`TFCStatus` = 'VALID',  
			`TFCSerialNumber` = '".$card_serial."'  
			Where `TFCNumber`= '".$card_number."' and StatusID = 1 Limit 1"; 
			$this->db->query($q); 
 
			//--- createds log
		 	$dt = date("Y-m-d H:i:s");
			$desc = "card_number=".$card_number.", card_serial=".$card_serial.", status=".$status.", dt=".$dt ;
			$q = "INSERT INTO `log_admin_action` (`ID`, `datetime`, `user_id`, `activity`, `description`) 
					VALUES ('', '".$dt."', '".$this->session->userdata('ID')."', 'Print-Card', '".$desc."' )";						 
			$this->db->query($q);
			
			echo "DONE";
						
		}				
	
	
	}
	
	function getcarddata(){
		if($_POST){
			//foreach($_POST as $key => $value) echo "<br>$key => $value";
		
			if(isset($_POST['card_number']))
			if(!empty($_POST['card_number'])){
			 
				$q = "SELECT * FROM member_table Where TFCNumber = '".$_POST['card_number']."' and StatusID = 1 limit 1"; 
				$qData = $this->db->query($q);
				
				if( $qData->num_rows() ){ 
				
					$row = $qData->result_array();   
					
					$FullName 			= $row[0]['FullName'];
					echo "FullName = $FullName<br>";
					$TFCNumber 			= $row[0]['TFCNumber'];
					echo "TFCNumber = $TFCNumber<br>";
					$TFCStatus 			= $row[0]['TFCStatus'];
					echo "TFCStatus = $TFCStatus<br>";
					$TFCNoPolisi 		= $row[0]['TFCNoPolisi'];
					echo "TFCNoPolisi = $TFCNoPolisi<br>";
					$TFCValidDateBegin 	= $row[0]['TFCValidDateBegin'];
					echo "TFCValidDateBegin = $TFCValidDateBegin<br>";
					$TFCValidDateEnd 	= $row[0]['TFCValidDateEnd'];
					echo "TFCValidDateEnd = $TFCValidDateEnd<br>";
				}
			
			}
		
		
		
		}
		
	
	}
	
	function trx($qString=''){
	
	
		$hostname = "http://admin.tribunfamilycard.com/query/trx/"; 
		//$hostname = "http://localhost/query/trx/"; 
		
		//http://localhost/query/trx/transaction_id=01-56789-160325-061589---card_number=0210000003---card_serialnumber=000001%20---member_credit=1---merchant_id=0210004---merchant_product=20
		//transaction_id=01-56789-160325-061589---card_number=0210000003---card_serialnumber=000001%20---member_credit=1---merchant_id=0210004---merchant_product=20
		//echo $qString;
		
		$arrQStr = explode("---",$qString);
		
		foreach($arrQStr as $key => $value) {		
			if(substr($value,0,4)=="note"){
				$value = str_replace("=",":",$value);
				$value = str_replace("note:","note=",$value);
				$value = str_replace("%20"," ",$value);
				$value = str_replace("'","`",$value);
				//$value = str_replace(",","_coma_",$value);
				//$value = str_replace(".","_dot_",$value);
				//$value = htmlspecialchars($value);
			}
			//echo "<br>$key => $value";  
			
			$row = explode("=",$value);
			$k = $row[0];
			$v = $row[1]; 
			$$k = $v;
			$data[$k] = $v;
			/*
			0 => transaction_id=021-160406-091925
			1 => card_number=0210000003
			2 => card_serialnumber=990C177D
			3 => member_credit=2
			4 => merchant_id=0210004
			5 => merchant_product=23
			
			6 => is_diskon=1
			7 => diskon_from=50000
			8 => diskon_value=20
			9 => diskon_amount=10000
			
			10 => note=transaction%20amount%20=%20100rb,%20discount%20=%2020,%20discount%20amount%20=%2020rb
			*/  
		} 
		//foreach($data as $key => $value) echo "<br>$key => $value"; 
		//exit;
		
		if(!isset($note)) $note='';
		
		//-- $product_type from merchant_product=20
		$product_type = '';	
		 
		$qp = "SELECT * FROM db_merchant_product Where id = '".$merchant_product."' and status_id = 1 limit 1"; 
		$qPrd = $this->db->query($qp);
		
		if($qPrd->num_rows()){ 
			$rowPrd = $qPrd->result_array();   
			
			$merchant_type = $rowPrd[0]['merchant_type'];
 
			$qp = "SELECT * FROM md_merchant_type Where id = '".$merchant_type."' and status_id = 1 limit 1"; 
			$qPtype = $this->db->query($qp);
			if($qPtype->num_rows()){ 
				$rowPtype = $qPtype->result_array(); 
					//$product_type_id 	  = $rowPtype[0]['id'];
					$product_type = $rowPtype[0]['name']; 
			}
		
		}
		
		//echo $product_typename; //DISCOUNT 
 
		/* ID IS DISKON
			$product_type
			http://localhost/query/trx/
			transaction_id=021-160406-091925---card_number=0210000003---card_serialnumber=990C177D---member_credit=2---merchant_id=0210004---merchant_product=23---
			is_diskon=1 
			
			---is_diskon=1
			---diskon_from=50000
			---diskon_value=20
			---diskon_amount=10000  
		
		*/ 
		$strInsertDiskonKey = '';
		$strInsertDiskonVal = '';
		if(isset($is_diskon)&&isset($diskon_from)&&isset($diskon_value)&&isset($diskon_amount)){
		
			if($is_diskon){
				$product_type = 'DISCOUNT';//$product_typename;
				
				$strInsertDiskonKey = " , `diskon_from`, `diskon_value`, `diskon_amount` ";
				$strInsertDiskonVal = " , '".$diskon_from."', '".$diskon_value."', '".$diskon_amount."' ";
		
			}
		}
		
		 
		echo "<br>transaction_id = $transaction_id"; 
		echo "<br>card_number = $card_number"; 
		echo "<br>card_serialnumber = $card_serialnumber"; 
		echo "<br>member_credit = $member_credit"; 
		echo "<br>merchant_id = $merchant_id"; 
		echo "<br>merchant_product = $merchant_product"; 
	 	
		//-- chk exist
		$q = "SELECT 1 FROM tfc_trx Where transaction_type = 'TRX' and transaction_id = '".$transaction_id."' limit 1"; 
		$dat = $this->db->query($q);
		$chk = $dat->num_rows();  
		$qInsert = 0;	 
		if(!$chk){  
			 $q2 = "INSERT INTO `tfc_trx` (
			`id`, `transaction_type`, `transaction_id`, `transaction_date`, `card_number`, `card_serialnumber`, 
			`member_credit`, `merchant_id`, `merchant_product`, `merchant_note`, `product_group`, `product_type`, `string_request`, `status_id`,
			`settlement_by`, `settlement_date`, `settlement_amount`, `settlement_status` ".$strInsertDiskonKey.") 
			VALUES (NULL, 'TRX', '".$transaction_id."', '".date("Y-m-d H:i:s")."', '".$card_number."', '".$card_serialnumber."', 
			'".$member_credit."', '".$merchant_id."', '".$merchant_product."', '".$note."', '0', '".$product_type."', '".$hostname.$qString."', '1',
			0,NULL,'',0 ".$strInsertDiskonVal."
			)"; 
			 
			if( $this->db->query($q2) ) $qInsert = 1 ;
			else $qInsert = 2 ;
			
		} else $qInsert = 3; 
		 
		if(isset($is_diskon)&&isset($diskon_from)&&isset($diskon_value)&&isset($diskon_amount)){ 
			//exit;
		}
		
		if($qInsert=='1'){ 
 			echo "<br>trx_result = SUCCESS. Thank You for using Tribun Family Card.";
			//$data['trx_result'] = "SUCCESS. Thank You for using Tribun Family Card.";
		}
		if($qInsert=='2'){ 
 			echo "<br>trx_result = TRANSACTION FAILED. Error submited this transaction to server, please try again or contact our TFC Customer Service.";
			//$data['trx_result'] = "TRANSACTION FAILED. Error submited this transaction to server, please try again or contact our TFC Customer Service.";
		}
		if($qInsert=='3'){ 
 			echo "<br>trx_result = This Transaction already exist, do not re-submit this item or please try again."; 
		} 
		
	
	}
	
	function val() { 
	
		$hostname = "http://admin.tribunfamilycard.com"; 
		//$hostname = "http://localhost"; 
	
		//-- htmlPOST from device => insert db transaction_type = "validate" 

		echo '<pre>';
		
		$qstr = '';
		
		if($_POST){
		
			$curDate = date("Y-m-d H:i:s");
			echo "<br>curDate => $curDate";
			
			//-- save htmlpost to db 
			$strRequest = base_url()."query/val/";
			
			foreach($_POST as $key => $value) {
				echo "<br>$key => $value";
 
				$strRequest .= $key."=".$value."---";
				
				$$key = $value;
				/*
				card_number => 11-0000-1111
				card_serialnum => 87654321
				merchant_id => 01-56789
				transaction_id => 01-56789-160302-050432
				*/
				
				//if($key=='transaction_id')
				//$qstr .= $key."=".$value."---";
			} 
			
			
			//--- INSERT TO DB TRX #1 : Send to Validation 
			
			$transaction_type = "VAL"; 
			$string_request = $strRequest."isPOST";
			
			//-- chk exist
			$q = "SELECT 1 FROM tfc_trx Where transaction_type = '".$transaction_type."' and transaction_id = '".$transaction_id."' limit 1"; 
			$dat = $this->db->query($q);
			$chk = $dat->num_rows();  
			
			if(!$chk){  //echo "INSERT";
				//-- INSERT  
				$q = " INSERT INTO `tfc_trx` (
				`id`, `transaction_type`, `transaction_id`, `transaction_date`, 
				`card_number`, `card_serialnumber`, `member_credit`, 
				`merchant_id`, `merchant_product`, `string_request`, `status_id`) 
				VALUES (
				NULL, '".$transaction_type."', '".$transaction_id."', '".date('Y-m-d H:i:s')."', 
				'".$card_number."', '".$card_serialnum."', '', 
				'".$merchant_id."', '', '".$string_request."', '1')"; 
				
				$this->db->query($q);
			
			} //else echo "EXIST";
			
 			//exit;
			//----------------------------------------------------------------------------- 
			echo "<br>";
			
			//-- VALIDATE MEMBER -> get Member Data
			//echo '<br>VALIDATE MEMBER:';
			
			$TFCStatus = 'NOTVALID';
			
			$q1 = "SELECT ID as MemberID, FullName, TFCNumber, TFCSerialNumber, TFCStatus, TFCNoPolisi, TFCValidDateBegin, TFCValidDateEnd 
				  FROM member_table Where TFCNumber = '".$card_number."' and TFCSerialNumber = '".$card_serialnum."' limit 1";
 
			$qData1 =  $this->db->query($q1);
 
			if($qData1->num_rows()){  
				foreach($qData1->result_array() as $row1){   
					foreach($row1 as $key => $value1) {
						echo "<br>$key => $value1";
						$$key = $value1;
						$data[$key] = $value1;
						/* 
						FullName => Agung Siagunggung  
						TFCNumber => 11-0000-1111
						TFCSerialNumber => 87654321
						TFCStatus => REGISTER
						TFCNoPolisi => AA 2222 XX 
						TFCValidDateBegin => 2016-02-01
						TFCValidDateEnd => 2017-02-01  
						*/
					}
				} 
				$member_exist = 1;
			} else { $member_exist = 0; $member_expired = '';}
			
			if($member_exist){
				$row = $qData1->result_array();
				
				$dtbegin = $row[0]['TFCValidDateBegin']; 
				$dtend   = $row[0]['TFCValidDateEnd']; 
				//echo "<br>dtbegin = $dtbegin";
				//echo "<br>dtend   = $dtend";
				//echo "<br>"; 
				//-- CHECK EXPIRE  
				$member_expired = $this->allmodel->dateIsExpire($curDate,$TFCValidDateBegin,$TFCValidDateEnd);
				
				//---if member expired => change TFCStatus to EXPIRED 
				if( $TFCStatus=="VALID" && $member_expired){
					$q = "Update member_table Set `TFCStatus` = 'EXPIRED' Where `ID`= '".$MemberID."' Limit 1"; 
					$this->db->query($q);
					$TFCStatus="EXPIRED";
					echo "<br>TFCStatus => $TFCStatus";
				}
 			}
			//-- MEMBER STATUS 
			echo "<br>";
			echo "member_exist => $member_exist";
			echo "<br>";
			echo "member_expired => $member_expired" ;


			//--- RESPONSE => if member not valid
			
			if( $TFCStatus != "VALID" ) {
			
				 $res['VALIDATE_RESULT'] = "TRANSACTION DENIED";
				 $res['VALIDATE_TEXT']   = "SORRY, YOUR CARD IS NOT-VALID OR EXPIRED";
				 $res['VALIDATE_ERROR']  = "MEMBER-STATUS : ".$TFCStatus.". ";
				 
				 echo "<br>";
				 $this->response_result($res);
				 exit;
			}
 			//exit;
			//----------------------------------------------------------------------------- 
			echo "<br>";
			
			
			//-- VALIDATE MERCHANT
			//echo '<br>VALIDATE MERCHANT:';
			
			$q2 = "SELECT ID as MerchantID, TFCMerchantID, TFCMerchantName, TFCMerchantStatus, TFCMerchantValidDateBegin, TFCMerchantValidDateEnd 
				   FROM merchant_table Where TFCMerchantID = '".$merchant_id."' limit 1";
			
			$qData2 =  $this->db->query($q2);
			 		
			if($qData2->num_rows()){  
				foreach($qData2->result_array() as $row2){   
					foreach($row2 as $key2 => $value2) {
						echo "<br>$key2 => $value2";
						/* 
						TFCMerchantID => 01-56789
						TFCMerchantName => Salon Uhuyi
						TFCMerchantStatus => VALID    
						TFCValidDateBegin => 2016-02-01
						TFCValidDateEnd => 2017-02-01 
						*/ 
						if($key2=="ID"){ 
							$data['Mid'] = $Mid = $value2;
						}					
						if($key2=="TFCValidDateBegin"){
	// 						echo "<br>TFCMerchantValidDateBegin => $value2";
							$data['TFCMerchantValidDateBegin'] = $TFCMerchantValidDateBegin = $value2;
						}
						elseif($key2=="TFCValidDateEnd"){
	// 						echo "<br>TFCMerchantValidDateEnd => $value2";
							$data['TFCMerchantValidDateEnd'] = $TFCMerchantValidDateEnd = $value2;
						}
						else{
	// 						echo "<br>$key2 => $value2";
							$$key2 = $value2;
							$data[$key2] = $value2; 
						}
					}
				} 
				$merchant_exist = 1;
			} else $merchant_exist = 0;
			
 
			//$row2 = $qData2->result_array();
			//$dtbegin2 = $row2[0]['TFCMerchantValidDateBegin']; 
			//$dtend2   = $row2[0]['TFCMerchantValidDateEnd'];
//			echo "<br>dtbegin2 = $dtbegin2";
//			echo "<br>dtend2   = $dtend2";

			//-- CHECK EXPIRE  
			if(!isset($TFCMerchantValidDateBegin)) $TFCMerchantValidDateBegin = '';
			if(!isset($TFCMerchantValidDateEnd)) $TFCMerchantValidDateEnd = '';
			$merchant_expired = $this->allmodel->dateIsExpire($curDate,$TFCMerchantValidDateBegin,$TFCMerchantValidDateEnd);
 			
			
			if(!isset($TFCMerchantStatus)) $TFCMerchantStatus = '';
			//---if member expired => change TFCStatus to EXPIRED 
			if( $TFCMerchantStatus=="VALID" && $merchant_expired){
				$q = "Update merchant_table Set `TFCMerchantStatus` = 'EXPIRED' Where `ID`= '".$MerchantID."' Limit 1"; 
				$this->db->query($q);
				$TFCMerchantStatus="EXPIRED";
				echo "<br>TFCMerchantStatus => $TFCMerchantStatus";
			}
 
			//-- MERCHANT STATUS 
			echo "<br>";
			echo "merchant_exist => $merchant_exist";
			echo "<br>";
			echo "merchant_expired => $merchant_expired" ;


			//--- RESPONSE => if member/merchant not valid
 
			if( $TFCMerchantStatus != "VALID" ) {
				 $res['VALIDATE_RESULT'] = "TRANSACTION DENIED";
				 $res['VALIDATE_TEXT']   = "SORRY, MERCHANT IS NOT-VALID OR EXPIRED";
				 $res['VALIDATE_ERROR']  = "MERCHANT-STATUS : ".$TFCMerchantStatus.". ";
				 
				 echo "<br>";
				 $this->response_result($res);
				 exit;
			} else {
			
				 $res['VALIDATE_RESULT'] = "VALIDATION SUCCESS";
				 $res['VALIDATE_TEXT']   = "MERCHANT-STATUS : VALID , MERCHANT-STATUS : VALID";
				 $res['VALIDATE_ERROR']  = "NONE";
				 
				 echo "<br>";
				 $this->response_result($res);
			
			}
 

 			//exit;
			//----------------------------------------------------------------------------- 
			echo "<br>";
			
			
			
			
			
			
			//-- PRODUCT MERCHANT
//			echo '<br>PRODUCTs MERCHANT:';
			 
			
			//$q3 = "SELECT * FROM db_merchant_product Where merchant_id = '".$MerchantID."' and status_id = 1 Order By product_name";
			$q3 = "SELECT id,merchant_id,merchant_category,merchant_type,product_name,product_value,product_periode,product_credit,product_term FROM db_merchant_product Where merchant_id = '".$MerchantID."' and status_id = 1 Order By product_name";
			$qData3 =  $this->db->query($q3);
			
			foreach($qData3->result_array() as $kkk => $row3){   
				foreach($row3 as $key3 => $value3) {
 					//echo "<br>products - $kkk => $key3 => $value3";
					$products[$kkk][$key3] = $value3;
					$data[$kkk][$key3] = $value3; 
				}
			} 
			foreach($products as $k10 => $row10){  
				$mp_id = $products[$k10]['id'];
				$merchant_product[$mp_id] = $row10; 
			}
 
 			//---- VALIDATE PRODUCTS
			foreach($merchant_product as $kkk => $row3){   
				foreach($row3 as $key3 => $value3) {
					echo "<br>item_$key3 => $value3";  
					$item[$kkk][$key3] = $value3;
				} 
 				//echo "<br>".$item[$kkk]['merchant_type'];
				
				
				//--- CHECK CREDIT FOR THIS PRODUCT
				/*
				item_id => 17
				item_merchant_id => 7
				item_product_name => Car Wash
				item_product_value => 4
				item_product_periode => dy
				item_product_credit => 356
 				*/
 				$merchant_product = $kkk; 
				
				$maxValue = $item[$kkk]['product_value']; 
 				
				$trxdate1 = date("Y-m-d 00:00:00");
				$trxdate2 = date("Y-m-d 23:59:59");
 				$strPeriode = '';
				
				if($item[$kkk]['product_periode']=="dy"){ 
					$trxdate1 = date("Y-m-d 00:00:00");
					$trxdate2 = date("Y-m-d 23:59:59");
					$strPeriode = "day";
				} 
 
				if($item[$kkk]['product_periode']=="mo"){ 
					$trxdate1 = date("Y-m")."-01 00:00:00";
					$a_date = date("Y-m-d");
					$ldate = date("t", strtotime($a_date));
					$trxdate2 = date("Y-m")."-".$ldate." 23:59:59";
					$strPeriode = "month";
				}
				if($item[$kkk]['product_periode']=="yr"){ 
					$trxdate1 = $TFCValidDateBegin." 00:00:00";
					$trxdate2 = $TFCValidDateEnd." 23:59:59"; 
					$strPeriode = "year";
				} 
				
 
				$transaction_type = "TRX"; 
				$q4 = "SELECT transaction_date 
						FROM tfc_trx 
						Where 
						transaction_type 	= '".$transaction_type."' and
						card_number 		= '".$card_number."' and 
						card_serialnumber 	= '".$card_serialnum."' and 
						merchant_id 		= '".$merchant_id."' and 
						merchant_product	= '".$merchant_product."' and 
						status_id 			= 1 and 
						transaction_date >= '".$trxdate1."' And transaction_date <= '".$trxdate2."' 
						Order By transaction_date Desc";
 
				$qData4 =  $this->db->query($q4); 
					
				$usedValue = $qData4->num_rows();	
 
				echo "<br>item_trx_value_max => ".$maxValue;
				echo "<br>item_trx_value_used => ".$usedValue; 
				
				$trxNow = $usedValue+1;
				if($trxNow>$maxValue) $trxNow = 0;
				$trxAccept = "OK";
				if(empty( $trxNow)) $trxAccept = "DENIED";
				
				$last_trx=""; 
				foreach($qData4->result_array() as $kkkk => $row4){   
					foreach($row4 as $key4 => $value4) { 
						$last_trx = $value4; 
						$break=1;
						break;
					} 
					if($break) break;
				}  
				echo "<br>item_trx_last_date => $last_trx";
 				
				echo "<br>";
				echo "<br>item_trx_allowed => ".$trxAccept;  
				echo "<br>item_trx_value_credit => ".( $maxValue - $usedValue); 
				echo "<br>item_trx_value_now => ".$trxNow; 
				
				if($item[$kkk]['merchant_type']==2) 
				echo "<br>item_trx_is_diskon => 1"; 
				
				
				
				
 
 
 				$message = "Sorry, Your credit is 0 for this $strPeriode. Available credit is $maxValue"."/".$strPeriode.". Please use your card next $strPeriode for available new credit(s)";
				
				if($trxAccept=="OK")
 				$message = "You are using $trxNow of $maxValue credit for this item / ".$strPeriode;
				echo "<br>item_trx_message => ".$message; 
 
				//-- URL TRX for this item
				/*
				`transaction_type`, 
				`transaction_id`, 
				`transaction_date`, 
				`card_number`, 
				`card_serialnumber`, 
				`member_credit`, 
				`merchant_id`, 
				`merchant_product`, 
				`product_group`, 
				`string_request`, 
				`status_id`
				*/
				$url_trx ="";
				if($trxAccept=="OK"){
					$url_trx =  $hostname."/query/trx/". 
							"transaction_id=$transaction_id---".
							"card_number=$card_number---".
							"card_serialnumber=$TFCSerialNumber---".
							"member_credit=$trxNow---".
							"merchant_id=$merchant_id---".
							"merchant_product=$merchant_product";
							
					if($item[$kkk]['merchant_type']==2) {
						$url_trx .=  "---is_diskon=1";	
						$isdiskon = 1;
					} else $isdiskon = 0;
				}	
				echo "<br>item_trx_url => $url_trx";	
				
				/*
				if(isset($isdiskon))if($isdiskon){
				
				 
				echo ' 
				<form id="form1" name="form1" method="post" action="">
item_diskon_from Rp. <input type="text" name="diskon_from" id="diskon_from"  size="6" /> -> <input type="submit" name="button" id="button" value="Submit" />
				</form>';	
					 
				}
				*/
				
				if($trxAccept=="OK")
				echo '<br><a href="'.$url_trx.'" target="_blank">SUBMIT THIS ITEM</a>';  
				
				 
				 		
				echo "<br>";
					
				 
				
			} 
 
		 
			echo "<br>";
			echo "----------------------------------------------------------------------------------";
			echo "<br>";
/* 
 			$ALLOW_TRX = false;
			
 		
			
			// -- val status 
 
			$VALIDATE_ERROR = '';
			if(!$valDTMember){
				if(date("Y-m-d H:i:s") > $TFCValidDateEnd) 
				$VALIDATE_ERROR .= "<br>MEMBER-DATE-STATUS : EXPIRE";
				else
				$VALIDATE_ERROR .= "<br>MEMBER-DATE-STATUS : NOT-VALID"; 
			}
			if(!$valDTMerchant){
				if(date("Y-m-d H:i:s") > $TFCMerchantValidDateEnd) 
				$VALIDATE_ERROR .= "<br>MERCHANT-VALID-DATE : EXPIRE";
				else
				$VALIDATE_ERROR .= "<br>MERCHANT-VALID-DATE : NOT-VALID"; 
			} 
			if(!$valSTMember){ 
				$VALIDATE_ERROR .= "<br>MEMBER-STATUS : ".$TFCStatus;  
			} 
			if(!$valSTMerchant){ 
				$VALIDATE_ERROR .= "<br>MERCHANT-STATUS : ".$TFCMerchantStatus;  
			}
			$VALIDATE_RESULT 	= "TRANSACTION DENIED";
			$VALIDATE_TEXT   	= "SORRY, YOUR CARD IS NOT-VALID OR EXPIRE"; 			
 
			if(empty($VALIDATE_ERROR)){
				$ALLOW_TRX = true; 
				$VALIDATE_RESULT 	= "TRANSACTION ALLOW";
				$VALIDATE_TEXT   	= "VALIDATE OK";  
			}
			else $ALLOW_TRX = false;
 
			echo "<br>";
			echo "<br>VALIDATE RESULT => $VALIDATE_RESULT ";
			echo "<br>VALIDATE TEXT 	=> $VALIDATE_TEXT ";
			echo "<br>VALIDATE ERROR  => $VALIDATE_ERROR ";
			echo "<br>";
			
			//----- MEMBER - MERCHAN - PRODUCT
 
 			if($ALLOW_TRX==true)
				
			foreach($merchant_product as $key => $value){
 
				$id = $merchant_product[$key]['id'];
				$tmember_credit[$key] = $member_credits[$id]['member_credit']; 
				
				if($tmember_credit[$key]=="") 
				$tmember_credit[$key] = $merchant_product[$key]['product_value']; 
 
				//--test
				//if($key=='1') $tmember_credit = 0;
				 
				
				$p_period = $merchant_product[$key]['product_periode'];
				if($p_period=="dy") $str_period = "/ Day";
				elseif($p_period=="mo") $str_period = "/ Month";
				elseif($p_period=="yr") $str_period = "/ Year";
				else $str_period = "";
				 
				
 
				echo "<br>";
				
				echo "<br>merchant_product[".$key."]['id'] = ".$merchant_product[$key]['id'] ; 
				echo "<br>merchant_product[".$key."]['name'] = ".$merchant_product[$key]['product_name'] ; 
				echo "<br>merchant_product[".$key."]['value'] = ".$merchant_product[$key]['product_value']." credit ".$str_period;  //-- harian/bulanan/tahunan
				echo "<br>merchant_product[".$key."]['member_credit'] = ".$tmember_credit[$key] ;  
				
				echo "<br>";
				 
				
				if($tmember_credit[$key]>0){ //-- saldo credit masih ada
				
					echo "<br> -- merchant_product[".$key."]['trx_allow'] = TRUE => SHOW BUTTON TO SELECT THIS PRODUCT"; 
					echo "<br> -- merchant_product[".$key."]['trx_error'] = You have ".$tmember_credit." credits lefts to select this product this month."; 
					echo "<br> -- merchant_product[".$key."]['trx_last']  = ".$products[$key]['product_transaction_last'] ; 
				
				} else {
				 
					echo "<br> -- merchant_product[".$key."]['trx_allow'] = FALSE => DISABLE BUTTON OF THIS PRODUCT";  
					echo "<br> -- merchant_product[".$key."]['trx_error'] = Sorry, you have using all credit this month for this product. Try next month...";  
					echo "<br> -- merchant_product[".$key."]['trx_last']  = ".$products[$key]['product_transaction_last'] ;  
 	
				}
				
				//if(empty($credits[$key]['member_credit'])) $valProduct = false;
			
			}
			
			
			if( $member_status=="VALID" && $meerchant_status=="VALID" && $valProduct ) $VALIDATE_TRANSACTION = "OK";
			else {
				
				 $VALIDATE_RESULT = "TRANSACTION DENIED";
				 $VALIDATE_TEXT   = "SORRY, YOUR CARD IS NOT-VALID OR EXPIRE";
				 $VALIDATE_ERROR  = "MERCHANT-STATUS : ".$TFCMerchantStatus." | MEMBER-STATUS : ".$TFCStatus.". ";
			
			
			}
 */			


		
		
		}
		
 
		
		
		echo '</pre>';
	
		
		//-- belum kelarrrrr....
		//echo "/query/val/<br>".str_replace("---","<br>",$qstr) ;
		
		//re_direct($str, 'refresh'); 
	
	}
	
	function response_result($res=''){

		if(is_array($res))
		if(count($res)>0)
		foreach($res as $key => $value)
		echo "<br>$key => $value";
		  
	}
	
	
	
}
