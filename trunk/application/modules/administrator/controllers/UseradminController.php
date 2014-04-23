<?php
class Administrator_UseradminController extends Zend_Controller_Action
{
	public function init() {
		
	}
	
	public function indexAction(){
		$objUser = new HT_Model_administrator_models_useradmin();
		$do 		= @$this->_request->getParam('do');
		$userid 	= $this->_request->getParam('userid');
		//var_dump($userid);
		
	    if($do == 'delete' && $userid  >0){
			$this->deleteuseradmin($userid);
		}if($do == 'list'){
			$this->getListUser();
		}elseif($do == 'setActive'){
			$this->setActive();
		}else{
			$keyword = $this->_request->getParam('keyword');
			$this->view->keyword 	= $keyword;
		}
		$this->view->inlineScript()->appendFile(WEB_PATH.'/application/modules/administrator/views/scripts/useradmin/index.js');
	}
	
	public function roleAction(){
		$userid 			= (int)@$this->_request->getParam('userid');
		$do 				= @$this->_request->getParam('do');
		if($do == 'submit'){
			$this->_updateRole();
		}elseif($userid >0){
			$objUser 		= new HT_Model_administrator_models_useradmin();
			$objUtil 		= new HT_Model_administrator_models_utility();
			
			$user			= $objUser->getUserById($userid);
			$role_id		= $user->role_id;
			//$role 			= $objUtil->GetCombobox('role_id','role_id','role_name','user_roles',array('defaultValue'=>$role_id,'isBlankVal'=>'Vui lòng chọn nhóm thành viên'));
			
			$this->view->user 	= $user;
		//	$this->view->role 	= $role;
			$this->view->userid = $userid;
			$this->view->role_id = $role_id;
			$this->view->inlineScript()->appendFile(WEB_PATH.'/application/modules/administrator/views/scripts/useradmin/update.js');
		}else{
			$this->_redirect(WEB_PATH.'/administrator/index/denied');
		}
	}
	
	private function _updateRole(){
		$userid 		= (int)@$this->_request->getParam('userid');
		//$role_id 		= (int)@$this->_request->getParam('role_id');
		$objUser 		= new HT_Model_administrator_models_useradmin();
		$pass = md5($this->_request->getParam('pass'));
		$data = array();
			
			$data['user_name'] 		= $this->_request->getParam('user_name');
			$data['firstname'] 		= $this->_request->getParam('firstname');
			$data['lastname'] 		= $this->_request->getParam('lastname');
			$data['birthday'] 		= $this->_request->getParam('birthday');
			$data['email'] 		    = $this->_request->getParam('email');
			$data['pass'] 		    = $pass;
		$objUser->update($data, 'userid = '.(int)$userid);		
		$this->_redirect(WEB_PATH.'/administrator/useradmin');
	}
	
	// edit pass 
	public function editpassAction(){
		$userid 			= (int)@$this->_request->getParam('userid');
		$do 				= @$this->_request->getParam('do');
		if($do == 'submit'){
			$this->_editpass();
		}elseif($userid >0){
			$objUser 		= new HT_Model_administrator_models_useradmin();
			$objUtil 		= new HT_Model_administrator_models_utility();
				
			$user			= $objUser->getUserById($userid);
			$role_id		= $user->role_id;
			//$role 			= $objUtil->GetCombobox('role_id','role_id','role_name','user_roles',array('defaultValue'=>$role_id,'isBlankVal'=>'Vui lòng chọn nhóm thành viên'));
				
			$this->view->user 	= $user;
			//	$this->view->role 	= $role;
			$this->view->userid = $userid;
			$this->view->role_id = $role_id;
			$this->view->inlineScript()->appendFile(WEB_PATH.'/application/modules/administrator/views/scripts/useradmin/editpass.js');
		}else{
			$this->_redirect(WEB_PATH.'/administrator/index/denied');
		}
	}
	
	private function _editpass(){
		$userid 		= (int)@$this->_request->getParam('userid');
		//$role_id 		= (int)@$this->_request->getParam('role_id');
		$objUser 		= new HT_Model_administrator_models_useradmin();
		$pass = md5($this->_request->getParam('pass'));
		$data = array();
		$data['pass'] 		    = $pass;
		$objUser->update($data, 'userid = '.(int)$userid);
		
		//$this->_redirect(WEB_PATH.'/administrator/useradmin');
	}
	//end edit pas
	
	// edit user
	public function getpassAction(){
		$userid 			= (int)@$this->_request->getParam('userid');
		//$do 				= @$this->_request->getParam('do');
		$pass               =  @$this->_request->getParam('pass');
		$objUser 		= new HT_Model_administrator_models_useradmin();
		
		$oject = $objUser->getUser_pass_id($userid);
		//var_dump($oject); die();
		
		if ($oject['pass'] === md5($pass) ) 
		{
			$oki = 'oki'; 
			echo $oki;
			return $oki;
		}else { $oki = 'false'; return $oki; }
		
	}
	
	
	
