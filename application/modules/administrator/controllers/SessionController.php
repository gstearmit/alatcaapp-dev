<?php
class Administrator_SessionController extends Zend_Controller_Action
{
	public function init() {
		
	}
	
	public function indexAction(){
		$do = @$this->_request->getParam('do');
		$id = (int)$this->_request->getParam('id');
		if($do == 'delete' && $id >0){
			$this->deleteSession($id);
		}elseif($do == 'list'){
			$this->getListSession();
		}else{
			$keyword 				= $this->_request->getParam('keyword');
			$this->view->keyword 	= $keyword;
		}
		$this->view->inlineScript()->appendFile(WEB_PATH.'/application/modules/administrator/views/scripts/session/index.js');
	}
	
	public function updateAction(){
		$objSession = new HT_Model_administrator_models_session();
		$do 		 = @$this->_request->getParam('do');
		$id 		= (int)$this->_request->getParam('id');
		$status 	= (int)$this->_request->getParam('status');
		if($do == 'submit'){
			$data = array();
			$data['session_key'] 		= strtolower(trim($this->_request->getParam('session_key')));
			$data['session_value'] 		= $this->_request->getParam('session_value');
			$data['description'] 		= $this->_request->getParam('description');
			if($id >0){
				$status = $objSession->updateData($data,(int)$id);
			}else{
				$status = $objSession->addData($data);
			}

			if($status > 0){
				$this->_redirect(WEB_PATH.'/administrator/session');
			}else{
				$redirectLink = WEB_PATH."/administrator/session/update?status=$status";
				if($id >0) $redirectLink .= "&id=$id";
				$this->_redirect($redirectLink);
			}
		}elseif($id >0){
			$session				= $objSession->getSession($id);
			$this->view->session = $session;
		}
		$this->view->id 		= $id;
		$this->view->status 	= $status;
		$this->view->inlineScript()->appendFile(WEB_PATH.'/application/modules/administrator/views/scripts/session/update.js');
	}

	function deleteSession($id){
		$objSession = new HT_Model_administrator_models_session();
		echo $objSession->delete("session_id=".(int)$id);die();
	}

	function getListSession(){
	    
        $objUtil 		= new HT_Model_administrator_models_utility();
		$objSession 		= new HT_Model_administrator_models_session();
		$keyword 		= trim($this->_request->getParam('keyword'));
		
		$listSession = $objSession->getListSession(array('keyword'=>$keyword));

		$ajaxData = '<table cellspacing="0" class="table">';
		$ajaxData .= '<thead>';
			$ajaxData .= '<tr>';
				$ajaxData .= '<th width="15">STT</th>';
				$ajaxData .= '<th width="200">Nguồn</th>';
				$ajaxData .= '<th width="200">Session</th>';
				$ajaxData .= '<th width="50">CTA</th>';
			$ajaxData .= '</tr>';
		$ajaxData .= '</thead>';
		$i=0;
		if($page>1){
			$i=($page-1)*$size;
		}
		$arrGroup = array();
		foreach($listSession as $sess){
			$i++;
			$trClass = null;
			if($i%2 == 1) $trClass = ' class="altrow"';
			$ajaxData .= '<tr id="'.$sess['session_id'].'" '.$trClass.'>';
			$ajaxData .= '<td align="center">'.$i.'</td>';
			$ajaxData .= '<td>'.$sess['source'].'</td>';
			$ajaxData .= '<td>'.$sess['session_id'].'</td>';
			$ajaxData .= '<td>'.$sess['cta'].'</td>';
			$ajaxData .= '</tr>';
		}
		$ajaxData .= '</tbody>';
		$ajaxData .= '</table>';
		echo $objUtil->renderData($ajaxData);die();
	}
}
