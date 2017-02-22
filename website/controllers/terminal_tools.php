<?php  
//session_start();  
class Terminal_tools extends Controller { 
	function Terminal_tools(){   
		parent::Controller(); 
		$this->load->helper('url'); 
		$this->load->model('allmodel'); 
		$this->load->library('allfunc');  
		$this->load->database(); 
		$this->load->library('session'); 
		//if(!$this->session->userdata('logged_in')) redirect('login','refresh');
		  
	} 
	function index(){   
 		echo "Hello U";  
	} 
	
	function mainvars($ci_func='',$status_id=1,$limit=10){  
	
		$_ci_func	= $ci_func;
		$_status_id	= $status_id;
		$_limit		= $limit;
		
		$data = $this->allfunc->reflector(__CLASS__,$ci_func); 
 
		$data['navMenu']   	= $this->allfunc->navMenu(9);  
		$data['ci_menu'] 	= $this->allfunc->navMenu(9,1);
		$data['ci_ctrl'] 	= strtolower(__CLASS__);  
     	$data['ci_func']	= $_ci_func; 
		$data['TABLE'] 		= $_ci_func;   
		$strTable 			= ucwords(str_replace("_"," ",$data['TABLE'])); 
		
     	$data['status_id'] 	= $_status_id;  
     	$data['limit'] 		= $_limit;  
		
     	$data['pageTITLE']	= ucwords(str_replace("_"," ",$data['ci_ctrl'].' - '.str_replace("Md ","",$strTable)));  
     	$data['pageLABEL'] 	= ucwords(str_replace("_"," ",$data['ci_menu'].' > '.str_replace("Md ","",$strTable)));  
 
		return $data;
		  
		//echo __CLASS__;  
		//echo __FUNCTION__; 	exit;
		//echo __METHOD__; 		exit; //Dealer_terminal::mainvars

	} 

	function remote_command($tid=0){   
	 
		$data = $this->mainvars(__FUNCTION__);
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;  
	
     	$data['pageTITLE']	= 'Lunari Web Admin - Terminal Tools'; 
     	$data['pageLABEL'] 	= 'Terminal Tools > Remote Command';
		 
		$data['qTerminal'] 	= $this->allmodel->getVendingTerminal(0);  
		$data['tid']  		= $tid; 
		$data['clss']  		= "remote_command"; 
		$qdata = $this->allmodel->getVendingTerminal($tid); 
		if($qdata->num_rows()){
			$qresdata = $qdata->result_array();  
			$data['rowtid'] = $qresdata[0];   
		} 
		if(!isset($data['rowtid'])) $data['rowtid']['IP'] = '';
		$this->load->view('terminal_tools/tools_viewer',$data); 
 
	}  

	function update_video($tid=0){ 
	 
		$data = $this->mainvars(__FUNCTION__);
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;  
 
		$data['clss']  		= "video"; 
		$data['qMedia'] 	= $this->allmodel->getMediaDB(0,$data['clss']); 
		$data['qTerminal'] 	= $this->allmodel->getVendingTerminal(0);
 
		$qdata = $this->allmodel->getVendingTerminal($tid);  
		if( $qdata->num_rows() ){
			$qresdata = $qdata->result_array();  
			//$data['rowtid'] = $qresdata[0]; 
			foreach( $qdata->result_array() as $row)
			foreach($row as $key => $val){ //echo "<br>$key => $val";
				$data[$key] 		 	= $val;
				//$data['IP'] 		 	= $row['IP']; 
				//$data['terminal_ID']	= $row['terminal_ID']; 
				//$data['terminal_owner'] = $row['terminal_owner']; 
			} 
		}
		//if(!isset($data['rowtid'])) $data['rowtid']['ip'] = '';
 
		$this->load->view('terminal_tools/tools_viewer',$data); 
	}
	
	

