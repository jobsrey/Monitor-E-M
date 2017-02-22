<? require_once('include/top.php'); ?>
<script type="text/javascript" language="javascript"> 

var ipsrv = "<?=server_ip();?>"; 
var clss = "<? echo "update_".$clss;?>"; 
var tip = "<?=$IP;?>";
var tid = "<?=$terminal_id;?>"; 

function vmping(msg){    
	var ipvm = 0;  
	var type = 'vmtools';
	var trxid = '';
	var xdata = '';
	url='http://'+ipsrv +'/request/vmping/0/'+type+'/'+ipvm+'/'+msg+'/'+trxid+'/'+xdata;	
	//alert(url);
	openCenteredWindow(url); 
	return false; 
}
function vmtools(msg){ 
	var ipvm = document.getElementById("vm").value;  
	var type = 'vmtools';
	var trxid = '';
	var xdata = ''; 
	url='http://'+ipsrv +'/request/vmtools/0/'+type+'/'+ipvm+'/'+msg+'/'+trxid+'/'+xdata;	 
	//alert(url);  
	openCenteredWindow(url); 
	return false; 
}  
function sendfiletovm(id,type){    
	url = 'http://'+ipsrv +'/terminal_tools/sendmedia/'+id+'/'+type+'/'+tip+'/'+tid;	 
	//alert(url);
	window.location.assign(url); 
	return false; 
}    
function sendfile(fn,type){    
	//str = fixedEncodeURIComponent(fn)
	var t = type;
	str = fn;
	str = str.replace(":", "yyyyy"); 	//==     : 
	str = str.replace(/\\/g, "xxxxx");  //--     \ 
	str = str.replace(" ", "zzzzz");     
	url = 'http://'+ipsrv +'/kirim/fname/'+str+'/'+t;	 
	//alert(url);
	window.location.assign(url); 
	return false; 
}  

function fixedEncodeURIComponent(str){
     return encodeURIComponent(str).replace(/[!'()]/g, escape).replace(/\*/g, "%2A");
}


function slcvm($tid){ 
	//var url = '/terminal_tools/'+clss+'/'+$tid;
	var url = '/terminal_tools/'+clss+'/'+$tid;
	//alert(url);
	window.location.assign(url); 
	
}
function slcvmjs(){
	var varvm =  document.getElementById('vm').value;
	document.getElementById('strvmslc').value = varvm; 
}
 
function openCenteredWindow(url) {
    var width = 670;
    var height = 280;
    var left = parseInt((screen.availWidth/2) - (width/2));
    var top = parseInt((screen.availHeight/2) - (height/2));
    var windowFeatures = "fullscreen=no,titlebar=no,toolbar=no,scrollbars=yes,location=no,resizable,width=" + width + ",height=" + height + ",left=" + left + ",top=" + top + "screenX=" + left + ",screenY=" + top;
    myWindow = window.open(url, "subWind", windowFeatures);
	return false; 
} 

function getTrxid() {
	var d = new Date();  
    var dateString = d.format("yymmddHHMMss");

	document.getElementById("trxid").value = dateString;
}


//:ajax  
function ajaxurl(url,id,id2,divload){ 
	var dload = document.getElementById(divload); 
	dload.style.display = "block";  
	var varURL=url;
	if(url!=""){
		var xmlHttp;
		try { xmlHttp=new XMLHttpRequest();  } 	// Firefox, Opera 8.0+, Safari 
		catch (e){  							// Internet Explorer  
			try { xmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); }
			catch (e){    
				try { xmlHttp=new ActiveXObject("Microsoft.XMLHTTP"); }
				catch (e){ alert("Your browser does not support AJAX!"); return false; }    
			}  
		}
		xmlHttp.onreadystatechange=function() {
			if(xmlHttp.readyState==4) { 
				res = xmlHttp.responseText; 
				document.getElementById(id).value=res; 
				document.getElementById(id2).innerHTML=res; 
				dload.style.display = "none";  
			} 
		}
		xmlHttp.open("GET",varURL,true);
		xmlHttp.send(null);  
	}else{ alert("No URL Found!"); return false; }
}


/*
 * Date Format 1.2.3
 * (c) 2007-2009 Steven Levithan <stevenlevithan.com>
 * MIT license
 *
 * Includes enhancements by Scott Trenda <scott.trenda.net>
 * and Kris Kowal <cixar.com/~kris.kowal/>
 *
 * Accepts a date, a mask, or a date and a mask.
 * Returns a formatted version of the given date.
 * The date defaults to the current date/time.
 * The mask defaults to dateFormat.masks.default.
 */

var dateFormat = function () {
    var token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,
        timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,
        timezoneClip = /[^-+\dA-Z]/g,
        pad = function (val, len) {
            val = String(val);
            len = len || 2;
            while (val.length < len) val = "0" + val;
            return val;
        };

    // Regexes and supporting functions are cached through closure
    return function (date, mask, utc) {
        var dF = dateFormat;

        // You can't provide utc if you skip other args (use the "UTC:" mask prefix)
        if (arguments.length == 1 && Object.prototype.toString.call(date) == "[object String]" && !/\d/.test(date)) {
            mask = date;
            date = undefined;
        }

        // Passing date through Date applies Date.parse, if necessary
        date = date ? new Date(date) : new Date;
        if (isNaN(date)) throw SyntaxError("invalid date");

        mask = String(dF.masks[mask] || mask || dF.masks["default"]);

        // Allow setting the utc argument via the mask
        if (mask.slice(0, 4) == "UTC:") {
            mask = mask.slice(4);
            utc = true;
        }

        var _ = utc ? "getUTC" : "get",
            d = date[_ + "Date"](),
            D = date[_ + "Day"](),
            m = date[_ + "Month"](),
            y = date[_ + "FullYear"](),
            H = date[_ + "Hours"](),
            M = date[_ + "Minutes"](),
            s = date[_ + "Seconds"](),
            L = date[_ + "Milliseconds"](),
            o = utc ? 0 : date.getTimezoneOffset(),
            flags = {
                d:    d,
                dd:   pad(d),
                ddd:  dF.i18n.dayNames[D],
                dddd: dF.i18n.dayNames[D + 7],
                m:    m + 1,
                mm:   pad(m + 1),
                mmm:  dF.i18n.monthNames[m],
                mmmm: dF.i18n.monthNames[m + 12],
                yy:   String(y).slice(2),
                yyyy: y,
                h:    H % 12 || 12,
                hh:   pad(H % 12 || 12),
                H:    H,
                HH:   pad(H),
                M:    M,
                MM:   pad(M),
                s:    s,
                ss:   pad(s),
                l:    pad(L, 3),
                L:    pad(L > 99 ? Math.round(L / 10) : L),
                t:    H < 12 ? "a"  : "p",
                tt:   H < 12 ? "am" : "pm",
                T:    H < 12 ? "A"  : "P",
                TT:   H < 12 ? "AM" : "PM",
                Z:    utc ? "UTC" : (String(date).match(timezone) || [""]).pop().replace(timezoneClip, ""),
                o:    (o > 0 ? "-" : "+") + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4),
                S:    ["th", "st", "nd", "rd"][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10]
            };

        return mask.replace(token, function ($0) {
            return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1);
        });
    };
}();

