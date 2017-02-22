<?php   
 
class Query_tap extends Controller { 
	function Query_tap(){ 
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
	
	function val() { 
 
 		//$hostname = "http://admin.tribunfamilycard.com"; 
		$hostname = "http://localhost"; 
 
		//$ECHO = '<pre>';
		
		$qstr = '';
		
		if($_POST){
		
			$curDate = date("Y-m-d H:i:s");
			$ECHO .= "<br>curDate => $curDate";
			
			//-- save htmlpost to db 
			$strRequest = base_url()."query/tap/";
			
			foreach($_POST as $key => $value) {
				
				if($key!=="button"){
					$ECHO .= "<br>$key => $value"; 
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
			
			$ECHO .= "<br>transaction_id => $transaction_id";
			
            //Set transaction_id  
			//$this->load->library('session'); 
           //$this->CI->session->set_userdata(array('transaction_id' => $transaction_id)); 			
			//echo "<br>transaction_id => ".$this->session->userdata('transaction_id');;
			
			
			//--- INSERT TO DB TRX #1 : Send to Validation 
			
			$transaction_type = "VAL"; 
			$string_request = $strRequest."isPOST";
			$card_serialnum = "UNCHECK";
 
			//-- INSERT  
			$q = " INSERT INTO `tfc_trx` (
				`id`, `transaction_type`, `transaction_id`, `transaction_date`, 
				`card_number`, `card_serialnumber`, `member_credit`, 
				`merchant_id`, `merchant_product`, `string_request`, `status_id`) 
				VALUES (
				NULL, '".$transaction_type."', '".$transaction_id."', '".date('Y-m-d H:i:s')."', 
				'".$card_number."', '".$card_serialnum."', '', 
				'".$merchant_id."', '', '".$string_request."', '1')"; 
				
			// $this->db->query($q); 
 			
			//----------------------------------------------------------------------------- 
			$ECHO .= "<br>";
			
			//-- VALIDATE MEMBER -> get Member Data
			$ECHO .= '<br>VALIDATE MEMBER:';
			
			$TFCStatus = 'NOTVALID';
			
			$q1 = "SELECT ID as MemberID, FullName, TFCNumber, TFCSerialNumber, TFCStatus, TFCNoPolisi, TFCValidDateBegin, TFCValidDateEnd 
				  FROM member_table Where TFCNumber = '".$card_number."' limit 1"; //and TFCSerialNumber = '".$card_serialnum."' 
 
			$qData1 =  $this->db->query($q1);
 
			if($qData1->num_rows()){  
				foreach($qData1->result_array() as $row1){   
					foreach($row1 as $key => $value1) {
						$ECHO .= "<br>$key => $value1";
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
					$ECHO .= "<br>TFCStatus => $TFCStatus";
				}
 			}
			//-- MEMBER STATUS 
			$ECHO .= "<br>";
			$ECHO .= "member_exist => $member_exist";
			$ECHO .= "<br>";
			$ECHO .= "member_expired => $member_expired" ;


			//--- RESPONSE => if member not valid
			
			if( $TFCStatus != "VALID" ) {
			
				 $res['VALIDATE_RESULT'] = "TRANSACTION DENIED";
				 $res['VALIDATE_TEXT']   = "SORRY, CARD-ID: <strong>$MemberID</strong> IS NOT-VALID OR EXPIRED";
				 $res['VALIDATE_ERROR']  = "MEMBER-STATUS : ".$TFCStatus.". ";
				 
				 
				 $ECHO .= "<br>";
				 //$ECHO .= $this->response_result($res);
			
				 $ECHO .= "VALIDATE_RESULT => TRANSACTION DENIED";
				 $ECHO .= "<br>";
				 $ECHO .= "VALIDATE_TEXT => SORRY, CARD-ID: <strong>$TFCNumber</strong> IS NOT-VALID OR EXPIRED";
				 $ECHO .= "<br>";
				 $ECHO .= "VALIDATE_ERROR => MEMBER-STATUS : ".$TFCStatus."";
				 //exit;
			}
 			//exit;
			//----------------------------------------------------------------------------- 
			$ECHO .= "<br>";
			
			
			//-- VALIDATE MERCHANT
			$ECHO .= '<br>VALIDATE MERCHANT:';
			
			$q2 = "SELECT ID as MerchantID, TFCMerchantID, TFCMerchantName, TFCMerchantStatus, 
					TFCMerchantValidDateBegin, TFCMerchantValidDateEnd, TFCMerchantLogo, TFCMerchantAddress 
				   	FROM merchant_table Where TFCMerchantID = '".$merchant_id."' limit 1"; 
			
			$qData2 =  $this->db->query($q2);
			 		
			if($qData2->num_rows()){  
				foreach($qData2->result_array() as $row2){   
					foreach($row2 as $key2 => $value2) {
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
						elseif($key2=="TFCMerchantLogo"){
	// 						echo "<br>TFCMerchantValidDateEnd => $value2";
							$value2 = str_replace("./upload","/upload",$hostname.$value2);
							$data['TFCMerchantLogo'] = $TFCMerchantLogo = $value2;
						}
						else{
	// 						echo "<br>$key2 => $value2";
							$$key2 = $value2;
							$data[$key2] = $value2; 
						}
						
						$ECHO .= "<br>$key2 => $value2";
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
				$ECHO .= "<br>TFCMerchantStatus => $TFCMerchantStatus";
			}
 
			//-- MERCHANT STATUS 
			$ECHO .= "<br>";
			$ECHO .= "merchant_exist => $merchant_exist";
			$ECHO .= "<br>";
			$ECHO .= "merchant_expired => $merchant_expired" ;


			//--- RESPONSE => if member/merchant not valid
 
			if( $TFCMerchantStatus != "VALID" ) {
				 $res['VALIDATE_RESULT'] = "TRANSACTION DENIED";
				 $res['VALIDATE_TEXT']   = "SORRY, MERCHANT IS NOT-VALID OR EXPIRED";
				 $res['VALIDATE_ERROR']  = "MERCHANT-STATUS : ".$TFCMerchantStatus.". ";
				 
				 $ECHO .= "<br>";
				 //$ECHO .= $this->response_result($res);
			
				 $ECHO .= "MERCHANT_VALIDATE_RESULT => TRANSACTION DENIED";
				 $ECHO .= "<br>";
				 $ECHO .= "MERCHANT_VALIDATE_TEXT => SORRY, MERCHANT ID: <strong>$TFCMerchantID</strong> IS NOT-VALID OR EXPIRED";
				 $ECHO .= "<br>";
				 $ECHO .= "MERCHANT_VALIDATE_ERROR => MERCHANT-STATUS : ".$TFCMerchantStatus."";
				 
				 //exit;
				 
				 
				 
				 
			} else {
			
				 //$res['VALIDATE_RESULT'] = "VALIDATION SUCCESS";
				 //$res['VALIDATE_TEXT']   = "MERCHANT-STATUS : VALID , MERCHANT-STATUS : VALID";
				// $res['VALIDATE_ERROR']  = "NONE";
				 
				 //echo "<br>";
				 ///$this->response_result($res);
			
			}
 

 			//exit;
			//----------------------------------------------------------------------------- 
			$ECHO .= "<br>";
			
			
			
			
			
			
			//-- PRODUCT MERCHANT
			$ECHO .= '<br>PRODUCT MERCHANT:';
			 
			
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
					$ECHO .= "<br>item_$key3 => $value3";  
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
						merchant_id 		= '".$merchant_id."' and 
						merchant_product	= '".$merchant_product."' and 
						status_id 			= 1 and 
						transaction_date >= '".$trxdate1."' And transaction_date <= '".$trxdate2."' 
						Order By transaction_date Desc";
						//card_serialnumber 	= '".$card_serialnum."' and 
 
				$qData4 =  $this->db->query($q4); 
					
				$usedValue = $qData4->num_rows();	
 
				$ECHO .= "<br>item_trx_value_max => ".$maxValue;
				$ECHO .= "<br>item_trx_value_used => ".$usedValue; 
				
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
				$ECHO .= "<br>item_trx_last_date => $last_trx";
 				 
				$ECHO .= "<br>item_trx_allowed => ".$trxAccept;  
				$ECHO .= "<br>item_trx_value_credit => ".( $maxValue - $usedValue); 
				$ECHO .= "<br>item_trx_value_now => ".$trxNow; 
				
				if($item[$kkk]['merchant_type']==2) 
				$ECHO .= "<br>item_trx_is_diskon => 1"; 
				
				
				
				
 
 
 				$message = "Sorry, Your credit is 0 for this $strPeriode. Available credit is $maxValue"."/".$strPeriode.". Please use your card next $strPeriode for available new credit(s)";
				
				if($trxAccept=="OK")
 				$message = "You are using $trxNow of $maxValue available credit(s)";
				$ECHO .= "<br>item_trx_message => ".$message; 
 
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
					$url_trx =  $hostname."/query_tap/trx/". 
							"transaction_id=$transaction_id---".
							"card_number=$card_number---".
							"member_credit=$trxNow---".
							"merchant_id=$merchant_id---".
							"merchant_product=$merchant_product";
							//"card_serialnumber=$TFCSerialNumber---".
							
					if($item[$kkk]['merchant_type']==2) {
						$url_trx .=  "---is_diskon=1";	
						$isdiskon = 1;
					} else $isdiskon = 0;
				}	
				$ECHO .= "<br>item_trx_url => $url_trx";	
				
				/*
				if(isset($isdiskon))if($isdiskon){
				
				 
				echo ' 
				<form id="form1" name="form1" method="post" action="">
item_diskon_from Rp. <input type="text" name="diskon_from" id="diskon_from"  size="6" /> -> <input type="submit" name="button" id="button" value="Submit" />
				</form>';	
					 
				}
				*/
				
				if($trxAccept=="OK")
				$ECHO .= '<br><a href="'.$url_trx.'" target="_blank">SUBMIT THIS ITEM</a>';  
				
				 
				 		
				$ECHO .= "<br>";
					
				 
				
			} 
 
		 
			$ECHO .= "<br>";
			$ECHO .= "----------------------------------------------------------------------------------";
			$ECHO .= "<br>";
 

		
		
		}
		
 
		
		
		//$ECHO .= '</pre>';
	
		
		//echo $ECHO;
		
		
		//-- belum kelarrrrr....
		//echo "/query/val/<br>".str_replace("---","<br>",$qstr) ;
		
		$data['response'] = $ECHO;
		//re_direct($str, 'refresh'); 
		$this->load->view('tap_res_1_view',$data); 
	
	}
	
	
 
	//function val_result($str_request='') { 
 
		//$this->load->view('sim2_view',$data); 
	
	//}
	
	 
	
	 
	
	function trx($qString=''){
	
	
		//$hostname = "http://admin.tribunfamilycard.com/query_tap/trx/"; 
		$hostname = "http://localhost/query_tap/trx/"; 
		
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
		
		 
		$ECHO = "<br>transaction_id => $transaction_id"; 
		$ECHO .= "<br>card_number => $card_number"; 
		//echo "<br>card_serialnumber => $card_serialnumber"; 
		$ECHO .= "<br>member_credit => $member_credit"; 
		$ECHO .= "<br>merchant_id => $merchant_id"; 
		$ECHO .= "<br>merchant_product  => $merchant_product"; 
	 	
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
			 
			//if( $this->db->query($q2) )
			 $qInsert = 1 ;
			//else $qInsert = 2 ;
			
		} else $qInsert = 3; 
		 
		if(isset($is_diskon)&&isset($diskon_from)&&isset($diskon_value)&&isset($diskon_amount)){ 
			//exit;
		}
		
		if($qInsert=='1'){ 
 			$ECHO .= "<br>trx_result => SUCCESS. Thank You for using Tribun Family Card.";
			//$data['trx_result'] = "SUCCESS. Thank You for using Tribun Family Card.";
		}
		if($qInsert=='2'){ 
 			$ECHO .= "<br>trx_result => TRANSACTION FAILED. Error submited this transaction to server, please try again or contact our TFC Customer Service.";
			//$data['trx_result'] = "TRANSACTION FAILED. Error submited this transaction to server, please try again or contact our TFC Customer Service.";
		}
		if($qInsert=='3'){ 
 			$ECHO .= "<br>trx_result => This Transaction already exist, do not re-submit this item or please try again."; 
		} 
		
	
		
		$data['response'] = $ECHO;
		//re_direct($str, 'refresh'); 
		$this->load->view('tap_res_2_view',$data); 
	
	
	
	}
 /*
	function response_result($res=''){

		if(is_array($res))
		if(count($res)>0)
		foreach($res as $key => $value)
		echo "<br>$key => $value";
		  
	}
*/	
	
	
}
