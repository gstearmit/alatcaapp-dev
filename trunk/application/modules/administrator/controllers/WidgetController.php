<?php
class Administrator_WidgetController extends Zend_Controller_Action
{	
    public function init() {
    	//$this->getListJob();
    }
    public function indexAction(){
    	
    }
    
    public function widgetjobAction(){
    	$do = @$this->_request->getParam('do');
    	if($do == 'list'){
    		$this->getListJob();
    	}
    }
    public function widgetdomainAction(){
    	$do = @$this->_request->getParam('do');
    	if($do == 'list'){
    		$this->getListDomain();
    	}
    }
    
    public function widgetleadreturnAction(){
    	$do = @$this->_request->getParam('do');
    	if($do == 'list'){
    		$this->getListLeadreturn();
    	}
    }
    
    public function widgetcampaignresponseAction(){
    	$do = @$this->_request->getParam('do');
    	if($do == 'list'){
    		$this->getListCampaignresponse();
    	}
    }
    
    function getListCampaignresponse(){
    	 
    	$objUtil 		= new HT_Model_administrator_models_utility();
    	$objCampaignresponse 		= new HT_Model_administrator_models_campaignresponse();
    	$listCampaignresponse = $objCampaignresponse->getListcampaignresponse_widget();
    	$ajaxData = '<table cellspacing="0" class="table">';
    	$ajaxData .= '<thead>';
    	$ajaxData .= '<tr>';
    	$ajaxData .= '<th width="200">Campaign</th>';
    	$ajaxData .= '<th width="200">Visitor </th>';
    	$ajaxData .= '<th width="250">Code</th>';
    	$ajaxData .= '<th width="250">Email</th>';
    	$ajaxData .= '<th width="250">Page</th>';
    	$ajaxData .= '<th width="250">Date</th>';
    
    
    	$ajaxData .= '</tr>';
    	$ajaxData .= '</thead>';
    
    	
    	foreach($listCampaignresponse as $cfg){
    		
    		
    		
    		$ajaxData .= '<tr id="'.$cfg['id'].'" '.'>';
    		
    		$ajaxData .= '<td>'.$cfg['campaign_name'].'</td>';
    			
    		$ajaxData .= '<td><a href="'.WEB_PATH.'/administrator/marketing/visitordetail/?visitor_id='.$cfg['visitor_id'].'">'.$cfg['visitor_name'].'</a></td>';
    		$ajaxData .= '<td>'.$cfg['responder_code'].'</td>';
    		$ajaxData .= '<td>'.$cfg['responder_email'].'</td>';
    		$ajaxData .= '<td>'.$cfg['url_current'].'</td>';
    		$ajaxData .= '<td>'.$cfg['response_dttm'].'</td>';
    
    
    			
    		$ajaxData .= '</tr>';
    	}
    	$ajaxData .= '</tbody>';
    	$ajaxData .= '</table>';
    	$title= "";
    	$paging="";
    	echo $objUtil->renderData($title,$ajaxData,$paging);die();
    }
    
