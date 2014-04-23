$(document).ready(function(){
	getJob(1);
	$('#search').click(function(){
		getJob(1);
    });
    $('#reset').click(function(){
    	$('#keyword').val('');
    	getJob(1);
    });
	$('#keyword').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
        	getJob(1); return false;
        }
 });
}); 

function deleteJob(jobId){
	if(confirm('Bạn có chắc chắn muốn xóa dữ liệu này không? Dữ liệu sẽ bị xóa và không thể phục hồi!')){
		$('#loading').show();
		$('#'+jobId).hide("slow");
		$.ajax({
            url: $("#jobUrl").val(),
            cache: false,
            type: "POST",
            data: "do=delete&id="+jobId,           
            success: function(serverData){
            	$('#loading').hide();
            }
        });
	}
}

function getJob(job){
	var ajaxData = $('#frmList').serialize()+"&do=list&job="+job;
	$('#loading').show();
	$.ajax({
        url: $("#jobUrl").val(),
        cache: false,
        type: "POST",
        data: ajaxData,           
        success: function(serverData){
        	$('#loading').hide();
        	$('#jobArea').html(serverData);
        }
      });
}
function buildNavigator(job,currentForm){
	getJob(job);
}
