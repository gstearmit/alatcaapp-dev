<?php
class Administrator_ExcutesController extends Zend_Controller_Action
{
	public function init() {
		
	}
	
	public function indexAction(){
		$do = @$this->_request->getParam('do');
		$id = (int)$this->_request->getParam('id');
		if($do == 'delete' && $id >0){
			$this->deleteConfig($id);
		}elseif($do == 'list'){
			$this->getListConfig();
		}else{
			$keyword 				= $this->_request->getParam('keyword');
			$this->view->keyword 	= $keyword;
		}
		$this->view->inlineScript()->appendFile(WEB_PATH.'/application/modules/administrator/views/scripts/config/index.js');
	}
	
	public function updateAction(){
		$objConfig = new HT_Model_administrator_models_config();
		$do 		 = @$this->_request->getParam('do');
		$id 		= (int)$this->_request->getParam('id');
		$status 	= (int)$this->_request->getParam('status');
		if($do == 'submit'){
			$data = array();
			$data['config_key'] 		= strtolower(trim($this->_request->getParam('config_key')));
			$data['config_value'] 		= $this->_request->getParam('config_value');
			$data['description'] 		= $this->_request->getParam('description');
			if($id >0){
				$status = $objConfig->updateData($data,(int)$id);
			}else{
				$status = $objConfig->addData($data);
			}

			if($status > 0){
				
				$this->_redirect(WEB_PATH.'/administrator/config?status='.$status);
			}else{
				$redirectLink = WEB_PATH."/administrator/config/update?status=$status";
				if($id >0) $redirectLink .= "&id=$id";
				$this->_redirect($redirectLink);
			}
		}elseif($id >0){
			$config				= $objConfig->getConfig($id);
			$this->view->config = $config;
		}
		$this->view->id 		= $id;
		$this->view->status 	= $status;
		$this->view->inlineScript()->appendFile(WEB_PATH.'/application/modules/administrator/views/scripts/config/update.js');
	}

	function deleteConfig($id){
		$objConfig = new HT_Model_administrator_models_config();
		echo $objConfig->delete("config_id=".(int)$id);die();
	}

	function getListConfig(){
	    
        $objUtil 		= new HT_Model_administrator_models_utility();
		$objConfig 		= new HT_Model_administrator_models_config();

		$obj_excutes= new HT_Model_administrator_models_dwExecutes();
		
		
		$keyword 		= trim($this->_request->getParam('keyword'));
		$page 			= (int)$this->_request->getParam('page');
		$size 			= PAGING_SIZE;
		if (!is_numeric($page) || $page <= 0) {
			$page = 1;
		}
		$start = $page * $size - $size;
		$totalRecord = $objConfig->getListConfig_nb(array('keyword'=>$keyword));
		$listConfig = $obj_excutes->getListExcutes($start,$size,array('keyword'=>$keyword));
		$paging = trim($objUtil->paging($page, $size, $totalRecord));

		$ajaxData = '<table cellspacing="0" class="table">';
		$ajaxData .= '<thead>';
			$ajaxData .= '<tr>';
				$ajaxData .= '<th width="15">No</th>';
				$ajaxData .= '<th width="200">Date</th>';
				$ajaxData .= '<th width="200">Message</th>';
				
				//$ajaxData .= '<th width=30">#</th>';
			$ajaxData .= '</tr>';
		$ajaxData .= '</thead>';
		
		$i=0;
		if($page>1){
		$i=($page-1)*$size;
		}
		$arrGroup = array();
		foreach($listConfig as $cfg){
			$i++;
			$trClass = null;
			if($i%2 == 1) $trClass = ' class="altrow"';
			$ajaxData .= '<tr id="'.$cfg['id'].'" '.$trClass.'>';
			$ajaxData .= '<td align="center">'.$i.'</td>';
			$ajaxData .= '<td>'.$cfg['date'].'</td>';
			$ajaxData .= '<td>'.$cfg['message'].'</td>';
			
		
			/*
			$ajaxData .= '<td style="white-space: nowrap" align="center">';
				
			$ajaxData .='
			<div class="text-center">
			<a href="'.WEB_PATH.'/administrator/excutes/update/?id='.$cfg['id'].'" class="btn btn-xs" title="Sửa">
			<i class="icon-pencil"></i>
			</a>
			<a  href="#" onclick="deleteConfig('.$cfg['id'].')" class="btn btn-danger btn-xs"  title="Xoá">
			<i class=" icon-trash "></i>
			</a>
			</div>
			';
			*/
			//$ajaxData .= '<a href="'.$cfg['url'].'">Mở</a>';
			
			$ajaxData .= '</td>';
			
			
			$ajaxData .= '</tr>';
		}
		$ajaxData .= '</tbody>';
		$ajaxData .= '</table>';
		$title= "Mesages";
		echo $objUtil->renderData($title,$ajaxData,$paging);die();
	}
}
