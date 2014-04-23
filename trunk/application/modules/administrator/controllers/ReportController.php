<?php
class Administrator_ReportController extends Zend_Controller_Action
{
	public function init() {
		
	}
	
	public function indexAction(){
		$do = @$this->_request->getParam('do');
		$id = (int)$this->_request->getParam('id');
		if($do == 'delete' && $id >0){
			$this->deleteCtapage($id);
		}elseif($do == 'list'){
			$this->getListCtapage();
		}else{
			$keyword 				= $this->_request->getParam('keyword');
			$this->view->keyword 	= $keyword;
		}
		$this->view->inlineScript()->appendFile(WEB_PATH.'/application/modules/administrator/views/scripts/report/index.js');
	}
	
	
	
	
	public function viewAction(){
		$objUtil 		= new HT_Model_administrator_models_utility();
		$objReport 		= new HT_Model_administrator_models_report();
		
		$id = (int)$this->_request->getParam('reportid');
		$do 		 = @$this->_request->getParam('do');
		$keyword 		= trim($this->_request->getParam('keyword'));
		$orderBy		= $this->_request->getParam('orderBy');
		$page 			= (int)$this->_request->getParam('page');
		$size 			= PAGING_SIZE;
		
		if (!is_numeric($page) || $page <= 0) {
			$page = 1;
		}
		$start = $page * $size - $size;
		
	
		
		$row_report= array();
		
		
		$row_report=$objReport->getReport_by_id($id);
		$sql_query=$row_report['select_query'];
		
		$arr_sort_labels = array();
		$str_sort_labels=$row_report['sort_labels'];
		$arr_sort_labels=$objReport->get_item_cut_string($str_sort_labels);
		
		$arr_sort_fields = array();
		$str_sort_fields=$row_report['sort_fields'];
		$arr_sort_fields=$objReport->get_item_cut_string($str_sort_fields);
		
		$arr_sort_value = array();
		$str_sort_value=$row_report['sort_value'];
		$arr_sort_value=$objReport->get_item_cut_string($str_sort_value);
		
		$arr_headers= array();
		$str_headers=$row_report['headers'];
		$arr_headers=$objReport->get_item_cut_string($str_headers);
		
		$arr_fields= array();
		$str_fields=$row_report['fields'];
		$arr_fields=$objReport->get_item_cut_string($str_fields);
		
		$arr_search_by= array();
		$str_search_by=$row_report['search_fields'];
		$arr_search_by=$objReport->get_item_cut_string($str_search_by);
		
		
		$sort_default_label=$row_report['sort_default_label'];
		$sort_default_field=$row_report['sort_default__field'];
		$sort_default_value=$row_report['sort_default__value'];
		
		$arr_cbb=array();
		$filter = array();
		if($keyword) $filter['keyword'] = $keyword;
		
		for ($i=0;$i<count($arr_sort_labels);$i++){
			array_push($arr_cbb,array('name'=>''.$arr_sort_labels[$i],'value'=>''.$arr_sort_fields[$i]));
			if($orderBy==$arr_sort_fields[$i]){
				$filter['orderBy'] 		= $arr_sort_fields[$i];
				$filter['direction'] 	= $arr_sort_value[$i];
			}
		}
		if($orderBy==$sort_default_field){
			$filter['orderBy'] 		= $sort_default_field;
			$filter['direction'] 	= $sort_default_value;
		}
		
		
		$sql_plus=$objReport->getList_select_query_sqlPlus($filter,$arr_search_by);
		$totalRecord = $objReport->get_select_querry_nb($sql_query.$sql_plus,$filter);
		$row_obj_report=$objReport->get_select_querry($sql_query.$sql_plus,$start,$size,$filter);
		$paging = trim($objUtil->paging($page, $size, $totalRecord));
		
		
		$title=$row_report['report_name'].' list';
		$list_data =$row_obj_report;
// 		echo '<pre>';
// 		var_dump($arr_fields);
// 		echo '</pre>';
		if($do == 'list'){
		$this->Get_list_table_report($title,$row_obj_report,$size,$paging,$page,$arr_headers,$arr_fields);
		}
		
		$this->view->title 	= $title;
		$this->view->arr_cbb= $arr_cbb;
		$this->view->default_sort_label= $row_report['sort_default_label'];
		$this->view->default_sort_field= $row_report['sort_default__field'];
		$this->view->arr_cbb= $arr_cbb;
		$this->view->inlineScript()->appendFile(WEB_PATH.'/application/modules/administrator/views/scripts/report/index.js');
	}
	public function processAction(){
		//$action 		 = @$this->_request->getParam('action');
		$objReport 					= new HT_Model_administrator_models_report();
		
		$do 						= @$this->_request->getParam('do');
		$id 						= (int)$this->_request->getParam('id');
		$module_name				= @$this->_request->getParam('txt_module_name');
		$header						= @$this->_request->getParam('txt_header');
		$fields						= @$this->_request->getParam('txt_fields');
		
		$sql_querry  				= @$this->_request->getParam('txt_querry');
		$search 					= @$this->_request->getParam('txt_search_by');
		$sort_detailt_label 		= @$this->_request->getParam('txt_sort_default_labels');
		$sort_detailt_field 		= @$this->_request->getParam('txt_sort_default_fieds');
		$sort_detailt_status 		= @$this->_request->getParam('txt_sort_default_status');
		$sort_sort_label 			= @$this->_request->getParam('txt_sort_labels');
		$sort_sort_field 			= @$this->_request->getParam('txt_sort_fields');
		$sort_sort_status 			= @$this->_request->getParam('txt_sort_status');
		$description				= $this->_request->getParam('txt_description');
		
		
		
		$status 	= (int)$this->_request->getParam('status');
		if($do == 'submit'){
			
			
			$data = array();
			$data['report_name'] 				= $module_name;
			$data['select_query'] 				= $sql_querry;
			$data['search_fields'] 				= $search;
			$data['headers'] 					= $header;
			$data['fields'] 					= $fields;
			
			$data['sort_default_label'] 		= $sort_detailt_label;
			$data['sort_default__field'] 		= $sort_detailt_field;
			$data['sort_default__value'] 		= $sort_detailt_status;
			
			$data['sort_fields'] 				= $sort_sort_label;
			$data['sort_labels'] 				= $sort_sort_field;
			$data['sort_value'] 				= $sort_sort_status;
			
			$data['description'] 				= $description;
			
			
			if($id >0){
				$status = $objReport->updateData($data,(int)$id);
			}else{
				$status = $objReport->addData($data);
			}
		
			if($status > 0){
				$this->_redirect(WEB_PATH.'/administrator/report?status='.$status);
			}else{
				$redirectLink = WEB_PATH."/administrator/report/update?status=$status";
				if($id >0) $redirectLink .= "&id=$id";
				$this->_redirect($redirectLink);
			}
		}elseif($id >0){
			$ctapage				= $objReport->getReport($id);
			$this->view->report = $ctapage;
		}
		$this->view->id 		= $id;
		$this->view->status 	= $status;
		
		//$this->view->inlineScript()->appendFile(WEB_PATH.'/application/modules/administrator/views/scripts/report/update.js');
	}
	
