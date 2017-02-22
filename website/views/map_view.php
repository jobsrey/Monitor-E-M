<? require_once('include/top_map.php'); ?>

<style>
#map_canvas {
    width: 100%;
    height: 500px; 
    background-color: #CCC; 
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px; 
	border:1px solid #666;
	margin-bottom:1em;
	box-shadow: 0px 0px 5px #666;

}
#infotable {
	
	box-shadow: 0px 0px 5px #666;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px; 
	border:1px solid #666;

}
.boxtopinfo{
	float:left;
	width:200px;
	padding:10px;
	margin: 0 20px;
	font-size:14px;  
	color:#FFFFFF;
	background-color: #1C68AF; 
	box-shadow: 0px 0px 5px #888;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;  
    overflow: hidden; 
	text-align:left;
}

.boxtopinfo-lbl{
	font: normal 12px arial; 
	text-shadow: 1px 1px 1px #666;
	border:0px solid red;
	display:inline-block; 
	position: absolute; 
	z-index:2; color:#FFCC00     
}

.boxtopinfo-res{
	border:0px solid red;
	display:inline-block;
	float:right;
	padding-top:15px;
	font: normal 20px arial; 
	z-index:1;   
}

.boxtopinfo-lbl2{
	font: normal 12px arial; 
	text-shadow: 1px 1px 1px #666;
	border:0px solid red;
	display:block;  
	color:#FFCC00;  
	padding-bottom:3px;   
}

.boxtopinfo-tbl td{
	font: normal 12px verdana;
	color:#FFFFFF;


}

.boxtopinfo3{
	float:left;
	xwidth:200px;
	padding:10px;
	margin: 0 20px;
	font-size:14px;  
	color:#FFFFFF;
	background-color: #1C68AF; 
	box-shadow: 0px 0px 5px #888;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;  
    overflow: hidden; 
	text-align:left;
}
.boxtopinfo-lbl3, .boxtopinfo-lbl3 a{
	font: normal 12px arial; 
	text-shadow: 1px 1px 1px #666;
	border:0px solid red;
	display:block;  
	color::#FFCC00;  
	padding-bottom:3px;   
}

#xrCont{ visibility:hidden; position:absolute; z-index:3;  }
a.pintxt{ color:#FFFFFF;}

#tabelinfo td {
	font: normal 12px arial; 
	padding:3px 2px;
}
 	
