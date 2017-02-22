<?php
class Allmodel extends Model {

    function Allmodel()
    {
        parent::Model();
		$this->load->database();
    }
	
	function navMenu() { 
		$arr_navText		= array("home","warta","metropolitan","gaya hidup","bisnis","otomotif","entertainment","komunitas","sport","pendidikan","galeri");
		$arr_navWidth		= array(54,69,110,100,67,82,121,97,67,99,62);
		
		//$arr_navColor 		= array("#df161e","#d64e00","#b90000","#ca357d","#11805f","#4b4b4b","#582f78","#886802","#1b7809","#225887","#844c19");
		//$arr_navColorLight	= array("#ff070f","#faa575","#e77070","#f4adcf","#70cdb3","#a9a9a9","#c799e9","#d1b95f","#6cc856","#74a4ca","#c0a388");

		$arr_navColor 		= array("#860100","#d64e00","#b90000","#ca357d","#11805f","#4b4b4b","#582f78","#886802","#1b7809","#225887","#844c19");
		$arr_navColorLight	= array("#ff070f","#faa575","#e77070","#f4adcf","#70cdb3","#a9a9a9","#c799e9","#d1b95f","#6cc856","#74a4ca","#c0a388");

		$arr_navParentID	= array(0,1,23,25,20,99,64,72,49,73,100); 
		return array($arr_navText,$arr_navWidth,$arr_navColor,$arr_navColorLight,$arr_navParentID);
	}
	
