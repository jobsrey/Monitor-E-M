<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>
<?=$pageTITLE;?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
a, a:visited {color: #000000; text-decoration:none}
.style1 {color: #006666}
.style7 {color: #FFFFFF}
.style9 {color: #666666}
-->
</style>
<script type="text/javascript" language="javascript" src="/asset/js/jquery.js"></script>
<script type="text/javascript" language="javascript">

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
</head>
<body> 
<strong>Media Database</strong> 
<hr size="3"> 
<br /> 
<table border="0" cellpadding="0" cellspacing="0"> 
  <tr> 
    <td> <table width="100%" border="0" cellpadding="1" cellspacing="10"> 
        <tr> 
          <td><strong>Select Media Files</strong> :
            <select name="select"> 
              <option selected="selected">Video</option> 
              <option>Image</option> 
              <option>Patch</option>
              <option>All</option> 
            </select></td> 
          <td align="right">Status :
            <select name="select2"> 
              <option selected="selected">Active</option> 
              <option>Delete</option> 
            </select></td> 
        </tr> 
      </table> 
      <table width="100%" border="0" cellpadding="1" cellspacing="10"> 
        <tr> 
          <td bgcolor="#666666"><table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF"> 
              <tr bgcolor="#666666"> 
                <td bgcolor="#666666"><span class="style9"><span class="style7">No</span>.</span></td> 
                <td bgcolor="#666666"><span class="style7">Title</span></td> 
                <td><span class="style7">Size</span></td> 
                <td><span class="style7">Dimension</span></td> 
                <td><span class="style7">Durasi</span></td> 
                <td><span class="style7">Format</span></td> 
                <td nowrap="nowrap" bgcolor="#666666"><span class="style7">Created Date </span></td> 
                <td nowrap="nowrap" bgcolor="#666666"><span class="style7">Created By</span></td> 
                <td align="center" nowrap="NOWRAP" bgcolor="#666666"><span class="style7">Status </span></td> 
                <td colspan="2" align="center" nowrap="NOWRAP" bgcolor="#666666"><span class="style7">Edit</span><span class="style7"></span></td> 
              </tr> 

              <tr bgcolor="#CCCC66"> 
                <td bgcolor="#CCCC66"><div align="right">1.</div></td> 
                <td nowrap="nowrap" bgcolor="#CCCC66"><input name="textfield2" type="text" value="VId-Promo-eMoney-Mandiri" size="30" /></td> 
                <td nowrap="nowrap">30Mb</td> 
                <td nowrap="nowrap">320x240px</td> 
                <td nowrap="nowrap">3 menit</td> 
                <td>.mp4</td> 
                <td nowrap="nowrap" bgcolor="#CCCC66">2014-11-09 00:00:00<br /> </td> 
                <td nowrap="nowrap" bgcolor="#CCCC66">Admin</td> 
                <td align="center" bgcolor="#CCCC66">Active</td> 
                <td width="100%" align="center" bgcolor="#CCCC66"><input type="button" name="Button2" value="SAVE" onclick="window.location.assign('user_edit.php')"/></td>
                <td width="100%" align="center" bgcolor="#CCCC66"> <input type="button" name="Button" value="DEL" onclick="window.location.assign('user_edit.php')"/> </td> 
              </tr> 
			  <? /*			  
              <tr bgcolor="#cccccc"> 
                <td><div align="right">2.</div></td> 
                <td>&nbsp; </td> 
                <td>&nbsp;</td> 
                <td>&nbsp;</td> 
                <td>&nbsp; </td> 
                <td>&nbsp;</td> 
                <td>&nbsp;</td> 
                <td>&nbsp; </td> 
                <td align="right">&nbsp;</td> 
                <td align="right">&nbsp;</td> 
                <td align="right">&nbsp; </td> 
              </tr> 
              <tr bgcolor="#eeeeee"> 
                <td><div align="right">3.</div></td> 
                <td>&nbsp; </td> 
                <td>&nbsp;</td> 
                <td>&nbsp;</td> 
                <td>&nbsp; </td> 
                <td>&nbsp;</td> 
                <td>&nbsp;</td> 
                <td>&nbsp; </td> 
                <td align="right">&nbsp;</td> 
                <td align="right">&nbsp;</td> 
                <td align="right">&nbsp; </td> 
              </tr> 
			  */ ?>
          </table></td> 
        </tr> 
      </table> 
      <hr width="98%" size="1" /> 
      <table width="100%" border="0" cellpadding="1" cellspacing="10"> 
        <form action="/tools/upload" method="post" enctype="multipart/form-data"  > 
          <tr> 
            <td><table border="0" cellpadding="4" cellspacing="1"> 
                <tr> 
                  <td colspan="7" nowrap="nowrap"><p><strong>Add to Media Database</strong></p></td> 
                </tr> 
                <tr bgcolor="#FFFFFF"> 
                  <td nowrap="nowrap" class="style1"><em>Type</em></td> 
                  <td class="style1"><em>Title</em></td> 
                  <td class="style1"><em>File</em></td> 
                  <td class="style1">&nbsp;</td> 
                </tr> 
                <tr bgcolor="#CCCCCC"> 
                  <td nowrap="nowrap" bgcolor="#CCCCCC">&nbsp;&nbsp;VidEO&nbsp;&nbsp; </td> 
                  <td nowrap="nowrap" bgcolor="#CCCCCC"><input name="textfield" type="text" size="30" /></td> 
                  <td bgcolor="#CCCCCC"><input type="file" name="file" /></td> 
                  <td nowrap="nowrap" bgcolor="#CCCCCC"><input name="filevideo" type="submit" id="filevideo3"  value="Upload" /></td> 
                </tr> 
              </table></td> 
          </tr> 
        </form> 
      </table> 
      <hr width="98%" size="1" /></td> 
  </tr> 
</table> 
</body>
</html>
