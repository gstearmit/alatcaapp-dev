<?php
class Administrator_IdentityController extends Zend_Controller_Action
{
	public function init() {}
	
	public function indexAction(){
		$do = @$this->_request->getParam('do');
		$id = (int)$this->_request->getParam('id');
		if($do == 'delete' && $id >0){
			$this->deleteIdentity($id);
		}elseif($do == 'list'){
			$this->getLisIdentity();
		}else{
			$keyword 				= $this->_request->getParam('keyword');
			$this->view->keyword 	= $keyword;
		}
		$this->view->inlineScript()->appendFile(WEB_PATH.'/application/modules/administrator/views/scripts/identity/index.js');
	}
	
	public function updateAction(){
		$objUrl = new HT_Model_administrator_models_url();
		$objIdentity 		= new HT_Model_administrator_models_trackingform();
		$do 		 = @$this->_request->getParam('do');
		$id 		= $this->_request->getParam('id');
		$status 	= (int)$this->_request->getParam('status');
		if($do == 'submit'){
			$data = array();
		//	$data['url'] 		= strtolower(trim($this->_request->getParam('url')));
			//$data['id'] 		= $id;
		 	$data['form_name'] 		= $this->_request->getParam('form_name');
		 	
			$data['domain'] 		= $this->_request->getParam('domain');
			$data['form_url'] 		= $this->_request->getParam('form_url');
			
			$data['form_format'] 	= $this->_request->getParam('form_format');
			
			$data['description'] 	= $this->_request->getParam('description');
			
			$data['reg_dttm'] 		= $this->_request->getParam('reg_dttm');
			$data['upd_dttm'] 		= $this->_request->getParam('upd_dttm');
			
			
			if($id !=""){
				$status = $objIdentity->updateData($data,$id);
				
				
				//$status=1;
				//$this->view->status 	= $status;
			}else{
				$status = $objIdentity->addData($data);
			}
			
			
			if($status > 0){
				//$this->view->status 	= $status;
				//$this->view->status 	= $status;
				$redirectLink = WEB_PATH."/administrator/identity?status=".$status;
				//$this->_redirect(WEB_PATH.'/administrator/url');
				//$this->_redirect(WEB_PATH.'/administrator/url?status='.$status);
				$this->_redirect($redirectLink);
				//$redirectLink = WEB_PATH."/administrator/url?status=$status";
			}elseif($status < 0){
				$redirectLink = WEB_PATH."/administrator/identity/update?status=$status";
				if($id >0) $redirectLink .= "&id=$id";
				$this->_redirect($redirectLink);
			}
		}elseif($id !="" ){
			$Identity				= $objIdentity->getIdentity($id);
			$this->view->Identity    = $Identity;
		}
		
		//$status=1;
		$this->view->id 		= $id;
		$this->view->status 	= $status;
		$this->view->inlineScript()->appendFile(WEB_PATH.'/application/modules/administrator/views/scripts/identity/update.js');
	}

	function deleteIdentity($IdentitylId){
		
		
		$objIdentity = new HT_Model_administrator_models_trackingform();
		echo $objIdentity->delete("form_id = '".$IdentitylId."'");die();
		return;
	}

	function getLisIdentity(){
	    
        $objUtil 		= new HT_Model_administrator_models_utility();
		$objIdentity 		= new HT_Model_administrator_models_trackingform();
		$keyword 		= trim($this->_request->getParam('keyword'));
		$page 			= (int)$this->_request->getParam('page');
		$size 			= PAGING_SIZE;
		if (!is_numeric($page) || $page <= 0) {
			$page = 1;
		}
		$start = $page * $size - $size;
		$totalRecord = $objIdentity->getListIdentity_nb(array('keyword'=>$keyword));
		
		$listIdentity = $objIdentity->getListIdentity($start,$size,array('keyword'=>$keyword));
		
		$paging = trim($objUtil->paging($page, $size, $totalRecord));
		$ajaxData="";
		$ajaxData .= '<table cellspacing="0" class="table">';
		$ajaxData .= '<thead>';
			$ajaxData .= '<tr>';
				$ajaxData .= '<th width="30" align="center">No</th>';
				$ajaxData .= '<th align="center">ID</th>';
				$ajaxData .= '<th align="center">Name</th>';
				$ajaxData .= '<th align="center">Domain</th>';
				$ajaxData .= '<th align="center">Url</th>';
				$ajaxData .= '<th align="center">Format</th>';
				$ajaxData .= '<th align="center">Description</th>';
				$ajaxData .= '<th align="center">reg_dttm</th>';
				$ajaxData .= '<th align="center">upd_dttm</th>';
				
				
				//$ajaxData .= '<th width="200">Name</th>';
				//$ajaxData .= '<th width="250">Description</th>';
				$ajaxData .= '<th align="center" width="50">#</th>';
			$ajaxData .= '</tr>';
		$ajaxData .= '</thead>';
		
		$i=0;
		if($page>1){
		$i=($page-1)*$size;
		}
		$arrGroup = array();
		
		//var_dump($listUrl);
		//die();
		
		foreach($listIdentity as $cfg){
			$i++;
			$trClass = null;
			if($i%2 == 1) $trClass = ' class="altrow"';
			
			$ajaxData .= '<tr id="'.$cfg['form_id'].'" '.$trClass.'>';
			$ajaxData .= '<td align="center">'.$i.'</td>';
			$ajaxData .= '<td>'.$cfg['form_id'].'</td>';
			$ajaxData .= '<td>'.$cfg['form_name'].'</td>';
			$ajaxData .= '<td>'.$cfg['domain'].'</td>';
			$ajaxData .= '<td>'.$cfg['form_url'].'</td>';
			$ajaxData .= '<td>'.$cfg['form_format'].'</td>';
			$ajaxData .= '<td>'.$cfg['description'].'</td>';
			$ajaxData .= '<td>'.$cfg['reg_dttm'].'</td>';
			$ajaxData .= '<td>'.$cfg['upd_dttm'].'</td>';
			
			
			//$ajaxData .= '<td>'.$cfg['name'].'</td>';
			//$ajaxData .= '<td>'.$cfg['description'].'</td>';
			$ajaxData .= '<td style="white-space: nowrap" align="center">';
			
			$ajaxData .='
			<div class="text-center">
			<a  href="'.WEB_PATH.'/administrator/identity/update/?id='.$cfg['form_id'].'" class="btn btn-xs" title="Edit">
			<i class="icon-pencil"></i>
			</a>
			<a  href="#" onclick="deleteIdentity('.$cfg['form_id'].')" class="btn btn-danger btn-xs"  title="Delete">
			<i class=" icon-trash "></i>
			</a>
			</div>
			';
				
			$ajaxData .= '</td>';
			$ajaxData .= '</tr>';
		}
		$ajaxData .= '</tbody>';
		$ajaxData .= '</table>';
		$title="Identity";
		echo $objUtil->renderData($title,$ajaxData,$paging);die();
	}

}
