<?php
	class IndexController extends Zend_Controller_Action{
		public function init(){
			
		}
		public function indexAction(){
	     	$objUser 		= new HT_Model_administrator_models_user();
	     	$do 			= $this->_request->getParam('do');
	     	$username 		= $this->_request->getParam('username');
	     	$password 		= $this->_request->getParam('password');
	     	@$auth 		= Zend_Auth::getInstance();
	     	$user 		= @$auth->getStorage()->read();
	     	if(isset($user->userid) && (int)$user->userid >0){
	     		$this->_redirect(WEB_PATH."/administrator/");
	     	}else if($do ==='login'){
	     		$user = $objUser->login($username, $password);
	     		if(is_array($user) && sizeof($user)>0 && (int)$user['role_id'] >0){
		     		$auth = Zend_Auth::getInstance();
		     		$auth->getStorage()->write((object)$user);
		            $this->_redirect(WEB_PATH."/administrator/");
	     		}
	     	}
	    }   

	    public function registerAction() 
	    {
	    var_dump( $_POST) ;
	    	
	    	$objUser 		= new HT_Model_administrator_models_user();
	    	$do 			= $this->_request->getParam('do');
	    	$username 		= $this->_request->getParam('username');
	    	$password 		= $this->_request->getParam('password');
	    	@$auth 		= Zend_Auth::getInstance();
	    	$user 		= @$auth->getStorage()->read();
	    	if(isset($user->userid) && (int)$user->userid >0){
	    		$this->_redirect(WEB_PATH."/administrator/");
	    	}else if($do ==='register'){
	    		echo 'doi chieu';
	    		
	    		$user = $objUser->login($username, $password);
	    		if(is_array($user) && sizeof($user)>0 && (int)$user['role_id'] >0){
	    			$auth = Zend_Auth::getInstance();
	    			$auth->getStorage()->write((object)$user);
	    			$this->_redirect(WEB_PATH."/administrator/");
	    		}
	    	}
	    }
	    
	    public function logoutAction(){
	    	$auth    = Zend_Auth::getInstance();
	    	$user    = $auth->getStorage()->read();
	    	$auth->clearIdentity();
	    	$this->_redirect(WEB_PATH);
	    }		
	}
?>