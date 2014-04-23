<?php
class Administrator_MenugroupController extends Zend_Controller_Action
{
	public function init() {}
	
	public function indexAction(){
		$objMenugroup = new HT_Model_administrator_models_menugroup();
		$do = @$this->_request->getParam('do');
		$group_id = (int)$this->_request->getParam('id');
		if($do == 'delete' && $group_id >0){
			$this->deleteMenugroup($group_id);
		}elseif($do == 'list'){
			$this->getListMenugroup();
		}else{
			$keyword = $this->_request->getParam('keyword');
			$this->view->keyword 	= $keyword;
		}
		$this->view->inlineScript()->appendFile(WEB_PATH.'/application/modules/administrator/views/scripts/menugroup/index.js');
	}
	
	public function updateAction(){
		$objMenugroup 	= new HT_Model_administrator_models_menugroup();
		$do 		 	= @$this->_request->getParam('do');
		$group_id 		= (int)$this->_request->getParam('id');
		$status 		= (int)$this->_request->getParam('status');
		
		//echo $do; die();
		if($do == 'submit'){
			$data = array();
			$data['group_url'] 			= $this->_request->getParam('group_url');
			$data['group_name'] 		= $this->_request->getParam('group_name');
			$data['group_icon'] 		= $this->_request->getParam('group_icon');
			$data['group_order'] 		= (int)$this->_request->getParam('group_order');
			$data['description'] 		= $this->_request->getParam('description');
			if($group_id >0){
				$objMenugroup->update($data, 'group_id='.(int)$group_id);
			}else{
				$group_id = $objMenugroup->addData($data);
			}
			//$this->_redirect(WEB_PATH.'/administrator/menugroup/update?status=1&id='.$group_id);
			$this->_redirect(WEB_PATH.'/administrator/menugroup');
		}elseif($group_id >0){
			$this->view->menugroup = $objMenugroup->getMenugroup($group_id);
		}
		$this->view->id = $group_id;
		$this->view->status 	 = $status;
		$this->view->inlineScript()->appendFile(WEB_PATH.'/application/modules/administrator/views/scripts/menugroup/update.js');
	}

	function deleteMenugroup($group_id){
		//$objMenugroup = new HT_Model_administrator_models_menugroup();
		//echo $objMenugroup->delete("id=".(int)$group_id);die();
	}

	function getListMenugroup(){
		$objUtil 		= new HT_Model_administrator_models_utility();
		$objMenugroup 	= new HT_Model_administrator_models_menugroup();
		$keyword 		= trim($this->_request->getParam('keyword'));
		$page 			= (int)$this->_request->getParam('page');
		$size 			= PAGING_SIZE;
		if (!is_numeric($page) || $page <= 0) {
			$page = 1;
		}
		$start = $page * $size - $size;
		$totalRecord = $objMenugroup->getListMenugroup_nb(array('keyword'=>$keyword));
		$listMenugroup = $objMenugroup->getListMenugroup($start,$size,array('keyword'=>$keyword));
		$paging = trim($objUtil->paging($page, $size, $totalRecord));
		
		$ajaxData="";
		$ajaxData .= '<table cellspacing="0" class="table">';
		$ajaxData .= '<thead>';
			$ajaxData .= '<tr>';
				$ajaxData .= '<th width="15" style="text-align: right;">No</th>';
				$ajaxData .= '<th width="350">Tên nhóm menu</th>';
				$ajaxData .= '<th width="400">URL</th>';
				$ajaxData .= '<th width="150" style="text-align: right;">Vị trí</th>';
				$ajaxData .= '<th width="150">Icon</th>';
				$ajaxData .= '<th width="30">#</th>';
			$ajaxData .= '</tr>';
		$ajaxData .= '</thead>';
		
	$i=0;
		if($page>1){
		$i=($page-1)*$size;
		}
		foreach($listMenugroup as $menugroup){
			$i++;
			$trClass = null;
			if($i%2 == 1) $trClass = ' class="altrow"';
			$ajaxData .= '<tr id="'.$menugroup['group_id'].'" '.$trClass.'>';
			$ajaxData .= '<td style="text-align: right;">'.$i.'</td>';
			$ajaxData .= '<td><a href="'.WEB_PATH.'/administrator/menugroup/update/?id='.$menugroup['group_id'].'">'.$objUtil->tooltipString($menugroup['group_name'],200).'</a></td>';
			$ajaxData .= '<td>'.$menugroup['group_url'].'</td>';
			$ajaxData .= '<td style="text-align: right;">'.$menugroup['group_order'].'</td>';
			$ajaxData .= '<td>'.$menugroup['group_icon'].'<i class='.$menugroup['group_icon'].'></i>'.'</td>';
		
			
			
			$ajaxData .= '<td style="white-space: nowrap" align="center">';
				
			$ajaxData .='
			<div class="text-center">
			<a  href="'.WEB_PATH.'/administrator/menugroup/update/?id='.$menugroup['group_id'].'" class="btn btn-xs" title="Sửa">
			<i class="icon-pencil"></i>
			</a>
			
			</div>
			';
			
			$ajaxData .= '</td>';
			
			
			$ajaxData .= '</tr>';
		}
		$ajaxData .= '</tbody>';
		$ajaxData .= '</table>';
		$title="Menu page";
		echo $objUtil->renderData($title,$ajaxData,$paging);die();
	}
}