	public function updateAction(){
		$objReport = new HT_Model_administrator_models_ctapage();
		$do 		 = @$this->_request->getParam('do');
		$id 		= (int)$this->_request->getParam('id');
		$status 	= (int)$this->_request->getParam('status');
		if($do == 'submit'){
			$data = array();
			$data['page_name'] 			= $this->_request->getParam('page_name');
			$data['domain'] 			= strtolower(trim($this->_request->getParam('domain')));
			$data['page_url'] 			= strtolower(trim($this->_request->getParam('page_url')));
			$data['description'] 		= $this->_request->getParam('description');
			if($id >0){
				$status = $objReport->updateData($data,(int)$id);
			}else{
				$status = $objReport->addData($data);
			}

			if($status > 0){
				$this->_redirect(WEB_PATH.'/administrator/ctapage?status='.$status);
			}else{
				$redirectLink = WEB_PATH."/administrator/ctapage/update?status=$status";
				if($id >0) $redirectLink .= "&id=$id";
				$this->_redirect($redirectLink);
			}
		}elseif($id >0){
			
			$ctapage				= $objReport->getCtapage($id);
			$this->view->ctapage = $ctapage;
		}
		$this->view->id 		= $id;
		$this->view->status 	= $status;
		$this->view->inlineScript()->appendFile(WEB_PATH.'/application/modules/administrator/views/scripts/ctapage/update.js');
	}

	function deleteCtapage($id){
		
		$objReport 		= new HT_Model_administrator_models_report();
		echo $objReport->delete("id=".(int)$id);die();
	}

