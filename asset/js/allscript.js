// JavaScript Document

//-- menu-users

function getvalue(resultid,v){ 
	//alert(resultid+' -- '+v);	
	document.getElementById(resultid).value = v;
	
}  
function loading(id){
	//alert(id);
	var lstload = document.getElementById("loading"+id); 
	lstload.style.display="block"; 
 
}
function loadcontent(url,idcontent){
	
	//alert(url);
	$.ajax({
	  url: url,
	  beforeSend: function(xhr) {
			xhr.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");
	  },
	  success: function(data){
		$('#'+idcontent).html(data)   
			.hide()   
			.fadeIn(1000);  
	  }
	});
	
} 

function loadcontent_2(url,idcontent,url2,idcontent2){
	
	//alert(url);
	$.ajax({
	  url: url,
	  beforeSend: function(xhr) {
			xhr.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");
	  },
	  success: function(data){
		$('#'+idcontent).html(data)   
			.hide()   
			.fadeIn(1000);  
	  } 
	});
	
	$.ajax({
	  url2: url2,
	  beforeSend: function(xhr) {
			xhr.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");
	  },
	  success: function(data){
		$('#'+idcontent2).html(data)   
			.hide()   
			.fadeIn(1000);  
	  } 
	});
	
} 
function confirmdelete(url,idcontent){
	if(confirm('Are you sure want to delete this data?')){
		loadcontent(url,idcontent)
	}
}
 
function gosubmit(myForm){  
	if(confirm('Are you sure want to delete this data?')){
		document.getElementById(myForm).submit();
	}
}

function validateFormAccess(form) {
	
    var curGrp  = document.forms[form]["curGroupID"];  
    var chgGrp  = document.forms[form]["chgGroupID"];  
 
    if (curGrp.value != chgGrp.value) {
        alert("You change to wrong group for this preivileges access."); 
		return false;
    }  
}
 
function validateFormUser(form) {
	
    var StatusID  = document.forms[form]["StatusID"];  
    var Username  = document.forms[form]["Username"]; 
	
	if (StatusID.value == null || StatusID.value == "" || StatusID.value == 2) {
   	   var Password  = document.forms[form]["Password"];
       var Password2 = document.forms[form]["Password2"];
	}
    var FullName  = document.forms[form]["FullName"];
    var Phone     = document.forms[form]["Phone"];
    var Email     = document.forms[form]["Email"] 
    var Email 	  = document.forms[form]["Email"];
    var atpos = Email.value.indexOf("@");
    var dotpos = Email.value.lastIndexOf(".");
	
	
    if (Username.value == null || Username.value == "") {
        alert("Username must be filled out");
        Username.focus();
		return false;
    }   
	if (StatusID.value == null || StatusID.value == "" || StatusID.value == 2) {	
		if (Password.value == null || Password.value == "") { 
			if (StatusID.value == 2)
			alert("NEW Password must be filled out");
			else
			alert("Password must be filled out"); 
			Password.focus();
			return false;
		}  else if (Password2.value == null || Password2.value == "") {
			alert("Enter the same Password as above"); 
			Password2.focus();
			return false;
		}  else if (Password.value != Password2.value) {
			alert("Enter the same Password as above!");
			Password2.focus();
			return false;
		}   
	}
	if (FullName.value == null || FullName.value == "") {
        alert("FullName must be filled out");
        FullName.focus();
		return false;
    }  else if (Phone.value == null || Phone.value == "") {
        alert("Phone must be filled out");
        Phone.focus();
		return false;
    }  else if (Email.value == null || Email.value == "") {
        alert("Email must be filled out");
        Email.focus();
		return false;
	} else if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=Email.value.length) {
        alert("Not a valid e-mail address");
        Email.focus();
        return false;
    }
}
function validateFormPass(form) { 
    var Password  = document.forms[form]["Password"];
    var PasswordNew1 = document.forms[form]["PasswordNew1"];
    var PasswordNew2 = document.forms[form]["PasswordNew2"];
  
    if (Password.value == null || Password.value == "") {
        alert("Current Password must be filled out");
        Password.focus();
		return false;
    } else if (PasswordNew1.value == null || PasswordNew1.value == "") {
        alert("NEW Password must be filled out");
        PasswordNew1.focus();
		return false;
    } else if (PasswordNew1.value != PasswordNew2.value) {
		alert("Enter the same NEW Password as above!");
		PasswordNew2.focus();
		return false; 
	} 
}
function popupwindow(url, title, w, h) {
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} 
 

function getRefToDivMod( divID, oDoc ) {
  if( !oDoc ) { oDoc = document; }
  if( document.layers ) {
    if( oDoc.layers[divID] ) { return oDoc.layers[divID]; } else {
      for( var x = 0, y; !y && x < oDoc.layers.length; x++ ) {
        y = getRefToDivMod(divID,oDoc.layers[x].document); }
      return y; } }
  if( document.getElementById ) { return oDoc.getElementById(divID); }
  if( document.all ) { return oDoc.all[divID]; }
  return document[divID];
}