	//--:index news
	function getIndexNews($section,$limit,$pg,$order,$sort,$isHot,$category,$lokasi,$country,$city,$spot,$datefrom,$dateend,$slcBy,$slcString){  
 
			$strSection = ''; 
			if($section) $strSection = " And ( a.SectionID = ".$section." OR ( a.SectionID in (select ID from sectiontable where ParentID =".$section.")) ) ";
			
			if($section==109){ //--bola
					$arrSIDs = array(109,77,78,79,80,81,82,83,84,95,98);
					$strSection = " AND ( ";
					foreach($arrSIDs as $key => $value){
					$strSection .= " a.SectionID = ".$value." OR ( a.SectionID in (select ID from sectiontable where ParentID =".$value.")) OR "; 
					}
					$strSection .= ") ";
					$strSection = str_replace("OR )",")",$strSection); 
			} 
	 
			if($limit==0) $limit = 1000; //max num request data
			
			if($pg<1)$pg=1;	
			$start = $limit*($pg-1);
			
			if(empty($order)) $order = 'PublishedDate'; //--default
			if(empty($sort))  $sort  = 'Desc'; 			//--default
	 
			$strHot = '';
			if($isHot) $strHot = " And a.HotNews = 1 ";
			
			//---category 
			$strCat1= $strCat2 = $strCat3 = '';
			if(!empty($category)){
				$strCat1 = " ,b.Name as Category, b.ID as CatID ";
				$strCat2 = " left join n_category_table b on b.ID = a.CategoryID ";
				$strCat3 = " And b.ID = ".$category." ";
			}
			 
			//---location  : $lokasi,$country,$city,$spot
			$strLoc01 = $strLoc02 = $strLoc03 = "";
			if(!empty($lokasi)||!empty($country)||!empty($city)||!empty($spot)){
	  
				$strCat1 = " ,c.Name as LocationName ";
				$strCat2 = " left join n_location_table c on c.ID = a.LocationID ";
				 
				if(!empty($spot)){	 
					$arrLocIDs = $this->allmodel->getArrLocatChildID($spot);
					if(count($arrLocIDs)){ 
						$strArray = "a.LocationID =".implode(" OR a.LocationID =", $arrLocIDs); 
						$strLoc03 = " And ( ".$strArray." )" ; 
					} 
				}elseif(!empty($city)){
					$arrLocIDs = $this->allmodel->getArrLocatChildID($city);
					if(count($arrLocIDs)){
						$strArray = "a.LocationID =".implode(" OR a.LocationID =", $arrLocIDs); 
						$strLoc03 = " And ( ".$strArray." )" ;
					}  
				}elseif(!empty($country)){
					$arrLocIDs = $this->allmodel->getArrLocatChildID($country);
					if(count($arrLocIDs)){
						$strArray = "a.LocationID =".implode(" OR a.LocationID =", $arrLocIDs); 
						$strLoc03 = " And ( ".$strArray." )" ;
					} 
				
				}elseif(!empty($lokasi)){	
					$arrLocIDs = $this->allmodel->getArrLocatChildID($lokasi);
					if(count($arrLocIDs)){
						$strArray = "a.LocationID =".implode(" OR a.LocationID =", $arrLocIDs); 
						$strLoc03 = " And ( ".$strArray." )" ;
					} 
				} 
			}
			//---topic selected 
			$strTopic= '';
			if(!empty($slcBy)) 
			if(!empty($slcString)){
				
				//if( strtolower($slcBy)=='topic' && strtolower($slcString)=='jelajah_museum')
				//$strTopic=" And a.Topic LIKE '%JELAJAH MUSEUM%' ";  
				//elseif( strtolower($slcBy)=='topic' && strtolower($slcString)=='jakarta_baru')
				//$strTopic=" And a.Topic LIKE '%JAKARTA BARU%' "; 
				//else( strtolower($slcBy)=='topic' && strtolower($slcString)=='jakarta_baru')
				
				//$slcString = str_replace("_"," ",$slcString);
				//$slcString = str_replace("-","-",$slcString);
				$strTopic=" And a.Topic LIKE '%".$slcString."%' ";
				  
			}
			
			//,$slcBy,$slcString
			
			  
			$q = "Select a.ID, a.Title, a.Teaser, a.Topic, a.SubTitle, a.SectionID, a.LocationID, a.PublishedDate 
					".$strCat1."  
					".$strLoc01." 
					
					From newstable a  
					".$strCat2."  
					".$strLoc02."  
					 
					Where a.StatusID = 3 
					".$strSection."
					".$strHot." 
					".$strCat3." 
					".$strLoc03." 
					".$strTopic." 
					
					Order By LTRIM(REPLACE(REPLACE(a.".$order.",\"'\",''),'\"','')) ".$sort; 
				
			$strLimit = " Limit ".$start.",".$limit;
			
			$arrayResult[0] = $this->db->query($q.$strLimit);
			
			$totData = $this->db->query($q);
			$arrayResult[1] = $totData->num_rows(); 
					
			return $arrayResult;
	 
		
		
	} 
	function getArrLocatChildID($id=0){ 
		$qData = $this->db->query("Select a.ID From n_location_table a where a.ID = ".$id." OR a.ParentID = ".$id." "); 
		$result = $qData->result_array();
		$totDat =  $qData->num_rows();
		$arrID = array();
		if($totDat)
		foreach($result as $k => $row){
			array_push($arrID,$row['ID']);	
			//--level2
			$qData2 = $this->db->query("Select a.ID From n_location_table a where a.ID = ".$row['ID']." OR a.ParentID = ".$row['ID']." "); 
			$result2 = $qData2->result_array();
			$totDat2 = $qData2->num_rows();
			if($totDat2)
			foreach($result2 as $k2 => $row2){
				array_push($arrID,$row2['ID']);
				//--level3
				$qData3 = $this->db->query("Select a.ID From n_location_table a where a.ID = ".$row2['ID']." OR a.ParentID = ".$row2['ID']." "); 
				$result3 = $qData3->result_array();
				$totDat3 = $qData3->num_rows();
				if($totDat3)
				foreach($result3 as $k3 => $row3){
					array_push($arrID,$row3['ID']);
					//--level4
					$qData4 = $this->db->query("Select a.ID From n_location_table a where a.ID = ".$row3['ID']." OR a.ParentID = ".$row3['ID']." "); 
					$result4 = $qData4->result_array();
					$totDat4 = $qData4->num_rows();
					if($totDat4)
					foreach($result4 as $k4 => $row4){
						array_push($arrID,$row4['ID']); 
					} 
				} 
			}
		}
		$arrResult = array_unique($arrID); 
		return $arrResult;
		//foreach($arrResult as $k => $row) echo "<br>arr[$k] => $row"; exit;
		
	}
	
	
	
	
	
	//--/index news
	
	
	//--:terkini
	function getTerkini($section=0,$limit=1,$isHot=0,$noID=array(),$useLocat=0,$subLocat='') { 
		//if($section==0){ // :home
			$strSection = '';
			//if($section) $strSection = " And SectionID = '".$section."' ";
			if($section) $strSection = " AND ( a.SectionID = ".$section." OR ( a.SectionID in (select ID from sectiontable where ParentID =".$section.")) ) ";
			
			if($section==109){ //--bola
				$arrSIDs = array(109,77,78,79,80,81,82,83,84,95,98);
				$strSection = " AND ( ";
				foreach($arrSIDs as $key => $value){
				$strSection .= " a.SectionID = ".$value." OR ( a.SectionID in (select ID from sectiontable where ParentID =".$value.")) OR "; 
				}
				$strSection .= ") ";
				$strSection = str_replace("OR )",")",$strSection);
				 
			}
			
 
			$strHot = '';
			if($isHot==1) $strHot = " And HotNews = 1 ";
			
			$strNoID = '';
			if(count($noID)){
				$strExplode = implode(";",$noID); //79020,78819
				$strNoID .= " And a.ID != '";
				$strNoID .= str_replace(";","' And a.ID != '",$strExplode);
				$strNoID .= "' ";
			} 
			
			$strLocat = '';
			if($useLocat==1){
				$LokasiID = $useLocat;
				if($subLocat=='Jakarta') 		$LokasiID = 4;
				elseif($subLocat=='Bogor') 		$LokasiID = 5;
				elseif($subLocat=='Depok')	 	$LokasiID = 6;
				elseif($subLocat=='Tangerang') 	$LokasiID = 7;
				elseif($subLocat=='Bekasi') 	$LokasiID = 8;
				 
				//--get all locatID
				$arrlocat = $this->getArrLocatChildID($LokasiID);
				if(count($arrlocat)){
					$strExplode = implode(";",$arrlocat); //79020,78819
					$strLocat .= " Or a.LocationID = '";
					$strLocat .= str_replace(";","' Or a.LocationID = '",$strExplode); 
					$strLocat .= "' ";
					
					$strLocat  = " And (".$strLocat.") ";
					$strLocat  = str_replace( "( Or a.LocationID" ,"( a.LocationID",$strLocat);
					 
				} 
			}
			elseif($useLocat==2||$useLocat==3){
				//echo $LokasiID = $useLocat;
				//--get all locatID
				$arrlocat = $this->getArrLocatChildID($useLocat);
				if(count($arrlocat)){
					$strExplode = implode(";",$arrlocat); //79020,78819
					$strLocat .= " Or a.LocationID = '";
					$strLocat .= str_replace(";","' Or a.LocationID = '",$strExplode); 
					$strLocat .= "' ";
					
					$strLocat  = " And (".$strLocat.") ";
					$strLocat  = str_replace( "( Or a.LocationID" ,"( a.LocationID",$strLocat);
				} 
			}
			
			//--if newslist need image
			$useImages='';
			$whereUseImages='';
			if( $section==64 || //entertainmen
				$section==25 || //gayahidup
				$section==72 	//komunitas
			){
				$useImages='
				inner join newsxphototable b on b.NewsID = a.ID
				inner join phototable c on c.ID = b.PhotoID   
				'; 
				$whereUseImages=' AND b.OrderID = 1';
			}  
			$q = "  
				select a.ID, a.Title, a.Teaser, a.Topic, a.SubTitle, a.SectionID, a.LocationID, a.PublishedDate, a.AuthorName, a.AuthorID
				from newstable a  
				".$useImages."  
				Where a.SectionID<200 and a.StatusID = 3 
				".$strSection."
				".$strHot."
				".$strNoID."
				".$strLocat."
				".$whereUseImages."  
				Order By a.PublishedDate desc Limit ".$limit;
			$result = $this->db->query($q);
			return $result;
		//}
	} 
	//--/terkini
	
	//--:hottopic 
	function getHotTopic($section=0,$limit=4,$olddate=0,$mode=0) { 
	 
	
		//$time2 = mktime(WKDATE("H"),WKDATE("i"),WKDATE("s"),WKDATE("m"),WKDATE("d"),WKDATE("Y")) + 0*86400;
		 $date2 = date("Y-m-d H:i:s");//date("Y-m-d",$time2);  
		
		$time1 = mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")) - ($olddate)*86400;
		
		$date1 = date("Y-m-d",$time1); 
		$strSec="";
		$result = '';
		$arr = array();
		if($section) 
		$strSec=" AND ( a.SectionID = ".$section." OR ( a.SectionID in (select ID from sectiontable where ParentID = ".$section.")) ) ";
		 
			/* ori
		echo $q =  "SELECT a.Topic, a.Title, a.PublishedDate, count( a.Topic ) AS Total
				FROM newstable a 
				WHERE a.Topic!='' AND a.StatusID = 3 AND PublishedDate >= '".$date1."' AND a.PublishedDate <= '".$date2."' ".$strSec."
				GROUP BY a.Topic
				ORDER BY Total DESC, a.PublishedDate DESC  
				LIMIT ".$limit  ; 		 
		return  $this->db->query($q);
		*/
		 $strNoTopic = " 
		 AND LOWER(a.Topic) != 'jelajah museum'  
		 AND LOWER(a.Topic) != 'jakarta baru' 
		 AND LOWER(a.Topic) != 'suara warga'  
		 AND LOWER(a.Topic) != 'NATAL DAN TAHUN BARU 2013'  
		 " ;
		 
		if(!$mode){
			$q =  "SELECT a.Topic, count( a.Topic ) AS Total
			FROM newstable a 
			WHERE (a.Topic!='' ".$strNoTopic." AND a.StatusID = 3 AND PublishedDate >= '".$date1."' AND a.PublishedDate <= '".$date2."' ".$strSec.")
			GROUP BY a.Topic ORDER BY Total DESC
			LIMIT ".$limit  ; 		
		}else{
			$q =  "SELECT a.Topic, count( a.Topic ) AS Total
			FROM newstable a 
			WHERE (a.Topic!='' ".$strNoTopic." AND a.StatusID = 3 AND PublishedDate >= '".$date1."' AND a.PublishedDate <= '".$date2."' ".$strSec.")
			GROUP BY a.Topic ORDER BY PublishedDate DESC
			LIMIT ".$limit  ;  
		}	
			
			 
		$query =  $this->db->query($q);
 
		if($query->num_rows()){
			
			$k=0; 
			foreach($query->result_array() as $row){ 
				$arr[$k]['Topic'] = '';
				$arr[$k]['Total'] = 0; 
				$arr[$k]['ID'] = 0;	 
				$arr[$k]['Title'] = ''; 
				$arr[$k]['PublishedDate'] = '';  
				
				$q2 =  "SELECT a.ID, a.SectionID, a.Teaser, a.Topic, a.Title, a.PublishedDate 
				FROM newstable a 
				WHERE a.Topic LIKE '%".$row['Topic']."%' AND a.StatusID = 3 
				 ".$strSec."
				
				ORDER BY a.PublishedDate DESC  
				LIMIT 1"; 		   
				$query2  = $this->db->query($q2);
				
				$q3 =  "SELECT a.ID, a.SectionID, a.Teaser, a.Topic, a.Title, a.PublishedDate 
				FROM newstable a 
				WHERE a.Topic LIKE '%".$row['Topic']."%' AND a.StatusID = 3 
				 ".$strSec." 
				ORDER BY a.PublishedDate DESC "; 		   
				$query3  = $this->db->query($q3);
				
				if($query2->num_rows()){
					$row2 = $query2->row_array();  
					
					$arr[$k]['Topic']			= $row['Topic'];
					$arr[$k]['Total']			= $query3->num_rows();
					$arr[$k]['ID']				= $row2['ID'];
					$arr[$k]['SectionID'] 		= $row2['SectionID'];
					$arr[$k]['Title']			= $row2['Title'];
					$arr[$k]['PublishedDate']	= $row2['PublishedDate'];
					$arr[$k]['Teaser']			= $row2['Teaser'];
				} 
				
				$k++;
			} 
			 
		}  
		//foreach($arr as $k => $v) foreach($v as $kk => $value) echo "<br>$k => $kk => $value";
		/*
		0 => Topic => Menuju DKI-1
		0 => Total => 515
		0 => ID => 101725
		0 => Title => Tamu Istimewa Foke di Akhir Masa Jabatannya
		0 => PublishedDate => 2012-10-05 18:50:13
		*/		
		//  exit;
		return $arr;
				  
		 
	}
	//--/hottopic
	
	function getInfoDiskon($typeID=0,$limit=1){ 
		$q = "select * from infodiskon_table a where 
		StatusID=3 And TypeID='".$typeID."' 
		Order By PublishedDate Desc 
		limit ".$limit;  
		$query = $this->db->query($q);
		return $query;
	}
	
	/*
	function getGaleri($section=0,$limit=1,$type=1){
		if($type==1)
		$q = "select a.*, b.Path, b.Format
			from photogallerytable a 
			left join phototable b on b.ID = a.ThumbID  
			where a.Type='1' And a.StatusID=3 Order By a.PublishedDate Desc limit ".$limit; 
 
		elseif($type==2) 
		$q = "Select a.*, b.Path as Path, b.Format as Format, c.`Source` as PathMedia, c.Embed 
			From photogallerytable a
			Left join phototable b on b.ID = a.ThumbID
			Left join gallery_media_table c on c.ID = a.MediaID 
			Where a.Type='2' And a.StatusID=3 Order By a.PublishedDate Desc limit ".$limit; 
						
 
		$query = $this->db->query($q);
		return $query;
	}
	*/
	function getGaleri($section=0,$limit=1,$x){
		if($x==1)
		$q = "select a.*, b.Path, b.Format, c.`Source` as PathMedia, c.Embed ,c.`Type` as TD
			from photogallerytable a 
			left join phototable b on b.ID = a.ThumbID 
			Left join newsmedia_table c on c.ID = a.MediaID  
			where a.Type='1' And a.StatusID=3 Order By a.PublishedDate Desc limit ".$limit; 
 
		elseif($x==2) 
		$q = "Select a.*, b.Path as Path, b.Format as Format, c.`Source` as PathMedia, c.Embed ,c.`Type` as TD
			From photogallerytable a
			Left join phototable b on b.ID = a.ThumbID
			Left join newsmedia_table c on c.ID = a.MediaID 
			Where a.Type='2' And a.StatusID=3 Order By a.PublishedDate Desc limit ".$limit; 
						
 
		$query = $this->db->query($q);
		return $query;
	}
	function getSectionNavi($id) {
		$getSec = $this->allmodel->getSectionByID($id);  
		if(empty($getSec['ParentID'])){ 
			$urlChild = $this->allmodel->linkPathSection($getSec['SectionID']) ; 
			$sName = $this->allmodel->getSectionName($getSec['SectionID']); 
			$lblSection0 = '<a href="'.$this->allmodel->valPath($urlChild).'">'.$sName.'</a>';  
			$lblSection1 = '';
		}else{
			$getSec2 = $this->allmodel->getSectionName($getSec['ParentID']); 
			$lblSection0 = '<a href="/'.$this->allmodel->valPath($getSec2).'">'.$getSec2.'</a>';  
			$urlChild = $this->allmodel->linkPathSection($getSec['SectionID']) ; 
			$sName = $this->allmodel->getSectionName($getSec['SectionID']);  
			$lblSection1 = ' / <a href="'.$this->allmodel->valPath($urlChild).'">'.$sName.'</a>';  
		} 
		return $lblSection0.$lblSection1;
	} 

	function getUserNamebyID($id) {
		$return = '';
		$gData = $this->db->query("select FullName from usertable Where ID = '".$id."' Limit 1" );
		$row = $gData->row_array();
 		if($gData->num_rows()) $return = $row['FullName'];
		return $return; 
	} 
	function getParentByNewsID($newsid) {
		$SectionID = 0;
		$q = $this->db->query("select SectionID from newstable where ID = ".$newsid." limit 1 "); 
		if($q->num_rows()){
			$row = $q->row_array();
			$SectionID = $row['SectionID'] ; 
		} 
		$getParent = $this->getParentName($SectionID); 
		return array($getParent['ID'],$getParent['Name']); 
	}
	function getSectionName($sectionid) {
		$q = $this->db->query("select Name from sectiontable where ID = ".$sectionid." limit 1 "); 
		if($q->num_rows()){
			$row = $q->row_array();
			return $row['Name'] ; 
		} 
	} 
	function getParentName($sectionid) {
		$q = $this->db->query("select ID,Name from sectiontable a 
			where (a.ID = ".$sectionid." AND a.ParentID = 0) OR ( a.ID in (select ParentID from sectiontable where ID = ".$sectionid.") )
			limit 1 "); 
		return $q->row_array();
	}
	function getSectionByID($id) {
		$q = $this->db->query("select b.ID SectionID, b.Name SectionName,b.ParentID from newstable a 
			Left join sectiontable b on b.ID = a.SectionID
			where a.ID = ".$id." 
			limit 1 "); 
		return $q->row_array();
	}
	function getLocationName($id) {
		$q = $this->db->query("select ID,Name from n_location_table where ID = ".$id." limit 1 "); 
		return $q->row_array();
	}
	function getNewsImages($newsid){
		$q = ("select a.OrderID, a.NewsID, b.Path, b.Format, b.Caption, b.Author as Photografer
		from newsxphototable a 
		left join phototable b on a.PhotoID = b.ID
		where a.NewsID = ".$newsid." And a.OrderID>0
		Order By a.OrderID asc limit 1"); 
		$query =  $this->db->query($q);
		
		$qdata = $query->result_array();  
		$arrImgs = array();//array( 0 => array("OrderID"=>'',"NewsID"=>'',"Path"=>'',"Format"=>'',"Caption"=>'',"Photografer"=>'') ); 
		$x=0;
		if($query->num_rows()){
			foreach($qdata as $k => $value){
				foreach($value as $kk=>$vv){
				 	//echo "<br>$k => $kk => $vv";	
				 	$arrImgs[$k][$kk]=$vv;
					
				}$x++;
			}
		} 
		 return $arrImgs;
	} 
	
	//--:headline
	function getHeadline($sectionid=0) { 
		if($sectionid==0){ // home

			$q=("select a.NewsID, b.ID, b.Title, b.Teaser, b.SectionID, b.LocationID, d.Path, d.Format
			from n_headline_table a
			inner join newstable b 		on b.ID = a.NewsID
			inner join newsxphototable c 	on c.NewsID = b.ID
			inner join phototable d 		on d.ID = c.PhotoID   
			Where a.SectionID = 0 And a.StatusID = 3 And c.OrderID = 1 
			Order By a.LineAge asc "); //Group By b.ID
			return $this->db->query($q);
			
		} else {  // section -> lastest news
			return $this->db->query("select  b.ID , b.Title, b.Teaser, b.SectionID, b.LocationID, d.Path, d.Format
			from  newstable b 		 
			inner join newsxphototable c 	on c.NewsID = b.ID
			inner join phototable d 		on d.ID = c.PhotoID   
			Where b.StatusID = 3 
			And c.OrderID = 1 
			AND ( b.SectionID = ".$sectionid." OR ( b.SectionID in (select ID from sectiontable where ParentID = ".$sectionid.")) )
			Order By b.PublishedDate Desc Limit 1"); 
		}
	} 
	//--/headline
	//--weather
	function getWeather($id){
		$query = $this->db->query("select * from weathertable where id=".$id." order by ID asc");
		return $query->row();
	}
	//--/weather
	//-- functions date time 
	function formatDateTime($vardate,$mode=0) {  
		
		$hari = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'); // dateformat --> w 
		$bulan = array(1=>'Januari', 2=>'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'); 
		$bulan2 = array(1=>'Jan', 2=>'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'); 
		$dywk = date('w',strtotime($vardate));  
		$dywk2 = $hari[$dywk];
		$dy = date('j',strtotime($vardate)); 
		$dy2 = date('d',strtotime($vardate));
		$mth = date('n',strtotime($vardate)); 
		$mth2 = date('m',strtotime($vardate));
		$bln = $bulan[$mth]; 
		$bln2 = $bulan2[$mth];
		$yr = date('Y',strtotime($vardate));
		$hr = date('H',strtotime($vardate));
		$mi = date('i',strtotime($vardate)); 
		$ss = date('s',strtotime($vardate));  
		
		
		if($mode==0){																				// -- 17:06   OR  ''.$dy2.'/'.$mth2.'';
			$dateDay = date("z",strtotime($vardate));
			$curDay  = date("z",strtotime(date("Y-m-d H:i:s")));
			if($curDay!==$dateDay)
			return  ''.$dy2.'/'.$mth2.'';
			else 
			return $hr.':'.$mi; 
		}
		elseif($mode==1) return $yr.'-'.$mth.'-'.$dy;  												// -- 2010-12-31 
		elseif($mode==2) return $dy.' '.$bln.' '.$yr; 												// -- 19 November 2009 
		elseif($mode==3) return $dywk2.', '.$dy.' '.$bln.' '.$yr; 									// -- Selasa, 19 November 2009		
		elseif($mode==4) return $dywk2.', '.$dy.' '.$bln2.' '.$yr.' | '.$hr.':'.$mi.''; 			// -- Selasa, 17 November 2010 | 06:33  			
		elseif($mode==5) return $dywk2.', '.$dy.' '.$bln.' '.$yr.' | '.$hr.':'.$mi.' WIB'; 			// -- Selasa, 19 November 2009 | 17:06 WIB
		elseif($mode==6) return $dywk2.' ('.$dy2.'/'.$mth2.')' ; 									// -- Selasa (17/05) 
		elseif($mode==7) return $dywk2.' ('.$dy2.'/'.$mth2.') | '.$hr.':'.$mi;						// -- Selasa (17/05) | 06:33
		elseif($mode==8) return $dywk2.' ('.$dy2.'/'.$mth2.') | '.$hr.':'.$mi.' WIB' ; 				// -- Selasa (17/05) | 06:33 WIB
		elseif($mode==9) return $hr.':'.$mi.' WIB ';												// -- 19:06 WIB
		elseif($mode==10) return  $dy2.'/'.$mth2 ; 													// -- 17/05
		elseif($mode==11) return '('.$dy2.'/'.$mth2.')';  											// -- (17/05)
		elseif($mode==12) return $dy.' '.$bln; 														// -- 17 Mei	
		elseif($mode==14) return $this->dateRange(1,$vardate); 										// -- 12 jam 59 menit lalu
		elseif($mode==15) return $dywk2.' ('.$dy2.'/'.$mth2.')'.$this->dateRange(0,$vardate,"",24); // -- Senin (17/05) | 12 jam 59 menit lalu 
		else return $yr.'-'.$mth.'-'.$dy.' '.$hr.':'.$mi.':'.$ss;   								// -- 2010-12-31 00:00:00 
	}  
	function dateRange($mode=0,$datePub="",$dateNow="",$timeMax=2){
		if(empty($datePub)) $datePub=date("Y-m-d H:i:s");	
		if(empty($dateNow)) $dateNow=date("Y-m-d H:i:s");
		$strText=$strText1=$strText2=$strText3=''; 	
		$foo1 = strtotime($dateNow);
		$yy11 = date("Y",$foo1);		$hh11 = date("H",$foo1);
		$mm11 = date("m",$foo1);		$ii11 = date("i",$foo1);
		$dd11 = date("d",$foo1);		$ss11 = date("s",$foo1); 
		$dyz1 = date("z",$foo1);
		$foo2 = strtotime($datePub);
		$yy21 = date("Y",$foo2);		$hh21 = date("H",$foo2);
		$mm21 = date("m",$foo2);		$ii21 = date("i",$foo2);
		$dd21 = date("d",$foo2);		$ss21 = date("s",$foo2); 
		$dyz2 = date("z",$foo1);
		$tttime1 = mktime($hh11,$ii11,$ss11,$mm11,$dd11,$yy11);
		$tttime2 = mktime($hh21,$ii21,$ss21,$mm21,$dd21,$yy21); 
		$hournya = ($tttime1-$tttime2)/60/60;
		$jamnya  = floor($hournya); 
		$minnya  = ($tttime1-$tttime2) - $jamnya*3600;
		$minnya  = floor($minnya/60);
		$secnya  = ($tttime1-$tttime2) ;
		if($jamnya<$timeMax){
			if($jamnya>0)  $strText1 .=  $jamnya.' jam '; 
			if($minnya>0)  $strText2 .=  $minnya.' menit ';  
			if($secnya<60 && $secnya>0) $strText3  =  $secnya.' detik '; 	 
			if(strlen($strText1)>0||strlen($strText2)>0||strlen($strText3)>0)
			$strText .= ' | '.$hh21.':'.$ii21.' WIB. <span class="nDate"> '.$strText1.$strText2.$strText3.' lalu.</span>'; 
			else 
			$strText .= ' | '.$hh21.':'.$ii21.' WIB.'; 
		}

		if($mode==1) return $strText = $strText1.$strText2.$strText3.' lalu.';
		else 		 return $strText; 
	} 
	//-- /functions date time
	
	function cutstr($string, $charcount) {
		$x = '';
		$countspace = $charcount - 1 ; 
		if (strlen($string) > $charcount) {
			while ($x != ' ') {
				$x = substr($string,$countspace,1);
				$countspace--;
			}
			return substr($string,0, $countspace + 1)."..";	 //return substr($string,0,$charcount)."...";
		}
		else { return $string; }
	}
	function linkDetailNews($id=0,$str=""){ 
		//if($str=='') return 'http://'.$_SERVER['HTTP_HOST'].'/';
		//else return 'http://'.$_SERVER['HTTP_HOST'].'/detil/berita/'.$id.'/'.url_title($str);
		if($str=='') return '/';
		else return '/detil/berita/'.$id.'/'.url_title($str);
	} 
	function valPath($str=""){ 
		$str = str_replace(" ","_",$str);
		$str = str_replace("-","_",$str);
		$str = str_replace("&","n",$str);
		return strtolower($str); 
	} 
	function linkPathSection($section){
		$strLinkPath = '';
		$q = $this->db->query("
			Select  
			a.ID as ParentID,
			a.Name as ParentName,
			coalesce(b.ID,a.ID) SectionID, 
			coalesce(a.Name,b.Name) SectionName,   
			LCASE(REPLACE(REPLACE(REPLACE(concat('/',a.Name,'/',coalesce(b.Name,'')),' ','_'),'&','n'),'-','_')) strPath  
			from sectiontable a 
			left outer join sectiontable b on b.ParentID=a.ID 
			Where a.ParentID=0 
			And coalesce(b.ID,a.ID) = ".$section."
			And coalesce(b.Type,a.Type) = 0 
			limit 1 "); 
		if($q->num_rows()){  
			$row = $q->row_array(); 
			$strLinkPath = $row['strPath']; 
		}else{ 
			$q2 = $this->db->query("select ID,Name, LCASE(REPLACE(REPLACE(REPLACE(concat('/',Name),' ','_'),'&','n'),'-','_')) strPath from sectiontable a 
			where (a.ID = ".$section." AND a.ParentID = 0) OR ( a.ID in (select ParentID from sectiontable where ID = ".$section.") )
			limit 1 "); 
			if($q2->num_rows()){ 
				$row2 =  $q2->row_array();
				$strLinkPath = $row2['strPath']; 
			} 
		}
		return $strLinkPath; 		
		
		//$str = strtolower($name);
		//$str = str_replace(" ","_",$str);
		//$str = str_replace("-","_",$str);
		//return $str = "/".$str;
		 
	}
	
	function toolTipVars($date,$titl,$teas,$id){
		$foo['href'] = $this->linkDetailNews($id,$titl);
		$foo['date'] = $this->formatDateTime($date,3);
		$foo['title'] = htmlspecialchars($titl);
		$foo['teaser'] = str_replace("'","\'",htmlspecialchars(str_replace("\n","<br>",$teas))); 
		$foo['teaser2'] = str_replace("'","'",$foo['teaser']);
		return $foo;
	}
	//--------------------------------------------
	function cari_dosen($limit,$offset,$nama)
	{
		$q = $this->db->query("SELECT newstable.*, phototable.ID AS PID, phototable.Path, phototable.Format, newsxphototable.* 
FROM (`newstable`) LEFT JOIN `newsxphototable` ON `newsxphototable`.`NewsID` = `newstable`.`ID` 
LEFT JOIN `phototable` ON `phototable`.`ID`=`newsxphototable`.`PhotoID` where newstable.Title like '%$nama%' AND newstable.StatusID = '3' ORDER BY newstable.PublishedDate desc LIMIT $offset,$limit");
		return $q;
	}
	function tot_hal($tabel,$field,$kata)
	{
		$q = $this->db->query("select * from $tabel where $field like '%$kata%'");
		return $q;
	}
	function indx_terkini($limit,$offset,$SecID)
	{
		$q = $this->db->query("SELECT newstable.*, phototable.ID AS PID, phototable.Path, phototable.Format, 
newsxphototable.*, sectiontable.ID as SecID, sectiontable.ParentID, 
sectiontable.LineAge FROM (`newstable`,`sectiontable`) 
LEFT JOIN `newsxphototable` ON `newsxphototable`.`NewsID` = `newstable`.`ID` 
LEFT JOIN `phototable` ON `phototable`.`ID`=`newsxphototable`.`PhotoID` 
where newstable.SectionID<200 and LineAge like '%$SecID%' and SectionID=sectiontable.ID and newstable.StatusID=3 order by newstable.PublishedDate desc LIMIT $offset,$limit");
		return $q;
	}
	function tot_hal_terkini($tabel,$field,$kata)
	{
		$q = $this->db->query("select * from $tabel,sectiontable where $field=sectiontable.ID and sectiontable.LineAge like '%$kata%' and $tabel.StatusID=3");
		return $q;
	}

	
	function getTerpopuler() { 
	/*$this->db->select('newstable.ID, newstable.Title, newstable.Content, newstable.PublishedDate, newstable.StatusID, sum(newsstatistictable.ReadCount) as Total', FALSE);
	$this->db->join('newsstatistictable', 'newsstatistictable.NewsID = newstable.ID');
	$this->db->group_by('NewsID');
	$this->db->order_by('Total', 'desc');
	$this->db->limit('10');
	$res=$this->db->get_where('newstable', array('StatusID'=>'3'));*/
	$res=$this->db->query("SELECT `NewsID`,SUM(`ReadCount`) as TOTAL, newstable.ID,newstable.Title,newstable.PublishedDate 
		FROM `newsstatistictable`,newstable WHERE newstable.ID=newsstatistictable.NewsID AND newstable.StatusID=3 AND newstable.PublishedDate >= DATE_ADD(DATE(NOW()),INTERVAL -14 DAY)
		GROUP BY `NewsID` ORDER BY TOTAL DESC LIMIT 10 ");
	return $res->result();	
	} 
	//--terpopuler
	
	function getTerpopuler_kanal($sect,$lim) { 
	$res=$this->db->query("SELECT `NewsID`,SUM(`ReadCount`) as TOTAL, newstable.ID,newstable.Title,newstable.PublishedDate,newstable.Teaser
		FROM `newsstatistictable`,newstable,sectiontable WHERE newstable.ID=newsstatistictable.NewsID AND newstable.StatusID=3 
		AND sectiontable.LineAge like '%$sect%'
		AND sectiontable.ID=newstable.SectionID
		AND newstable.PublishedDate >= DATE_ADD(DATE(NOW()),INTERVAL -14 DAY)
		GROUP BY `NewsID` ORDER BY TOTAL DESC LIMIT $lim ");
	return $res->result();	
	} 

	function getKlasemen($liga){
		$res=$this->db->query("select * from klasemen where liga like '%$liga%'");
		return $res->result();
	}
	function getHasil($liga){
		$res=$this->db->query("select * from hasil_skorer where liga like '%$liga%' and section='hasil'");
		return $res->result();
	}
	function getSkorer($liga){
		$res=$this->db->query("select * from hasil_skorer where liga like '%$liga%' and section='skorer'");
		return $res->result();
	}
}
?>