	function getListCtapage(){
	    
        $objUtil 		= new HT_Model_administrator_models_utility();
		$objReport 		= new HT_Model_administrator_models_report();
		$keyword 		= trim($this->_request->getParam('keyword'));
		$page 			= (int)$this->_request->getParam('page');
		$size 			= PAGING_SIZE;
		if (!is_numeric($page) || $page <= 0) {
			$page = 1;
		}
		$start = $page * $size - $size;
		$totalRecord = $objReport->getListReport_nb(array('keyword'=>$keyword));
		$listCtapage = $objReport->getListReport($start,$size,array('keyword'=>$keyword));
		$paging = trim($objUtil->paging($page, $size, $totalRecord));

		$ajaxData = '<table cellspacing="0" class="table">';
		$ajaxData .= '<thead>';
			$ajaxData .= '<tr>';
				$ajaxData .= '<th width="15">No</th>';
				$ajaxData .= '<th width="400">Module</th>';
				
				$ajaxData .= '<th width="400">Desciption</th>';
				
				$ajaxData .= '<th width="50">#</th>';
			$ajaxData .= '</tr>';
		$ajaxData .= '</thead>';
		
	$i=0;
		if($page>1){
		$i=($page-1)*$size;
		}
		$arrGroup = array();
		foreach((array)$listCtapage as $rep){
			$i++;
			$trClass = null;
			if($i%2 == 1) $trClass = ' class="altrow"';
			$ajaxData .= '<tr id="'.$rep['id'].'" '.$trClass.'>';
			$ajaxData .= '<td align="center">'.$i.'</td>';
			$ajaxData .= '<td>'.$rep['report_name'].'</td>';
			$ajaxData .= '<td>'.$rep['description'].'</td>';
			$ajaxData .= '<td style="white-space: nowrap" align="center">';
			$ajaxData .= '
			<a href="'.WEB_PATH.'/administrator/report/view/?reportid='.$rep['id'].'" class="btn btn-xs" title="View"><i class="icon-eye-open"></i></a>
			<a  href="'.WEB_PATH.'/administrator/report/process/?id='.$rep['id'].'" class="btn btn-xs" title="Edit">
			<i class="icon-pencil"></i>
			</a>
			<a  href="#" onclick="deleteJob('.$rep['id'].')" class="btn btn-danger btn-xs"  title="Delete">
			<i class=" icon-trash "></i>
			</a>';
			$ajaxData .= '</td>';
			$ajaxData .= '</tr>';
		}
		$ajaxData .= '</tbody>';
		$ajaxData .= '</table>';
		$title="Report list";
		echo $objUtil->renderData($title,$ajaxData,$paging);die();
	}
	
	
	
	
	function Get_list_table_report($title_header,$lst_data,$size,$paging,$page,$arr_header_name=array(),$arr_filed_data=array()){
 		$objUtil 		= new HT_Model_administrator_models_utility();
// 		$objReport 		= new HT_Model_administrator_models_report();
// 		$keyword 		= trim($this->_request->getParam('keyword'));
// 		$page 			= (int)$this->_request->getParam('page');
// 		$size 			= PAGING_SIZE;
// 		if (!is_numeric($page) || $page <= 0) {
// 			$page = 1;
// 		}
// 		$start = $page * $size - $size;
		//$totalRecord = $objReport->getListReport_nb(array('keyword'=>$keyword));
		///$listCtapage = $objReport->getListReport($start,$size,array('keyword'=>$keyword));
		//$paging = trim($objUtil->paging($page, $size, $totalRecord));
	
		$ajaxData = '<table cellspacing="0" class="table">';
		$ajaxData .= '<thead>';
		$ajaxData .= '<tr>';
		
		$ajaxData .= '<th width="15">No</th>';
		//var_dump($arr_header_name);
		//echo count($arr_header_name);
		
		
		
		for($j=0;$j<count($arr_header_name);$j++){
			if($arr_header_name[$j]!=null){
				$ajaxData .= '<th width="200">'.$arr_header_name[$j].'</th>';
			}else{
				$ajaxData .= '<th width="200" class="hidden">'.$arr_header_name[$j].'</th>';
			}
		}
		
		//$ajaxData .=$box;
		
		$ajaxData .= '</tr>';
		$ajaxData .= '</thead>';
	
		
		$ajaxData .= '<tbody>';
		$i=0;
		if($page>1){
			$i=($page-1)*$size;
		}
		$arrGroup = array();
		foreach((array)$lst_data as $rep){
			$i++;
			
			$ajaxData .= '<tr id="'.'" '.'>';
			$ajaxData .= '<td align="center">'.$i.'</td>';
			//=0;
			/*
			$box_data='';
				for($j=0;$j<count($arr_filed_data);$j++){
					//echo $arr_header_name[$j];
					//$box_data = $box_data. '<th width="400">'.$arr_header_name[$j].'</th>';
					if($arr_filed_data[$j]!=null){
						$box_data = $box_data . '<td>'.$rep[$arr_filed_data[$j]].'</td>';
					}
					//echo '<br/>';
					//echo $j;
				}*/
				
			for($j=0;$j<count($arr_filed_data);$j++){
					//echo $item;
					if($arr_filed_data[$j]!=null){
						if($arr_header_name[$j]!=null){
						$ajaxData .= '<td>'.$objUtil->tooltipString($rep[$arr_filed_data[$j]]).'</td>';
						}else{
						$ajaxData .= '<td class="hidden">'.$objUtil->tooltipString($rep[$arr_filed_data[$j]]).'</td>';
						}
					}
					
				}
				//echo $item;
				//$ajaxData .=$box_data;
				//$ajaxData .= '<td>'.$rep["'".$item."'"].'</td>';
			
			$ajaxData .= '</tr>';
		}
		$ajaxData .= '</tbody>';
		$ajaxData .= '</table>';

		echo $objUtil->renderData($title_header,$ajaxData,$paging);die();
	}
}