	function update_patch($tid=0){ 
	 
		$data = $this->mainvars(__FUNCTION__);
		foreach($data as $key => $val) if(isset($$key)) $data[$key] = $$key;  
 
		$data['clss']  		= "patch"; 
		$data['qMedia'] 	= $this->allmodel->getMediaDB(0,$data['clss']); 
		$data['qTerminal'] 	= $this->allmodel->getVendingTerminal(0);
 
		$qdata = $this->allmodel->getVendingTerminal($tid);  
		if( $qdata->num_rows() ){
			$qresdata = $qdata->result_array();  
			//$data['rowtid'] = $qresdata[0]; 
			foreach( $qdata->result_array() as $row)
			foreach($row as $key => $val){ //echo "<br>$key => $val";
				$data[$key] 		 	= $val;
				//$data['IP'] 		 	= $row['IP']; 
				//$data['terminal_ID']	= $row['terminal_ID']; 
				//$data['terminal_owner'] = $row['terminal_owner']; 
			} 
		}
		//if(!isset($data['rowtid'])) $data['rowtid']['ip'] = '';
 
		$this->load->view('terminal_tools/tools_viewer',$data); 
	}
	
 
	function update_remote_command($tid=0){   
	
     	$data['pageTITLE']	= 'Lunari Web Admin - Terminal Tools'; 
     	$data['pageLABEL'] 	= 'Terminal Tools > Remote Command';
		$data['navMenu']   	= $this->allfunc->navMenu(9);  
		$data['qTerminal'] 	= $this->allmodel->getVendingTerminal(0);  
		$data['tid']  		= $tid; 
		$data['clss']  		= "remote_command"; 
		$qdata = $this->allmodel->getVendingTerminal($tid); 
		if($qdata->num_rows()){
			$qresdata = $qdata->result_array();  
			$data['rowtid'] = $qresdata[0]; 
			foreach( $qresdata[0] as $key=>$value) $data[$key] = $value; 
		}
		
		//echo $data['rowtid']['IP'];
		//echo $data['rowtid']['terminal_ID'];
		//if(!isset($data['rowtid'])) $data['rowtid']['IP'] = '';
		$this->load->view('terminal_tools/tools_viewer',$data); 
 
	}  
  
	
	function media_database($type='video',$status_id=1, $curpage=1,$limit=10,$sort="id",$order="desc",$ci_ctrl="terminal_tools",$ci_func="media_database",$ci_changePage="changepage",$result_id="dspdata"){  
  
	
     	$data['pageTITLE']	= 'Lunari Web Admin - Terminal Tools'; 
     	$data['pageLABEL'] 	= 'Terminal Tools > Media Database';
		$data['navMenu']   	= $this->allfunc->navMenu(9);   
		
		$data['type']  		= $type; 
		$data['status_id']  = $status_id;
		  
		$data['indexData']  = $this->indexData($type,$curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_func,$ci_changePage,$result_id);

		$this->load->view('terminal_tools/media_database',$data); 
 
   
	}  
	
	function media_delete($id='0',$curpage=1,$limit=10,$status_id=1,$sort="id",$order="desc",$ci_ctrl="terminal_tools",$ci_func="media_database",$ci_changePage="changepage",$result_id="dspdata",$type=""){  
		//media_delete/'.$row['ID'].'/'.$curpage.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_func.'/'.$ci_changePage.'/'.$result_id.'/'.$type
 
 		if(!empty($id)) $this->db->query("update media_database set status_id = '0' where id=".$id);
		
		$data['data'] = $this->indexData($type,$curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_func,$ci_changePage,$result_id);
		 
		$this->load->view('data_view',$data);
 
	}
	function media_save($id='0',$tit='',$curpage=1,$limit=10,$status_id=1,$sort="id",$order="desc",$ci_ctrl="terminal_tools",$ci_func="media_database",$ci_changePage="changepage",$result_id="dspdata",$type=""){  
 		$tit = urldecode($tit);
 		$status_id = 1;
		
 		if(!empty($id) && !empty($tit)) $this->db->query("update media_database set `title` = '".$tit."', `status_id` = '".$status_id."' where id=".$id);
		 
		$url = base_url().'terminal_tools/media_database/'.$type.'/'.$status_id.'/'.$curpage.'/'.$limit.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_func.'/'.$ci_changePage.'/'.$result_id;
 		echo '<meta http-equiv="refresh" content="0;URL='.$url.'">';
		//redirect($url,'refresh');
	}
	