// Some common format strings
dateFormat.masks = {
    "default":      "ddd mmm dd yyyy HH:MM:ss",
    shortDate:      "m/d/yy",
    mediumDate:     "mmm d, yyyy",
    longDate:       "mmmm d, yyyy",
    fullDate:       "dddd, mmmm d, yyyy",
    shortTime:      "h:MM TT",
    mediumTime:     "h:MM:ss TT",
    longTime:       "h:MM:ss TT Z",
    isoDate:        "yyyy-mm-dd",
    isoTime:        "HH:MM:ss",
    isoDateTime:    "yyyy-mm-dd'T'HH:MM:ss",
    isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
};

// Internationalization strings
dateFormat.i18n = {
    dayNames: [
        "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat",
        "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
    ],
    monthNames: [
        "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
        "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
    ]
};

// For convenience...
Date.prototype.format = function (mask, utc) {
    return dateFormat(this, mask, utc);
};
</script>
<div class="container">

	<div class="lblpage" align="right">
		<div class="float_l tahoma size18"><?=$pageLABEL;?></div>
		<div class="float_r arial12 grey9"> 
		</div> 
	</div> 
	
    <div class="linelbl"></div> 
  	<div id="contMenu"> 
   		<div style="clear:both"></div> 
       
       <table border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td> <input type="button" name="Submit2" onclick="vmping('PING')" value="CHECK ALL TERMINALS" />          <? /*last check 00:00 */ ?></td>
         </tr>
        <tr>
          <td valign="bottom"><br>
            Online Terminal:<br>
			<select name="vm" id="vm" onChange="slcvm($('select#vm').val())" >
           	  <option value="" >Pilih Terminal dibawah ini:</option> 
            	<? if($qTerminal->num_rows()){   
					$x=0;
					foreach($qTerminal->result_array() as $row){ ?>
            	<option value="<?=$row['id']?>" <? if($tid==$row['id']) echo 'selected="selected"';?> > <?=$row['terminal_id']?>  |  <?=$row['terminal_name']?></option>
            	<? 	}
				}
				?>
          </select></td>
         </tr>
      </table> 
      <hr size="1" /> 
	  <div id="dspdata"> 
      	<? if(!empty($tid)){ ?> 
		<table width="200" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td colspan="3"><span class="red" style="font-size:10px">Detail Terminal : </span></td>
        </tr>
        <tr>
          <td><span class="style6">Terminal</span></td>
          <td><span class="style6">:</span></td>
          <td nowrap="nowrap"><strong><?=$terminal_id;?></strong></td>
        </tr>
        <tr>
          <td>Title</td>
          <td>:</td>
          <td nowrap="nowrap"><strong><?=$terminal_name;?></strong></td>
        </tr>
        <tr>
          <td><span class="style6">address</span></td>
          <td><span class="style6">:</span></td>
          <td nowrap="nowrap"><strong><?=$terminal_address;?></strong></td>
        </tr>
        <tr>
          <td><span class="style6">Location</span></td>
          <td><span class="style6">:</span></td>
          <td nowrap="nowrap"><strong><?=$venue;?>, <?=$area;?>, <?=$city;?>, <?=$province;?>, <?=$country;?></strong></td>
        </tr>
        <tr>
          <td><span class="style6">Owner</span></td>
          <td><span class="style6">:</span></td>
          <td nowrap="nowrap"><strong><?=$terminal_owner;?></strong></td>
        </tr>
      </table>
	  <hr size="1" /> 
	  
	  <? if($clss=='remote_command'){ ?>
      <table border="0" cellpadding="5" cellspacing="1">
        <tr>
          <td colspan="5">Update Command </td>
        </tr>
        <tr bgcolor="#CCCCCC">
          <td align="center"><input type="button" name="Submit223" onclick="vmtools('BLOCK')" value="BLOCK" /></td>
          <td align="center"><input type="button" name="Submit2242" onclick="vmtools('UNBLOCK')" value="UNBLOCK" /></td>
          <td bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          <td align="center"><input name="button"  type="button"  style="font-size:18;padding:2px 10px;" onclick="vmtools('RESTART')" value="RESTART" /></td>
          <td align="center"><input type="button" name="Submit222" onclick="vmtools('SHUTDOWN')" value="SHUTDOWN" /></td>
        </tr> 
        <tr>
          <td colspan="5">Check Status Device </td>
        </tr>
        <tr bgcolor="#CCCCCC">
          <td align="center"><input type="button" name="Submit2233" onClick="vmtools('PRINTER')" value="PRINTER" /></td>
          <td align="center"><input type="button" name="Submit2232" onClick="vmtools('BA')" value="BILL ACCEPTOR" /></td>
          <td bgcolor="#FFFFFF">&nbsp;</td>
          <td colspan="2" align="center" nowrap><input type="button" name="Submit2234" onclick="vmtools('CD1')" value="CD 1" />
			&nbsp; <input type="button" name="Submit22342" onclick="vmtools('CD2')" value="CD 2" disabled style="color:#999" />
			&nbsp; <input type="button" name="Submit22343" onclick="vmtools('CD3')" value="CD 3" disabled style="color:#999" />
			&nbsp; <input type="button" name="Submit22344" onclick="vmtools('CD4')" value="CD 4" disabled style="color:#999" /></td>
        </tr>
      </table>
	  <? } elseif($clss=='video') { 
	  
	  	 //foreach($qMedia->result_array() as $row) foreach($row as $k => $v) echo "<br>$k => $v"; 
	  ?>
	  <div style="padding:12px 5px">
      
 
	 
	  Pilih Video file: &nbsp; 
	  <select name="selectmedia" id="selectmedia"> 
        <option value=""  selected="selected" ></option>
         <? $slc_id = 0;
		 	if($qMedia->num_rows()){   
			$x=0;
				foreach($qMedia->result_array() as $row){ 
					$arrFN = explode("/",$row['file']);
					foreach($arrFN as $k => $v) //echo "<br>$k => $v"; 
					$fn = $arrFN[7];  
	 	 ?>
     				<option value="<?=$row['id'];?>/<?=$fn;?>" <? if($video_id==$row['id']) echo 'selected="selected"';?> ><?=$row['title'];?> - [<?=$fn;?>]</option>
          <?
		 		}
			}
		?>
      </select> &nbsp;  &nbsp; 
 
	  <input type="submit" name="Submit" onClick="sendfiletovm($('select#selectmedia').val(),'video')" value="SEND to TERMINAL"> 
	  </div> 
	  

	  <? } elseif($clss=='xupdate_patch') { ?>
	  
	  <div style="padding:12px 5px">
	  Pilih patch file: &nbsp; 
	  <select name="selectfn" id="selectfn"> 
      		<?  if($qTerminal->num_rows()){   
				$x=0;
				foreach($qTerminal->result_array() as $row){ ?>
            <option value="<?=$row['id']?>" <? if($tid==$row['id']) echo 'selected="selected"';?> > <?=$row['vmid']?>  |  <?=$row['name']?></option>
            <? 	
				}
				}
			?>
      </select> &nbsp;  &nbsp; 
	  <input type="submit" name="Submit" value="UPDATE to TERMINAL"> 
	  </div> 
	  
	  <? } ?>
	  
	  <? } else echo "<h3 class='red'>Terminal belum dipilih !<h3>";  ?>
 	  </div> 
	  
      
        
        
       
        <hr size="1" />
       
       
       
       
       
 
	</div> 
</div> 
<? require_once('include/bottom.php'); ?>