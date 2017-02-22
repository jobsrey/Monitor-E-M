<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title><?=$pageTITLE;?></title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
a, a:visited {color: #000000; text-decoration:none}
.style1 {color: #006666}
.style2 {color: #FF6600}
.style3 {
	font-size: 10px;
	font-weight: bold;
}
.style4 {
	color: #666666;
	font-weight: bold;
}
.style6 {color: #666666}
-->
</style>
<script> 

var ipsrv = "25.196.36.42";
 
function vmtools(msg){    
	var ipvm = document.getElementById("vm").value;  
	var type = 'vmtools';
	var trxid = '';
	var xdata = '';
	url='http://'+ipsrv +'/request/vmtools/0/'+type+'/'+ipvm+'/'+msg+'/'+trxid+'/'+xdata;	
	openCenteredWindow(url); 
	return false; 
}  

function slcvm(){
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

function getTrxID() {
	var d = new Date();  
    var dateString = d.format("yymmddHHMMss");

	document.getElementById("trxid").value = dateString;
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
</head>
<body>
<table width="100%" border="0" cellpadding="1" cellspacing="1" bordercolor="#CCCCCC">
  <tr>
    <td rowspan="2" valign="bottom"><img src="/images/logo.png" width="180" height="43" /></td>
    <td rowspan="2" nowrap="NOWRAP"><br /><br />
    - Web Administrator</td>
    <td width="100%" rowspan="2" valign="bottom" nowrap="nowrap"><br /></td>
    <td height="24" valign="bottom" nowrap="nowrap"><div align="right">
      <p align="left">User Login : <strong><span class="style2">USer1</span><br />
        </strong></p>
    </div></td>
    <td rowspan="2" valign="bottom" nowrap="nowrap"><div align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div></td>
    <td rowspan="2" valign="bottom" nowrap="nowrap"><div align="right" class="style3">LOGOUT</div></td>
    <td rowspan="2" valign="bottom" nowrap="nowrap">&nbsp;</td>
  </tr>
  <tr>
    <td valign="bottom" nowrap="NOWRAP"><span class="style1">Last Login Date: 12-31-0000 </span></td>
  </tr>
</table>
<hr size="3">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF"><br />
    &nbsp;&nbsp;MAIN MENU<br /><br /><? $this->load->view('main_leftmenu'); ?></td>
    <td width="100%" valign="top">
      <h2>TOOLS</h2>      
      <hr size="1"> 
      <table border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td nowrap="nowrap">Select Machine :</td>
          <td><select name="vm" id="vm" onchange="slcvm()" >
            <option value="" selected="selected"  >Pilih VM</option>  
            <?=$selectvm;?>
          </select></td>
        </tr>
      </table> 
      <br />
&nbsp;      <table width="200" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td colspan="3"><span class="style4">Detail VM : </span></td>
        </tr>
        <tr>
          <td><span class="style6">ID</span></td>
          <td><span class="style6">:</span></td>
          <td><span class="style6">SC010CP-MAN</span></td>
        </tr>
        <tr>
          <td><span class="style6">Location</span></td>
          <td><span class="style6">:</span></td>
          <td nowrap="nowrap"><span class="style6">Senayan City Lt 1 </span></td>
        </tr>
        <tr>
          <td><span class="style6">Type</span></td>
          <td><span class="style6">:</span></td>
          <td><span class="style6">Card Prepaid </span></td>
        </tr>
        <tr>
          <td><span class="style6">Vendor</span></td>
          <td><span class="style6">:</span></td>
          <td><span class="style6">Mandiri</span></td>
        </tr>
      </table>
      <br />      <strong> </strong>      <table width="200" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td><strong>VM TOOLS </strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><input name="button"  type="button"  style="font-size:18;padding:2px 10px;" onclick="vmtools('RESTART')" value="RESTART" /></td>
          <td>&nbsp;</td>
          <td><input type="button" name="Submit223" onclick="vmtools('BLOCK')" value="BLOCK" /></td>
          <td>&nbsp;</td>
          <td><input type="button" name="Submit224" onclick="vmtools('RESET BA')" value="RESET BA" /></td>
        </tr>
        <tr>
          <td><input type="button" name="Submit222" onclick="vmtools('SHUTDOWN')" value="SHUTDOWN" /></td>
          <td>&nbsp;</td>
          <td><input type="button" name="Submit2242" onclick="vmtools('UNBLOCK')" value="UNBLOCK" /></td>
          <td>&nbsp;</td>
          <td><input type="button" name="Submit226" onclick="vmtools('EMPTY BA')" value="EMPTY BA" /></td>
        </tr>
        <tr>
          <td colspan="5"><input type="button" name="Submit225" onclick="vmtools('CEK DEVICE STATUS')" value="CEK DEVICE STATUS" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
     <form action="/tools/upload" method="post" enctype="multipart/form-data"  > 
      <table width="200" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td colspan="6" nowrap="nowrap"><p><strong>UPDATE TOOLS </strong></p>
            <p><span class="style1">VM:
                <input name="strvmslc" type="text" id="strvmslc" value="" />
</span></p>
            </td>
        </tr>
        <tr>
          <td nowrap="nowrap"><span class="style1">
          </span></td>
          <td class="style1"><em>Current</em></td>
          <td class="style1"><em> </em></td>
          <td class="style1"><em>Upload New </em></td>
          <td class="style1">&nbsp;</td>
          <td class="style1">&nbsp;</td>
        </tr>
        <tr>
          <td>VIDEO ADS </td>
          <td nowrap="NOWRAP">movie file.mp4
            <input type="submit" name="Submit5" value="view" /> </td>
          <td nowrap="NOWRAP">&nbsp;           </td>
          <td><input name="filevideo" type="file" id="filevideo" /></td>
          <td><input name="filevideo" type="submit" id="filevideo"  value="Upload" /></td>
          <td nowrap="nowrap">&nbsp;&nbsp;          &nbsp;&nbsp;</td>
        </tr>
        <tr>
          <td>RUN TEXT </td>
          <td>text file.txt
            <input type="submit" name="Submit522" value="view" /> </td>
          <td>&nbsp;          </td>
             
          
          <td><input name="filetext" type="file" id="filetext" /></td>
          <td><input name="filetext" type="submit" id="filetext" value="Upload" /></td>
		  
       
          <td nowrap="nowrap">&nbsp;&nbsp;
&nbsp;&nbsp;</td>
        </tr>
        <tr>
          <td>STATION </td>
          <td>??? </td>
          <td>&nbsp;          </td>
          <td>&nbsp; </td>
          <td>&nbsp; </td>
          <td nowrap="nowrap">&nbsp;&nbsp;
&nbsp;&nbsp;</td>
        </tr>
        <tr>
          <td nowrap="nowrap">UPDATE PATCH  </td>
          <td>last patch.xxx
            <input type="submit" name="Submit52" value="view" /> </td>
          <td>&nbsp;          </td>
          <td><input name="filepatch" type="file" id="filepatch" /></td>
          <td><input name="filepatch" type="submit" id="filepatch" value="Upload" /></td>
          <td nowrap="nowrap">&nbsp;&nbsp;
&nbsp;&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp; 
          </td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table></form>
      <p>&nbsp;      </p>
	  
	   
    
	  
	  
	  
	  
	  
    </td>
  </tr>
</table>
 
</body>
</html>