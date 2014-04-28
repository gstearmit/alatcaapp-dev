<?php
class Administrator_EditertemplateController extends Zend_Controller_Action {

	private $urlProject = "ThemeEditer/themeMagazine/";
	private $urlhttpIframe = "http://";
	private $dir = "";
	
	public function init() {
	
		$idaddress = $this->getIpaddress();
		$exName = $this->checkexplore();
		$getinforobj = new HT_Model_administrator_models_inforproject();
		$datapro = $getinforobj->getInfor($idaddress, $exName);
	
// 		if($datapro == false){
// 			echo 'ip nay chua duoc khoi tao bao gio';
// 			// $messager =   $this->copyProject();
// 			// echo $messager;
// 		}
	
		if ($datapro > 0) {
			$this->urlProject = "Theme/".$datapro["projectname"];
		}
		$this->dir = $this->loaddirroot();
	
// 		echo'</br>';
// 		echo 'dir';
// 		var_dump($this->dir);
	
		$this->urlhttpIframe.= $_SERVER['HTTP_HOST'] . "/";
		//echo "bug";
		parent::init();
	}
	
	
	private function loaddirroot() {
		$root = $_SERVER['DOCUMENT_ROOT'] . "/";
		return $root;
	}
	
	public function alldirectoryAction()
	{
		$array_All_Dir = $this->dir_list($this->dir ."/ThemeEditer");
		echo '<pre>';
		print_r($array_All_Dir);
		echo '</pre>';
		die();
	}
	
	public function creatinforprojectAction() {
		echo "Dang tien hanh xu li";
		//if ($this->_request->isPost()) {
		$getinfor = new HT_Model_administrator_models_inforproject();
		$data = $this->_request->getParam('cthtml');
		$urlwfile = $this->_request->getParam('urlfile');
		//khoi tao thong tin neu chua co.
		//Kiem tra xem da ton tai chua
		$idaddress = $this->getIpaddress();
		$exName = $this->checkexplore();
		$projectName = $exName . $idaddress;
		$foldername = $getinfor->checkfolder($projectName);
		if ($foldername == null) {
	
			$datapro = $getinfor->getInfor($idaddress, $exName);
			if ($datapro != null) {
				//da ton tai
			} else {
				//chua ton tai thi khoi tao thong tin moi
				$addInfor = $getinfor->insertporject($idaddress, $exName, $projectName);
				if ($addInfor) {
					echo "Day la lan dau tien ban tien hanh sua file tren trinh duyet :" . $exName . " va Ip la : " . $idaddress . "<br/>";
					//bat dau tao thu muc va coppy file sang thu muc moi.
					$this->makelistforder($projectName);
					//bat dau ghi de file sang thu muc vua moi tao;
					$this->ghiFileEdit($data, $urlwfile);
					echo "Qua trinh khoi tao thu muc project cua ban da thanh cong !<br/>";
					echo "Ban vui long bam <a href='" . WEB_PATH . "/administrator/editertemplate/index' title=''>vao day</a> de quay lai project cua minh.";
				} else {
					echo "Qua trinh khoi tao that bai.";
				}
			}
		} else {
			//Thu muc da ton tai khong tao them vaf xu lys ghi de luon.
	
			$this->ghiFileEdit($data, $urlwfile);
			echo "File da bi ghi de";
			$this->_redirect($this->urlhttpIframe."/administrator/editertemplate/loadfilehtml?urlfile=".$urlwfile."");
		}
		//} else {
		//echo "Chua bam chua vao nhe.";
		// }
	}
	
	public function ghiFileEdit($data, $filename) {
		$urlfile = $this->dir . $this->urlProject . $filename;
		$ofile = fopen($urlfile, 'w');
		fwrite($ofile, $data);
		fclose($ofile);
	}
	
	public function indexAction() {
		 
	
		$dir = $this->dir. $this->urlProject;
// 	echo '</br>';	echo 'index dir'; var_dump($dir);
		$file = $this->listDirs($dir);
		$this->view->listFile = $file;
		$this->view->dir = $this->dir. $this->urlProject;
		
   
	}
	
	public function listDirs($root) {
		
		$files = array('files' => array(), 'dirs' => array());
		$directories = array();
		$last_letter = $root[strlen($root) - 1];
		$root = ($last_letter == '\\' || $last_letter == '/') ? $root : $root . DIRECTORY_SEPARATOR;
	
		$directories[] = $root;
	
		while (sizeof($directories)) {
			$dir = array_pop($directories);
			if ($handle = opendir($dir)) {
				while (false !== ($file = readdir($handle))) {
					if ($file == '.' || $file == '..') {
						continue;
					}
					$file = $dir . $file;
					if (is_dir($file)) {
						$directory_path = $file . DIRECTORY_SEPARATOR;
						array_push($directories, $directory_path);
						$files['dirs'][] = $directory_path;
					} elseif (is_file($file)) {
						$files['files'][] = $file;
					}
				}
				closedir($handle);
			}
		}
	
		return $files;
	}
	