    function getListLeadreturn(){
    	 
    	$objUtil 		= new HT_Model_administrator_models_utility();
    	$objLeadreturn 		= new HT_Model_administrator_models_leadreturn();
    	$listLeadreturn = $objLeadreturn->getListLeadreturn_widget();
    
    	$ajaxData = '<table cellspacing="0" class="table">';
    	$ajaxData .= '<thead>';
    	$ajaxData .= '<tr>';
    	$ajaxData .= '<th width="200">Name</th>';
    	$ajaxData .= '<th width="200">Code</th>';
    	
    	$ajaxData .= '<th width="250">Last visit</th>';
    	$ajaxData .= '<th width="250">Interval </th>';
    
    	
    	$ajaxData .= '</tr>';
    	$ajaxData .= '</thead>';
    	foreach($listLeadreturn as $cfg){
    		$ajaxData .= '<tr id="'.$cfg['id'].'" '.'>';		
    		$ajaxData .= '<td><a href="'.WEB_PATH.'/administrator/marketing/visitordetail/?visitor_id='.$cfg['id'].'">'.$cfg['visitor_name'].'</a></td>';
    			
    			
    		$ajaxData .= '<td>'.$cfg['customer_code'].'</td>';
    			
    		
    		$ajaxData .= '<td>'.$cfg['visitor_last_visit'].'</td>';
    		$ajaxData .= '<td>'.$objUtil->secondsToTime($cfg['time_returning']).'</td>';
    		
    		$ajaxData .= '</tr>';
    	}
    	$ajaxData .= '</tbody>';
    	$ajaxData .= '</table>';
    	$title= "";
    	$paging="";
    	echo $objUtil->renderData($title,$ajaxData,$paging);die();
    }
    
    
    function getListJob(){
    	$obj_uti= new HT_Model_administrator_models_utility();
    	$objUtil 		= new HT_Model_administrator_models_utility();
    	$objJob 		= new HT_Model_administrator_models_job();
    	$listJob = $objJob->getListJob_widget();
    	$ajaxData="";
    	$ajaxData .= '<table cellspacing="0" class="table">';
    	$ajaxData .= '<thead>';
    	$ajaxData .= '<tr>';
    	$ajaxData .= '<th width="200">Name</th>';
    	$ajaxData .= '<th width="200">Begin</th>';
    	$ajaxData .= '<th width="200">Update</th>';
    	$ajaxData .= '<th width="200">Status</th>';
    	$ajaxData .= '</tr>';
    	$ajaxData .= '</thead>';
	    	foreach($listJob as $item){
	    		$ajaxData .= '<tr id="'.$item['ID_JOB'].'" '.'>';
	    		$ajaxData .= '<td><a href="'.WEB_PATH.'/administrator/job/detail/?id='.$item['ID_JOB'].'">'.$item['JOBNAME'].'</a></td>';
	    		$value_status="";
	    		if($item['ERRORS']==null){
	    			$value_status=$item['STATUS'];
	    		}else{
	    			if($item['ERRORS']==1){
	    				$value_status="Error";
	    			}else{
	    				$value_status="Success";
	    			}
	    		}
	    		$ajaxData .= '<td>'.$item['REPLAYDATE'].'</td>';
	    		$ajaxData .= '<td>'.$item['LOGDATE'].'</td>';
	    		$ajaxData .= '<td>'.$value_status.'</td>';
	    		$ajaxData .= '</tr>';
	    	}
    	$ajaxData .= '</tbody>';
    	$ajaxData .= '</table>';
    	$title= "";
    	$paging="";
    	echo $objUtil->renderData($title,$ajaxData,$paging);die();
    }
    
    function getListDomain(){
    	$objUtil 		= new HT_Model_administrator_models_utility();
    	$objDomain 		= new HT_Model_administrator_models_referdomain();
    	$listDomain = $objDomain->getListreferdomain_widget();
    	$ajaxData = '<table cellspacing="0" class="table">';
    	$ajaxData .= '<thead>';
    	$ajaxData .= '<tr>';
    	$ajaxData .= '<th width="200">Domain</th>';
    	$ajaxData .= '<th width="300" style="text-align: right;">Page views</th>';
    	$ajaxData .= '<th width="50 style="text-align: right;"">Visitor</th>';
    	$ajaxData .= '<th width="50" style="text-align: right;">Lead</th>';
    	$ajaxData .= '<th width="50" style="text-align: right;">Customer</th>';
    	$ajaxData .= '</tr>';
    	$ajaxData .= '</thead>';
	    	foreach($listDomain as $item){
	    		$ajaxData .= '<tr id="'.$item['id'].'" '.'>';
	    		$ajaxData .= '<td><a  href="'.WEB_PATH.'/administrator/referdomain/view/?id='.$item['id'].'">'.$item['name'].'</a></td>';
	    		$ajaxData .= '<td style="text-align: right;">'.$item['page_view_count'].'</td>';
	    		$ajaxData .= '<td style="text-align: right;">'.$item['visitor_count'].'</td>';
	    		$ajaxData .= '<td style="text-align: right;">'.$item['lead_count'].'</td>';
	    		$ajaxData .= '<td style="text-align: right;">'.$item['customer_count'].'</td>';
	    		$ajaxData .= '</tr>';
	    	}
    	$ajaxData .= '</tbody>';
    	$ajaxData .= '</table>';
    	$title="";
    	$paging="";
    	echo $objUtil->renderData($title,$ajaxData,$paging);die();
    }
    
    public function deniedAction(){
    	
    }
    	
}
