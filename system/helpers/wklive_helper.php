<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
// ------------------------------------------------------------------------ 
if ( !function_exists('WKDATE') ) {
	function WKDATE($mode="",$datetime=''){
		
		if(empty($datetime)) $datetime = date("Y-m-d H:i:s");
		/*
		//-- chk ads top 0-----------------------------------------------------------------

		$database='warkot'; $host="10.50.16.154"; $username="wartakota"; $password="w4rt4k0t4";
		if($_SERVER['HTTP_HOST']=="wartakota") { $host="localhost"; $username="root"; $password=""; }
		 
		$conn2 = mysql_connect($host,$username,$password);
		if (!$conn2) die ('Gagal Melakukan Koneksi');
		mysql_select_db($database,$conn2) or die ('Database Tidak Diketemukan di Server');  
		
		//-- chk pending news ------------------------------------------------------------- 
		
		$sql="SELECT * FROM `Webvars_Table` WHERE `Key` = 'ChgHour' OR `Key` = 'ChgMinute'";
		$query	=	mysql_query($sql);  
		$arrChg = array();  
		while($row = mysql_fetch_row($query)) $arrChg[$row[0]] = $row[1]; 
  
		// foreach($arrChg as $key=>$val) echo "<br>$key=>$val"; 
 */
		$bedaJam 	= 0;//$arrChg['ChgHour']; //1;//24; //-- jam server lebih lambat n jam
		
		$bedaMenit  = 0;//$arrChg['ChgMinute']; //0;//38;  //-- jam server lebih lambat n menit 
		
		$thn 		= date('Y',strtotime($datetime));
		$bln		= date('n',strtotime($datetime));
		$hri		= date('j',strtotime($datetime));
		$jam 		= date('H',strtotime($datetime));
		$men 		= date('i',strtotime($datetime));
		$sec 		= date('s',strtotime($datetime));
		
		$ttime = mktime($jam,$men,$sec,$bln,$hri,$thn) + (($bedaJam*60*60)+($bedaMenit*60)) ;  //-- min 1 jam is Apache default time ??? 
		
		 
		
		if( !empty($mode) ) return date("$mode",$ttime);   
		
		else				return date("Y-m-d H:i:s",$ttime);   
		
		//return date("Y-m-d H:i:s");
		 
	}
} 
if ( !function_exists('SERVERDATE') ) {
	function SERVERDATE(){
		return $datetime = date("Y-m-d H:i:s");  
	}
} 
// ------------------------------------------------------------------------
 