	public function loadfilehtmlAction() {
	
		$dir = $this->dir. $this->urlProject;
		//$fileName = $this->_request->getParam('namefile');
		$urlfile = $this->_request->getParam('urlfile');
	
		$fileDir = $this->dir. $this->urlProject . "/" . $urlfile;
		echo $fileDir;
		$listline = file($fileDir);
		$listFile = $this->listDirs($dir);
		$this->view->ctdata = $listline;
		$this->view->urlfile = $urlfile;
		$this->view->srcFrame = $this->urlhttpIframe . $this->urlProject . $urlfile;
		$this->view->dir = $this->dir. $this->urlProject;
		$this->view->listFile = $listFile;
	}
	
	public function getIpaddress() {
		$ip = $_SERVER['REMOTE_ADDR'];
	
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		return $ip;
	}
	
	public function dir_list($dir)
	{ 
	    $i=0; 
	    $dl = array(); 
	    if ($hd = opendir($dir))    { 
	        while ($sz = readdir($hd)) {  
	            if (preg_match("/^\./",$sz)==0) $dl[] = $sz;$i.=1;  
	        } 
	    closedir($hd); 
	    } 
	    asort($dl); 
	    return $dl; 
   } 
	
	public function checkexplore() {
		$u_agent = $_SERVER['HTTP_USER_AGENT'];
		$exName = "";
		if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
			$exName = 'ie';
			$ub = "MSIE";
		} elseif (preg_match('/Firefox/i', $u_agent)) {
			$exName = 'ff';
			$ub = "Firefox";
		} elseif (preg_match('/Chrome/i', $u_agent)) {
			$exName = 'gc';
			$ub = "Chrome";
		} elseif (preg_match('/Safari/i', $u_agent)) {
			$exName = 'as';
			$ub = "Safari";
		} elseif (preg_match('/Opera/i', $u_agent)) {
			$exName = 'o';
			$ub = "Opera";
		} elseif (preg_match('/Netscape/i', $u_agent)) {
			$exName = 'ns';
			$ub = "Netscape";
		}
		return $exName;
	}
	
	public function makelistforder($folderBackup) {
		//Khoi tao thu muc se coppy file backup.
		//tao thu muc backup
		if (file_exists($folderBackup)) {
			echo "thu muc da ton tai khong tao them.";
		} else {
			mkdir($this->dir ."Theme/". $folderBackup);
		}
	
		//tao 1 danh sach thu muc
		$dir = $this->dir . $this->urlProject;
		$listFile = $this->listDirs($dir);
		foreach ($listFile["dirs"] as $key => $data) {
			//lay ve ten thu muc goc.
			$dirurl = $listFile["dirs"][$key];
				
			//loai bo duong dan toi profect html chi lay cac duong dan thu muc con ben trong.
			$onlyFolder = str_replace($this->dir . $this->urlProject, "", $dirurl);
				
			$abc = str_replace("\\", "/", $onlyFolder);
			echo $abc . "------";
			//lay ten thu muc cuoi cung.
			$split = explode("/", $abc);
	
			$countDir = count($split) - 2;
			$thumucluicap = "";
			for ($i = 0; $i < count($split); $i++) {
				if ($i < $countDir) {
					$thumucluicap.=$split[$i] . "/";
				}
				if ($i == $countDir) {
					$folderlast = $split[$i];
					$checkexitFolder = file_exists($this->dir ."Theme/". $folderBackup . "/" . $folderlast);
					if ($checkexitFolder > 0) {
						echo "Thu muc nay da ton tai rui.<br/>";
					} else {
						echo "Thu muc lui ve 1 cap la :" . $thumucluicap . "<br/>";
						echo "Dang tao thu muc......<br/>";
						$urlMake = $this->dir ."Theme/". $folderBackup . "/" . $thumucluicap . $folderlast;
						echo "Thu muc co duong dan :" . $urlMake . "<br/>";
						$makeFolderTree = mkdir($urlMake);
						if ($makeFolderTree) {
							echo "Tao thu muc thanh cong.<br/>";
						} else {
							echo "tao thu muc that bai<br/>";
						}
						//neu thu muc chua ton tai thi tao thu muc.
						//lay Url de tao thu muc lui thu muc can tao ve 1 cap.
					}
				}
			}
		}
		//Coppy file
		echo "--------------- Chuan bi coppy file------------------<br/>";
		echo "Dang load danh sach cac file se duoc coppy.</br/>";
		echo "Co tat ca : " . count($listFile["files"]) . " File se duoc coppy.";
		foreach ($listFile["files"] as $keyFile => $dataFile) {
			$urlFile = $listFile["files"][$keyFile];
			$formatfile = str_replace("\\", "/", $urlFile);
			//chi lay duong dan file khong lay duong dan o dia va thu muc project
			$onlyfile = str_replace($this->dir . $this->urlProject, "", $formatfile);
			echo "Dang thuc hien coppy file : -- " . $urlFile . "<br/>";
			$copyfile = copy($urlFile, $this->dir ."Theme/". $folderBackup . "/" . $onlyfile);
			echo $copyfile;
			if ($copyfile) {
				echo "Coppy file thanh cong <br/>";
			} else {
				echo "Coppy file that bai. <br/>";
			}
		}
	}
}
