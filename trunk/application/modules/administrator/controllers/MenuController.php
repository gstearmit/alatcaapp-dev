<?php
class Administrator_MenuController extends Zend_Controller_Action
{
	public function init() {
		
	}
	
	public function indexAction(){
		$objMenu = new HT_Model_administrator_models_menu();
		$do = @$this->_request->getParam('do');
		$menu_id = (int)$this->_request->getParam('id');
		if($do == 'delete' && $menu_id >0){
			$this->deleteMenu($menu_id);
		}elseif($do == 'list'){
			$this->getListMenu();
		}else{
			$keyword = $this->_request->getParam('keyword');
			$this->view->keyword 	= $keyword;
			$this->reloadACL();
		}
		$this->view->inlineScript()->appendFile(WEB_PATH.'/application/modules/administrator/views/scripts/menu/index.js');
	}
	
	private function reloadACL(){
		//$objAcl 	= new HT_Model_administrator_models_acl();
		//$fileList	= $this->_getAdminFiles();
		//$objAcl->autoUpdateModules($fileList);
	}
	
	private function _getAdminFiles(){
		$front = $this->getFrontController();
		$fileList = array();
		foreach ($front->getControllerDirectory() as $module => $path) {
			$fileItem = array();
			$adminDir1 = APPLICATION_PATH.'/modules/administrator/controllers';
			$adminDir2 = APPLICATION_PATH.'/modules/admin/controllers';
			if($path == $adminDir1 || $path == $adminDir2){
				foreach (scandir($path) as $file) {
					if (strstr($file, "Controller.php") !== false) {
						$filePath = $path . DIRECTORY_SEPARATOR . $file;
						$fileItem['filePath'] 	= $filePath;
						$fileItem['fileName'] 	= $file;
						$fileList[] = $fileItem;
					}
				}
			}
		}
		return $fileList;
	}
	
	public function updateAction(){
		$objMenu 		= new HT_Model_administrator_models_menu();
		$objUtil 		= new HT_Model_administrator_models_utility();
		$do 		 	= @$this->_request->getParam('do');
		$menu_id 		= (int)$this->_request->getParam('id');
		$status 		= (int)$this->_request->getParam('status');
		$group_id 		= null;
		if($do == 'submit'){
			$data = array();
			$data['group_id'] 			= $this->_request->getParam('group_id');
			$data['menu_name'] 			= $this->_request->getParam('menu_name');
			$data['menu_url'] 			= $this->_request->getParam('menu_url');
			$data['menu_order'] 		= $this->_request->getParam('menu_order');
			$data['menu_description'] 	= '';
			
			if($menu_id >0){
				$status = $objMenu->updateData($data,$menu_id);
			}else{
				$status = $objMenu->addData($data);
			}
			if($status > 0){
				//$this->_redirect(WEB_PATH.'/administrator/menu/update?status=1&id='.$status);
				$this->_redirect(WEB_PATH.'/administrator/menu');
			}else{
				$this->_redirect(WEB_PATH.'/administrator/menu/update?status='.$status.'&id='.$menu_id);
			}
		}elseif($menu_id >0){
			$menu 				= $objMenu->getMenu($menu_id);
			$group_id			= (int)$menu['group_id'];
			$this->view->menu	= $menu;
			$this->reloadACL();
			
		}
		$menugroup 			= $objUtil->GetCombobox('group_id','group_id','group_name','zend_menugroup',array('defaultValue'=>$group_id,'isBlankVal'=>'Vui lòng chọn nhóm menu','cssClass'=>'form-control'));
		
		$this->view->id 		= $menu_id;
		$this->view->status 	= $status;
		$this->view->menugroup	= $menugroup;
		$this->view->inlineScript()->appendFile(WEB_PATH.'/application/modules/administrator/views/scripts/menu/update.js');
	}
	
	function deleteMenu($menu_id){
		$objMenu = new HT_Model_administrator_models_menu();
		echo $objMenu->delete("menu_id=".(int)$menu_id);die();
	}

	function getListMenu(){
		$objUtil 		= new HT_Model_administrator_models_utility();
		$objMenu 	= new HT_Model_administrator_models_menu();
		$keyword 		= trim($this->_request->getParam('keyword'));
		$page 			= (int)$this->_request->getParam('page');
		$size 			= PAGING_SIZE;
		if (!is_numeric($page) || $page <= 0) {
			$page = 1;
		}
		$start = $page * $size - $size;
		$totalRecord = $objMenu->getListMenu_nb(array('keyword'=>$keyword));
		$listMenu = $objMenu->getListMenu($start,$size,array('keyword'=>$keyword));
		$paging = trim($objUtil->paging($page, $size, $totalRecord));
		$ajaxData = '<table cellspacing="0" class="table">';
		$ajaxData .= '<thead>';
			$ajaxData .= '<tr>';
				$ajaxData .= '<th width="15" style="text-align: right;">No</th>';
				$ajaxData .= '<th width="100">Menu group</th>';
				$ajaxData .= '<th width="250">Menu name</th>';
				$ajaxData .= '<th width="50" style="text-align: right;">Order</th>';
				$ajaxData .= '<th width="300">Menu URL</th>';
				$ajaxData .= '<th width="80">Module</th>';
				$ajaxData .= '<th width="80">Action</th>';
				$ajaxData .= '<th width="50">#</th>';
			$ajaxData .= '</tr>';
		$ajaxData .= '</thead>';
		
	$i=0;
		if($page>1){
		$i=($page-1)*$size;
		}
		foreach($listMenu as $menu){
			$i++;
			$trClass = null;
			if($i%2 == 1) $trClass = ' class="altrow"';
			$ajaxData .= '<tr id="'.$menu['menu_id'].'" '.$trClass.'>';
			$ajaxData .= '<td style="text-align: right;">'.$i.'</td>';
			$ajaxData .= '<td>'.$menu['group_name'].'</td>';
			$ajaxData .= '<td><a href="'.WEB_PATH.'/administrator/menu/update/?id='.$menu['menu_id'].'">'.$objUtil->tooltipString($menu['menu_name'],200).'</a></td>';
			$ajaxData .= '<td style="text-align: right;">'.$menu['menu_order'].'</td>';
			$ajaxData .= '<td>'.$menu['menu_url'].'</td>';
			$ajaxData .= '<td>'.$menu['module_name'].'</td>';
			$ajaxData .= '<td>'.$menu['action_name'].'</td>';
			
			
			$ajaxData .= '<td style="white-space: nowrap" align="center">';
				
			$ajaxData .='
			<div class="text-center">
			<a  href="'.WEB_PATH.'/administrator/menu/update/?id='.$menu['menu_id'].'" class="btn btn-xs" title="Sửa">
			<i class="icon-pencil"></i>
			</a>
			<a  href="#" onclick="deleteMenu('.$menu['menu_id'].')" class="btn btn-danger btn-xs"  title="Xoá">
			<i class=" icon-trash "></i>
			</a>
			</div>
			';
			
			$ajaxData .= '</td>';
			
			
			
			
			$ajaxData .= '</tr>';
		}
		$ajaxData .= '</tbody>';
		$ajaxData .= '</table>';
		$title= "Menu";
		echo $objUtil->renderData($title,$ajaxData,$paging);die();
	}
}