	// edit pass admin
	public function editpassadminAction(){
		$objUser = new HT_Model_administrator_models_useradmin();
		$status 	= (int)$this->_request->getParam('status');
		$userid 			= (int)@$this->_request->getParam('userid');
		$do 				= @$this->_request->getParam('doing');
		$birthday1        =  (string)$this->_request->getParam('birthday');
		if ($birthday1 != "")
		{
			$birthdayarray= explode("/",$birthday1);
			$birthday = $birthdayarray[0].$birthdayarray[1].$birthdayarray[2];
		
		}else $birthday = $birthday1;
		
		if($do == 'submit'){
				$data = array();
				$pass = md5($this->_request->getParam('pass_new_nl'));
				$data['user_name'] 		= $this->_request->getParam('user_name');
				$data['firstname'] 		= $this->_request->getParam('firstname');
				$data['lastname'] 		= $this->_request->getParam('lastname');
				$data['birthday'] 		= $birthday;
				$data['email'] 		    = $this->_request->getParam('email');
				$data['pass'] 		    = $pass;
			if($userid >0){
				$objUser->update($data, 'userid = '.(int)$userid);
				$this->_redirect(WEB_PATH.'/administrator/useradmin/editpassadmin/?userid='.$userid);
				$status = 1;
				$this->view->status = $status;
			}elseif($userid < 0) {
				//$this->_redirect(WEB_PATH.'/administrator/index/denied');
				$objUser->_edituseradmin();  // add user
			 }
		 }elseif($userid > 0){
			$this->view->userad = $objUser->getUser_id($userid);
		}
		$this->view->userid = $userid;
		//$this->view->status 	 = $status;
		$this->view->inlineScript()->appendFile(WEB_PATH.'/application/modules/administrator/views/scripts/useradmin/editpass_admin.js');	
	}
	private function _edituseradmin(){
		$userid 		= (int)@$this->_request->getParam('userid');
		//$role_id 		= (int)@$this->_request->getParam('role_id');
		$objUser 		= new HT_Model_administrator_models_useradmin();
		$birthday1        =  (string)$this->_request->getParam('birthday');
		if ($birthday1 != "")
		{
			$birthdayarray= explode("/",$birthday1);
			$birthday = $birthdayarray[0].$birthdayarray[1].$birthdayarray[2];
		
		}else $birthday = $birthday1;
		$pass = md5($this->_request->getParam('pass_new_nl'));
		$data = array();
			
		$data['user_name'] 		= $this->_request->getParam('user_name');
		$data['firstname'] 		= $this->_request->getParam('firstname');
		$data['lastname'] 		= $this->_request->getParam('lastname');
		$data['birthday'] 		= $this->_request->getParam('birthday');
		$data['email'] 		    = $this->_request->getParam('email');
	    $data['birthday'] 		= $birthday;
		$objUser->update($data, 'userid = '.(int)$userid);
		
		$this->_redirect(WEB_PATH.'/administrator/useradmin/editpassadmin/?userid='.$userid);
	}
	
	//end edit passadmin
	
	public function setActive(){
		$objUser = new HT_Model_administrator_models_useradmin();
		$userid 	= $this->_request->getParam('userid');
		$active 	= $this->_request->getParam('active');
		$data 		= array('active'=>$active);
		echo $objUser->update($data,"userid=".(int)$userid); die();
	}
	
	public function updateAction(){
		$objUser = new HT_Model_administrator_models_useradmin();
		$do 		      = @$this->_request->getParam('do');
		$userid           = (int)$this->_request->getParam('id');
		$status 	      = (int)$this->_request->getParam('status');
		$birthday1        =  (string)$this->_request->getParam('birthday');
		if ($birthday1 != "") 
		{
			$birthdayarray= explode("/",$birthday1);
			$birthday = $birthdayarray[0].$birthdayarray[1].$birthdayarray[2];
		
		}else $birthday = $birthday1;
		
		$pass = md5($this->_request->getParam('pass'));
		if($do == 'submit'){
			$data = array();
			$data['user_name'] 		= $this->_request->getParam('user_name');
			$data['firstname'] 		= $this->_request->getParam('firstname');
			$data['lastname'] 		= $this->_request->getParam('lastname');
			$data['birthday'] 		= $birthday;
			$data['email'] 		    = $this->_request->getParam('email');
			$data['pass'] 		    = $pass;
			if($userid >0){
				$objUser->update($data, 'userid='.(int)$userid);
			}else{
				$userid = $objUser->addData($data);
			}
			//$this->_redirect(WEB_PATH.'/administrator/user/update?status=1&id='.$userid);
			$this->_redirect(WEB_PATH.'/administrator/useradmin');
		}elseif($userid >0){
			$this->view->user = $objUser->getUser($userid);
		}
		$this->view->userid = $userid;
		$this->view->status 	 = $status;
		$this->view->inlineScript()->appendFile(WEB_PATH.'/application/modules/administrator/views/scripts/useradmin/update.js');
	}

	//check_exitemail
	