	function sendmedia($mediaid='',$filename='',$type='',$totip='',$totid=''){  
	//14/mandiri.mp4/video/025.100.127.173/210-00-000-0-111
		//echo "($mediaid ,$type ,$toip ,$tovmid ,$id )";
 
		$this->load->library('funcsocket'); 
 
		if($type=='video') $data['response']	= "0016000001RQ16010101";
		
		$totip = "127.0.0.1"; //--temp
		
		$req = $this->funcsocket->sendmediabysocket($totip,$totid,$data['response']);
		echo $req;
		
	}
	
	
	function uploadmedia(){
	   	$tipe = $_POST['slcTipe'];
	   	$tit = $_POST['txtTitle'];
		$goUpload = 0;
	   	if(!empty($tipe)){
	   
	   		if (is_uploaded_file($_FILES['file']['tmp_name'])) {
			   //echo "File ". $_FILES['file']['name'] ." uploaded successfully.\n";
			   
				$upload_path  = $this->createDir($tipe);
					
				$type 			= $tipe;
				$title 			= $tit;
				$file 			= $_FILES['file']['name'];
				$format 		= $_FILES['file']['type'];
				 
				$s = round($_FILES['file']['size']/1000000,2);
				$size = $s."Mb";
				if(!$s) {
					$s2 = round($_FILES['file']['size']/1000,2); 
					$size = $s2."Kb"; 
				}
				$created_date 	= date('Y-m-d H:i:s');
				$created_by  	= $this->session->userdata('ID');
				$status_id 	 	= 1;
					
			 	if($tipe=="video"){
					//foreach($_FILES['file'] as $k => $v) echo "<br>$k => $v";
					//name => Focus Self Service Payment Kiosk.mp4
					//type => video/mp4
					//tmp_name => D:\xampp\tmp\php138.tmp
					//error => 0
					//size => 13479002
					$ext = substr($_FILES['file']['name'],strlen(trim($_FILES['file']['name']))-3,3);
					
					if($ext=="mpg"||$ext=="flv"||$ext=="avi"||$ext=="mp4"||$ext=="3gp"){ //
				 
					 /**
					 * FFMPEG-PHP Test Script
					 *
					 * Special thanks to http://www.sajithmr.me/ffmpeg-sample-code for this code example!
					 * See the tutorial at http://myownhomeserver.com on how to install ffmpeg-php.
					 */
					// Check if the ffmpeg-php extension is loaded first
					extension_loaded('ffmpeg') or die('Error in loading ffmpeg');
		
					// Determine the full path for our video
					$vid = realpath($_FILES['file']['tmp_name']);
		
					//error_reporting(E_ALL & ~E_NOTICE);
					
					// Create the ffmpeg instance and then display the information about the video clip.
					$ffmpegInstance = new ffmpeg_movie($vid);
					/*
					echo "getDuration: " . $ffmpegInstance->getDuration() . "<br />".
					"getFrameCount: " . $ffmpegInstance->getFrameCount() . "<br />".
					"getFrameRate: " . $ffmpegInstance->getFrameRate() . "<br />".
					"getFilename: " . $ffmpegInstance->getFilename() . "<br />".
					"getComment: " . $ffmpegInstance->getComment() . "<br />".
					"getTitle: " . $ffmpegInstance->getTitle() . "<br />".
					"getAuthor: " . $ffmpegInstance->getAuthor() . "<br />".
					"getCopyright: " . $ffmpegInstance->getCopyright() . "<br />".
					"getArtist: " . $ffmpegInstance->getArtist() . "<br />".
					"getGenre: " . $ffmpegInstance->getGenre() . "<br />".
					"getTrackNumber: " . $ffmpegInstance->getTrackNumber() . "<br />".
					"getYear: " . $ffmpegInstance->getYear() . "<br />".
					"getFrameHeight: " . $ffmpegInstance->getFrameHeight() . "<br />".
					"getFrameWidth: " . $ffmpegInstance->getFrameWidth() . "<br />".
					"getPixelFormat: " . $ffmpegInstance->getPixelFormat() . "<br />".
					"getBitRate: " . $ffmpegInstance->getBitRate() . "<br />".
					"getVideoBitRate: " . $ffmpegInstance->getVideoBitRate() . "<br />".
					"getAudioBitRate: " . $ffmpegInstance->getAudioBitRate() . "<br />".
					"getAudioSampleRate: " . $ffmpegInstance->getAudioSampleRate() . "<br />".
					"getVideoCodec: " . $ffmpegInstance->getVideoCodec() . "<br />".
					"getAudioCodec: " . $ffmpegInstance->getAudioCodec() . "<br />".
					"getAudioChannels: " . $ffmpegInstance->getAudioChannels() . "<br />".
					"hasAudio: " . $ffmpegInstance->hasAudio();
					
					getDuration: 50.2719993591 
					getFrameCount: 3004
					getFrameRate: 59.75
					getFilename: D:\xampp\tmp\php155.tmp
					getComment:
					getTitle:
					getAuthor:
					getCopyright:
					getArtist:
					getGenre:
					getTrackNumber: 0
					getYear: 0
					getFrameHeight: 240
					getFrameWidth: 290
					getPixelFormat: yuv420p
					getBitRate: 8000
					getVideoBitRate:
					getAudioBitRate: 8000
					getAudioSampleRate: 22050
					getVideoCodec: flv
					getAudioCodec: mp3
					getAudioChannels: 2
					hasAudio: 1
					*/ 
					$format 		= $ffmpegInstance->getVideoCodec();
					$dimension 		= $ffmpegInstance->getFrameHeight()."X".$ffmpegInstance->getFrameWidth()."pixel";
					$durasi 		= round($ffmpegInstance->getDuration())."sec";
					
					
					//error_reporting(E_ALL);
					} else { echo "Error... The video file is NOT allowed formats."; exit; }
 
					$frfile = $_FILES["file"]["tmp_name"];
					$tofile = $upload_path.$_FILES["file"]["name"]; 
					move_uploaded_file($frfile,$tofile); 
					$file = $tofile;
						$goUpload = 1;
 
			  	} 
			 	elseif($tipe=="image"){
					//foreach($_FILES['file'] as $k => $v) echo "<br>$k => $v"; 
					$dim 		= getimagesize($_FILES['file']['tmp_name']);
					//foreach($s as $k => $v) echo "<br>$k => $v"; 
					$dimension 	= "w:".$dim[0]." X "."h:".$dim[1]."pixel";
					$durasi 	= ''; 
					if(empty($dim[0])) { echo "Error... The file is NOT Image!"; exit; } 
					else{
 
						$frfile = $_FILES["file"]["tmp_name"];
						$tofile = $upload_path.$_FILES["file"]["name"]; 
						move_uploaded_file($frfile,$tofile); 
						$file = $tofile;
						$goUpload = 1;
					}
				} 
				elseif($tipe=="patch"){  
					$dim 		= '';//getimagesize($_FILES['file']['tmp_name']); 
					$dimension 	= '';//"w:".$dim[0]." X "."h:".$dim[1]."pixel";
					$durasi 	= ''; 
					
					$frfile = $_FILES["file"]["tmp_name"];
					$tofile = $upload_path.$_FILES["file"]["name"]; 
					move_uploaded_file($frfile,$tofile); 
					$file = $tofile;
					$goUpload = 1;
				}
				
				if($goUpload){
				$q = ("insert into media_database(`type`,`title`,`file`,`format`,`size`,`dimension`,`durasi`,`created_date`,`created_by`,`status_id`) 
				Values('".$type."','".$title."','".$file."','".$format."','".$size."', '".$dimension."','".$durasi."','".$created_date."','".$created_by."','".$status_id."')");
				$this->db->query($q);
				}
		 		echo '<meta http-equiv="refresh" content="0;URL=/terminal_tools/media_database/'.$type.'/1">';
	 
			} else {
			   echo "Possible file upload attack: "; exit; 
			   //echo "filename '". $_FILES['file']['tmp_name'] . "'.";
			}
			 

 
		}else{
			echo "Belum pilih tipe media!";  exit; 
		}
	}
 
	
	function createDir($type)
	{
		$year=date('Y');
		$month=date('m');
		$day=date('d');
		if(!is_dir('./upload/')){
			mkdir('./upload/',0777);
		}
		if(!is_dir('./upload/media/')){
			mkdir('./upload/media/',0777);
		}
		if(!is_dir('./upload/media/'.$type.'')){
			mkdir('./upload/media/'.$type.'',0777);
		}
		if(!is_dir('./upload/media/'.$type.'/'.$year)){
			mkdir('./upload/media/'.$type.'/'.$year,0777);
		}
		if(!is_dir('./upload/media/'.$type.'/'.$year."/".$month)){
			mkdir('./upload/media/'.$type.'/'.$year."/".$month,0777);
		}
		if(!is_dir('./upload/media/'.$type.'/'.$year."/".$month."/".$day)){
			mkdir('./upload/media/'.$type.'/'.$year."/".$month."/".$day,0777);
		}
		return $dirupload='./upload/media/'.$type.'/'.$year.'/'.$month.'/'.$day.'/';
	}
	
  	function indexData($type,$curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_func,$ci_changePage,$result_id){ 
	 
		if($order=="asc") $orderO="desc";
		elseif($order=="desc") $orderO="asc";
		 
		$content=$disableAll='';
		
		$start=($curpage*$limit)-$limit;
 
		$x=0;
		if($start >= 0){
 
			$qData=$this->allmodel->selectMediaDB($start,$limit,$status_id,$sort,$order,$type); 
			
			if($qData->num_rows()){ 
				$col1 = "#ffffff";
				$col2 = "#f6f6f6";
				$col3 = "#FFDDFF";
				 
				//if($this->session->userdata('AccessType')=='admin') $disableAll = ''; 
				//if($this->session->userdata('AccessType')=='user')  $disableAll = ' disabled="disabled" '; 
				 
				 		$content.=
						'<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#bbbbbb"> 
							<tr bgcolor="#666666" class="style4 lightgrey"> 
							  <td><span class="lightgrey">No.</span></td>   
							  <td><a class="lightgrey" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$ci_func.'/'.$type.'/'.$status_id.'/1/'.$limit.'/type/'.$orderO.'\')">type</a></td>
							  <td><a class="lightgrey" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$ci_func.'/'.$type.'/'.$status_id.'/1/'.$limit.'/title/'.$orderO.'\')">title</a></td> 
							  <td><a class="lightgrey" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$ci_func.'/'.$type.'/'.$status_id.'/1/'.$limit.'/format/'.$orderO.'\')">format</a></td>
							  <td><a class="lightgrey" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$ci_func.'/'.$type.'/'.$status_id.'/1/'.$limit.'/size/'.$orderO.'\')">size</a></td>
							  <td><a class="lightgrey" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$ci_func.'/'.$type.'/'.$status_id.'/1/'.$limit.'/dimension/'.$orderO.'\')">dimension</a></td>
							  <td><a class="lightgrey" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$ci_func.'/'.$type.'/'.$status_id.'/1/'.$limit.'/durasi/'.$orderO.'\')">durasi</a></td>
							  <td><a class="lightgrey" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$ci_func.'/'.$type.'/'.$status_id.'/1/'.$limit.'/created_date/'.$orderO.'\')">created_date</a></td>
							  <td><a class="lightgrey" href="javascript:void(0);window.location.assign(\''.base_url().$ci_ctrl.'/'.$ci_func.'/'.$type.'/'.$status_id.'/1/'.$limit.'/created_by/'.$orderO.'\')">created_by</a></td>
							  <td align="center" nowrap="NOWRAP" colspan="2" ><span class="lightgrey">Edit</span></td>  
							</tr> 
						<tbody>';
				 
				 
				$x=$start+1;
				foreach($qData->result_array() as $row){
					$n = fmod($x,2); 
					if($n) $clr = $col1;
					else   $clr = $col2;
					   
					$disable = ''; 
					$disable2 = '';  
					//if( $row['AccessType']=='user' && $this->session->userdata('AccessType')=='user')  $disable2 = ' disabled="disabled" ';  
					//if( $row['AccessType']=='user') 	 $strAccessType =  "Limited";
					//elseif( $row['AccessType']=='admin') $strAccessType =  "Administrator";
					//if( $row['GroupID']==0) 			 $strGroupID =  "";
					//elseif( $row['GroupID']==1) 		 $strGroupID =  "Lunari";
					//if($row['status_id']) $sid = "ONLINE"; else echo $sid = "offline"; 
					
					$content.='<tr bgcolor="'.$clr.'">
					 
      				  <form action="/terminal_tools/media_database_qedit" method="post"> 
					  <td align="right">'.$x.'.&nbsp;</td> 
					  <td>'.$row['type'].'</td>
					  <td><input id="title_'.$row['id'].'" name="title_'.$row['id'].'" type="text" value="'.$row['title'].'" size="30" />
					  	<br><div class="orange pad5" style="font:normal 11px arial">File : '.$this->allmodel->cutstr($row['file'],100).'</div>
					  </td> 
					  <td>'.$row['format'].'</td>
					  <td>'.$row['size'].'</td>
					  <td>'.$row['dimension'].'</td>
					  <td>'.$row['durasi'].'</td>
					  <td>'.$row['created_date'].'</td>
					  <td>'.$this->allmodel->getUserNamebyID($row['created_by']).'</td> 
					  <td><input '.$disable.'  type="button" name="SAVE" value="SAVE" onclick="window.location.assign(\''.base_url().$ci_ctrl.
					  '/media_save/'.$row['id'].'/'.('\'+$(\'input#title_'.$row['id'].'\').val()+ \'').'/'.$curpage.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_func.'/'.$ci_changePage.'/'.$result_id.'/'.$type.'\')"/></td>
					   
					 
					  
					  <td><input '.$disable2.' type="button" name="DEL"  value="DEL"  onclick="confirmdelete(\''.base_url().$ci_ctrl.'/media_delete/'.$row['id'].'/'.$curpage.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_func.'/'.$ci_changePage.'/'.$result_id.'/'.$type.'\',\''.$result_id.'\')"/></td>';
					//if($this->session->userdata('ID')==1 || $this->session->userdata('ID')==2 || $this->session->userdata('ID')==$row['ID'] || $this->session->userdata('AccessType')=='admin')   
					//$content.='<input '.$disable.' type="button" name="EDIT" value="EDIT" onclick="window.location.assign(\''.base_url().$ci_ctrl.'/user_edit/'.$row['ID'].'\')"/>';
					//$content.='</td>';
					//$content.='<td>';
					//if($this->session->userdata('ID')==1 || $this->session->userdata('ID')==2 || $this->session->userdata('AccessType')=='admin'){   
					//if($status_id!=2) 
					//$content.='<input '.$disable2.' type="submit" name="DEL" value="DEL" onclick="confirmdelete(\''.base_url().$ci_ctrl.'/user_delete/'.$row['ID'].'/'.$curpage.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_changePage.'/'.$result_id.'\',\''.$result_id.'\')"/>';
					//}
					//$content.='</td>'; 
					$content.='</form>';  
					$content.='</tr>'; 
					$x++;
				}	
			}
		}
		$content.='</tbody>';
		$content.='</table>';		
		
		if($x)
		$content.=$this->pagenav($curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_func,$ci_changePage,$result_id,$type);

		return $content;
	} 
	
	function pagenav($curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_func,$ci_changePage,$result_id,$type){

		$cData=$this->allmodel->countMediaDB($type,$status_id); 
		
		$var='<div class="pagenave">';
		if($cData->num_rows()){
			$tempData=$cData->result_array();
			$totalData=$tempData[0]['count'];
			$totalPage=ceil($totalData/$limit);
			
			if(($curpage-1)>0){
				$prev=($curpage-1);
			}else{
				$prev=$curpage;
			}
			if(($curpage+1) < $totalPage){
				$next=($curpage+1);
			}else{
				$next=$totalPage;
			} 
	 		$var.='<table width="100%" cellpadding="0" cellspacing="5" border="0">
			  		<tr>';
					
			$var.='		<td nowrap="nowrap" style="border-right:1px dotted grey">';
				$var.='<a href="javascript:void(0);loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/'.$prev.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_func.'/'.$ci_changePage.'/'.$result_id.'/'.$type.'\',\''.$result_id.'\')"><img src="/asset/icons/arrow_left.gif" width="16" height="16" />prev</a>';
				$var.='&nbsp; &nbsp;'; 
				$var.='<a href="javascript:void(0);loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/'.$next.'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_func.'/'.$ci_changePage.'/'.$result_id.'/'.$type.'\',\''.$result_id.'\')">next<img src="/asset/icons/arrow_right.gif" width="16" height="16" /></a>';
				$var.='&nbsp; &nbsp;'; 
			
			$var.='		</td>';
				
			$var.='		<td width="100%" nowrap="nowrap" >';
							$var.='&nbsp; &nbsp;Page: <select name="page" id="page" onchange="loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/\'+$(this).val()+\'/'.$limit.'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_func.'/'.$ci_changePage.'/'.$result_id.'/'.$type.'\',\''.$result_id.'\')">'; 
				for($i=1;$i<=$totalPage;$i++){
					$var.='<option value="'.$i.'"';
					if($curpage==$i){
						$var.=' selected';
					}
					$var.='>'.$i.'</option>';
				}
				$var.='</select>';
				$var.=' of <b>'.$totalPage.'</b> pages &nbsp;-&nbsp; ';			
				$var.='Total <strong>'.$totalData.'</strong> records found.';
			$var.='		</td>';  
			$var.='		<td align="right" nowrap="nowrap" >';
				$var.='Show <select name="view" id="view" onchange="loadcontent(\''.base_url().$ci_ctrl.'/'.$ci_changePage.'/1/\'+$(this).val()+\'/'.$status_id.'/'.$sort.'/'.$order.'/'.$ci_ctrl.'/'.$ci_func.'/'.$ci_changePage.'/'.$result_id.'/'.$type.'\',\''.$result_id.'\')" >';
				$arrView=array(10,20,50,100);
				foreach($arrView as $val){
					$var.= '<option value="'.$val.'"';  
					if($limit==$val){
						$var.=' selected';
					}
					$var.='>'.$val.'</option>';  
				}
				$var.='</select> item/page';
			$var.='		</td>'; 
			$var.='	</tr> 
				   </table>';
 
			 
		}
		$var.='</div>';
		return $var;
	} 
	function changepage($curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_func,$ci_changePage,$result_id,$type){	
		//echo "data['data']=this->data($curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$result_id)";
		$data['data']=$this->indexData($type,$curpage,$limit,$status_id,$sort,$order,$ci_ctrl,$ci_func,$ci_changePage,$result_id);
		 
		$this->load->view('data_view',$data);
	} 
}
