$(document).ready(function(){
	getJob();
	getDomain();
	getleadreturnUrl();
	getfrmCampaignresponse();
}); 

function getJob(){
	var ajaxData = $('#frmJob').serialize()+"&do=list";
	$('#loading').show();
	$.ajax({
        url: $("#jobUrl").val(),
        cache: false,
        type: "POST",
        data: ajaxData,           
        success: function(serverData){
        	
        	$('#jobArea').html(serverData);
        	$('#frmJob .loading').hide();
        }
      });
}



function getleadreturnUrl(){
	var ajaxData = $('#frmLeadreturn').serialize()+"&do=list";
	$('#loading').show();
	$.ajax({
        url: $("#leadreturnUrl").val(),
        cache: false,
        type: "POST",
        data: ajaxData,           
        success: function(serverData){
        	
        	$('#leadreturn').html(serverData);
        	$('#frmLeadreturn .loading').hide();
        }
      });
}

function getDomain(){
	var ajaxData = $('#frmDomain').serialize()+"&do=list";
	$('#loading').show();
	$.ajax({
        url: $("#domainUrl").val(),
        cache: false,
        type: "POST",
        data: ajaxData,           
        success: function(serverData){
        	
        	$('#DomainArea').html(serverData);
        	$('#frmDomain .loading').hide();
        }
      });
}

function getfrmCampaignresponse(){
	var ajaxData = $('#frmCampaignresponse').serialize()+"&do=list";
	$('#loading').show();
	$.ajax({
        url: $("#CampaignresponseUrl").val(),
        cache: false,
        type: "POST",
        data: ajaxData,           
        success: function(serverData){
        	$('#CampaignresponseArea').html(serverData);
        	$('#frmCampaignresponse .loading').hide();
        }
      });
}