	public function check_exitemailAction()
	   {
	   	// get POST ajax email
	   //	$email = $_POST('email');
	    $do 		= (int)@$this->_request->getParam('do');
	   	$email		= @$this->_request->getParam('email');

	   echo $do;
	   echo $email;	
	   return ;
	   die();
	   	
		$objUser = new HT_Model_administrator_models_useradmin();
		$objUser->findByUserEmail($email);die();
		
		}
	
	
	
	function deleteuseradmin($userid){
		$objUser = new HT_Model_administrator_models_useradmin();
		echo $objUser->deleteuseradmin($userid);die();
	}
    
	function getListUser(){
		$objUtil 		= new HT_Model_administrator_models_utility();
		$objUser 	    = new HT_Model_administrator_models_useradmin();
		$keyword 		= trim($this->_request->getParam('keyword'));
		$page 			= (int)$this->_request->getParam('page');
		$size 			= 10;
		if (!is_numeric($page) || $page <= 0) {
			$page = 1;
		}
		$start = $page * $size - $size;
		$totalRecord = $objUser->getListUser_nb(array('keyword'=>$keyword));
		$listUser = $objUser->getListUser($start,$size,array('keyword'=>$keyword));
		$paging = trim($objUtil->paging($page, $size, $totalRecord));
		
		$ajaxData="";
		$ajaxData .= '<table cellspacing="0" class="table">';
		$ajaxData .= '<thead>';
			$ajaxData .= '<tr>';
				$ajaxData .= '<th width="15">STT</th>';
				$ajaxData .= '<th width="200">Họ và Tên</th>';
				$ajaxData .= '<th width="200">Nickname</th>';
				$ajaxData .= '<th width="300">Email</th>';
				$ajaxData .= '<th width="100">Ngày sinh</th>';
			    $ajaxData .= '<th width="100">Giới tính</th>';
				//$ajaxData .= '<th width="100"></th>';
				//$ajaxData .= '<th width="100"></th>';
				$ajaxData .= '<th width="500"style="white-space: nowrap;" align="center">Điều khiển</th>';
			$ajaxData .= '</tr>';
		$ajaxData .= '</thead>';
		
	$i=0;
		if($page>1){
		$i=($page-1)*$size;
		}
		//die();
		foreach($listUser as $user){
			$avatarBox = null;
			$action 	= '<div class="action_buttons">';
			$active 	= $user['active'];
			$sex		= $user['sex'];
			$userid		= $user['userid'];
			$username	= $user['user_name'];
			$avatar	= trim($user['avatar']);
			/*
			if($active == 1){
				$action .= '<div id="icon_'.$userid.'" onclick="setActive(\''.$userid.'\',0)" class="icon_on fl"></div>';
			}else{
				$action .= '<div id="icon_'.$userid.'" onclick="setActive(\''.$userid.'\',1)" class="icon_off fl"></div>';
			}
			*/
			if($avatar){
				$avatarBox .= '<div class="avatar_box">';
				$avatarBox .= '<img src="'.WEB_PATH."/application/album/$username/$avatar".'" />';
				$avatarBox .= '</div>';
			}
			if($sex == 1){
				$sex = "Nữ";
			}else{
				$sex = "Nam";
			}
			$action .= '<div onclick="deleteuseradmin(\''.$userid.'\')" class="ml5 fl" >Xóa |</div>';
			$action .= '<a alt="Sửa User" title="Sửa User" href="'.WEB_PATH.'/administrator/useradmin/role/?userid='.$user['userid'].'"><div class=" ml5 fl">Sửa | </div></a>';
			$action .= '<a alt="Sửa User" title="đổi User" href="'.WEB_PATH.'/administrator/useradmin/editpassadmin/?userid='.$user['userid'].'"><div class=" ml5 fl">Đổi mật khẩu</div></a>';
			$action .= '<div class="cb"></div>';
			$action .= '</div>';
			$i++;
			$trClass = null;
			if($i%2 == 1) $trClass = ' class="altrow"';
			$ajaxData .= '<tr id="'.$user['userid'].'" '.$trClass.'>';
			$ajaxData .= '<td align="center">'.$i.'</td>';
			$ajaxData .= '<td>'.$user['firstname'].' '.$user['lastname'].'</td>';
			$ajaxData .= '<td>'.$username.'</td>';
			$ajaxData .= '<td>'.$user['email'].'</td>';
		    $ajaxData .= '<td>'.$objUtil->parseDate($user['birthday']).'</td>';
			$ajaxData .= '<td>'.$sex.'</td>';
			//$ajaxData .= '<td>'.$avatarBox.'</td>';
			//$ajaxData .= '<td>'.$user['role_name'].'</td>';
			$ajaxData .= '<td style="white-space: nowrap" align="center">';
			$ajaxData .= $action;
			$ajaxData .= '</td>';
			$ajaxData .= '</tr>';
		}
		$ajaxData .= '</tbody>';
		$ajaxData .= '</table>';
		$title="User";
		echo $objUtil->renderData($title,$ajaxData,$paging);die();
	}
}