function openPerfectPopup(oW,oTitle,oContent) {
  var x = window.open('','windowName','width=500,height=400,resizable=1');
  if( !x ) { return true; }
  x.document.open();
  x.document.write('<html><head><title>'+oTitle+'<\/title><\/head><body>'+
    (document.layers?('<layer left="0" top="0" width="'+oW+'" id="myID">')
      :('<div style="position:absolute;left:0px;top:0px;display:table;width:'+oW+'px;" '+
      'id="myID">'))+
    oContent+(document.layers?'<\/layer>':'<\/div>')+'<\/body><\/html>');
  x.document.close();
  var oH = getRefToDivMod( 'myID', x.document ); if( !oH ) { return false; }
  var oH = oH.clip ? oH.clip.height : oH.offsetHeight; if( !oH ) { return false; }
  x.resizeTo( oW + 200, oH + 200 );
  var myW = 0, myH = 0, d = x.document.documentElement, b = x.document.body;
  if( x.innerWidth ) { myW = x.innerWidth; myH = x.innerHeight; }
  else if( d && d.clientWidth ) { myW = d.clientWidth; myH = d.clientHeight; }
  else if( b && b.clientWidth ) { myW = b.clientWidth; myH = b.clientHeight; }
  if( window.opera && !document.childNodes ) { myW += 16; }
  x.resizeTo( oW + ( ( oW + 200 ) - myW ), oH + ( (oH + 200 ) - myH ) );
  if( x.focus ) { x.focus(); }
  return false;
}







function warning(url){
	alert(url);
}
function confirmdel(url){
	if(confirm('Do You Want to Delete This Data?')){
		self.location=url;
	}
}

function getParent(par1,par2){
	$("input#parent").val(par2);
	$("input#parentid").val(par1);
}
function validmenu(url){
	if($("input#name").val()==""){
		alert('Pleaser insert Name');
		$("input#name").focus();
		return false;
	}else{
		$("#form")[0].submit();
	}
}

function validgroup(url,urlcallback,idcontent){
	if($("input#name").val()==""){
		alert('Pleaser insert Name');
		$("input#name").focus();
		return false;
	}else{
		dataString='name='+$("input#name").val();
		$.ajax({   
		  type: "POST",   
		  url: url,
		  data: dataString,   
		  success: function(data) {   
			if(data){
				loadcontent(urlcallback,idcontent);
				$("#form")[0].reset();
			}else{
				alert('Data failed to save');
			}
		  }   
		});
	}
}
    

function validpassword(url,urlcallback,idcontent){
	if($("input#old").val()==""){
		alert('Please insert Old Password');
		$("input#old").focus();
		return false;
	} else if($("input#new").val()==""){
		alert('Please insert New Password');
		$("input#new").focus();
		return false;	
	} else if($("input#retype").val()==""){
		alert('Please Retype New Password');
		$("input#retype").focus();
		return false;	
	} else if($("input#new").val() != $("input#retype").val()){
		alert('New Password and Retype New Password not same');
		$("input#retype").focus();
		return false;			
	}else{
		dataString='oldpassword='+$("input#old").val()+'&newpassword='+$("input#new").val();
		$.ajax({   
		  type: "POST",   
		  url: url,
		  data: dataString,   
		  success: function(data) {   
			if(data){
				//loadcontent(urlcallback,idcontent);
				alert('Password have been changed!');
				$("#form")[0].reset();
			}else{
				alert('Data failed to save');
			}
		  }   
		});
	}
}




function validuser(url,urlcallback,idcontent){
	if($("input#fullname").val()==""){
		alert('Pleaser insert Fullname');
		$("input#fullname").focus();
		return false;
	}else if($("input#email").val()==""){
		alert('Pleaser insert UserID');
		$("input#email").focus();
		return false;
	}else{
		dataString='fullname='+$("input#fullname").val()+'&email='+$("input#email").val()+'&id='+$("input#txtid").val();
		$.ajax({   
		  type: "POST",   
		  url: url,   
		  data: dataString,   
		  success: function(data) {   
			if(data){
				loadcontent(urlcallback,idcontent);
				$("#form")[0].reset();
			}else{
				alert('Data failed to save');
			}
		  }   
		});
	}
}
function validationemail(str){
	var at="@"
	var dot="."
	var lat=str.indexOf(at)
	var lstr=str.length
	var ldot=str.indexOf(dot)
	if (str.indexOf(at)==-1){
	   return false
	}

	if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
	   return false
	}

	if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		return false
	}

	 if (str.indexOf(at,(lat+1))!=-1){
		return false
	 }

	 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		return false
	 }

	 if (str.indexOf(dot,(lat+2))==-1){
		return false
	 }
	
	 if (str.indexOf(" ")!=-1){
		return false
	 }

	 return true		
}

function ContentCheck(varUrl) {
	//alert ( document.form.selSection.options[document.form.selSection.options.selectedIndex].value );
	
	var xmlHttp;
	try{  // Firefox, Opera 8.0+, Safari  
		xmlHttp=new XMLHttpRequest();  
	}
	catch (e){  // Internet Explorer  
		try{    
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");    
		}
		catch (e){    
			try{      
				xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");      
			}
			catch (e){      
				alert("Your browser does not support AJAX!");      
				return false;      
			}    
		}  
	}
			


var url = varUrl + 'admin5.php/cms/getsectiontype/' + document.form.selSection.options[document.form.selSection.options.selectedIndex].value;
xmlHttp.open("GET", url, true);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.setRequestHeader("Connection", "close");

xmlHttp.onreadystatechange = function() {
	if(xmlHttp.readyState == 4 && xmlHttp.status == 200) {
		//alert(xmlHttp.responseText);
		if (xmlHttp.responseText == 1) {
			document.getElementById("btnCekQuestion").innerHTML = '<input type="button" value="Pick Questions" onClick="window.open(\''+varUrl+'admin5.php/consultation/browse/'+ document.form.selSection.options[document.form.selSection.options.selectedIndex].value +'\',600,300)" />';
		} else {
			document.getElementById("btnCekQuestion").innerHTML = '';
		}
	}
}
xmlHttp.send();

}