.style1 {color: #FF9900}
</style>
 

<div id="contMenu" align="left">
  

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
<script type="text/javascript" src="/infobox.js"></script>
<script type="text/javascript">
function initialize() {
    var secheltLoc = new google.maps.LatLng(-6.2682374,106.8507639),
         markers,
            myMapOptions = {
				zoom: 11
				,center: secheltLoc
				,mapTypeId: google.maps.MapTypeId.ROADMAP  
				,mapTypeControl: false
        	},
        map = new google.maps.Map(document.getElementById("map_canvas"), myMapOptions);

    function initMarkers(map, markerData) {
        var newMarkers = [],
            marker;

        for(var i=0; i<markerData.length; i++) {
            marker = new google.maps.Marker({
                map: map,
                draggable: true,
                position: markerData[i].latLng,
                visible: true
            }),
            boxText = document.createElement("div"),
            //these are the options for all infoboxes
            infoboxOptions = {
                content: boxText,
                disableAutoPan: false,
                maxWidth: 0,
                pixelOffset: new google.maps.Size(-10, 0),
                zIndex: null,
                boxStyle: {
                    background: "url('/tipbox.gif') -130px 0px no-repeat", 
                    opacity: 0.8 
                },
                closeBoxMargin: "8px 0px 2px -15px",
                closeBoxURL: "/close.gif",
                infoBoxClearance: new google.maps.Size(1, 1),
                isHidden: false,
                pane: "floatPane",
                enableEventPropagation: false
            };

            newMarkers.push(marker);
            //define the text and style for all infoboxes
            boxText.style.cssText = " display: inline-block; border: 1px solid #666; margin-top: 8px; background:"+markerData[i].bg+"; color:#FFF; font-family:Arial; font-size:13px; padding: 3px 20px 3px 5px; border-radius:7px; -webkit-border-radius:7px; -moz-border-radius:7px;";
            boxText.innerHTML = markerData[i].address + "<br>" + markerData[i].state;
            //Define the infobox
            newMarkers[i].infobox = new InfoBox(infoboxOptions);
            //Open box when page is loaded
            newMarkers[i].infobox.open(map, marker);
            //Add event listen, so infobox for marker is opened when user clicks on it.  Notice the return inside the anonymous function - this creates
            //a closure, thereby saving the state of the loop variable i for the new marker.  If we did not return the value from the inner function, 
            //the variable i in the anonymous function would always refer to the last i used, i.e., the last infobox. This pattern (or something that
            //serves the same purpose) is often needed when setting function callbacks inside a for-loop.
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    newMarkers[i].infobox.open(map, this);
                    map.panTo(markerData[i].latLng);
                }
            })(marker, i));
        }

        return newMarkers;
    }

    //here the call to initMarkers() is made with the necessary data for each marker.  All markers are then returned as an array into the markers variable
    markers = initMarkers(map, [
<?php 
	$str = "";
	foreach($arrStatus  as $k => $row){  
 		if($arrStatus[$k]['status_ping']=='00') $strClr = "green";
 		if($arrStatus[$k]['status_ping']=='FF') $strClr = "red";  
		$str .= "{ latLng: new google.maps.LatLng(".$arrTerminal[$k]['googlemapcoordinate']."),  address: \"<a href='javascript:void(0);javascript:showinfomap(".$arrTerminal[$k]['ID'].")' class='pintxt'>".$arrTerminal[$k]['googlemappinlabel']."</a>\", state:\"\", bg: \"".$strClr."\" },"; 
	}	
	echo substr($str,0,strlen($str)-1); 
 ?> 
        //{ latLng: new google.maps.LatLng(-6.248697,106.7928331),  address: "<a href='javascript:void(0);javascript:showinfomap(1)' class='pintxt'>Lunari Dev</a>",    state:"", bg: "red" }, 
        //{ latLng: new google.maps.LatLng(-6.2244983,106.8140951), address: "<a href='javascript:void(0);javascript:showinfomap(2)' class='pintxt'>Plasa Mandiri</a>", state:"", bg: "green" }
    	
	]);
	
} 
function showinfomap(id){
	document.getElementById("rCont").style.visibility = "visible";
	document.getElementById("rCont").style.position = "relative";
	getboxinfo(id);
} 
function infoclose(){
	document.getElementById("rCont").style.visibility = "hidden";
	document.getElementById("rCont").style.position = "absolute";

}

function getboxinfo(id){
	//var boxinfo = '<?php echo base_url()."map/tabelinfo/"; ?>'+id;
	//$('#boxinfo').load(boxinfo);  
}

