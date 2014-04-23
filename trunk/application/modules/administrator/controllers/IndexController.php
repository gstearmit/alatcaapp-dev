<?php
class Administrator_IndexController extends Zend_Controller_Action
{	
    public function init() {
    	//$this->getListJob();
    }
    public function indexAction(){
    	$objAcl 			= new HT_Model_administrator_models_acl();
    	@$auth 		= Zend_Auth::getInstance();
    	$user 		= @$auth->getStorage()->read();
    	
    	if(isset($user->role_id) && (int)$user->role_id >0){
				$roleId							= $user->role_id;
				$this->view->rightWgetJob 		= $objAcl->checkRightAccess($roleId,'widget','widgetjob');
				$this->view->rightWgetDomain 	= $objAcl->checkRightAccess($roleId,'widget','widgetdomain');
				$this->view->rightWgetLeadreturn 	= $objAcl->checkRightAccess($roleId,'widget','widgetleadreturn');
				$this->view->rightWgetCampaignresponse 	= $objAcl->checkRightAccess($roleId,'widget','widgetcampaignresponse');
    	}
    	
    	$this->view->inlineScript()->appendFile(WEB_PATH.'/application/modules/administrator/views/scripts/widget/index.js');
    }
    public function deniedAction(){
    	
    }
    	
}
