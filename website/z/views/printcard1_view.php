<html>
<head>
<title>Sim Transaction</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
.frame {
	width:527px;
	height:300px;
}
.left {
	float:left;
	padding-left:40px;
	width:200px;
	padding-top:15px;
	font: normal 12px arial;
	color:#333333
}
.right {
	float:right;
	margin-right:30px;
	padding-top:70px;
	width:230px;
	font: normal 12px arial;
	color:#666666
}
.form {
	font: normal 11px arial;
	width:180px;
	color:#333333;
	border:1px solid #666666;
}
.lupa a {
	color:#333333;
	text-decoration:underline;
	font:normal 11px arial;
}
.lupa a:hover {
	text-decoration:none;
}
.red {
	color:#F00;
	font-weight: bold;
}
.style5 {
	color: #F00;
	font-weight: bold;
	font-size: 12px;
}
.style9 {font-size: 12px}
</style>
<script type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div align="center" style="font:normal 13px tahoma">
  <table width="527" height="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" valign="middle"><table border="1" cellpadding="0" cellspacing="0" bordercolor="#eeeeee" bgcolor="#efefef">
        <tr>
          <td bgcolor="#FFFFFF">
          <img src="/asset/images/logo.png" width="180" height="43" hspace="20" vspace="10"></td>
          </tr>
        <tr>
          <td align="center"><div style="padding:20px;">
            <p><span class="style5">HTML POST:</span></p>
            <p>When Processing PRINTING-CARD TFC =&gt;<br>
            </p>
            <form name="form1" method="post" action="/query/getcarddata">
              <label>card_number <br>
              <input name="card_number" type="text" id="card_number" value="<?=$card_number?>">
                </label>
              
                <p>
                  <input type="submit" name="button" id="button" value="Submit">
                  <br>
                    <br>
                  NOTE: member status  di server harus &quot;PRINTCARD&quot;, for test : 0210000002. atau bisa rubah status member menjadi PRINTCARD terlebih dahulu utk test NumCard lainnya. Rubah status di menu member_validate</p>
                <p> hasil response submit:<br>
                -------------------------------------------------<br>
                  FullName = Mba Seleb Warkot<br>
                  TFCNumber = 0210000002<br>
                  TFCStatus = PRINTCARD<br>
                  TFCNoPolisi = AB 5678 ZZ<br>
                  TFCValidDateBegin = 0000-00-00<br>
                  TFCValidDateEnd = 0000-00-00<br>
                -------------------------------------------------</p>
                <p> FullName : Nama yag akan tertulis di Kartu<br>
                  TFCNoPolisi bisa saja empty/kosong,<br>
                  TFCValidDateBegin OR TFCValidDateEnd tidak boleh : 0000-00-00 / empty /kosong<br>
                  TFCStatus HARUS= PRINTCARD<br>
                =&gt; <br>
                jika all data ada yg TDK-BENAR maka
                tombol write data dan print TIDAK-ACTIVE (atau silahkan dgn metode lain yg lebih efisien utk filter ini)<br>
                  , artinya admin harus isi data diatas dgn komplit dulu pada data di server agar bisa melakukan proses write data dan print card baru.</p>
                <p><br>
                </p>
                <p> <strong></strong></p>
                </form>
            <p>-----------------------------------</p>
            <p>After Get response data =&gt; Begin CREATE NEW MEMBER-CARD.</p>
            <p>WHEN  PRINT CARD OK, THAN SEND HTTP-GET to SERVER</p>
            <p>URL:</p>
            <p>http://admin.tribunfamilycard.com/query/printed_card/XXXXXXXXXX/YYYYYY/PRINTSTATUS/DATETIME</p>
            <p>XXXXXXXXXX = card_number<br>
              YYYYYY = CArd Serial Numver<br>
              PRINTSTATUS = OK =&gt; success print and write data to card<br>
PRINTSTATUS = ERROR =&gt; not-success print and write data to card<br>
DATETIME = YYYmmddHis (waktu saat diprint)</p>
            <p>&nbsp;</p>
            <p>*example :<br>
                <br> 
              if PRINT CARD SUCCEED =&gt; send http-get to :<br>
              <br>
              http://admin.tribunfamilycard.com/<strong>query</strong>/<strong>printed_card</strong>/<strong>0210000002</strong>/<strong>990C177D</strong>/<strong>OK</strong>/<strong>20160409</strong></p>
            <p><em>ini akan membuat status member dari &quot;<strong>PRINTCARD</strong>&quot; menjadi &quot;<strong>VALID</strong>&quot; dan <strong>insert</strong> <strong>Serial</strong> <strong>Number</strong> Card di member data di server.</em></p>
            <p>if PRINT CARD NOT-SUCCEED :</p>
            <p>http://admin.tribunfamilycard.com/query/printed_card/XXXXXXXXXX/YYYYYY/ERROR/DATETIME</p>
            <p>also -&gt;
              PRINT STATUS on log list = &quot;NOT-PRINT&quot; <br>
              =&gt; agar bisa utk di re-print nextime, mungkin pas tinta habis/tulisan tidak clear, click CANCEL setelah proses printing utk diulang dgn CARD BARU.)<br>
              AND CLEAR WRITE DATA on CARD ? <br>
              <br>
              *ini apakah mungkin?</p>
            <p>&nbsp;</p>
            <p>-----------------------------</p>
            <p>setiap proses ada lognya, disimpan di local </p>
            <p>&nbsp;</p>
          </div>
            <hr>
            <span class="style9">test data sample: <br>
            </span></td>
        </tr>
        
      </table>
      </td>
    </tr>
  </table>
  </td>
</div>
</body>
</html>