</script>
<? /*
	foreach($arrStatus  as $k => $row){  
 		if($arrStatus[$k]['status_ping']=='00') $strClr = "green";
 		if($arrStatus[$k]['status_ping']=='FF') $strClr = "red"; 
		echo "<br>(".$arrTerminal[$k]['googlemapcoordinate'].")  javascript:showinfomap(".$arrTerminal[$k]['ID'].")  class='pintxt'>".$arrTerminal[$k]['googlemappinlabel']."</a> bg: ".$strClr;
	}	
	*/ 
 ?>   
    <div style="border:0px solid red;width:97%;display:inline-block;padding-top:20px"  align="center">
    <div style="border:0px solid green;display:inline-block;"> 
    
    	 
    		<div class="boxtopinfo"> 
            	<div class="boxtopinfo-lbl2">Terminal Status</div>  
                <div class="boxtopinfo-tbl">
                	<table border="0" cellpadding="1" cellspacing="0">
                      <tr>
                        <td>ONLINE</td>
                        <td> : <?=$totOnline;?></td> 
                      </tr>
                      <tr>
                        <td>OFFLINE</td>
                        <td> : <?=$totOffline;?></td> 
                      </tr>
                      <tr>
                        <td>Total Terminal&nbsp;</td>
                        <td> : <?=$totTerminal;?></td> 
                      </tr>
                    </table> 
              </div> 
            </div>
            
    		<div class="boxtopinfo"> 
            	<div class="boxtopinfo-lbl2">Transaksi Kartu</div>  
                <div class="boxtopinfo-tbl">
                	<table border="0" cellpadding="1" cellspacing="0">
                      <tr>
                        <td>Nilai Trx</td>
                        <td> : Rp. <?=number_format($TotarrCardTot,0,",",".");?>,-</td> 
                      </tr>
                      <tr>
                        <td>Kartu-Keluar</td>
                        <td> : <?=$TotarrCardTrx;?></td> 
                      </tr>
                      <tr>
                        <td>Sisa-Kartu</td>
                        <td> : <?=$TotarrTotalCard-$TotarrCardTrx;?> </td> 
                      </tr>
                    </table> 
              </div> 
            </div>  
    		<div class="boxtopinfo">
           	  <div class="boxtopinfo-lbl2">Transaksi Top-Up</div>  
                 <div class="boxtopinfo-tbl">
                	<table border="0" cellpadding="1" cellspacing="0">
                      <tr>
                        <td>Nilai Trx</td>
                        <td> : Rp. <?=number_format($TotarrTUAllTot,0,",",".");?>,-</td> 
                      </tr>
                      <tr>
                        <td>Jumlah Trx&nbsp;</td>
                        <td> : <?=$TotarrTUPTrx;?> </td> 
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td> 
                      </tr>
                    </table> 
              </div>   
            </div>
            <div class="boxtopinfo3">
           	  <div class="boxtopinfo-lbl3"><a href="/reporting/summary_transaction" style="color:#FFCC00">WEB-ADMIN</a></div>   
      </div>
    	<div style=" clear:both"></div>
        
 	</div>
 	</div> 
	
 
    <div style="padding-top:20px;"></div> 
    
    <div style="border:0px solid red;width:100%;display:inline-block;" align="center">
    <div style="border:0px solid green;display:inline-block;"> 
	 	<table width="100%"  border="0" cellpadding="0" cellspacing="0">
		  <tr>
          <? /*
			<td valign="top" nowrap>
				<div style="border:0px solid red;xdisplay:inline-block;xfloat:left;">
            	<div id="map_canvas"></div>
        		</div>
			</td>
			*/ ?>
			<td valign="top" nowrap>
			<div id="rCont" style="border:0px solid red; display:inline-block;float:left;padding:0 0 0 0">  
			<div id="tabelinfo" >  
                 <table id="infotable" border="0" cellspacing="1" bgcolor="#999999">
                  <tr>
                    <td colspan="23" bgcolor="#009966"><span style="float:left"><strong>Last Update : 09:00 am</strong></span><span style="float:right"><a href="javascript:void(0);javascript:infoclose()"><img src="/close.gif" alt="close" border="0" /></a></span></td>
                   </tr>
                  <tr align="center" valign="bottom" bgcolor="#CCCCCC">
                    <td  rowspan="2" bgcolor="#cccccc">No</td>
                    <td  rowspan="2" bgcolor="#cccccc">
                    ID-VM <br>
                    Lokasi</td> 
                    <td  rowspan="2" bgcolor="#cccccc">Terminal<br>
                    ID </td>
                    <td colspan="5" bgcolor="#EEFFB3">KA 1 - Topup</td>
                    <td colspan="5" bgcolor="#B3FFB3">KA 2 - Topup</td>
                    <td  rowspan="2" bgcolor="#cccccc"><br>
                    Topup<br>
                    Trx</td>
                    <td  rowspan="2" bgcolor="#FFD7D7">Card<br>
                    In</td>
                    <td  rowspan="2" bgcolor="#FFD7D7">Card<br>
                    Out</td>
                    <td  rowspan="2" bgcolor="#FFD7D7">Sisa<br>
                    Kartu</td>
                    <td  rowspan="2" bgcolor="#cccccc"><br>
                    Total<br>
                    Trx</td>
                    <td  rowspan="2" bgcolor="#cccccc"><br>
                      Total Nilai<br>
                    Transaksi</td>
                    <td colspan="3" bgcolor="#C6E8FF">Device Status </td>
                    <td  rowspan="2" bgcolor="#cccccc">Status<br>
                    VM<strong></strong></td>
                   </tr>
				  
                  <tr>
                    <td align="center" bgcolor="#EEFFB3" >Status</td>
                    <td align="center" bgcolor="#EEFFB3" >Limit</td>
                    <td align="center" bgcolor="#EEFFB3" >Trx</td>
                    <td align="center" bgcolor="#EEFFB3" >Balance</td>
                    <td align="center" bgcolor="#EEFFB3" >Last
                    Trx</td>
                    <td align="center" bgcolor="#B3FFB3" >Status</td>
                    <td align="center" bgcolor="#B3FFB3" >Limit</td>
                    <td align="center" bgcolor="#B3FFB3" >Trx</td>
                    <td align="center" bgcolor="#B3FFB3" >Balance</td>
                    <td align="center" bgcolor="#B3FFB3" >Last
                    Trx</td> 
                    <td align="center" bgcolor="#C6E8FF" >PR</td>
                    <td align="center" bgcolor="#C6E8FF" >BA</td>
                    <td align="center" bgcolor="#C6E8FF" >CD</td>
                   </tr>
				    <? /*
                  <tr>
                    <td align="center" bgcolor="#efefef">1.</td>
                    <td align="center" nowrap  bgcolor="#efefef"><div align="center">210-00-000-0-111 <br>
                    Plaza Mandiri </div></td> 
                    <td align="center"  bgcolor="#efefef">78907890</td>
                    <td align="center"  bgcolor="#F8FFDF">5.000.000</td>
                    <td align="center"  bgcolor="#F8FFDF">5</td>
                    <td align="center"  bgcolor="#F8FFDF">4.750.000</td>
                    <td align="center"  bgcolor="#F8FFDF">10/28/2015<br> 
                    10:32:10</td>
                    <td align="center"  bgcolor="#F8FFDF">Active</td>
                    <td align="center"  bgcolor="#D9FFD9">5.000.000</td>
                    <td align="center"  bgcolor="#D9FFD9">5</td>
                    <td align="center"  bgcolor="#D9FFD9">4.750.000</td>
                    <td align="center"  bgcolor="#D9FFD9">10/28/2015<br>
  10:32:10</td>
                    <td align="center"  bgcolor="#D9FFD9">Active</td>
                    <td align="center"  bgcolor="#E8F5FF">OK</td>
                    <td align="center"  bgcolor="#E8F5FF">OK</td>
                    <td align="center"  bgcolor="#E8F5FF">OK</td>
                    <td align="center"  bgcolor="#E8F5FF">OK</td>
                    <td align="center"  bgcolor="#FFF0F8">30</td>
                    <td align="center"  bgcolor="#FFF0F8">30</td>
                    <td align="center"  bgcolor="#FFF0F8">0</td>
                    <td align="center"  bgcolor="#FFF0F8">20</td>
                    <td align="center"  bgcolor="#FFF0F8">1.500.000</td>
                    <td align="center"  bgcolor="green"><span style="color:white">Online</span></td>
                   </tr>
				   */ ?>
				   <? $n = 1; 

				   foreach($arrTabelInfo as $key => $row){
				   	  $ka_slot 		= 0;
				   	  $ka_balance 	= 0;
				   	  $limitKA1 	= "";
				   	  $limitKA2 	= "";
					  $statusKA1	= "";
					  $statusKA2	= "";
					  $tupTrxKA1 = $tupTrxKA2 = "";
					  $balTrxKA1 = $balTrxKA2 = ""; 
					  $lstTrxKA1 = $lstTrxKA2 = ""; 
					  $sisakartu 	= 0;	
					  
					  	if(!isset($arrTotalCard[$key])) $arrTotalCard[$key] = 0;
					 	 if(!isset($arrCardTrx[$key])) $arrCardTrx[$key] = 0; 
					  
					  			   
				   		//echo "<br>$key => $row";
				   
				   		//if( isset($arrTotalCard[$key]) && isset($arrCardTrx[$key]) )
				   		$sisakartu = $arrTotalCard[$key]-$arrCardTrx[$key]; 
						
						
						//if($key=="210-00-000-0-DEV") $limitKA = 0;
						//-- get limitKA
						$q = "Select * From topup_mandiri_balance Where terminal_id = '".$key."' and TID = '".$row['TID']."' order by ka_date desc limit 1";
						
						//echo $q."<br>"; continue;
						$qdata = $this->db->query($q); 
						if($qdata->num_rows()){
							$arrResult = $qdata->result_array(); 
							$terminal_id = $arrResult[0]['terminal_id']; 
							$ka_slot 	= $arrResult[0]['ka_slot']; 
							$ka_balance = $arrResult[0]['ka_balance']; 
						} 
						
						
						//if($key=="210-00-000-0-DEV") $strLstTx = "00-00-0000<br>00:00";
						//else { 
							$q = "Select `date` from topup_mandiri where terminal_id = '".$key."' order by `date` desc limit 1";
							$qData = $this->db->query($q);  
							$result = $qData->result_array(); 
							$strLstTx = "";
							if($qData->num_rows()) 
							foreach($result as $k => $rowdate){ 
							//foreach($row as $kk => $val){
								//echo "<br>$k => $kk => $val";
								$strLstTx = str_replace(" ","<br>",$rowdate['date']);
							
							} 
					
						//}
					
						 
						if($ka_slot==1){
							$limitKA1 =number_format( $ka_balance,0,",",".");
							$statusKA1 = "active";  
							$tupTrxKA1 = $arrTUPTrx[$key];
							$balTrxKA1 = number_format($ka_balance-$arrTUAllTot[$key],0,",",".");
							$lstTrxKA1 = $strLstTx;
						}
						 
						elseif($ka_slot==2){
							$limitKA2 = number_format($ka_balance,0,",",".");
							$statusKA2 = "active"; 
							$tupTrxKA2 = $arrTUPTrx[$key];
							$balTrxKA2 = number_format($ka_balance-$arrTUAllTot[$key],0,",",".");
							$lstTrxKA2 = $strLstTx;
						
						
						} 
						?>
                  <tr>
                    <td align="center" bgcolor="#efefef"><?=$n?>.</td>
                    <td align="center" bgcolor="#efefef"><?=$key?><br><?=$row['name'];?></td> 
                    <td align="center" bgcolor="#efefef"><?=$row['TID'];?></td>
                    
                    <td align="center"  bgcolor="#F8FFDF"><?=$statusKA1;?></td>
                    <td align="center"  bgcolor="#F8FFDF"><?=$limitKA1;?></td>
                    <td align="center"  bgcolor="#F8FFDF"><?=$tupTrxKA1;?></td>
                    <td align="center"  bgcolor="#F8FFDF"><?=$balTrxKA1;?></td>
                    <td align="center"  bgcolor="#F8FFDF"><?=$lstTrxKA1?></td>
                    
                    <td align="center"  bgcolor="#D9FFD9"><?=$statusKA2;?></td>
                    <td align="center"  bgcolor="#D9FFD9"><?=$limitKA2;?></td>
                    <td align="center"  bgcolor="#D9FFD9"><?=$tupTrxKA2;?></td>
                    <td align="center"  bgcolor="#D9FFD9"><?=$balTrxKA2;?></td>
                    <td align="center"  bgcolor="#D9FFD9"><?=$lstTrxKA2?></td> 
                    <? 
					//if($key=="210-00-000-0-DEV") echo "none";
					//else echo "active";  
					
					if(!isset($row['prn'])) $row['prn'] = "";
					if(!isset($row['ba']))  $row['ba']  = "";
					if(!isset($row['cd1'])) $row['cd1'] = "";
					 
					
					?>
                    <td align="center"  bgcolor="#FFF0F8"><?=$tupTrxKA1+$tupTrxKA2;?></td>
                    <td align="center"  bgcolor="#FFF0F8"><?=$arrTotalCard[$key]?></td>
                    <td align="center"  bgcolor="#FFF0F8"><?=$arrCardTrx[$key]?></td>
					
                    <td align="center"  bgcolor="<? if($sisakartu<=5) echo "#FFFF00"; else echo "#FFF0F8";?>"><?=$sisakartu?></td>
                    <td align="center"  bgcolor="#efefef"><?=$arrTUPTrx[$key]+$arrCardTrx[$key]?></td>
                    <td align="right"  bgcolor="#efefef"><?=number_format($arrTUAllTot[$key]+$arrCardTot[$key],0,",",".");?></td>
                    <? 
						if(!isset($row['ping'])) $row['ping'] = '00';
						
						$curPRN 	= $this->func_v2->getColChkDev($row['prn']);
						$curBA 		= $this->func_v2->getColChkDev($row['ba']);
						$curCD1 	= $this->func_v2->getColChkDev($row['cd1']);
						$curPING 	= $this->func_v2->getColChkDev($row['ping']);
						
						if(isset($curPRN['colorbg']))  $strPrnBG  = ' bgcolor="'.$curPRN['colorbg'].'"'; 		else $strPrnBG = '';
						if(isset($curPRN['colortxt'])) $strPrnTxt = ' style="color:'.$curPRN['colortxt'].'"'; 	else $strPrnTxt = '';
						
						if(isset($curBA['colorbg']))  $strBaBG    = ' bgcolor="'.$curBA['colorbg'].'"'; 		else $strBaBG = '';
						if(isset($curBA['colortxt'])) $strBaTxt   = ' style="color:'.$curBA['colortxt'].'"'; 	else $strBaTxt = '';
						
						if(isset($curCD1['colorbg']))  $strCd1BG  = ' bgcolor="'.$curCD1['colorbg'].'"'; 		else $strCd1BG = '';
						if(isset($curCD1['colortxt'])) $strCd1Txt = ' style="color:'.$curCD1['colortxt'].'"'; 	else $strCd1Txt = '';
						
						if(isset($curPING['colorbg']))  $strPingBG    = ' bgcolor="'.$curPING['colorbg'].'"'; 		else $strPingBG = '';
						if(isset($curPING['colortxt'])) $strPingTxt   = ' style="color:'.$curPING['colortxt'].'"'; 	else $strPingTxt = '';
					 
					//echo "#FF6600"; else echo "#E8F5FF";
					?> 
                    
                    <td align="center" <?=$strPrnBG;?>><span <?=$strPrnTxt;?>><?=$row['prn'];?></span></td>
                    <td align="center" <?=$strBaBG;?>><span <?=$strBaTxt;?>><?=$row['ba'];?></span></td> 
                    <td align="center" <?=$strCd1BG;?>><span <?=$strCd1Txt;?>><?=$row['cd1'];?></span></td> 
                    <td align="center" <?=$strPingBG;?>><span <?=$strPingTxt;?>><? if($row['ping']=="00") echo "&nbsp;Online&nbsp;"; else echo "&nbsp;Offline&nbsp;";?></span></td>
                   </tr>
                   <? $n++; 
				   } ?>
                  <tr>
                    <td  bgcolor="#ccc">&nbsp; </td>
                    <td  bgcolor="#ccc">&nbsp;</td> 
                    <td  bgcolor="#ccc">&nbsp;</td>
                    <td  bgcolor="#ccc">&nbsp;</td>
                    <td  bgcolor="#ccc">&nbsp;</td>
                    <td  bgcolor="#ccc">&nbsp;</td>
                    <td  bgcolor="#ccc">&nbsp;</td>
                    <td  bgcolor="#ccc">&nbsp;</td>
                    <td  bgcolor="#ccc">&nbsp;</td>
                    <td  bgcolor="#ccc">&nbsp;</td>
                    <td  bgcolor="#ccc">&nbsp;</td>
                    <td  bgcolor="#ccc">&nbsp;</td>
                    <td  bgcolor="#ccc">&nbsp;</td> 
                    <td  bgcolor="#ccc">&nbsp;</td> 
                    <td  bgcolor="#ccc">&nbsp;</td>
                    <td  bgcolor="#ccc">&nbsp;</td>
                    <td  bgcolor="#ccc">&nbsp;</td>
                    <td  bgcolor="#ccc">&nbsp;</td>
                    <td  bgcolor="#ccc">&nbsp;</td>
                    <td  bgcolor="#ccc">&nbsp;</td>
                    <td  bgcolor="#ccc">&nbsp;</td>
                    <td  bgcolor="#ccc">&nbsp;</td>
                    <td  bgcolor="#ccc">&nbsp;</td>
                   </tr>
                  <tr>
                    <td colspan="23" bgcolor="#CC9900">&nbsp; </td>
                   </tr>
                </table> 
				 
	   			<div style="padding-bottom:40px"></div>  
      		  </div> 
   	  		</div>
      		</td>
		  </tr>
	  </table>

       
      <table width="100%"  border="0" cellpadding="0" cellspacing="0">
		  <tr>
          <? /**/ ?> 
			<td valign="top" nowrap>
				<div style="border:0px solid red;xdisplay:inline-block;xfloat:left;">
            	<div id="map_canvas"></div>
        		</div>
			</td>
			 
		  </tr>
	  </table>  
	 
	   <div style="padding-bottom:30px"></div>  
      
	</div>
	</div>
 

</div> 
<script>
 
</script>
<? require_once('include/bottom.php'); ?>